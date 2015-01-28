<?php

use Base\Controller;
use Symfony\Component\HttpFoundation\Response;

class defaultController extends Controller
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

  /** Вход */
  function loginAction()
  {
    if ($u = $this->getUser()) {
      return $this->redirect('/protected/');
    }

    $f = new \Form\Auth($this->getRequest(), $this->getManager(), $this->auth(), 'dummy');

    if ($f->validate()) {
      $r = $this->redirect('/protected/');

      if ($c = $this->auth()->getCookieForResponse()) {
        $r->headers->setCookie($c);
      }

      return $r;
    }

    if ($err = $f->getErrors('<br />')) {
      $this->notice($err, false);
    }

    return $this->layout()
      ->setTitle('Авторизация')
      ->setContent($this->renderForm($f, 'Войти'))
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

  /** Пример страницы с формой */
  function formAction()
  {
    $u = false;
    if ($id = $this->getUrl()->getId()) {
      if (!$u = $this->db()->users()->findOne($id)) {
        $this->notFound('Пользователь не найден');
      }
    }

    $p = $this->layout()->setTitle('Пример работы формы');
    $f = new \Form\Dummy($this->getRequest(), $this->db(), 'dummy');

    if ($u) {
      $f->setUser($u);
      $p->setTitle('Редактирование пользователя');
    }

    if ($f->validate()) {
      $this->notice('Успешно сохранено', true);

      if (!$u) {
        return $this->redirect('/form/id:' . $f->getUser()->getId() . '/');
      }
    }

    if ($err = $f->getErrors('<br />')) {
      $this->notice($err, false);
    }

    return $p->setContent($this->renderForm($f, 'Сохранить'));
  }

  /** Отображение пропущенных Exception. Отображается через подзапрос */
  function errorAction()
  {
    /** @var $e Symfony\Component\Debug\Exception\FlattenException */
    if (!$e = $this->getRequest()->attributes->get('exception')) {
      $this->forbidden('Exception отсутствует в запросе');
    }

    switch ($code = $e->getStatusCode()) {
      case 404:
        $title = 'Страница не найдена!';
        break;

      case 403:
        $title = 'Доступ запрещен!';
        break;

      default:
        $title = 'Ошибка!';
    }

    return Response::create(
      $this->render('error', array('code' => $code, 'error' => $e->getMessage(), 'title' => $title)),
      $code,
      $e->getHeaders()
    );
  }
}