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

// Fetch user details from the database
$sql = "SELECT id, username, address, phone_number, email, designation, profile_image, registration_date, password FROM users WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);  // Bind the user ID
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
    $stmt->close();
} else {
    echo "Database query error.";
    exit;
}

$conn->close();
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
                        <li><a href="password.php"><i class="bi bi-key-fill"></i> Change Password</a></li>
                        <li><a href="#contact-support"><i class="bi bi-telephone-plus-fill"></i> Contact Support</a></li>
                        <li><a href="../settings/index.php"><i class="bi bi-geo-alt-fill"></i> Settings</a></li>

                        <li><a href="../login/logout.php"><i class="bi bi-box-arrow-left"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>


    <!-- <div id="loading-screen">
        <dotlottie-player
            src="https://lottie.host/afe18fee-b7ce-41c1-8095-0bf5b26a4609/5eK6cRjZsV.json"
            background="transparent"
            speed="1"
            style="width: 300px; height: 300px;"
            loop
            autoplay>
        </dotlottie-player>
    </div> -->

    <main>
    <div class="profile-page">
        <header class="profile-header">
            <div class="cover-photo">
                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Cover Photo" class="cover-photo-img">
            </div>
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="profile-image">
                <h1 class="profile-username"><?php echo htmlspecialchars($user['username']); ?></h1>
                <p class="profile-bio">Welcome to my profile!</p>
                <button id="edit-profile-btn" class="btn-edit"><i class="bi bi-person-fill-gear"></i> Edit Profile</button> <!-- Edit Profile Button with ID -->
            </div>
        </header>
        <div class="profile-details">
            <h2>About Me</h2>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Designation:</strong> <?php echo htmlspecialchars($user['designation']); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>

            <p><strong>Registration Date:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($user['registration_date']))); ?></p>
        </div>
    </div>
    </main>

   <!-- Edit Profile Modal -->
<div id="edit-profile-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Edit Profile</h2>
        <form action="update_profile.php" method="post" enctype="multipart/form-data" class="edit-profile-form">
            <div class="form-group">
                <label for="profile-image">Profile Image:</label>
                <input type="file" id="profile-image" name="profile_image">
                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Current Profile Image" class="current-profile-image">
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone-number">Phone Number:</label>
                <input type="text" id="phone-number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
            </div>

            <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" value="<?php echo htmlspecialchars($user['designation']); ?>">
            </div>

            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</div>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Get the modal and the button
    const modal = document.getElementById('edit-profile-modal');
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const closeModal = document.querySelector('.close-modal');

    // Get form fields
    const profileImageField = document.getElementById('profile-image');
    const currentProfileImage = document.querySelector('.current-profile-image');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');
    const phoneField = document.getElementById('phone-number');
    const addressField = document.getElementById('address');
    const designationField = document.getElementById('designation');

    // When the button is clicked, open the modal and populate it with user data
    editProfileBtn.addEventListener('click', function () {
        // Fetch user data and populate form fields (PHP embedded in JS)
        usernameField.value = "<?php echo addslashes($user['username']); ?>";
        emailField.value = "<?php echo addslashes($user['email']); ?>";
        phoneField.value = "<?php echo addslashes($user['phone_number']); ?>";
        addressField.value = "<?php echo addslashes($user['address']); ?>";
        designationField.value = "<?php echo addslashes($user['designation']); ?>";
        currentProfileImage.src = "<?php echo addslashes($user['profile_image']); ?>"; // Pre-fill current profile image
        
        // Show modal
        modal.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10); // Add class to trigger the opening animation
    });

    // When the close button is clicked, close the modal
    closeModal.addEventListener('click', function () {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300); // Wait for the closing animation to complete
    });

    // Close the modal if clicked outside the modal content
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    });
});

    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>


</body>

</html>