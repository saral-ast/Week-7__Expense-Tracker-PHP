<?php
function dd($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}
function view($path,$attributes = []){
    extract($attributes);
    require base_path("view/{$path}");
}

function base_path($path){
    return BASE_PATH . $path;
}

function abort($code = 404){
    http_response_code($code);
    require base_path("view/{$code}.php");
    die();
}

function redirect($path){
    header("Location: {$path}");
    exit();
}

function old($key,$default = ''){
    return Core\Session::get('old')[ $key ] ?? $default;
}