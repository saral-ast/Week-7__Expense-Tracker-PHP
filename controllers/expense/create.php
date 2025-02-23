<?php
$config = require base_path('config.php');
$db = new Core\Database($config['database']);

// Fetch Group Name (Category)
$category = $db->query('SELECT group_name FROM groups WHERE id = :id', [
    'id' => $_POST['group_id']
])->findOrFail();

// Insert Expense
$db->query('INSERT INTO expenses (title, amount, group_id, date) 
            VALUES (:title, :amount, :group_id, DATE_FORMAT(:date, "%Y-%m-%d"))', [
    'title' => $_POST['title'],
    'amount' => $_POST['amount'],
    'group_id' => $_POST['group_id'],
    'date' => $_POST['date']
]);


// Redirect to Home
header('Location: /');
exit();
