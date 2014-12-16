<?php /** @var $field \SQRT\Form\Element|\SQRT\Form\ElementWithOptions */ ?>

<div>
  <?php if ($field instanceof \SQRT\Form\Element\Checkbox): ?>
    <span>&nbsp;</span>
    <label>
      <?= $field->render() ?>
      <?= $field->getName() ?>
    </label>
  <?php else: ?>
    <span><?= $field->getName() ?><?= $field->isRequired() ? ' *' : '' ?></span>
    <?= $field->render() ?>
  <?php endif ?>
</div>