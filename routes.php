<?php

// Main pages
$router->get('/', 'controllers/index.php');

// Group Routes
$router->get('/groups', 'controllers/group/index.php'); // List all groups
$router->get('/group', 'controllers/group/show.php');  // Show a single group
$router->get('/group/edit', 'controllers/group/edit.php'); // Edit page
$router->post('/groups', 'controllers/group/create.php'); // Create a group
$router->patch('/groups', 'controllers/group/update.php'); // Update a group
$router->delete('/group', 'controllers/group/destroy.php'); // Delete a group

// Expense Routes
$router->get('/expense', 'controllers/expense/index.php'); // List all expenses
$router->get('/expense/edit', 'controllers/expense/edit.php'); // Edit expense page
$router->post('/expense', 'controllers/expense/create.php'); // Create an expense
$router->patch('/expenses', 'controllers/expense/update.php'); // Update an expense
$router->delete('/expense', 'controllers/expense/destroy.php'); // Delete an expense

// API Routes for AJAX Requests
$router->get('/api/groups', 'controllers/group/fetch.php'); // Fetch all groups
$router->get('/api/expenses', 'controllers/expense/fetch.php'); // Fetch all expenses
$router->get('/api/dashboard', 'controllers/dashboard.php'); // Fetch dashboard stats
