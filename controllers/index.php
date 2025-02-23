<?php
$config = require base_path('config.php');
$db = new Core\Database($config['database']);


$group_expenses = $db->query("
    SELECT g.id, g.group_name, 
           DATE_FORMAT(g.created_at, '%d-%m-%Y') AS formatted_created_at,
           COALESCE(SUM(e.amount), 0) AS total
    FROM groups g
    LEFT JOIN expenses e ON g.id = e.group_id
    GROUP BY g.id, g.group_name, g.created_at
")->get();
$expenses = $db->query('SELECT e.id, e.title, e.amount, e.date, g.group_name AS category 
                        FROM expenses e
                        JOIN groups g ON e.group_id = g.id
                        ORDER BY e.date DESC')->get();
// dd($expenses);

$sum = $db->query("SELECT SUM(amount) AS total FROM expenses")->findOrFail();
$max = $db->query("
    SELECT MAX(amount) AS total 
    FROM expenses 
    WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
    AND YEAR(date) = YEAR(CURRENT_DATE())
")->findOrFail();
$total = $db->query("
    SELECT SUM(amount) AS total 
    FROM expenses 
    WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
    AND YEAR(date) = YEAR(CURRENT_DATE())
")->findOrFail();
$group_total = $db->query("
    SELECT g.id AS group_id, COALESCE(SUM(e.amount), 0) AS total 
    FROM groups g
    LEFT JOIN expenses e ON g.id = e.group_id
    GROUP BY g.id
")->get();


view('index.view.php',[
    'groups'=> $group_expenses,
    'expenses'=> $expenses,
    'sum'=> floor($sum['total']),
    'max'=> floor($max['total']),
    'total'=> floor($total['total']),
]);