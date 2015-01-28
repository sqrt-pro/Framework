<?php

namespace Form;

use Base\Form;

class Dummy extends Form
{
  /** @var \User */
  protected $user;

  /** @return \User */
  public function getUser()
  {
    return $this->user;
  }

  /** @return static */
  public function setUser(\User $user)
  {
    $this->user = $user;
    $this->setDefaultValues($user->toArray());

    return $this;
  }

  /** Настраиваем форму */
  protected function init()
  {
    $this->addCheckbox('is_active', 'Включен');

    $this->addInput('name', 'Имя')
      ->setIsRequired();

    $this->addInput('login', 'Логин')
      ->addFilter(REGULAR_LOGIN)
      ->setIsRequired();

    $this->addSelect('status', 'Статус', \User::GetStatusArr())
      ->setPlaceholder('Выберите')
      ->setIsRequired();

    $this->addPassword('password', 'Пароль');

    $this->addPassword('confirm', 'Подтверждение пароля');
  }

  /** После основной валидации делаем дополнительные проверки */
  protected function afterValidation($data)
  {
    if (!empty($data['password']) && ($data['password'] != $data['confirm'])) {
      $this->addError('Пароль и подтверждение не совпадают');
    }

    return $data;
  }

  /** Если форма проходит валидацию - выполняем полезные действия */
  protected function process()
  {
    $d = $this->getValues();

    try {
      if (!$u = $this->getUser()) {
        $this->user = $u = $this->getManager()->users()->make();
      }

      $u->setIsActive($d['is_active']);
      $u->setName($d['name']);
      $u->setLogin($d['login']);
      $u->setStatus($d['status']);
      if (!empty($d['password'])) {
        $u->setPassword($d['password']);
      }
      $u->save();

    } catch (\Exception $e) {
      $this->addError($e->getMessage());
    }
  }
}