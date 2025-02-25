<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure JSON response

$db = App::resolve(Database::class);

// Fetch total expense
$totalExpense = $db->query("SELECT SUM(amount) AS total FROM expenses")->find();
$totalExpense = $totalExpense['total'] ?? 0;

// Fetch total expense for the current month
$totalCurrentMonth = $db->query("SELECT SUM(amount) AS total FROM expenses WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())")->find();
$totalCurrentMonth = $totalCurrentMonth['total'] ?? 0;

// Fetch the highest spending expense in the current month
$maxCurrentMonth = $db->query("SELECT MAX(amount) AS max FROM expenses WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())")->find();
$maxCurrentMonth = $maxCurrentMonth['max'] ?? 0;

// Return JSON response
echo json_encode([
    "success" => true,
    "totalExpense" => floor($totalExpense),
    "totalCurrentMonth" => floor($totalCurrentMonth),
    "maxCurrentMonth" => floor($maxCurrentMonth)
]);
exit;
