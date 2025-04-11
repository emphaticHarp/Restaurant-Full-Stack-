<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Retrieve messages
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="../images/logo.png" alt="Restaurant Logo">
                <h1>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?> </h1>
            </div>
            <ul class="nav-links">
                <li><a href="../admin/index.php">Home</a></li>
                <li><a href="../admin/orders.php">Orders</a></li>
                <li><a href="../admin/dish.php">Dishes</a></li>
                <li><a href="../admin/online_order.php">Online Orders</a></li>
                <li><a href="../admin/chefs.php">Chefs</a></li>
                <li><a href="../admin/reserve.php">Reservations</a></li>
                <li class="profile-dropdown">
                    <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?><span class="arrow">&#9662;</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php"><i class="bi bi-person-fill"></i> Profile Details</a></li>
                        <li><a href="#change-password"><i class="bi bi-key-fill"></i> Change Password</a></li>
                        <li><a href="#contact-support"><i class="bi bi-telephone-plus-fill"></i> Contact Support</a></li>
                        <li><a href="#map"><i class="bi bi-geo-alt-fill"></i> Map</a></li>
                        <li><a href="../login/logout.php"><i class="bi bi-box-arrow-left"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

   

    <main>
    <div class="password-page-wrapper">
        <div class="password-container">
            <div class="password-header">Change Password</div>
            <form id="password-form">
                <div class="password-field">
                    <label for="current-password" class="password-label">Current Password</label>
                    <input type="password" id="current-password" class="password-input" required>
                </div>
                <button type="button" id="check-password" class="password-button">Check</button>
                
                <div id="new-password-fields" style="display: none;">
                    <div class="password-field">
                        <label for="new-password" class="password-label">New Password</label>
                        <input type="password" id="new-password" class="password-input" required>
                    </div>
                    <button type="button" id="update-password" class="password-button">Update Password</button>
                </div>
            </form>
        </div>
    </div>

     <!-- Error Modal -->
     <div id="error-modal" class="custom-modal error-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close" id="close-error-modal">&times;</span>
            <p id="error-message">Current password is incorrect.</p>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="custom-modal success-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close" id="close-success-modal">&times;</span>
            <p>Password updated successfully!</p>
        </div>
    </div>

       

        <script src="script.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    </main>

</body>

</html>
