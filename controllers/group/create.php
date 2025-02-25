<?php
use Core\App;
use Core\Database;

header('Content-Type: application/json'); // Ensure JSON Response

$db = App::resolve(Database::class);

// Get Data from POST Request
$groupName = trim($_POST['group_name'] ?? '');

// Check if group already exists (case-insensitive)
$existingGroup = $db->query("SELECT id FROM groups WHERE LOWER(group_name) = LOWER(:name)", [
    'name' => $groupName
])->find();

if ($existingGroup) {
    echo json_encode(["success" => false, "error" => "Group name already exists."]);
    exit;
}

// Insert new group
$db->query("INSERT INTO groups (group_name) VALUES (:name)", [
    'name' => $groupName
]);

// Return success response
echo json_encode(["success" => true, "message" => "Group added successfully!"]);
exit;
