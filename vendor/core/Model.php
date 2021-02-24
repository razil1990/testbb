<?php

namespace vendor\core;

abstract class Model {
  use TValidation;
  public $pdo;
  protected $table;
  protected $pk;

  public function __construct(){
    $this->pdo = \vendor\core\Db::instance();
  }

  public function query( $sql, $params = [] ){
    return $this->pdo->execute( $sql, $params );
  }

  public function findAll(){
    $sql = "SELECT * FROM {$this->table}";
    return $this->pdo->query( $sql );
  }

  public function findOne($field, $value){
    $field = $field ?: $this->pk;
    $sql = "SELECT * FROM {$this->table} WHERE $field=? LIMIT 1";
    return $this->pdo->query( $sql, [$value] );
  }

  public function findAllWIthParams($sql, $param) {
    return $this->pdo->query($sql, $param);
  }

  public function countPlaceHolders($arr) {
    return implode(',', array_fill(0, count($arr), '?'));
  }
}