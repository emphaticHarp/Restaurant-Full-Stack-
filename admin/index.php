<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script type="module" src="notification-component.js" defer></script>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="../images/logo.png" alt="Restaurant Logo">
                <h1>Welcome <?php echo $_SESSION['username']; ?> </h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="dish.php">Dishes</a></li>
                <li><a href="online_order.php">Online Orders</a></li>
                <li><a href="chefs.php">Chefs</a></li>
                <li><a href="reserve.php">Reservations</a></li>
                <!-- Profile Section -->
                <li class="profile-dropdown">
                    <a href="#"><?php echo $_SESSION['username']; ?><span class="arrow">&#9662;</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../profile/index.php"><i class="bi bi-person-fill"></i> Profile Details</a></li>
                        <li><a href="../profile/password.php"><i class="bi bi-key-fill"></i> Change Password</a></li>
                        <li><a href="#contact-support"><i class="bi bi-telephone-plus-fill"></i> Contact Support</a></li>
                        <li><a href="../settings/index.php"><i class="bi bi-tools"></i> Settings</a></li>
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

    <main>
        <?php
        include '../login/connect.php'; // Make sure to include your database connection

        $sql = "SELECT * FROM restaurant_tables";
        $result = $conn->query($sql);
        ?>

        <section id="home">
            <h2>Welcome <?php echo $_SESSION['username']; ?></h2>
            <p>Manage your restaurant efficiently and effectively.</p>
        </section>
        
        <h2>Restaurant Table Status</h2>
        <div class="table-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = $row['is_occupied'] ? 'Occupied' : 'Free';
                    $statusClass = $row['is_occupied'] ? 'occupied' : 'free';
                    $orders = $row['is_occupied'] ? $row['orders'] : 'No orders';
                    $requirements = $row['food_requirements'] ? $row['food_requirements'] : 'None';
                    $showUpdateButton = $row['is_occupied'] ? true : false; // Determine if update button should be shown
            ?>
                    <div class="table-card">
                        <h3>Table : <?php echo $row['table_number']; ?></h3>
                        <p>Status: <span class="status <?php echo $statusClass; ?>"><?php echo $status; ?></span></p>
                        <p>Orders: <?php echo $orders; ?></p>
                        <p class="requirement">Requirements: <?php echo $requirements; ?></p>

                        <?php if ($showUpdateButton) { ?>
                            <button type="submit"  data-table-id="<?php echo $row['table_number']; ?>" class="update-btn" name="update"><i class="bi bi-emoji-smile"></i> Ordered</button>
                        <?php } ?>
                    </div>
            <?php
                }
            } else {
                echo "<p>No tables found.</p>";
            }
            ?>
        </div>

        <!-- Notifications Section -->
        <div id="notifications-container">
            <!-- Notifications will be dynamically inserted here -->
        </div>
    </main>

    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
  
    <script src="script.js"></script>
</body>

</html>

<?php
$conn->close();
?>
