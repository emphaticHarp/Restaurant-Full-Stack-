<?php
include '../login/connect.php'; // Connect to the database
session_start(); // Start the session to use session variables like user ID

// Fetch all available dishes from the database, ordered by category
$query = "SELECT id, name, description, price, image, category FROM dishes ORDER BY category";
$result = $conn->query($query);

// Initialize an array to store dishes grouped by category
$dishes_by_category = [];

while ($row = $result->fetch_assoc()) {
    $dishes_by_category[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">Restaurant</div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../menu/index.php">Menu</a></li>
            <li><a href="../order/index.php" class="active">Order Online</a></li>
            <li><a href="../about/index.php">About</a></li>
            <li><a href="../contact/index.php">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <button class="cart-btn" id="cart-btn"><i class="bi bi-cart4"></i>Cart</button>
        </div>
    </nav>

    <main>
        <h1>Available Dishes</h1>
        <!-- Loop through each category -->
        <?php foreach ($dishes_by_category as $category => $dishes): ?>
            <div class="category-section">
                <h3 class="category-title"><?php echo ucfirst($category); ?></h3>
                <div class="dish-container">
                    <?php foreach ($dishes as $dish): ?>
                        <div class="dish-item">
                            <img src="../images/<?php echo $dish['image']; ?>" alt="<?php echo $dish['name']; ?>">
                            <h3><?php echo $dish['name']; ?></h3>
                            <p><?php echo $dish['description']; ?></p>
                            <p>Price: $<?php echo $dish['price']; ?></p>

                            <form class="dish-form" data-dish-price="<?php echo $dish['price']; ?>">
                                <input type="hidden" name="dish_id" value="<?php echo $dish['id']; ?>">
                                <label for="quantity_<?php echo $dish['id']; ?>">Quantity:</label>
                                <div class="quantity-control">
                                    <button type="button" class="decrease-btn">-</button>
                                    <input type="number" id="quantity_<?php echo $dish['id']; ?>" name="quantity" value="1" min="1" required>
                                    <button type="button" class="increase-btn">+</button>
                                </div>
                                <button type="button" class="add-to-cart-btn" data-dish-id="<?php echo $dish['id']; ?>">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <!-- Cart Modal -->
    <div id="cart-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Cart</h2>
            <div id="cart-items"></div>
            <div id="cart-summary">
                <p>Subtotal: $<span id="subtotal">0</span></p>
                <p>GST (10%): $<span id="gst">0</span></p>
                <p>Delivery Charges: $<span id="delivery-charges">50</span></p>
                <p>Total: $<span id="total">50</span></p>
                <label for="referral-code">Referral Code (Optional):</label>
                <input type="text" id="referral-code">
                <button id="order-now">Order Now</button>
            </div>
        </div>
    </div>


    <!-- Payment Modal -->
    <div id="payment-modal" class="payment-modal">
        <div class="payment-content1">
            <span class="close">&times;</span>
            <h2>Payment</h2>
            <p>Total: $<span id="payment-total">0</span></p>
            <form id="payment-form">
                <label for="payment-method">Payment Method:</label>
                <select id="payment-method">
                    <option value="upi">UPI</option>
                    <option value="card">Card Payment</option>
                    <option value="visa">Visa</option>
                    <option value="paypal">PayPal</option>
                </select>

                <!-- UPI Input Section -->
                <div id="upi-section" class="hidden">
                    <label for="upi-id">UPI ID:</label>
                    <input type="text" id="upi-id" placeholder="Enter UPI ID" required>
                    <div class="upi-logos">
                        <img src="../images/google-pay.png" alt="Google Pay">
                        <img src="../images/phone-pay.png" alt="Phone Pay">
                        <img src="../images/razor-pay.png" alt="Razorpay">
                    </div>
                </div>
                <label for="payer-name">Name:</label>
            <input type="text" id="payer-name" class="payput" placeholder="Enter Name" required>

            <label for="payer-address">Address:</label>
            <input type="text" id="payer-address" class="payput" placeholder="Enter Address" required>

            <label for="payer-phone">Phone Number:</label>
            <input type="tel" id="payer-phone" class="payput" placeholder="Enter Phone Number" required>
                <button type="submit" id="confirm-payment">Pay Now</button>
            </form>
        </div>
    </div>

    
<!-- Order Confirmation Modal -->
<div id="order-success-modal" class="confirm-modal">
    <div class="modal-content1">
        <span class="close1">&times;</span>
        <h2>Order Placed Successfully!</h2>
        <p>Your order has been placed. Thank you for dining with us!</p>
    </div>
</div>


    <script src="script.js"></script>
</body>

</html>