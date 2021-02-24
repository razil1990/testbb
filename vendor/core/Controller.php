<?php 

namespace vendor\core;

class Controller {

  public $route = [];
  public $layout;
  public $view;
  public $vars = [];

  public function __construct($route){
    $this->route = $route;
    $this->view = $route['action'];
  }

  public function setView($vars){
    $this->vars = $vars;
  }

  public function getView(){
    $vObj = new View($this->route, $this->layout, $this->view);
    $vObj->render($this->vars);
  }
}