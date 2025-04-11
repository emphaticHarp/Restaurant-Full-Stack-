<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost'; // Your database host
$dbname = 'restaurant'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the category parameter from the POST request
    $category = isset($_POST['group']) ? $_POST['group'] : '';

    // Prepare the SQL query
    $stmt = $pdo->prepare("SELECT id, name, description, price, image FROM dishes WHERE category = :category");

    // Execute the query with the parameter
    $stmt->execute(['category' => $category]);

    // Fetch the results
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($items);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
