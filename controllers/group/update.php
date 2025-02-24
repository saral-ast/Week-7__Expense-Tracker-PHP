<?php
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


$db->query("UPDATE groups SET group_name = :name WHERE id = :id",[
    'name' => $_POST['groupName'],
    'id' => $_POST['id']
]);



redirect('/');