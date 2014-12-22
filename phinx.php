<?php

require_once __DIR__ . '/inc/init.php';

return array(
  'paths'        => array(
    'migrations' => DIR_MIGRATION
  ),
  'environments' => array(
    'default_migration_table' => 'phinxlog',
    'default_database'        => 'development',
    'development'             => array(
      'adapter' => 'mysql',
      'host'    => DB_HOST,
      'name'    => DB_NAME,
      'user'    => DB_USER,
      'pass'    => DB_PASS,
      'port'    => '3306',
      'charset' => 'utf8',
    ),
  )
);