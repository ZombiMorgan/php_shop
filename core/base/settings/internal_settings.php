<?php

defined('__ACCESS__') or die('Access denied');

const TEMPLATE = 'templates/default/';
const ADMIN_TEMPLATE = 'core/admin/views/';

const COOKIE_VERSION = '1.0.0';
const CRYPT_KEY = '';
const COOKIE_TIME = 60;
const BLOCK_TIME = 3;

const QTY = 8;
const QTY_LINKS = 3;

const ADMIN_CSS_JS = [
  'styles' => ['css/admin_style.css'],
  'scripts' => ['js/admin_script.js'],
];

const USER_CSS_JS = [
  'styles' => ['css/style.css'],
  'scripts' => ['js/script.js'],
];

use core\base\exceptions\RouteException;

function autoloadMainClasses($class_name) {
  $class_name = str_replace('\\', '/', $class_name);
  if (!@include_once $class_name . '.php')
    throw new RouteException('Неверное имя файла для подключения - ' . $class_name);
}

spl_autoload_register('autoloadMainClasses');
