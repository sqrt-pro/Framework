<?php

namespace Base;

use SQRT\Form as BaseForm;
use Symfony\Component\HttpFoundation\Request;

class Form extends BaseForm
{
  /** @var Manager */
  protected $manager;

  function __construct(Request $request, Manager $manager = null, $name = null)
  {
    if ($manager) {
      $this->setManager($manager);
    }

    parent::__construct($request, $name);
  }

  /** @return Manager */
  public function getManager()
  {
    return $this->manager;
  }

  /** @return static */
  public function setManager(Manager $manager)
  {
    $this->manager = $manager;

    return $this;
  }
}