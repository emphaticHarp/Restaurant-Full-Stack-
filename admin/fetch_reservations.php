<?php
include '../login/connect.php';

// Fetch all reservations from the `reservations` table
$sql = "SELECT * FROM reservations";
$reservations_result = $conn->query($sql);

// Fetch available tables that are not occupied from the `restaurant_tables` table
$tables_sql = "SELECT id, table_number FROM restaurant_tables WHERE is_occupied = 0";
$tables_result = $conn->query($tables_sql);

// Assign a table number to a reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_table'])) {
    $reservation_id = $_POST['reservation_id'];
    $table_id = $_POST['table_id'];

    // Assign the table to the reservation
    $assign_sql = "UPDATE reservations SET table_number = (SELECT table_number FROM restaurant_tables WHERE id = ?) WHERE id = ?";
    $stmt = $conn->prepare($assign_sql);
    $stmt->bind_param("ii", $table_id, $reservation_id);
    $stmt->execute();

    // Mark the table as occupied
    $occupy_table_sql = "UPDATE restaurant_tables SET is_occupied = 1 WHERE id = ?";
    $stmt = $conn->prepare($occupy_table_sql);
    $stmt->bind_param("i", $table_id);
    $stmt->execute();

    header("Location: reserve.php"); // Redirect to avoid form resubmission
    exit();
}
?>
