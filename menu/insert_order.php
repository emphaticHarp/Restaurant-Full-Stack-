<?php
// Database configuration
$host = 'localhost';
$dbname = 'restaurant'; // Replace with your database name
$user = 'root';   // Replace with your database username
$pass = ''; // Replace with your database password

// Create connection
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get POST data
$tableNumber = $_POST['tableNumber'] ?? '';
$orderDetails = $_POST['orderDetails'] ?? '';
$foodRequirements = $_POST['foodRequirements'] ?? '';

if (empty($tableNumber)) {
    echo json_encode(['status' => 'error', 'message' => 'Table number is required.']);
    exit;
}

try {
    // Check if the table number exists
    $stmt = $pdo->prepare('SELECT id FROM restaurant_tables WHERE table_number = :tableNumber');
    $stmt->execute(['tableNumber' => $tableNumber]);
    $table = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$table) {
        echo json_encode(['status' => 'error', 'message' => 'Table number not found.']);
        exit;
    }

    // Update the table with order details
    $stmt = $pdo->prepare('
        UPDATE restaurant_tables 
        SET orders = :orders, food_requirements = :foodRequirements, is_occupied = TRUE 
        WHERE table_number = :tableNumber
    ');
    $stmt->execute([
        'orders' => $orderDetails,
        'foodRequirements' => $foodRequirements,
        'tableNumber' => $tableNumber
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
