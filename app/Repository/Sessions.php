<?php

namespace Repository;

/**
 * Этот файл сгенерирован автоматически по схеме Sessions
 *
 * @method \Session[]|\Base\Collection find($where = null, $orderby = null, $onpage = null, $page = null) Получить коллекцию объектов
 * @method \Session findOne($where = null, $orderby = null) Найти и получить один объект
 * @method \Session make() Создать новый объект
 * @method \Session fetchObject(\PDOStatement $statement) Получение объекта из запроса
*/
class Sessions extends \Base\Repository
{
  protected function init()
  {
    $this->setItemClass('\Session');
    $this->setTable('sessions');
  }
}
