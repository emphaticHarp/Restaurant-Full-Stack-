<?php
header('Content-Type: application/json');
include '../login/connect.php'; // Adjust the path as needed

// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data was properly decoded
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit();
}

// Extract data
$paymentMethod = isset($data['paymentMethod']) ? $data['paymentMethod'] : null;
$payerName = isset($data['payerName']) ? $data['payerName'] : null;
$payerAddress = isset($data['payerAddress']) ? $data['payerAddress'] : null;
$payerPhone = isset($data['payerPhone']) ? $data['payerPhone'] : null;
$upiId = isset($data['upiId']) ? $data['upiId'] : null;
$totalAmount = isset($data['totalAmount']) ? $data['totalAmount'] : null;
$cartItems = isset($data['cartItems']) ? $data['cartItems'] : null;

// Validate required fields
if (!$paymentMethod || !$payerName || !$payerAddress || !$payerPhone || !$totalAmount || !is_array($cartItems)) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid data']);
    exit();
}

// Debugging: Print the cart items to verify their structure
error_log(print_r($cartItems, true));

// Validate cart items and gather invalid items
$valid = true;
$invalidItems = [];
foreach ($cartItems as $index => $item) {
    if (!isset($item['id'], $item['name'], $item['price'], $item['quantity']) ||
        !is_numeric($item['id']) || !is_string($item['name']) || !is_numeric($item['price']) || !is_numeric($item['quantity'])) {
        $valid = false;
        $invalidItems[] = ['index' => $index, 'item' => $item];
    }
}

// Report invalid cart items
if (!$valid) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart item data', 'invalidItems' => $invalidItems]);
    exit();
}

// Prepare and execute the SQL statement for payments
$sql = "INSERT INTO payments (payment_method, payer_name, payer_address, payer_phone, upi_id, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssss', $paymentMethod, $payerName, $payerAddress, $payerPhone, $upiId, $totalAmount);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to insert payment data']);
    exit();
}

$paymentId = $stmt->insert_id; // Get the last inserted payment ID

$stmt->close();

// Prepare and execute the SQL statement for order items
$sql = "INSERT INTO order_items (payment_id, dish_id, dish_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($cartItems as $item) {
    $id = (int)$item['id']; // Ensure ID is an integer
    $name = $item['name'];
    $price = (float)$item['price']; // Ensure price is a float
    $quantity = (int)$item['quantity']; // Ensure quantity is an integer

    // Bind parameters: 'iissd' stands for int, int, string, string, double
    if (!$stmt->bind_param('iissd', $paymentId, $id, $name, $price, $quantity)) {
        echo json_encode(['success' => false, 'message' => 'Binding parameters failed']);
        exit();
    }

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert order item data']);
        exit();
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
?>
