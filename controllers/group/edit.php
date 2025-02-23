<?php

// dd($_GET['id']);
$config = require base_path('config.php');
$db = new Core\Database($config['database']);
$group = $db->query('SELECT * FROM groups WHERE id = :id',[
    'id' => $_GET['id']
])->findOrFail();
// dd($name);

view('group/edit.view.php',[
    'group'=> $group
]);