<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$groupExpenses = $db->select("
    SELECT g.id, g.group_name, 
           DATE_FORMAT(g.created_at, '%d-%m-%Y') AS formatted_created_at,
           COALESCE(SUM(e.amount), 0) AS total
    FROM groups g
    LEFT JOIN expenses e ON g.id = e.group_id
    GROUP BY g.id, g.group_name, g.created_at
")->get();
$expenses = $db->select('SELECT e.id, e.title, e.amount, e.date, g.group_name AS category 
                        FROM expenses e
                        JOIN groups g ON e.group_id = g.id
                        ORDER BY e.date DESC')->get();


$totalExpense = floor(array_sum(array_column($expenses,'amount')));

$currentMonth = date("Y-m"); // Get current month in "YYYY-MM" format

$currentMonthExpenses = array_map(fn($e) => 
                                    (substr($e["date"], 0, 7)) === $currentMonth ? $e['amount'] : 0, $expenses);

$totalCurrentMonth = array_sum($currentMonthExpenses);
$maxCurrentMonth = max($currentMonthExpenses);





// $sum = $db->query("SELECT SUM(amount) AS total FROM expenses")->findOrFail();
// $max = $db->query("
//     SELECT MAX(amount) AS total 
//     FROM expenses 
//     WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
//     AND YEAR(date) = YEAR(CURRENT_DATE())
// ")->findOrFail();
// $total = $db->query("
//     SELECT SUM(amount) AS total 
//     FROM expenses 
//     WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
//     AND YEAR(date) = YEAR(CURRENT_DATE())
// ")->findOrFail();
// $group_total = $db->query("
//     SELECT g.id AS group_id, COALESCE(SUM(e.amount), 0) AS total 
//     FROM groups g
//     LEFT JOIN expenses e ON g.id = e.group_id
//     GROUP BY g.id
// ")->get();


view('index.view.php',[
    'groups'=> $groupExpenses,
    'expenses'=> $expenses,
    'totalExpense'=> $totalExpense,
    'maxCurrentMonth'=> floor($maxCurrentMonth),
    'totalCurrentMonth'=> floor($totalCurrentMonth),
]);