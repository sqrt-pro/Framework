<?php

namespace Base;

use League\Plates\Engine;
use SQRT\Plates\Extension\DB;
use SQRT\Plates\Extension\Notice;
use SQRT\Plates\Extension\URL;
use League\Plates\Extension\Asset;
use SQRT\Plates\Extension\User;
use Symfony\Component\HttpFoundation\Request;

class Controller extends \SQRT\Controller
{
  /** @var Manager */
  protected $manager;

  /** @var Auth */
  protected $auth;

  function __construct(Request $request, Engine $engine, \SQRT\URL $url = null)
  {
    $this->engine = $engine;

    parent::__construct($request, $url);
  }

  /** @return Auth */
  public function auth()
  {
    if (is_null($this->auth)) {
      $this->auth = new Auth($this->getManager(), $this->getRequest());
    }

    return $this->auth;
  }

  /** @return \User */
  public function getUser()
  {
    return $this->auth()->getUser();
  }

  /**
   * Альяс для getManager
   *
   * @return Manager
   */
  public function db()
  {
    return $this->getManager();
  }

  /** @return Manager */
  public function getManager()
  {
    if (is_null($this->manager)) {
      $this->manager = new Manager();
    }

    return $this->manager;
  }

  /** Отрисовка формы */
  public function renderForm(Form $form, $submit = null, $submit_attr = null, $form_action = null)
  {
    return $this->render(
      'form/form',
      array('form' => $form, 'submit' => $submit, 'submit_attr' => $submit_attr, 'form_action' => $form_action)
    );
  }

  /**
   * {@inheritdoc}
   *
   * @return Layout
   */
  public function layout($template = null)
  {
    return new Layout($this->getTemplatesEngine(), $template);
  }
}