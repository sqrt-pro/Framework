<?php /** @var $page \SQRT\Layout */ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <?= $page->title() ?>

  <?= $page->keywords() ?>

  <?= $page->description('Лучший сайт на свете') ?>

  <?php if ($arr = $page->getCSS()): ?>
    <?php foreach ($arr as $css): ?>
      <?= $this->fetch('block/css', $css) ?>
    <?php endforeach ?>
  <?php endif ?>

</head>

<body>
  <div class="wrapper">
    <!-- Заголовок -->
    <?= $page->header('h1', 'blue') ?>

    <!-- Пример меню -->
    <nav>
      <a href="/" <?= $this->url() == '/' ? 'class="active"' : '' ?>>Демо-страница</a>
      <a href="/form/" <?= $this->url() == '/form/' ? 'class="active"' : '' ?>>Добавить пользователя</a>
    </nav>

    <!-- Отрисовываем всплывающие сообщения в шаблоне notice -->
    <?= $this->notice('notice') ?>

    <!-- Контент страницы -->
    <?= $page->getContent() ?>
  </div>

  <!-- JS -->
  <?php if ($arr = $page->getJS()): ?>
    <?php foreach ($arr as $js): ?>
      <?= $this->fetch('block/js', $js) ?>
    <?php endforeach ?>
  <?php endif ?>

</body>
</html>