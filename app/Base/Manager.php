<?php

namespace Base;

/** Этот файл сгенерирован автоматически командой db:manager */
class Manager extends \SQRT\DB\Manager
{
  function __construct()
  {
    $this->addConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $this->setPrefix(PREFIX);

    $this->setRepositoryClass('Sessions', '\Repository\Sessions');
    $this->setRepositoryClass('Users', '\Repository\Users');
  }

  /** @return \Repository\Sessions */
  public function sessions()
  {
    return $this->getRepository('Sessions');
  }

  /** @return \Repository\Users */
  public function users()
  {
    return $this->getRepository('Users');
  }
}