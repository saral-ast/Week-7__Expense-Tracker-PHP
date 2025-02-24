<?php
use Core\App;
use Core\Container;
use Core\Database;
use Core\Session;
use Core\ValidationException;
const BASE_PATH = __DIR__ . '/../';
require BASE_PATH. 'vendor/autoload.php';
require BASE_PATH. 'core/function.php';


session_start();



$container = new Container();
$container ->bind('Core\Database', function(){
    $config = require base_path('config.php');

    return new Database($config['database']);

});
App::setContainer($container);



$router = new Core\Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method']??$_SERVER['REQUEST_METHOD'];





try{
    $router->route($uri,$method);
    Session::flush();
}catch(ValidationException $e){
   Session::put('name',$e->getErrors());
   Session::put('old',$e->getOld());
   return redirect($router->prevUrl());
}




