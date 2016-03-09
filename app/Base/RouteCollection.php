<?php

namespace Base;

use FastRoute\DataGenerator;
use FastRoute\RouteParser;
use League\Container\ContainerInterface;

abstract class RouteCollection extends \League\Route\RouteCollection
{
  public function __construct(
    ContainerInterface $container = null,
    RouteParser $parser = null,
    DataGenerator $generator = null
  )
  {
    parent::__construct($container, $parser, $generator);

    $this->setStrategy(new RouteStrategy);

    $this->init();
  }

  abstract protected function init();
}