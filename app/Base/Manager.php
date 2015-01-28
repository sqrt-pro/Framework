<?php

namespace Base;

/** Этот файл сгенерирован автоматически командой db:manager */
class Manager extends \SQRT\DB\Manager
{
  function __construct()
  {
    $this->addConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $this->setPrefix(PREFIX);

    $this->setCollectionClass('Sessions', '\Collection\Sessions');
    $this->setCollectionClass('Users', '\Collection\Users');
  }

  /** @return \Collection\Sessions */
  public function sessions()
  {
    return $this->getCollection('Sessions');
  }

  /** @return \Collection\Users */
  public function users()
  {
    return $this->getCollection('Users');
  }
}