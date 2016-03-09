<?php /** @var $users \Collection\Users|User[] */ ?>

<!-- Переменная передана из контроллера -->
<h2>Привет, <?= $name ?>! :)</h2>

<!-- Объект текущего URL -->
<h3>Текущий URL: <?= $this->url()->asString(true) ?></h3>

<?php if ($users): ?>
  <p>Всего пользователей: <b><?= $users->count() ?></b></p>
  <?php foreach ($users as $user): ?>
    <p><?= $user->getId() ?>: <a href="/form/<?= $user->getId() ?>"><?= $user->getName() ?></a></p>
  <?php endforeach ?>
<?php endif ?>