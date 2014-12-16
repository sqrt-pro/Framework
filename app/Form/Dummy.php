<?php

namespace Form;

use Base\Form;

class Dummy extends Form
{
  protected function init()
  {
    $this->addCheckbox('is_active', 'Включен');

    $this->addInput('name', 'Имя')
      ->setIsRequired();

    $this->addSelect('gender', array('m' => 'Мужской', 'f' => 'Женский'), 'Пол')
      ->setPlaceholder('Выберите');

    $this->addInput('age', 'Возраст')
      ->addFilter('is_numeric');
  }

  protected function afterValidation($data)
  {
    if ($data['gender'] == 'f' && $data['age'] < 18) {
      $this->addError('Девушки от 18');
    }

    return $data;
  }

  protected function process()
  {
    $d = $this->getValues();

    try {
      // Какая-то логика
    } catch (\Exception $e) {
      $this->addError($e->getMessage());
    }
  }
}