<?php

namespace core\admin\controllers;

use core\base\controllers\BaseController;

class IndexController extends BaseController
{

  protected function inputData()
  {
    $this->init(true);
    print_r($this);
    exit();
  }

}