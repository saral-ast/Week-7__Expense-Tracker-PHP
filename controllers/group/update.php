<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->query("UPDATE groups SET group_name = :name WHERE id = :id",[
    'name' => $_POST['groupName'],
    'id' => $_POST['id']
]);

header('Location: /');
exit();