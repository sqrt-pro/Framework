<?php

define ('START_AT', microtime(true));
define ('ENV', 'web');

require_once __DIR__ . '/../inc/init.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

try {

  $container = new \Container();
  $router    = new \RouteCollection($container);
  $request   = $container->get(Request::class);
  $method    = strtoupper($request->get('_method', $request->getMethod()));
  $response  = $router->getDispatcher()->dispatch(DEVMODE ? $method : $request->getMethod(), $request->getPathInfo());

} catch (\Exception $e) {

  $headers = [];
  $code    = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
  $title   = DEVMODE ? $e->getMessage() : 'Внутренняя ошибка сервера';
  $slug    = 'unknown';

  if ($e instanceof League\Route\Http\Exception) {
    $code    = $e->getStatusCode();
    $headers = $e->getHeaders();
    $title   = $e->getMessage();
  }

  $response = JsonResponse::create(['errors' => [['title' => $title, 'code' => $slug]]], $code, $headers);
}

$response->send();

//echo microtime(true) - START_AT;