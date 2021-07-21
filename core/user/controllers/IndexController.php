<?php

namespace core\user\controllers;

use core\base\controllers\BaseController;
use core\base\models\BaseModel;

class IndexController extends BaseController
{

  protected function inputData()
  {
    $db = BaseModel::instance();
    
    return '123';
  }

}
