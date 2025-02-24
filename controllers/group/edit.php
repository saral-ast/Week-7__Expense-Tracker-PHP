<?php
use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);
$group = $db->query('SELECT * FROM groups WHERE id = :id',[
    'id' => $_GET['id']?? 0,
])->findOrFail();
// dd($name);

view('group/edit.view.php',[
    'group'=> $group,
    'errors' => Session::get('name'),
]);