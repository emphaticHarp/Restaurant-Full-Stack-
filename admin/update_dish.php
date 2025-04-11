<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Handle Edit Dish
if (isset($_POST['dish_id'])) {
    $dish_id = $_POST['dish_id'];
    $dish_name = $_POST['dish_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Initialize an empty variable for the image path
    $imagePath = '';

    // Check if a new image is being uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageFileName = basename($_FILES['image']['name']);
        $targetDir = '../images/';  // Path where the image will be saved
        $targetFilePath = $targetDir . $imageFileName;

        // Validate file type and size
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        if (in_array($fileType, $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            // Check if the directory exists, if not, create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Store the relative path in the database
                $imagePath = $targetDir . $imageFileName;
            } else {
                echo "Error: There was a problem uploading the image.";
                exit();
            }
        } else {
            echo "Error: Invalid file type or file size exceeds 2MB.";
            exit();
        }
    }

    // Prepare SQL query for updating the dish
    $update_query = "UPDATE dishes SET 
                     name = ?, 
                     category = ?, 
                     description = ?, 
                     price = ?, 
                     image = ? 
                     WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($update_query);
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('sssssi', $dish_name, $category, $description, $price, $imagePath, $dish_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the dishes page or display success message
            header("Location: dish.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
