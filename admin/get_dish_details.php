<?php
include '../login/connect.php';

header('Content-Type: application/json');

if (isset($_GET['dish_id'])) {
    $dish_id = intval($_GET['dish_id']);
    $query = "SELECT id, name, category, description, price, image FROM dishes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dish = $result->fetch_assoc();
        echo json_encode($dish);
    } else {
        echo json_encode(['error' => 'Dish not found']);
    }
} else {
    echo json_encode(['error' => 'No dish ID provided']);
}
?>
