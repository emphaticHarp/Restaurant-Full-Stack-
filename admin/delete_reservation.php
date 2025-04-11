<?php
include '../login/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    // Fetch the table number associated with this reservation
    $table_number_sql = "SELECT table_number FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($table_number_sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Update the restaurant_tables table to mark the table as not occupied
        $update_table_sql = "UPDATE restaurant_tables SET is_occupied = 0 WHERE table_number = ?";
        $stmt = $conn->prepare($update_table_sql);
        $stmt->bind_param("i", $row['table_number']);
        $stmt->execute();
    }

    // Delete the reservation from the reservations table
    $delete_sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();

    header("Location: reserve.php");
    exit();
}
?>
