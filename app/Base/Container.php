<?php

namespace Base;

use SQRT\URLImmutable;
use SQRT\RouteCollection;
use League\Plates\Engine;
use SQRT\Plates\Extension\DB;
use SQRT\Plates\Extension\URL;
use SQRT\Plates\Extension\User;
use SQRT\Plates\Extension\Notice;
use League\Plates\Extension\Asset;
use League\Container\Container as Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class Container extends Base
{
  public function __construct($config = [], $factory = null)
  {
    parent::__construct($config, $factory);

    $this->singleton(\League\Container\Container::class, $this);

    $this->singleton(Session::class);
    $this->singleton(Manager::class);
    $this->singleton(\SQRT\DB\Manager::class, $this->get(Manager::class));
    $this->singleton(Auth::class)->withArguments([\SQRT\DB\Manager::class, Request::class]);
    $this->singleton(RouteCollection::class, \RouteCollection::class)->withArgument($this);

    $this->singleton(
      \SQRT\URL::class,
      function (Request $request) {
        return new URLImmutable($request->getUri());
      }
    )->withArgument(Request::class);

    $this->singleton(
      Engine::class,
      function (Session $session, \SQRT\URL $url, Manager $manager, Auth $auth) {
        $e = new Engine(DIR_TMPL);
        $e->loadExtension(new Asset(DIR_WEB, true));
        $e->loadExtension(new Notice($session->getFlashBag()));
        $e->loadExtension(new URL($url));
        $e->loadExtension(new DB($manager));
        $e->loadExtension(new User($auth->getUser() ?: null));

        return $e;
      }
    )->withArguments([Session::class, \SQRT\URL::class, Manager::class, Auth::class]);

    $this->init();
  }

  abstract protected function init();
}