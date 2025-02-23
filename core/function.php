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
