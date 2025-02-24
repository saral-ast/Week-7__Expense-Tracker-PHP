<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
// dd('sfsdf');
// dd($_POST);
$db->query("UPDATE groups SET group_name = :name WHERE id = :id",[
    'name' => $_POST['groupName'],
    'id' => $_POST['id']
]);

// $group = $db -> query("SELECT * FROM groups")->get();
// dd($group);

redirect('/');