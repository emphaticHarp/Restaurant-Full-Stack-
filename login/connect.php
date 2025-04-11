<?php


// Database connection
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "restaurant";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
