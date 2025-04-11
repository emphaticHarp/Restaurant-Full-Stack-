<?php
include '../login/connect.php'; // Include your database connection

// Fetch distinct categories from the dishes table
$query = "SELECT DISTINCT category FROM dishes";
$result = $conn->query($query);
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    // Proceed if the query is successful
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu</title>
    <link rel="stylesheet" href="style.css" class="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <nav class="navbar">
        <div class="logo">Restaurant</div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="index.php" class="active">Menu</a></li>
            <li><a href="../order/index.php">Order Online</a></li>

            <li><a href="../about/index.php">About</a></li>

            <li><a href="../contact/index.php">Contact</a></li>
        </ul>

        <div class="auth-buttons">
            <button class="cart-btn" id="cart-button"><i class="bi bi-cart4"></i>Cart</button>
        </div>


    </nav>


    <section id="food-groups" class="container">
        <h2>Our Menu</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="food-group" onclick="showItems('<?php echo strtolower($row['category']); ?>')">
    <?php echo ucfirst($row['category']); ?>
</div>

        <?php endwhile; ?>
        
    </section>

    <section id="menu-details" class="container">

        <!-- Food items will be dynamically inserted here -->
    </section>


    <!-- Modal -->
    <!-- Modal -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Order Summary</h2>
            </div>
            <div class="modal-body">
                <ul id="orderList">
                    <!-- Order items will be dynamically inserted here -->
                </ul>
                <div class="table-number-wrapper">
                    <label for="table-number">Table Number:</label>
                    <input type="text" id="table-number" placeholder="Enter table number">
                </div>
                <div class="table-number-wrapper">
                    <label for="food-requirements">Requirements:</label>
                    <input type="text" id="food-requirements" placeholder="Any additional Requirements? ">
                </div>
            </div>
            <div class="modal-footer">
                <div class="payment-breakdown">
                    <div>
                        <span class="total-price">Subtotal:</span>
                        <span class="total-price">$0.00</span>
                    </div>
                    <div>
                        <span class="gst">GST (10%):</span>
                        <span class="gst">$0.00</span>
                    </div>
                    <div>
                        <span class="grand-total">Total:</span>
                        <span class="grand-total">$0.00</span>
                    </div>
                </div>
                <button class="payment-btn" id="submitOrder">Make Payment ($0.00)</button>
            </div>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>