<?php

define('__ACCESS__', true);

header('Content-Type:text/html;charset:utf-8');
session_start();

require_once 'config.php';
require_once 'core/base/settings/internal_settings.php';

use core\base\exceptions\RouteException;
use core\base\controllers\RouteController;
use core\base\exceptions\DBException;

try {
  $a = RouteController::instance()->route();
} catch (RouteException $e) {
  exit($e->getMessage());
} catch (DBException $e) {
  exit($e->getMessage());
}
