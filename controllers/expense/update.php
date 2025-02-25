<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Set response type to JSON

$db = App::resolve(Database::class);

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Validate if required fields exist
if (!isset($data['id'], $data['title'], $data['amount'], $data['group_id'], $data['date'])) {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
    exit;
}

$id = $data['id'];
$title = $data['title'];
$amount = $data['amount'];
$group_id = $data['group_id'];
$date = $data['date'];

// Update the expense record
$updated = $db->query(
    "UPDATE expenses 
     SET title = :title, 
         amount = :amount,  
         group_id = :group_id, 
         date = :date 
     WHERE id = :id",
    [
        'title'    => $title,
        'amount'   => $amount,
        'group_id' => $group_id,
        'date'     => $date,
        'id'       => $id
    ]
);

if ($updated) {
    echo json_encode(["success" => true, "message" => "Expense updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "No changes were made"]);
}

exit;
