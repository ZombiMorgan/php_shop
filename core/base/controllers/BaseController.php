<?php


namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

abstract class BaseController
{

  use BaseMethods;

  protected $page;
  protected $errors;

  protected $controller;
  protected $inputMethod;
  protected $outputMethod;
  protected $parameters;

  protected $styles;
  protected $scripts;

  public function route()
  {
    $controller = str_replace('/', '\\', $this->controller);
    try {
      $request = new \ReflectionMethod($controller, 'request');

      $args = [
        'inputMethod' => $this->inputMethod,
        'outputMethod' => $this->outputMethod,
        'parameters' => $this->parameters
      ];

      $request->invoke(new $controller, $args);
    } catch (\ReflectionException $e) {
      throw new RouteException($e->getMessage());
    }
  }

  public function request($args)
  {
    $this->parameters = $args['parameters'];
    $inputMethod = $args['inputMethod'];
    $outputMethod = $args['outputMethod'];

    if (!method_exists($this, $inputMethod)) {
      $class = get_class($this);
      throw new RouteException("Нет входного метода {$inputMethod} для контроллера {$class}");
    }
    $data = $this->$inputMethod();

    if (method_exists($this, $outputMethod)) {
      $page = $this->$outputMethod($data);
      if (!empty($page)) $this->page = $page;
    } elseif (!empty($data)) $this->page = $data;

    if ($this->errors) {
      $this->writeLog($this->errors);
    }

    $this->getPage();
  }

  protected function render($path = '', $parameters = [])
  {
    if (!empty($parameters))
      extract($parameters);

    if (empty($path)) {
      $class = new \ReflectionObject($this);
      $space = str_replace('\\', '/', $class->getNamespaceName() . '\\');
      $routes = Settings::get('routes');
      if ($space === $routes['user']['path']) $template = TEMPLATE;
      elseif ($space === $routes['admin']['path']) $template = ADMIN_TEMPLATE;

      $path = $template . explode('controller', strtolower((new \ReflectionObject($this))->getShortName()))[0];
    }

    ob_start();

    if (!@include_once $path . '.php') throw new RouteException("Отсутствует шаблон: {$path}");

    return ob_get_clean();
  }

  private function getPage()
  {
    if (is_array($this->page)) {
      foreach ($this->page as $block) echo $block;
    } else {
      echo $this->page;
    }
  }

  protected function init($admin = false)
  {
    if (!$admin) {
      if (!empty(USER_CSS_JS['styles'])) {
        foreach (USER_CSS_JS['styles'] as $item) $this->styles[] = PATH . TEMPLATE . trim($item, '/');
      }
      if (!empty(USER_CSS_JS['scripts'])) {
        foreach (USER_CSS_JS['scripts'] as $item) $this->scripts[] = PATH . TEMPLATE . trim($item, '/');
      }
    } else {
      if (!empty(ADMIN_CSS_JS['styles'])) {
        foreach (ADMIN_CSS_JS['styles'] as $item) $this->styles[] = PATH . ADMIN_TEMPLATE . trim($item, '/');
      }
      if (!empty(ADMIN_CSS_JS['scripts'])) {
        foreach (ADMIN_CSS_JS['scripts'] as $item) $this->scripts[] = PATH . ADMIN_TEMPLATE . trim($item, '/');
      }
    }
  }
}
