<?php

namespace ORM;

use SQRT\DB\Exception;

/** Этот файл сгенерирован автоматически по схеме Users */
abstract class User extends \Base\Item
{
  const STATUS_GUEST = 'guest';
  const STATUS_USER = 'user';
  const STATUS_ADMIN = 'admin';

  protected static $status_arr = array(
    self::STATUS_GUEST => 'guest',
    self::STATUS_USER => 'user',
    self::STATUS_ADMIN => 'admin',
  );

  protected function init()
  {
    $this->setPrimaryKey('id');
    $this->setTable('users');
    $this->setFields(
      array(
        'id',
        'is_active',
        'status',
        'name',
        'salt',
        'password',
        'created_at',
      )
    );
  }

  public function getId($default = null)
  {
    return $this->get('id', $default);
  }

  /** @return static */
  public function setId($id)
  {
    return $this->set('id', $id);
  }

  public function getIsActive($default = null)
  {
    return (int)$this->get('is_active', $default);
  }

  /** @return static */
  public function setIsActive($is_active)
  {
    return $this->set('is_active', (int)$is_active);
  }

  public function getStatus($default = null)
  {
    return $this->get('status', $default);
  }

  public function getStatusName()
  {
    return static::GetNameForStatus($this->getStatus());
  }

  /** @return static */
  public function setStatus($status)
  {
    if (!empty($status) && !static::GetNameForStatus($status)) {
      Exception::ThrowError(Exception::ENUM_BAD_VALUE, 'status', $status);
    }

    return $this->set('status', $status);
  }

  public function getName($default = null)
  {
    return $this->get('name', $default);
  }

  /** @return static */
  public function setName($name)
  {
    return $this->set('name', $name);
  }

  public function getSalt($default = null)
  {
    return $this->get('salt', $default);
  }

  /** @return static */
  public function setSalt($salt)
  {
    return $this->set('salt', $salt);
  }

  public function getPassword($default = null)
  {
    return $this->get('password', $default);
  }

  /** @return static */
  public function setPassword($password)
  {
    return $this->set('password', $password);
  }

  public function getCreatedAt($default = false, $format = null)
  {
    return $this->getAsDate('created_at', $default, $format);
  }

  /** @return static */
  public function setCreatedAt($created_at)
  {
    return $this->setAsDate('created_at', $created_at);
  }

  public static function GetStatusArr()
  {
    return static::$status_arr;
  }

  public static function GetNameForStatus($status)
  {
    $a = static::GetStatusArr();

    return isset($a[$status]) ? $a[$status] : false;
  }
}
