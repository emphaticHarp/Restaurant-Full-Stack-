<?php
include('../login/connect.php'); // Your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_name = $_POST['offer_name'];
    $offer_type = $_POST['offer_type'];
    $offer_percentage = $_POST['offer_percentage'];
    $offer_details = $_POST['offer_details'];

    // Insert offer into the database
    $sql = "INSERT INTO offers (offer_name, offer_type, offer_percentage, offer_details) 
            VALUES ('$offer_name', '$offer_type', '$offer_percentage', '$offer_details')";

    if (mysqli_query($conn, $sql)) {
        echo "Offer added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
