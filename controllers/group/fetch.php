<?php

use Core\App;
use Core\Database;

 // Adjust path if needed

header('Content-Type: application/json'); // Ensure JSON response

try {
    $db = App::resolve(Database::class);

    $groups = $db->query("
    SELECT groups.id, 
           groups.group_name, 
           DATE_FORMAT(groups.created_at, '%Y-%m-%d') AS formatted_created_at, 
           COALESCE(SUM(expenses.amount), 0) AS total 
    FROM groups 
    LEFT JOIN expenses ON groups.id = expenses.group_id 
    GROUP BY groups.id, groups.group_name, groups.created_at
")->get();

    echo json_encode($groups);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

exit;
