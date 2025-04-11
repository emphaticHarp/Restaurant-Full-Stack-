<?php
session_start();

// Debugging output
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = 'localhost';
$db = 'restaurant';
$user = 'root';
$pass = '';

// Establishing a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed.'
    ]);
    exit();
}

// Retrieve the logged-in user's ID
$userId = $_SESSION['user_id'];

function checkCurrentPassword($pdo, $userId, $currentPassword) {
    $sql = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    return $currentPassword === $user['password'];
}

function updatePassword($pdo, $userId, $newPassword) {
    $sql = "UPDATE users SET password = :new_password WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':new_password', $newPassword, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    return $stmt->execute();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['currentPassword'])) {
    // Handle password checking
    $currentPassword = $data['currentPassword'] ?? '';

    if (checkCurrentPassword($pdo, $userId, $currentPassword)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Current password is correct.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Current password is incorrect.'
        ]);
    }
} elseif (isset($data['newPassword'])) {
    // Handle password updating
    $newPassword = $data['newPassword'] ?? '';

    if (updatePassword($pdo, $userId, $newPassword)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Password updated successfully!'
            
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update password. Please try again later.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
}
?>
