<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->delete('DELETE FROM groups WHERE id = :id',[
    'id' => $_POST['id']
]);

header('Location: /');
exit();