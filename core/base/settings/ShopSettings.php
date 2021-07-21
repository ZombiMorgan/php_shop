<?php


namespace core\base\settings;

use core\base\controllers\Singleton;
use core\base\settings\Settings;

class ShopSettings
{

  use Singleton;
  
  private $baseSettings;

  private $routes = [
    'plugins' => [
      'dir' => 'controllers/',
      'routes' => [
      ]
    ],
    'vasya' => [
      'name' => 'vasya'
    ]
  ];

  static private function getInstance()
  {
    if (self::$_instance == null) {
      self::$_instance = new self;
      self::$_instance->baseSettings = Settings::instance();
      $baseProperties = self::$_instance->baseSettings->clueProperties(get_class());
      self::$_instance->setProperties($baseProperties);
    }
    return self::$_instance;
  }

  private function setProperties($properties)
  {
    if ($properties) {
      foreach ($properties as $name => $property) {
        $this->$name = $property;
      }
    }
  }

  static public function get($property)
  {
    if (isset(ShopSettings::getInstance()->$property)) return ShopSettings::getInstance()->$property;
    return '';
  }
}
