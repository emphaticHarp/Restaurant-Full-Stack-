<?php
include '../login/connect.php'; // Make sure to include your database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the table number from POST data
    $tableNumber = isset($_POST['table_number']) ? intval($_POST['table_number']) : 0;
    
    if ($tableNumber) {
        // Prepare the SQL statement to reset the table data
        $stmt = $conn->prepare("UPDATE restaurant_tables SET is_occupied = 0, orders = '', food_requirements = '' WHERE table_number = ?");
        $stmt->bind_param('i', $tableNumber);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Table data reset successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to reset table data.'];
        }

        $stmt->close();
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid table number.'];
    }

    $conn->close();
    echo json_encode($response);
    exit();
}
?>
