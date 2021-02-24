<?php 

namespace vendor\core;

class Router {

  public static $routes = [];
  public static $route = [];

  public static function add($regexp, $route = []){
      self::$routes[$regexp] = $route;
      
  }

  protected static function matchRoute($url){
    foreach(self::$routes as $pattern => $route){
      if(preg_match("#$pattern#i", $url, $matches)){
        foreach($matches as $k => $v){
            if(is_string($k)){
                $route[$k] = $v;
            }   
        }
        if(!isset($route['action'])){
            $route['action'] = 'index';  
        }
        $route['controller'] = self::upperCamelCase($route['controller']);
        self::$route = $route;
        return true;
      }
    } 
    return false;
  }


  public static function dispatch($url){
    $url = self::removeQueryStr($url);
    if(self::matchRoute($url)){
      $controller = 'app\\controllers\\' . self::$route['controller'];
      if(class_exists($controller)){
        $cObj = new $controller(self::$route);
        $action = lcfirst(self::upperCamelCase(self::$route['action'])) . 'Action';
        if(method_exists($cObj, $action)){
            $cObj->$action();
            $cObj->getView();
        }else{
            echo 'Метода ' . $action . ' не существует';
        }  
      }else{
        require_once WWW . '/' . 'public/404.html';
        die;
      } 
    }
    return false;
  }

  protected static function upperCamelCase($str){
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
  }

  protected static function removeQueryStr($url){
    if($url){
      $params = explode('&', $url, 2);
      if(false === strpos($params[0], '=')){
          return rtrim($params[0], '/');
      }else{
          return '';
      }  
    }
  }
}