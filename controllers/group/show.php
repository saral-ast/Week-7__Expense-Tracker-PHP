<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$group = $db->select("SELECT * FROM groups WHERE id = :id", ['id' => $_GET['id']])->findOrFail();


$expenses = $db->select("SELECT id, title, amount, DATE_FORMAT(date, '%d-%m-%Y') AS formatted_date FROM expenses where group_id = :id",[
    'id' => $_GET['id']
])->get();

$totalExpense = array_sum(array_column($expenses,'amount'));



view('group/show.view.php',[
    'expenses'=> $expenses,
    'total'=> $totalExpense
]);