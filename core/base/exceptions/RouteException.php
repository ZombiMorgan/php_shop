<?php

namespace core\base\exceptions;

use core\base\controllers\BaseMethods;

class RouteException extends \Exception
{

  protected $messages;

  use BaseMethods;

  public function __construct($message = '', $code = 0)
  {
    parent::__construct($message, $code);

    $this->messages = include 'messages.php';

    $error = !empty($this->getMessage()) ? $this->getMessage() : $this->messages[$this->getCode()];
    $error .= "\r\n" . 'File: ' . $this->getFile();
    $error .= "\r\n" . 'In line: ' . $this->getLine();
    $error .= "\r\n";

    if (!empty($this->messages[$this->getCode()]))
      $this->message = $this->messages[$this->getCode()];
    
    $this->writeLog($error);
  }
}
