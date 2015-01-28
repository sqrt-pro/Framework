<?php

namespace Form;

use Base\Form;
use Base\Manager;
use Symfony\Component\HttpFoundation\Request;

class Auth extends Form
{
  protected $auth;

  function __construct(Request $request, Manager $manager = null, \Base\Auth $auth, $name = null)
  {
    $this->auth = $auth;

    parent::__construct($request, $manager, $name);
  }

  protected function init()
  {
    $this->addInput('login', 'Логин')
      ->setIsRequired();
    $this->addPassword('password', 'Пароль')
      ->setIsRequired();
    $this->addCheckbox('remindme', 'Запомнить меня');
  }

  protected function process()
  {
    $d = $this->getValues();

    if (!$this->auth->login($d['login'], $d['password'], $d['remindme'])) {
      $this->addError('Пользователь не найден');
    }
  }
}