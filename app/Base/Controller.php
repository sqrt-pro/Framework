<?php

namespace Base;

class Controller extends \SQRT\Controller
{
  /** @return Auth */
  public function auth()
  {
    return $this->container->get(Auth::class);
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
    return $this->container->get(Manager::class);
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