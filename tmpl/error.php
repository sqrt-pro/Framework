<html>
  <title><?= $title ?></title>

  <center>
    <h1><?= $title ?> [<?= $code ?>]</h1>

    <?php if (DEVMODE && !empty($error)): ?>
      <h3><?= $error ?></h3>
    <?php endif ?>
  </center>
</html>