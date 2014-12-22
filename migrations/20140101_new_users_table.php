<?php

use Phinx\Migration\AbstractMigration;

class NewUsersTable extends AbstractMigration
{
  public function up()
  {
    $tbl = $this->table('test_users', array('id' => 'id'));
    $tbl->addColumn("is_active", "boolean", array ( 'default' => 0,));
    $tbl->addColumn("status", "string", array ( 'null' => true, 'length' => 255,));
    $tbl->addColumn("name", "string", array ( 'length' => 255, 'null' => true,));
    $tbl->addColumn("salt", "string", array ( 'length' => 255, 'null' => true,));
    $tbl->addColumn("password", "string", array ( 'length' => 255, 'null' => true,));
    $tbl->addColumn("created_at", "timestamp", array ( 'default' => 'CURRENT_TIMESTAMP',));
    $tbl->save();
  }

  public function down()
  {
    $tbl = $this->table('test_users', array('id' => 'id'));
    $tbl->drop();
  }
}
