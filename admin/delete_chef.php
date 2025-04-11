<?php
// Include your database connection file
include '../login/connect.php';

// Check if 'id' is passed in the query string
if (isset($_GET['id'])) {
    $chefId = $_GET['id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM chefs WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $chefId); // 'i' denotes an integer
        if ($stmt->execute()) {
            // Check if a row was actually deleted
            if ($stmt->affected_rows > 0) {
                echo 'success';
            } else {
                echo 'error'; // No row found with the given ID
            }
        } else {
            echo 'error'; // Error during execution
        }
        $stmt->close();
    } else {
        echo 'error'; // Error preparing the statement
    }
} else {
    echo 'error'; // 'id' parameter not set
}

// Close the database connection
$conn->close();
?>
