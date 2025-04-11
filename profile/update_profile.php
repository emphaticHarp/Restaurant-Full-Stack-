<?php
// Include your database connection file
include '../login/connect.php';

// Start the session
session_start();

// Assuming user ID is stored in session after login
$userId = $_SESSION['user_id'];

// Fetch the current profile data from the database
$sql = "SELECT profile_image, password FROM users WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($currentProfileImage, $currentPassword);
    $stmt->fetch();
    $stmt->close();
}

// Check if the user uploaded a new profile image
$profileImage = $currentProfileImage;
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
    $profileImage = '../images/' . basename($_FILES['profile_image']['name']);
    move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileImage);
}

// Get other profile details from the form
$username = $_POST['username'];
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];
$address = $_POST['address'];
$designation = $_POST['designation'];
$password = $_POST['password'];

// Handle password update (only if provided)
if (!empty($password)) {
    // Optionally, hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);
} else {
    $password = $currentPassword; // Keep the current password if no new one is provided
}

// Prepare the SQL query to update the profile details
$sql = "UPDATE users SET username = ?, email = ?, phone_number = ?, address = ?, designation = ?, profile_image = ?, password = ? WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssssssi", $username, $email, $phoneNumber, $address, $designation, $profileImage, $password, $userId);
    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect back to the profile page after successful update
        exit;
    } else {
        echo "Error updating profile.";
    }
    $stmt->close();
} else {
    echo "Database query error.";
}

$conn->close();
?>
