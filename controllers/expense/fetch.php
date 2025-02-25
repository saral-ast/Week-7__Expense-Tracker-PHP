<?php

use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure JSON response

try {
    $db = App::resolve(Database::class);

    $expenses = $db->query("
        SELECT expenses.id AS expense_id, 
               expenses.title, 
               expenses.amount, 
               DATE_FORMAT(expenses.date, '%Y-%m-%d') AS date, 
               groups.group_name  AS category
        FROM expenses 
        JOIN groups ON expenses.group_id = groups.id
    ")->get();

    echo json_encode($expenses);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

exit;
