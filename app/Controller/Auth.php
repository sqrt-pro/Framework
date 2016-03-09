<?php

namespace Controller;

use Base\Controller;

class Auth extends Controller
{
  /** Вход */
  function loginAction(\Form\Auth $form)
  {
    if ($u = $this->getUser()) {
      return $this->redirect('/protected/');
    }

    if ($form->validate()) {
      $r = $this->redirect('/protected/');

      if ($c = $this->auth()->getCookieForResponse()) {
        $r->headers->setCookie($c);
      }

      return $r;
    }

    if ($err = $form->getErrors('<br />')) {
      $this->notice($err, false);
    }

    return $this->layout()
      ->setTitle('Авторизация')
      ->setContent($this->renderForm($form, 'Войти'))
      ->render();
  }

  /** Выход */
  function logoutAction()
  {
    $a = $this->auth()->logout();
    $r = $this->redirect('/');

    $r->headers->clearCookie($a->getTokenVar());

    return $r;
  }
}