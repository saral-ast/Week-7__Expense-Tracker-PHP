<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Get JSON Data
$data = json_decode(file_get_contents('php://input'), true);

$groupName = trim($data['name']);
$groupId = $data['id'] ?? null;

if (!$groupId) {
    echo json_encode(['success' => false, 'message' => 'Invalid request: Missing group ID']);
    exit;
}

// Validate group name uniqueness
$existingGroup = $db->query("SELECT * FROM groups WHERE group_name = :name AND id != :id", [
    'name' => $groupName,
    'id' => $groupId
])->find();

if ($existingGroup) {
    echo json_encode(['success' => false, 'message' => 'Group name already exists']);
    exit;
}

// Update the group in the database
$db->query("UPDATE groups SET group_name = :name WHERE id = :id", [
    'name' => $groupName,
    'id' => $groupId
]);

echo json_encode(['success' => true, 'message' => 'Group updated successfully']);
exit;
