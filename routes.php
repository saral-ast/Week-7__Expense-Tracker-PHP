<?php

$router->get('/','controllers/index.php');
$router->delete('/expense','controllers/expense/destroy.php');
$router->get('/groups','controllers/group/index.php');
$router->get('/expense','controllers/expense/index.php');
$router->get('/group','controllers/group/show.php');
$router->delete('/group','controllers/group/destroy.php');
$router->get('/group/edit','controllers/group/edit.php');
$router->get('/expense/edit','controllers/expense/edit.php');

$router->post('/groups','controllers/group/create.php');
$router->patch('/groups','controllers/group/update.php');
$router->post('/expense','controllers/expense/create.php');
$router->patch('/expenses','controllers/expense/update.php');

