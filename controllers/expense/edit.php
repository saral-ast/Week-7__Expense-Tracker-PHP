<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$groups = $db->select('SELECT * FROM groups')->get();

$expense = $db->select('SELECT * FROM expenses WHERE id = :id',[
    'id' => $_GET['id']
])->findOrFail();

view('expense/edit.view.php',[
    'expense'=> $expense,
    'groups'=> $groups,
]);