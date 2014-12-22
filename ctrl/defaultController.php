<?php

use Base\Controller;
use Symfony\Component\HttpFoundation\Response;

class defaultController extends Controller
{
  /** Главная страница */
  function indexAction()
  {
    $users = $this->db()->users()->find();

    return $this->layout()
      ->setTitle('SQRT Framework')
      ->setHeader('Главная страница')
      ->setKeywords('META-ключевые слова')
      ->setDescription('META-описание страницы')
      ->setContent($this->render('welcome', array('name' => 'Мир', 'users' => $users)))
      ->render();
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