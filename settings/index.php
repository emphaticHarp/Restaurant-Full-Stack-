<?php
// Include your database connection file
include '../login/connect.php';

// Start the session if you are using sessions to manage user login
session_start();

// Assuming user ID is stored in session after login

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$userId = $_SESSION['user_id']; // Assign the user_id from session


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
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
                        <li><a href="password.php"><i class="bi bi-key-fill"></i> Change Password</a></li>
                        <li><a href="#contact-support"><i class="bi bi-telephone-plus-fill"></i> Contact Support</a></li>
                        <li><a href="../settings/index.php"><i class="bi bi-geo-alt-fill"></i> Settings</a></li>
                        <li><a href="../login/logout.php"><i class="bi bi-box-arrow-left"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>


    <div id="loading-screen">
        <dotlottie-player
            src="https://lottie.host/afe18fee-b7ce-41c1-8095-0bf5b26a4609/5eK6cRjZsV.json"
            background="transparent"
            speed="1"
            style="width: 300px; height: 300px;"
            loop
            autoplay>
        </dotlottie-player>
    </div>

    <main class="settings-page">
        <section class="settings-section">
            <h2>General Settings</h2>
            <div class="settings-options">
                <!-- Shut down website -->
                <!-- The slider button to toggle the shutdown state -->
                <label class="switch">
                    <input type="checkbox" id="shutdownToggle">
                    <span class="slider round"></span>
                    <span id="toggleLabel">Shut Down Webpage</span>
                </label>

                <!-- Clear data -->
                <button class="settings-btn clear-data-btn">
                    <i class="bi bi-trash"></i> Clear All Data
                </button>

                <!-- View database tables -->
                <a href="view_tables.php" class="settings-btn view-tables">
                    <i class="bi bi-database"></i> View Database Tables
                </a>

                <!-- Change terms & conditions -->
                <button class="settings-btn terms-btn" onclick="window.location.href='change_terms.php'">
                    <i class="bi bi-file-earmark-text"></i> Change Terms & Conditions
                </button>

                <!-- Add SOS -->
                <button class="settings-btn sos-btn" id="saveBackupBtn">
                    <i class="bi bi-exclamation-triangle"></i> Emergency Backup
                </button>

                <!-- Toggle dark/light mode -->
                <button class="settings-btn toggle-mode-btn" id="toggle-dark-mode">
                    <i class="bi bi-moon"></i>
                </button>
            </div>
        </section>

        <section class="event-section">
            <h2>Event Management</h2>
            <div class="settings-options">
                <!-- Add events -->
                <button class="settings-btn add-event-btn" >
                    <i class="bi bi-calendar-event"></i> Add Events
                </button>

                <!-- Manage offers -->
                <button class="settings-btn manage-offers-btn" onclick="window.location.href='manage_offers.php'">
                    <i class="bi bi-tags"></i> Manage Offers
                </button>
            </div>
        </section>

        <section class="sos-section">
            <h2>Emergency Settings</h2>
            <div class="settings-options">
                <!-- Emergency shutdown -->
                <button class="settings-btn emergency-shutdown-btn">
                    <i class="bi bi-shield-exclamation"></i> Emergency Shut Down
                </button>

                <!-- Clear all data -->
                <button class="settings-btn emergency-clear-btn">
                    <i class="bi bi-trash-fill"></i> Emergency Clear Data
                </button>
            </div>
        </section>
    </main>


    <footer>
        <p>© 2024 Restaurant Management System</p>
    </footer>

    <!-- JavaScript for Dark/Light Mode Toggle -->
    <script src="script.js"></script>
</body>

</html>