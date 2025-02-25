<?php

use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure response is JSON

$db = App::resolve(Database::class);

// Retrieve ID from DELETE request
parse_str(file_get_contents("php://input"), $_DELETE);
$groupId = $_DELETE['id'] ?? null;

if (!$groupId) {
    echo json_encode(["success" => false, "error" => "Invalid group ID."]);
    exit;
}

// Check if group exists
$existingGroup = $db->query("SELECT id FROM groups WHERE id = :id", ['id' => $groupId])->find();

if (!$existingGroup) {
    echo json_encode(["success" => false, "error" => "Group not found."]);
    exit;
}

// Delete group
$db->query("DELETE FROM groups WHERE id = :id", ['id' => $groupId]);

echo json_encode(["success" => true, "message" => "Group deleted successfully."]);
exit;
