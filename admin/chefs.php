<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Include the database connection
include '../login/connect.php';

// Fetch chefs from the database
$sql = "SELECT * FROM chefs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Chefs</title>
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

        <h1>Chef Management</h1>
        <button id="add-chef-btn" class="btn-primary">Add Chef</button>

        <div class="chef-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='chef-card'>
                        <img src='" . htmlspecialchars($row['photo_url']) . "' alt='Chef Photo' class='chef-photo'>
                        <h3>" . htmlspecialchars($row['name']) . "</h3>
                          <div class='divider'></div> <!-- Divider line -->
                        <p>Experience: " . htmlspecialchars($row['experience']) . " years</p>
                          <div class='divider'></div> <!-- Divider line -->
                        <p>Specialty: " . htmlspecialchars($row['specialty_dish']) . "</p>
                          <div class='divider'></div> <!-- Divider line -->
                        <p>Status: " . ($row['status'] ? 'Available' : 'Not Available') . "</p>
                          <div class='divider'></div> <!-- Divider line -->
                        <p>Joined: " . htmlspecialchars($row['date_of_joining']) . "</p>
                           <div class='divider'></div> <!-- Divider line -->
                        <button class='btn-details' data-id='" . htmlspecialchars($row['id']) . "'>More Details</button>
                        <button class='btn-delete' data-id='" . htmlspecialchars($row['id']) . "'>Delete</button>
                    </div>";
                }
            } else {
                echo "<p>No chefs found.</p>";
            }
            ?>
        </div>

        <!-- Add Chef Modal -->
        <div id="new-chef-modal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <h2>Add New Chef</h2>
        <form id="new-chef-form" action="add_chef.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="chef-name">Name:</label>
                <input type="text" id="chef-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="chef-experience">Experience (Years):</label>
                <input type="number" id="chef-experience" name="experience" required>
            </div>
            <div class="form-group">
                <label for="chef-specialty">Specialty Dish:</label>
                <input type="text" id="chef-specialty" name="specialty_dish" required>
            </div>
            <div class="form-group">
                <label for="chef-status">Status:</label>
                <select id="chef-status" name="status" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label for="chef-joining-date">Date of Joining:</label>
                <input type="date" id="chef-joining-date" name="date_of_joining" required>
            </div>
            <div class="form-group">
                <label for="chef-more-details">More Details:</label>
                <textarea id="chef-more-details" name="more_details" rows="4"></textarea>
            </div>
            <div class="form-group full-width">
                <label for="chef-photo">Photo:</label>
                <input type="file" id="chef-photo" name="photo" required>
            </div>
            <div class="form-group full-width">
                <button type="submit" class="btn-add-chef">Add Chef</button>
            </div>
        </form>
    </div>
</div>


        <script>
          document.addEventListener('DOMContentLoaded', () => {
    const addChefBtn = document.getElementById('add-chef-btn');
    const addChefModal = document.getElementById('new-chef-modal');
    const closeModalBtn = document.querySelector('#new-chef-modal .custom-close');
    const deleteButtons = document.querySelectorAll('.btn-delete');

    // Open Add Chef Modal
    addChefBtn.addEventListener('click', () => {
        addChefModal.style.display = 'block';
    });

    // Close Add Chef Modal
    closeModalBtn.addEventListener('click', () => {
        addChefModal.style.display = 'none';
    });

    // Delete Chef
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const chefId = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this chef?')) {
                fetch(`delete_chef.php?id=${chefId}`, { method: 'GET' })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            button.closest('.chef-card').remove();
                        } else {
                            alert('Failed to delete chef.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });
    });

    // Close Modal on Outside Click
    window.addEventListener('click', (event) => {
        if (event.target === addChefModal) {
            addChefModal.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Delay to keep the loading screen visible for 1-2 seconds
    setTimeout(function() {
        document.body.classList.add('loaded');
    }, 1000); // Adjust the delay as needed (2000 milliseconds = 2 seconds)
});

        </script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    </main>
</body>

</html>

<?php
$conn->close();
?>