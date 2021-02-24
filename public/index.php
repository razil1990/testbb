<?php
error_reporting(0);
session_start();
require '../vendor/functions.php';
define('WWW', dirname(__DIR__));
$query = rtrim($_SERVER['QUERY_STRING'], '/');
spl_autoload_register(function ($class) {
    $file = WWW . '/' . str_replace('\\', '/', $class) . '.php';
    if(is_file($file)){
        require_once $file;
    }
});
\vendor\core\Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
\vendor\core\Router::add('(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
\vendor\core\Router::dispatch($query);


