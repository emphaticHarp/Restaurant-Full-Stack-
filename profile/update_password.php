<?php
// update_password.php
session_start();
header('Content-Type: application/json');

// Connect to your database
include '../login/connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$newPassword = $data['newPassword'];

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

$userId = $_SESSION['user_id']; // Assuming user_id is stored in session
$query = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
$query->bind_param('si', $hashedPassword, $userId);
if ($query->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
