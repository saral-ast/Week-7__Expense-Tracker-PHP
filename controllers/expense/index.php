<?php

$config = require base_path('config.php');
$db = new Core\Database($config['database']);

$groups = $db->query("SELECT id, group_name, DATE_FORMAT(created_at, '%d-%m-%Y') AS formatted_created_at FROM groups")->get();
view('expense/index.view.php',[
    'groups'=> $groups
]);

// header('Location: /');
// exit();