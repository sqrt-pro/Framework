<?php

namespace Base;

use League\Plates\Engine;
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
    )
      ->withArgument(Session::class);
    $this->add(\SQRT\DB\Manager::class, new \Base\Manager(), true);
    $this->add(\SQRT\Auth::class, null, true);
    $this->add(
      Engine::class,
      function (Session $session) {
        $e = new Engine(DIR_TMPL);
        $e->loadExtension(new Asset(DIR_WEB, true));
        $e->loadExtension(new Notice($session->getFlashBag()));

        return $e;
      },
      true
    )->withArgument(Session::class);

    $this->init();
  }

  abstract protected function init();
}