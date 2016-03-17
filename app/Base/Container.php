<?php

namespace Base;

use SQRT\URLImmutable;
use League\Plates\Engine;
use SQRT\Plates\Extension\DB;
use SQRT\Plates\Extension\URL;
use SQRT\Plates\Extension\User;
use SQRT\Plates\Extension\Notice;
use League\Plates\Extension\Asset;
use League\Container\Container as Base;
use Symfony\Component\HttpFoundation\Request;
use League\Container\Definition\FactoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class Container extends Base
{
  public function __construct($config = [], FactoryInterface $factory = null)
  {
    parent::__construct($config, $factory);

    $this->add(Session::class, null, true);

    $this->add(
      Request::class,
      function (Session $session) {
        $req = Request::createFromGlobals();
        $req->setSession($session);

        if ($req->getContentType() == 'json') {
          $data = json_decode($req->getContent(), true);

          if ($data) {
            $req->request->replace($data);
          }
        }

        return $req;
      }, true
    )->withArgument(Session::class);

    $this->add(
      \SQRT\URL::class,
      function (Request $request) {
        return new URLImmutable($request->getUri());
      },
      true
    )->withArgument(Request::class);

    $this->add(\SQRT\DB\Manager::class, new Manager(), true);

    $this->add(Auth::class, null, true)
      ->withArguments([Manager::class, Request::class]);

    $this->add(
      Engine::class,
      function (Session $session, \SQRT\URL $url, Manager $manager, Auth $auth) {
        $e = new Engine(DIR_TMPL);
        $e->loadExtension(new Asset(DIR_WEB, true));
        $e->loadExtension(new Notice($session->getFlashBag()));
        $e->loadExtension(new URL($url));
        $e->loadExtension(new DB($manager));
        $e->loadExtension(new User($auth->getUser() ?: null));

        return $e;
      },
      true
    )->withArguments([Session::class, \SQRT\URL::class, Manager::class, Auth::class]);

    $this->init();
  }

  abstract protected function init();
}