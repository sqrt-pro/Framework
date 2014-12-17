<?php

use Base\Controller;
use Symfony\Component\HttpFoundation\Response;

class defaultController extends Controller
{
  /** Главная страница */
  function indexAction()
  {
    return $this->layout()
      ->setTitle('SQRT Framework')
      ->setHeader('Главная страница')
      ->setKeywords('META-ключевые слова')
      ->setDescription('META-описание страницы')
      ->setContent($this->render('welcome', array('name' => 'Мир')))
      ->render();
  }

  /** Пример страницы с формой */
  function formAction()
  {
    $f = new \Form\Dummy($this->getRequest(), 'dummy');

    if ($f->validate()) {
      $this->notice('Успешно сохранено', true);
    }

    if ($err = $f->getErrors('<br />')) {
      $this->notice($err, false);
    }

    return $this->layout()
      ->setTitle('Пример работы формы')
      ->setContent($this->renderForm($f, 'Сохранить'))
      ->render();
  }

  /** Добавляем всплывающее сообщение */
  function noticeAction()
  {
    $ok = $this->getUrl()->hasParameter('success');

    $this->notice($ok ? 'Все хорошо' : 'Печалька', true);

    return $this->back();
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