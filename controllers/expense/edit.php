<?php

$config = require base_path('config.php');
$db = new Core\Database($config['database']);
$groups = $db->query('SELECT * FROM groups')->get();

$expense = $db->query('SELECT * FROM expenses WHERE id = :id',[
    'id' => $_GET['id']
])->findOrFail();

view('expense/edit.view.php',[
    'expense'=> $expense,
    'groups'=> $groups,
]);