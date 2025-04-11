<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $experience = $_POST['experience'];
    $specialty_dish = $_POST['specialty_dish'];
    $status = $_POST['status'];
    $date_of_joining = $_POST['date_of_joining'];
    $more_details = $_POST['more_details'];

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $target_dir = "../images/";
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO chefs (name, experience, specialty_dish, status, date_of_joining, more_details, photo_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $name, $experience, $specialty_dish, $status, $date_of_joining, $more_details, $target_file);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: chefs.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
