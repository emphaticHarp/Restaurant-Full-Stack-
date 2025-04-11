<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Check if 'id' parameter is set
if (isset($_GET['id'])) {
    $payment_id = intval($_GET['id']); // Sanitize and convert to integer

    // Prepare SQL statements to delete from order_items and payments
    $sql1 = "DELETE FROM order_items WHERE payment_id = ?";
    $sql2 = "DELETE FROM payments WHERE id = ?";

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare and execute the deletion queries
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $payment_id);
        $stmt1->execute();

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $payment_id);
        $stmt2->execute();

        // Commit transaction
        $conn->commit();

        // Redirect to the orders page
        header("Location: online_order.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close statements
    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>
