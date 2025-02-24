<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$groups = $db->select("SELECT id, group_name, DATE_FORMAT(created_at, '%d-%m-%Y') AS formatted_created_at FROM groups")
        ->get();
view('expense/index.view.php',[
    'groups'=> $groups
]);
