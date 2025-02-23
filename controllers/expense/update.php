<?php
$config = require base_path('config.php');
$db = new Core\Database($config['database']);

// Debugging - Check posted data
dd($_POST);

// Update expense details
$db->query("UPDATE expenses 
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
