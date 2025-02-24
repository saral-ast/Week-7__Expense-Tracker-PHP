<?php

use Core\App;
use Core\Database;
// dd("sfsd");

$db = App::resolve(Database::class);
$db->query('DELETE FROM groups WHERE id = :id',[
    'id' => $_POST['id']
]);




header('Location: /');
exit();