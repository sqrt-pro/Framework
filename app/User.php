<?php

use ORM\User as BaseItem;

class User extends BaseItem
{
  protected static $status_arr = array(
    self::STATUS_GUEST => 'Гость',
    self::STATUS_USER  => 'Пользователь',
    self::STATUS_ADMIN => 'Админ',
  );

  protected $pass_change;

  public function setPassword($password)
  {
    $this->pass_change = $password;

    return $this;
  }

  /** Хешировать пароль */
  public function hashPassword($password)
  {
    return hash('whirlpool', hash('sha256', $this->getSalt()) . $password);
  }

  protected function beforeSave()
  {
    if ($this->pass_change) {
      $this->setSalt(md5(uniqid('', true)));
      $this->set('password', $this->hashPassword($this->pass_change));
      $this->pass_change = null;
    }
  }
}