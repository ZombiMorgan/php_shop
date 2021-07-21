<?php

namespace core\base\controllers;

trait Singleton
{

  private static $_instance;

  private function __clone()
  {
  }

  private function __construct()
  {
  }

  public static function instance()
  {
    if (self::$_instance == null)
      self::$_instance = new self;
    return self::$_instance;
  }
}
