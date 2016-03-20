<?php /** @var $layout \SQRT\Layout */ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <?= $layout->title() ?>

  <?= $layout->keywords() ?>

  <?= $layout->description('Лучший сайт на свете') ?>

  <?php if ($arr = $layout->getCSS()): ?>
    <?php foreach ($arr as $css): ?>
      <?= $this->fetch('block/css', $css) ?>
    <?php endforeach ?>
  <?php endif ?>

  <link rel="shortcut icon" href="/html/favicon.ico" type="image/x-icon" />
</head>

<body>
  <div class="wrapper">
    <!-- Заголовок -->
    <?= $layout->header('h1', 'blue') ?>

    <!-- Пример меню -->
    <nav>
      <a href="/" <?= $this->url() == '/' ? 'class="active"' : '' ?>>Демо-страница</a>
      <a href="/form/" <?= $this->url() == '/form/' ? 'class="active"' : '' ?>>Добавить пользователя</a>
      <a href="/protected/" <?= $this->url() == '/protected/' ? 'class="active"' : '' ?>>Закрытый раздел</a>
      <?php if ($u = $this->user()): ?>
        <a href="/logout/">Выход <?= $u->getName() ?> [<?= $u->getStatusName() ?>]</a>
      <?php endif ?>
    </nav>

    <!-- Отрисовываем всплывающие сообщения в шаблоне notice -->
    <?= $this->notice('notice') ?>

    <!-- Контент страницы -->
    <?= $layout->getContent() ?>
  </div>

  <!-- JS -->
  <?php if ($arr = $layout->getJS()): ?>
    <?php foreach ($arr as $js): ?>
      <?= $this->fetch('block/js', $js) ?>
    <?php endforeach ?>
  <?php endif ?>

</body>
</html>