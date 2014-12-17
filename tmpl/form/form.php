<?php
/** @var $form \Base\Form */
$submit = !empty($submit) ? $submit : 'Отправить';
$submit_attr = !empty($submit_attr) ? $submit_attr : null;
$form_action = !empty($form_action) ? $form_action : null;
?>

<form method="POST" action="<?= $form_action ?>" id="form-<?= $form->getName() ?>" enctype="multipart/form-data">
  <?php foreach ($form->getFields() as $field): ?>
    <?= $this->fetch('form/field', array('field' => $field)) ?>
  <?php endforeach ?>

  <div>
    <span>&nbsp;</span>
    <?= new \SQRT\Tag('button', $submit, $submit_attr) ?>
  </div>
</form>