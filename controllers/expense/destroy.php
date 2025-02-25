<?php

use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure response is JSON

$db = App::resolve(Database::class);


// Retrieve ID from DELETE request
parse_str(file_get_contents("php://input"), $_DELETE);
$expenseId = $_DELETE['id'] ?? null;

if (!$expenseId) {
    echo json_encode(["success" => false, "error" => "Invalid expenseId."]);
    exit;
}

// Check if group exists
$exist = $db->query("SELECT id FROM expenses WHERE id = :id", ['id' => $expenseId])->find();

if (!$exist) {
    echo json_encode(["success" => false, "error" => "expenseId not found."]);
    exit;
}

// Delete group
$db->query("DELETE FROM expenses WHERE id = :id", ['id' => $expenseId]);

echo json_encode(["success" => true, "message" => "expense deleted successfully."]);
exit;
