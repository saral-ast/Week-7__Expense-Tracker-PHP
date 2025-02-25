<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure JSON Response

$db = App::resolve(Database::class);



// Insert Expense
$db->query('INSERT INTO expenses (title, amount, group_id, date) 
            VALUES (:title, :amount, :group_id, DATE_FORMAT(:date, "%Y-%m-%d"))', [
    'title' => $_POST['title'],
    'amount' => $_POST['amount'],
    'group_id' => $_POST['group_id'],
    'date' => $_POST['date']
]);

echo json_encode(["success" => true, "message" => "Expense added successfully!"]);
exit;
