<?php

namespace core\base\models;

use core\base\controllers\Singleton;
use core\base\exceptions\DBException;

class BaseModel
{

  use Singleton;

  protected $db;
  protected $db2;

  private function __construct()
  {

    $opt  = array(
      \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::ATTR_EMULATE_PREPARES   => true,
    );

    // try {
    //   $this->db = @new \PDO(DSN, USER, PASS, $opt);
    // } catch (\PDOException $e) {
    //   throw new DBException($e->getMessage());
    // }

    $this->db2 = @new \mysqli(HOST, USER, PASS, DB_NAME);
    if ($this->db2->connect_error) {
      throw new DBException('Ошибка подключения к базе данных: ['
      . $this->db2->connect_errno . '] ' . $this->db2->connect_error);
    }
    $this->db2->set_charset('utf8mb4');

  }
}
