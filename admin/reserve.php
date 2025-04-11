<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

include '../login/connect.php';
include 'fetch_reservations.php'; // Include the script to fetch reservations and tables

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <section id="reservations">
            <h2>Customer Reservations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Members</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Created At</th>
                        <th>Table Number</th>
                        <th>Assignation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'fetch_reservations.php'; // Include the script to fetch reservations and tables

                    if ($reservations_result->num_rows > 0) {
                        while ($reservation = $reservations_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $reservation['id'] . "</td>";
                            echo "<td>" . $reservation['name'] . "</td>";
                            echo "<td>" . $reservation['email'] . "</td>";
                            echo "<td>" . $reservation['phone'] . "</td>";
                            echo "<td>" . $reservation['guests'] . "</td>";
                            echo "<td>" . $reservation['date'] . "</td>";
                            echo "<td>" . $reservation['time'] . "</td>";
                            echo "<td>" . $reservation['created_at'] . "</td>";
                            echo "<td>" . ($reservation['table_number'] ?? "Not Assigned") . "</td>";

                            // Separate column for the select dropdown
                            echo "<td>
                                    <form method='post' action=''>
                                        <select name='table_id' required>
                                            <option value=''>Select Table</option>";
                                            if ($tables_result->num_rows > 0) {
                                                while ($table = $tables_result->fetch_assoc()) {
                                                    echo "<option value='" . $table['id'] . "'>Table " . $table['table_number'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No tables available</option>";
                                            }
                            echo "      </select>
                                </td>";

                            // Separate column for the action buttons
                            echo "<td>
                                        <input type='hidden' name='reservation_id' value='" . $reservation['id'] . "'>
                                        <button type='submit' name='assign_table'>Assign</button>
                                    </form>
                                    <form method='post' action='delete_reservation.php' style='margin-top: 5px;'>
                                        <input type='hidden' name='reservation_id' value='" . $reservation['id'] . "'>
                                        <button type='submit' name='delete_reservation'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No reservations found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="script.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</body>

</html>

<?php
$conn->close();
?>
