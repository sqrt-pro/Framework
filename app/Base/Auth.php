<?php

namespace Base;

/**
 * @method Manager getManager()
 * @method \User getUser()
 */
class Auth extends \SQRT\Auth
{
  /** Поиск пользователя в БД по логину-паролю */
  public function findUser($login, $password)
  {
    if (!$u = $this->getManager()->users()->findOne(array('is_active' => true, 'login' => $login))) {
      return false;
    }

    return $u->hashPassword($password) == $u->getPassword() ? $u : false;
  }

  /** Поиск пользователя в БД по токену */
  public function findUserByToken($token)
  {
    $m = $this->getManager();
    $u = $m->users();
    $s = $m->sessions();
    $q = $m->getQueryBuilder()
      ->select($u->getTable() . ' u')
      ->join($s->getTable() . ' s', 's.user_id = u.id')
      ->columns('u.*');
    $q->getWhere()
      ->equal('u.is_active', true)
      ->equal('s.token', $token)
      ->expr('s.expires_at >= NOW()');

    return $m->users()->fetchObject($m->query($q));
  }

  /** Сохранение токена в БД */
  public function createToken($expire = null)
  {
    $u = $this->getUser();
    $t = sha1(uniqid());
    $s = new \Session($this->getManager());
    $s->setToken($t);
    $s->setUserId($u->getId());
    $s->setIp($this->getRequest()->getClientIp());
    $s->setExpiresAt(is_numeric($expire) ? date('d.m.Y', $expire) : $expire);
    $s->save();

    return $t;
  }

  /** Удаление токена из БД */
  public function deleteToken($token)
  {
    $m = $this->getManager();
    $s = $m->sessions()->findOne(array('token' => $token));

    $s->delete();
  }
}