<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'login/connect.php';

    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $guests = $_POST['guests'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Prepare the SQL query
    $sql = "INSERT INTO reservations (name, email, phone, guests, date, time) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $guests, $date, $time);

    // Execute the query
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
