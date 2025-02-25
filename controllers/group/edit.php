<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); 

$db = App::resolve(Database::class);
$group = $db->query('SELECT * FROM groups WHERE id = :id',[
    'id' => $_GET['id']?? 0,
])->findOrFail();
// dd($name);

echo json_encode($group);