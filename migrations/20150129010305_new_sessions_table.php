<?php

use Phinx\Migration\AbstractMigration;

class NewSessionsTable extends AbstractMigration
{
  public function up()
  {
    $tbl = $this->table('test_sessions', array('id' => 'id'));
    $tbl->addColumn("user_id", "integer", array ( 'length' => 10, 'signed' => true, 'null' => true,));
    $tbl->addColumn("ip", "string", array ( 'length' => 15, 'null' => true,));
    $tbl->addColumn("token", "string", array ( 'length' => 255, 'null' => true,));
    $tbl->addColumn("expires_at", "timestamp", array ( 'null' => true,));
    $tbl->addColumn("created_at", "timestamp", array ( 'default' => 'CURRENT_TIMESTAMP',));
    $tbl->addForeignKey("user_id", "test_users", "id", array (  'delete' => 'CASCADE',  'update' => 'CASCADE',));
    $tbl->save();
  }

  public function down()
  {
    $tbl = $this->table('test_sessions', array('id' => 'id'));
    $tbl->drop();
  }
}
