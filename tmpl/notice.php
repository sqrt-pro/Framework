<?php foreach ($notices as $type => $messages): ?>
  <?php foreach ($messages as $message): ?>
    <div class="notice notice-<?= $type ?>"><?= $message ?></div>
  <?php endforeach ?>
<?php endforeach ?>