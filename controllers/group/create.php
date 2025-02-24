<?php
// dd('group');
use Core\App;
use Core\Database;
use Form\Group;

$db = App::resolve(Database::class);

$groupName = trim($_POST['groupName']);

$hasGroup = (new Group($attribute = [
    'groupName'=> $groupName
]))->validate();
// dd($hasGroup);
if($hasGroup){
    $hasGroup -> setErrors('name','Group name already exist')
              -> throw();
}

//if already exist than it means it throw an exception

$db->insert('INSERT INTO groups (group_name) VALUES (:name)',[
    'name'=> $groupName
]);

redirect('/');