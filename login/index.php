<?php
session_start();
include 'connect.php'; // Make sure this file connects to your MySQL database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username (or email) and password from the POST request
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to find the user based on username or email
    $sql = "SELECT id, username, email, password FROM users WHERE username = '$username' OR email = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the entered password matches the stored password
        if ($password == $row['password']) {
            // If the password is correct, create a session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../admin/index.php"); // Redirect to the admin page
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that username or email.";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <img src="../images/logo.png" alt="Restaurant Logo">
        </div>
        <div class="login-section">
            <h2>Chef Admin Login</h2>
            <form id="loginForm" action="index.php" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
