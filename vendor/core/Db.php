<?php

namespace vendor\core;

class Db {

  use TSingletone;
  
  public $pdo;
  public static $instance;

  public function __construct(){
    $db = require WWW . '/' . 'config/config_db.php';
    $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
  }

  public function execute( $sql, $params = [] ){
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($params);
  }

  public function query( $sql, $params = []){
    $stmt = $this->pdo->prepare($sql);
    $res = $stmt->execute($params);

    if( $res !== false ){
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    return [];
  }
}