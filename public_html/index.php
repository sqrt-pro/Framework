<?php

define ('START_AT', microtime(true));
define ('ENV', 'web');

require_once __DIR__ . '/../inc/init.php';

use Symfony\Component\HttpFoundation\Request;

$app = new \SQRT\Kernel(new Container());
$app->handle(Request::createFromGlobals())->send();

//echo microtime(true) - START_AT;