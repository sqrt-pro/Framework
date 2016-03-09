<?php

namespace Controller;

use Base\Controller;
use Form\Dummy;

class Welcome extends Controller
{
  /** Главная страница */
  function indexAction()
  {
    $users = $this->db()->users()->find();
    $user  = $this->getUser();

    return $this->layout()
      ->setTitle('SQRT Framework')
      ->setHeader('Главная страница')
      ->setKeywords('META-ключевые слова')
      ->setDescription('META-описание страницы')
      ->setContent($this->render('welcome', array('name' => $user ? $user->getName() : 'Мир', 'users' => $users)))
      ->render();
  }

  /** Страница с ограниченным доступом */
  function protectedAction()
  {
    if (!$u = $this->getUser()) {
      $this->notice('Доступ запрещен', false);

      return $this->redirect('/login/');
    }

    return $this->layout()
      ->setTitle('Закрытый раздел')
      ->setContent($this->render('protected', array('user' => $u)))
      ->render();
  }

  /** Форма редактирование пользователя */
  function editUserAction(Dummy $form, $id = null)
  {
    $id && $this->loadUserToForm($form, $id);

    $form->setName('dummy');
    $page = $this->layout()->setTitle($id ? 'Редактирование пользователя' : 'Добавление пользователя');

    return $page->setContent($this->renderForm($form, 'Сохранить'));
  }

  /** Сохранение пользователя */
  function saveUserAction(Dummy $form, $id = null)
  {
    $id && $this->loadUserToForm($form, $id);
    $form->setName('dummy');

    if ($form->validate()) {
      $this->notice('Успешно сохранено', true);

      if (!$id) {
        return $this->redirect('/form/' . $form->getUser()->getId());
      }
    }

    if ($err = $form->getErrors('<br />')) {
      $this->notice($err, false);
    }

    return $this->back();
  }

  /** Находит юзера и подставляет его в форму */
  protected function loadUserToForm(Dummy $form, $id)
  {
    if ($user = $this->db()->users()->findOne($id)) {
      $form->setUser($user);
    } else {
      $this->notFound('Пользователь не найден');
    }

    return $form;
  }
}