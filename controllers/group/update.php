<?php

// dd($_POST);
$config = require base_path('config.php');
$db = new Core\Database($config['database']);

$db->query("UPDATE groups SET group_name = :name WHERE id = :id",[
    'name' => $_POST['groupName'],
    'id' => $_POST['id']
]);

header('Location: /');
exit();