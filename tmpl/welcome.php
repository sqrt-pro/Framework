<!-- Стиль будет подключен с версионированием -->
<link rel="stylesheet" href="<?= $this->asset('/html/demo.css') ?>" />

<!-- Переменная передана из контроллера -->
<h1>Привет, <?= $name ?>! :)</h1>

<!-- Отрисовываем всплывающие сообщения в шаблоне notice -->
<?= $this->notice('notice') ?>

<!-- Объект текущего URL -->
<h3>Текущий URL: <?= $this->url()->asString(true) ?></h3>

<p>Добавить сообщение: <a href="/notice/success:true/">Успех</a> | <a href="/notice/">Ошибка</a>.</p>

<p><a href="/form/">Пример работы формы</a></p>