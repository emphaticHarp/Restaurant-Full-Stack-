<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Fetch orders from the database
$sql = "
SELECT 
    payments.id AS payment_id,
    payments.payer_name,
    payments.payer_address,
    payments.payer_phone,
    payments.payment_method,
    payments.total_amount,
    order_items.dish_id,
    order_items.dish_name,
    order_items.quantity,
    order_items.price
FROM 
    payments
JOIN 
    order_items ON payments.id = order_items.payment_id
ORDER BY 
    payments.id DESC
";
$result = $conn->query($sql);

// To keep track of the previous order ID
$previousOrderId = null;
$rowspanCount = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Orders</title>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="dish.php">Dishes</a></li>
                <li><a href="online_order.php">Online Orders</a></li>
                <li><a href="chefs.php">Chefs</a></li>

                <li><a href="reserve.php">Reservations</a></li>
                <li class="profile-dropdown">
                    <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?><span class="arrow">&#9662;</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#profile-details"><i class="bi bi-person-fill"></i> Profile Details</a></li>
                        <li><a href="#change-password"><i class="bi bi-key-fill"></i> Change Password</a></li>
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
        <h1>Customer Orders</h1>
        <table border="1" class="order-table">
            <thead>
                <tr>
                    <th class="order-table-header">Order ID</th>
                    <th class="order-table-header">Customer Name</th>
                    <th class="order-table-header">Address</th>
                    <th class="order-table-header">Phone No.</th>
                    <th class="order-table-header">Payment Method</th>
                    <th class="order-table-header">Total Amount</th>
                    <th class="order-table-header">Dish</th>
                    <th class="order-table-header">Quantity</th>
                    <th class="order-table-header">Price</th>
                    <th class="order-table-header">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($previousOrderId !== $row['payment_id']) {
                            $rowspanQuery = "SELECT COUNT(*) as item_count FROM order_items WHERE payment_id = " . $row['payment_id'];
                            $rowspanResult = $conn->query($rowspanQuery);
                            $rowspanData = $rowspanResult->fetch_assoc();
                            $rowspanCount = $rowspanData['item_count'];

                            echo "<tr class='order-table-row'>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>" . htmlspecialchars($row['payment_id']) . "</td>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>" . htmlspecialchars($row['payer_name']) . "</td>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>" . htmlspecialchars($row['payer_address']) . "</td>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>" . htmlspecialchars($row['payer_phone']) . "</td>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>" . htmlspecialchars($row['payment_method']) . "</td>";
                            echo "<td class='order-table-cell' rowspan='" . $rowspanCount . "'>$" . htmlspecialchars($row['total_amount']) . "</td>";
                        }

                        echo "<td class='order-table-cell'>" . htmlspecialchars($row['dish_name']) . "</td>";
                        echo "<td class='order-table-cell'>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td class='order-table-cell'>$" . htmlspecialchars($row['price']) . "</td>";
                        echo "<td class='order-table-cell'><a href='delete_order.php?id=" . htmlspecialchars($row['payment_id']) . "' class='delete-button12'><i class='bi bi-trash3-fill'></i></a></td>";
                        echo "</tr>";

                        $previousOrderId = $row['payment_id'];
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Delay to keep the loading screen visible for 1-2 seconds
    setTimeout(function() {
        document.body.classList.add('loaded');
    }, 1000); // Adjust the delay as needed (2000 milliseconds = 2 seconds)
});

   </script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</body>

</html>

<?php
$conn->close();
?>
