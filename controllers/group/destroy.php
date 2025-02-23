<?php

$config = require base_path('config.php');
$db = new Core\Database($config['database']);

$db->query('DELETE FROM groups WHERE id = :id',[
    'id' => $_POST['id']
]);

header('Location: /');
exit();