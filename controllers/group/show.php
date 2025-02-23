<?php
// dd('sdfsdf');
// dd($_GET['id']);
$config = require base_path('config.php');
$db = new Core\Database($config['database']);
$expenses = $db->query("SELECT id, title, amount, DATE_FORMAT(date, '%d-%m-%Y') AS formatted_date FROM expenses where group_id = :id",[
    'id' => $_GET['id']
])->get();
// dd($expenses);


view('group/show.view.php',[
    'expenses'=> $expenses
]);