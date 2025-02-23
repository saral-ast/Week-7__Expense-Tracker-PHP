<?php

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH. 'vendor/autoload.php';
require BASE_PATH. 'core/function.php';

$router = new Core\Router();
$routes = require base_path('routes.php');

// dd($config);
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method']??$_SERVER['REQUEST_METHOD'];
// dd($db);

$router->route($uri,$method);




