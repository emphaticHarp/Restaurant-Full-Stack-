<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Handle Edit Dish
if (isset($_POST['edit_dish'])) {
    $dish_id = $_POST['dish_id'];
    // Redirect to edit dish page or handle editing here
}

// Handle Delete Dish
if (isset($_POST['delete_dish'])) {
    $dish_id = $_POST['dish_id'];
    $delete_query = "DELETE FROM dishes WHERE id = $dish_id";
    if ($conn->query($delete_query)) {
        header("Location: dish.php"); // Redirect to the dishes page
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
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
        <section id="dishes" class="pop">
            <h2>Manage Dishes</h2>
            <!-- Display Dishes by Category -->
            <div class="dishes-container">
                <?php
                // Query to fetch dishes
                $query = "SELECT id, name, category, description, price, image FROM dishes";
                $dishes_result = $conn->query($query);

                if (!$dishes_result) {
                    die("Query failed: " . $conn->error);
                }

                // Group dishes by category
                $dishes_by_category = [];
                while ($dish = $dishes_result->fetch_assoc()) {
                    $category = $dish['category'];
                    if (!isset($dishes_by_category[$category])) {
                        $dishes_by_category[$category] = [];
                    }
                    $dishes_by_category[$category][] = $dish;
                }

                // Display dishes by category
                foreach ($dishes_by_category as $category => $dishes) {
                    echo "<h3>$category</h3>";
                    echo "<table class='dishes-table'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($dishes as $dish) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($dish['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($dish['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($dish['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($dish['price']) . "</td>";
                        echo "<td><img src='../images/" . $dish['image'] . "' alt='" . $dish['name'] . "' class='dish-image'></td>";
                        echo "<td>
                                <form method='post' action=''>
                                    <input type='hidden' name='dish_id' value='" . htmlspecialchars($dish['id']) . "'>
                                    <button type='button' class='action-button edit-button' onclick='openEditModal(" . intval($dish['id']) . ")'>Edit</button>
                                    <button type='submit' name='delete_dish' class='action-button delete-button'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                }
                ?>
            </div>

            <!-- Add New Dish Button -->
            <button id="openModal" class="action-button add-dish-button">Add New Dish</button>



        </section>
    </main>
    <!-- edit dish -->
      <!-- Edit Dish Modal -->
    <div id="editDishModal" class="custom-dish-modal">
        <div class="custom-dish-modal-content">
            <span class="custom-close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Dish</h3>
            <form id="editDishForm" method="post" action="update_dish.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_dish_id" name="dish_id">
                <div class="custom-form-group">
                    <input type="text" id="edit_dish_name" name="dish_name" placeholder="Dish Name" required>
                </div>
                <div class="custom-form-group">
                    <input type="text" id="edit_category" name="category" placeholder="Category" required>
                </div>
                <div class="custom-form-group">
                    <textarea id="edit_description" name="description" placeholder="Description" required></textarea>
                </div>
                <div class="custom-form-group">
                    <input type="number" id="edit_price" name="price" placeholder="Price" step="0.01" required>
                </div>
                <div class="custom-form-group">
                    <label for="edit_image">Dish Image:</label>
                    <input type="file" id="edit_image" name="image">
                </div>
                <div class="custom-form-group">
                    <img id="current_image" class="dish-image" style="display: none;">
                </div>
                <button type="submit" class="custom-action-button">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Add New Dish Modal -->
    <div id="addDishCustomModal" class="custom-dish-modal">
        <div class="custom-dish-modal-content">
            <span class="custom-close">&times;</span>
            <h3>Add New Dish</h3>
            <form method="post" action="add_dish.php" enctype="multipart/form-data">
                <div class="custom-form-group">
                    <input type="text" id="dish_name" name="dish_name" placeholder="Dish Name" required>
                </div>
                <div class="custom-form-group">
                    <input type="text" id="category" name="category" placeholder="Category" required>
                </div>
                <div class="custom-form-group">
                    <textarea id="description" name="description" placeholder="Description" required></textarea>
                </div>
                <div class="custom-form-group">
                    <input type="number" id="price" name="price" placeholder="Price" step="0.01" required>
                </div>
                <div class="custom-form-group">
                    <label for="image">Dish Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="custom-action-button">Add Dish</button>
            </form>
        </div>
    </div>



    <script src="script.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</body>

</html>

<?php
$conn->close();
?>