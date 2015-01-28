<?php

namespace Schema;

use Base\Manager;
use SQRT\DB\Schema;

class Users extends Schema
{
  protected function init()
  {
    $this->setTable('users');
    $this->setName('Users');
    $this
      ->addId()
      ->addBool('is_active')
      ->addEnum('status', array('guest', 'user', 'admin'))
      ->addChar('name')
      ->addChar('login')
      ->addChar('salt')
      ->addChar('password')
      ->addTimeCreated()
    ;
  }

  public function fixture()
  {
    /** @var Manager $m */
    $m = $this->getManager();
    $u = $m->users()->make();

    $u->setIsActive(true);
    $u->setLogin('admin');
    $u->setName('Admin');
    $u->setPassword('qwerty');
    $u->setStatus(\User::STATUS_ADMIN);
    $u->save();
  }
}