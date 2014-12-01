<?php

namespace Base;

use SQRT\Plates\Extension\Notice;
use SQRT\Plates\Extension\URL;
use League\Plates\Extension\Asset;
use Symfony\Component\HttpFoundation\Request;

class Controller extends \SQRT\Controller
{
  function __construct(Request $request, \SQRT\URL $url = null)
  {
    parent::__construct($request, $url);

    // Настройка шаблонизатора
    $engine = $this->getTemplatesEngine();
    $engine->setDirectory(DIR_TMPL);
    $engine->loadExtension(new Asset(DIR_WEB, true));
    $engine->loadExtension(new Notice($this->getSession()->getFlashBag()));
    $engine->loadExtension(new URL($this->getUrl()));
  }
}