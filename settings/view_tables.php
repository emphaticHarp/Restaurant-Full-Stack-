<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$dbname = 'restaurant'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get the list of tables
    $query = $pdo->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Tables</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f3f4f6, #e5e9f2);
            color: #333;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .table-container {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.15);
            padding: 30px;
            margin: 20px;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .table-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #5a2d81;
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #5a2d81, #9a5a81);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-bottom: 10px;
            border-bottom: 2px solid #5a2d81;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: none;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background: #5a2d81;
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0;
        }
        td {
            background: #f9f9f9;
            border-radius: 0 0 8px 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e1e5ea;
        }
        .btn-back {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 15px;
            font-size: 18px;
            color: #fff;
            background: linear-gradient(45deg, #5a2d81, #9a5a81);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn-back:hover {
            background: linear-gradient(45deg, #9a5a81, #5a2d81);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h1>Database Tables</h1>
        <table>
            <thead>
                <tr>
                    <th>Table Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($table); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn-back">Back to Settings</a>
    </div>
</body>
</html>
