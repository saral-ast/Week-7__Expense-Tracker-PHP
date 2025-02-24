<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->delete("DELETE FROM expenses WHERE id = :id",[
    'id' => $_POST['id']
]);

redirect('/');