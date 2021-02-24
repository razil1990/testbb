<?php 

namespace vendor\core;

class View {
  public $route = [];
  public $layout;
  public $view;

  public function __construct($route, $layout = '', $view = ''){
    $this->route = $route;
    if($layout === false){
      $this->layout = false;  
    }else{
      $this->layout = $layout ? $layout : 'default';
    }
    $this->view = $view;
  }

  public function render($vars){
    extract($vars);
    $file_view = WWW . '/app/views/' . $this->route['controller'] . '/' . $this->view . '.php';
    ob_start();
    if(is_file($file_view)){
        require $file_view;
    }else{
      echo "Не найден вид: <b>$file_view</b>";
    }
    $content = ob_get_clean();
    $file_layout = WWW . '/app/views/layouts/' . $this->layout . '.php';
    if(is_file($file_layout)){
      require $file_layout;
    }else{
      echo "Не найден шаблон: <b>$file_layout</b>";
    }
  }
}