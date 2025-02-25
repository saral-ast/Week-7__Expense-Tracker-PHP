<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); 
$db = App::resolve(Database::class);

$expense = $db->select('SELECT * FROM expenses WHERE id = :id',[
    'id' => $_GET['id']
])->findOrFail();

$groups = $db->select('SELECT * FROM groups')->get();

echo json_encode($expense);