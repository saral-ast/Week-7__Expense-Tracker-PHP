<?php
// dd('delete');
$config = require base_path('config.php');
$db = new Core\Database($config['database']);

$db->query("DELETE FROM expenses WHERE id = :id",[
    'id' => $_POST['id']
]);
header('Location: /');
exit();