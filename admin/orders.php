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
    <section id="orders">
    <h2>Current Orders</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Table Number</th>
                <th>Orders</th>
                <th>Quantity</th>
                <th>Food Requirements</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include your database connection
include '../login/connect.php';;

// Query to fetch orders
$query = "SELECT id, table_number, orders, quantity, food_requirements, is_occupied FROM restaurant_tables WHERE is_occupied = 1";
$orders_result = $conn->query($query);

if (!$orders_result) {
    die("Query failed: " . $conn->error);
}

            if ($orders_result->num_rows > 0) {
                while ($order = $orders_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $order['id'] . "</td>";
                    echo "<td>Table " . $order['table_number'] . "</td>";
                    echo "<td>" . $order['orders'] . "</td>";
                    echo "<td>" . $order['quantity'] . "</td>";
                    echo "<td>" . $order['food_requirements'] . "</td>";

                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='order_id' value='" . $order['id'] . "'>
                                <button type='submit' name='mark_prepared' class='action-button'>Mark as Prepared</button>
                            </form>
                          </td>
                          <td> <button type='submit' name='delete_order' class='action-button delete-order'>Delete</button></td>
                          ";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php
// Handle Mark as Prepared
if (isset($_POST['mark_prepared'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE restaurant_tables SET is_occupied = 0 WHERE id = $order_id";
    $conn->query($update_query);
}

// Handle Delete Order
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $delete_query = "DELETE FROM restaurant_tables WHERE id = $order_id";
    $conn->query($delete_query);
}
?>



    </main>

    <script src="script.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

</body>

</html>

<?php
$conn->close();
?>