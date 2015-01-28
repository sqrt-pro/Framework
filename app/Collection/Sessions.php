<?php

namespace Collection;

/**
 * Этот файл сгенерирован автоматически по схеме Sessions
 *
 * @method \Session[]|Sessions find($where = null, $orderby = null, $onpage = null, $page = null) Загрузить в коллекцию объекты
 * @method \Session findOne($where = null) Найти и получить один объект
 * @method \Session make() Создать новый объект
 * @method \Session fetchObject(\PDOStatement $statement) Получение объекта из запроса
*/
class Sessions extends \Base\Collection
{
  protected function init()
  {
    $this->setItemClass('\Session');
    $this->setTable('sessions');
  }
}
