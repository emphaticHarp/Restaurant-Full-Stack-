<?php
// Include your database connection file
include '../login/connect.php';

// Start the session if you are using sessions to manage user login
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Initialize variables
$message = '';
$current_terms = ''; // Initialize to avoid undefined variable warning
$current_webpage_maker = '';
$current_senior_developer = '';
$current_server_director = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $terms = $_POST['terms'];
    $webpage_maker = $_POST['webpage_maker'];
    $senior_developer = $_POST['senior_developer'];
    $server_director = $_POST['server_director'];

    // Ensure the database connection is open
    if ($conn) {
        $stmt = $conn->prepare("UPDATE settings SET terms_conditions = ?, webpage_maker = ?, senior_developer = ?, server_director = ? WHERE id = 1");
        $stmt->bind_param("ssss", $terms, $webpage_maker, $senior_developer, $server_director);
        if ($stmt->execute()) {
            $message = "Settings updated successfully!";
        } else {
            $message = "Failed to update settings.";
        }
        $stmt->close();
    } else {
        $message = "Database connection error.";
    }
}

// Fetch current settings
if ($conn) {
    $result = $conn->query("SELECT terms_conditions, webpage_maker, senior_developer, server_director FROM settings WHERE id = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        $current_terms = $row['terms_conditions'] ?? '';
        $current_webpage_maker = $row['webpage_maker'] ?? '';
        $current_senior_developer = $row['senior_developer'] ?? '';
        $current_server_director = $row['server_director'] ?? '';
    } else {
        $message = "Failed to fetch settings.";
    }
    $conn->close(); // Ensure the connection is closed after operations
} else {
    $message = "Database connection error.";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Terms & Conditions</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e3a8a;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand img {
            height: 60px;
            margin-right: 15px;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        /* Main Content */
        main {
            padding: 40px 20px;
        }

        .terms-page {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            font-size: 16px;
        }

        .terms-form h2 {
            margin-top: 0;
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 500;
        }

        textarea, input[type="text"] {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 15px;
            font-size: 16px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 15px;
        }

        textarea:focus, input[type="text"]:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 4px rgba(30, 58, 138, 0.2);
            outline: none;
        }

        .submit-btn, .back-btn {
            display: inline-block;
            background-color: #1e3a8a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .submit-btn:hover, .back-btn:hover {
            background-color: #1a2a6d;
            transform: scale(1.05);
        }

        .back-btn {
            background-color: #f3f4f6;
            color: #1e3a8a;
            border: 1px solid #1e3a8a;
        }

        .back-btn:hover {
            background-color: #e0e4e8;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand img {
                height: 50px;
            }

            h1 {
                font-size: 22px;
            }

            .terms-page {
                padding: 20px;
            }

            textarea, input[type="text"] {
                height: 150px;
            }

            .submit-btn, .back-btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="../images/logo.png" alt="Restaurant Logo">
                <h1>Change Terms & Conditions</h1>
            </div>
        </nav>
    </header>

    <main class="terms-page">
        <section class="terms-form">
            <h2>Edit Terms & Conditions</h2>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <textarea name="terms" placeholder="Enter the new terms and conditions here..."><?php echo htmlspecialchars($current_terms); ?></textarea>
                <input type="text" name="webpage_maker" placeholder="Webpage Maker" value="<?php echo htmlspecialchars($current_webpage_maker); ?>">
                <input type="text" name="senior_developer" placeholder="Senior Developer" value="<?php echo htmlspecialchars($current_senior_developer); ?>">
                <input type="text" name="server_director" placeholder="Server Director" value="<?php echo htmlspecialchars($current_server_director); ?>">
                <br>
                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
            <a href="../settings/index.php" class="back-btn">Back to Settings</a>
        </section>
    </main>
</body>
</html>
