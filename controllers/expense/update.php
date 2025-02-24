<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$db->update("UPDATE expenses 
            SET title = :title, 
                amount = :amount,  
                group_id = :group_id, 
                date = :date 
            WHERE id = :id", [
    'title'    => $_POST['title'],
    'amount'   => $_POST['amount'],
    'group_id' => $_POST['group_id'],
    'date'     => $_POST['date'],
    'id'       => $_POST['id']
]);

// Redirect after update
header('Location: /');
exit();
