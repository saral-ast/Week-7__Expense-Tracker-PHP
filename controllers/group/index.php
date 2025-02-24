<?php
use Core\Session;

view('group/index.view.php',[
    'errors' => Session::get('name'),
    // dd($errors)
]);