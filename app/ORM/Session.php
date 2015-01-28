<?php

namespace ORM;

use SQRT\DB\Exception;

/** Этот файл сгенерирован автоматически по схеме Sessions */
abstract class Session extends \Base\Item
{
  protected function init()
  {
    $this->setPrimaryKey('id');
    $this->setTable('sessions');
    $this->setFields(
      array(
        'id',
        'user_id',
        'ip',
        'token',
        'expires_at',
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

  public function getUserId($default = null)
  {
    return (int)$this->get('user_id', $default);
  }

  /** @return static */
  public function setUserId($user_id)
  {
    return $this->set('user_id', is_null($user_id) ? null : (int)$user_id);
  }

  public function getIp($default = null)
  {
    return $this->get('ip', $default);
  }

  /** @return static */
  public function setIp($ip)
  {
    return $this->set('ip', $ip);
  }

  public function getToken($default = null)
  {
    return $this->get('token', $default);
  }

  /** @return static */
  public function setToken($token)
  {
    return $this->set('token', $token);
  }

  public function getExpiresAt($default = false, $format = null)
  {
    return $this->getAsDate('expires_at', $default, $format);
  }

  /** @return static */
  public function setExpiresAt($expires_at)
  {
    return $this->setAsDate('expires_at', $expires_at);
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
}
