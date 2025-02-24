<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Insert Expense
$db->select('INSERT INTO expenses (title, amount, group_id, date) 
            VALUES (:title, :amount, :group_id, DATE_FORMAT(:date, "%Y-%m-%d"))', [
    'title' => $_POST['title'],
    'amount' => $_POST['amount'],
    'group_id' => $_POST['group_id'],
    'date' => $_POST['date']
]);


// Redirect to Home
redirect('/');
