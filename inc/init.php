<?php

/** Автолодер Composer */
require_once __DIR__ . '/../vendor/autoload.php';
/** Константы */
require_once __DIR__ . '/const.php';
/** Пути к папкам в системе */
require_once __DIR__ . '/paths.php';
/** Настройка доступа в БД, префикс, режим отладки */
require_once __DIR__ . '/config.php';

/** Вывод ошибок */
if (DEVMODE) {
  error_reporting(E_ALL ^ E_STRICT); // E_ALL ^ E_STRICT ^ E_DEPRECATED
  ini_set('display_errors', true);
} else {
  ini_set('display_errors', false);
}