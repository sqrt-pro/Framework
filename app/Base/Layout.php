<?php

namespace Base;

class Layout extends \SQRT\Layout
{
  protected function init()
  {
    $this->setTemplate('layout/default');

    $this->addCSS('/html/demo.css', true);
  }
}