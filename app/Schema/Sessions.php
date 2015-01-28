<?php

namespace Schema;

use SQRT\DB\Schema;

class Sessions extends Schema
{
  protected function init()
  {
    $this
      ->addId()
      ->addInt('user_id', null)
      ->addChar('ip', 15)
      ->addChar('token')
      ->addTime('expires_at')
      ->addTimeCreated()
    ;
  }

  protected function relations()
  {
    $this->addForeignKey('user_id', 'Users', null, static::FK_CASCADE);
  }
}