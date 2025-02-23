<?php
// dd('group');
use Core\Validator;
$config = require base_path('config.php');
$db = new Core\Database($config['database']);
$groupName = $_POST['groupName'];

$errors = [];

if(!Validator::string($_POST['groupName'],7,50)){
    $errors['name'] = 'Group name is required and must be between 1 and 1000 characters';
}

$group = $db->query('SELECT * FROM groups WHERE group_name = :name',[
    'name' => $groupName
])->findOrFail();
if(empty($group)){
    $errors['name'] = 'Group name already exists';
}
// dd($errors);
if(!empty($errors)){
    // dd($errors);
    view('group/index.view.php',[
        'errors'=> $errors
    ]);
    exit();
    
}

$db->query('INSERT INTO groups (group_name) VALUES (:name)',[
    'name'=> $groupName
]);


header('Location: /');