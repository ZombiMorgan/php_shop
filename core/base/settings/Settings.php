<?php

namespace core\base\settings;

use core\base\controllers\Singleton;

class Settings
{

  use Singleton;

  private $routes = [
    'admin' => [
      'alias' => 'sudo',
      'path' => 'core/admin/controllers/',
      'hrUrl' => false,
      'routes' => [
        'shop2' => 'index'
      ]
    ],
    'settings' => [
      'path' => 'core/base/settings/'
    ],
    'plugins' => [
      'path' => 'core/plugins/',
      'hrUrl' => false,
      'dir' => false
    ],
    'user' => [
      'path' => 'core/user/controllers/',
      'hrUrl' => true,
      'routes' => [
        'shop2' => 'index'
      ]
    ],
    'default' => [
      'controller' => 'IndexController',
      'inputMethod' => 'inputData',
      'outputMethod' => 'outputData'
    ]
  ];

  private $templateArr = [
    'text' => ['a', 'b', 'c'],
    'textarea' => ['a', 'b', 'c']
  ];

  private $lalala = 'lalala';

  static public function get($property)
  {
    return self::instance()->$property;
  }

  public function clueProperties($class)
  {
    $baseProperties = [];

    foreach ($this as $name => $item) {
      $property = $class::get($name);
      if (is_array($item) && is_array($property))
        $baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
      if (!$property) $baseProperties[$name] = $this->$name;
    }
    return $baseProperties;
  }

  public function arrayMergeRecursive()
  {
    $arrays = func_get_args();
    $base = array_shift($arrays);
    foreach ($arrays as $array) {
      foreach ($array as $name => $value) {
        if (is_array($value) && isset($base[$name]) && is_array($base[$name]))
          $base[$name] = $this->arrayMergeRecursive($base[$name], $value);
        else {
          if (is_int($name)) {
            if (!in_array($value, $base))
              array_push($base, $value);
            continue;
          }
          $base[$name] = $value;
        }
      }
    }
    return $base;
  }
}
