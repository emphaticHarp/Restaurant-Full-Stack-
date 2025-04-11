<?php
include '../login/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dish_name = $_POST['dish_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Handle image upload
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if the image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
        } else {
            // Check file size (e.g., 2MB maximum)
            if ($_FILES["image"]["size"] > 2000000) {
                echo "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Attempt to upload file
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // Insert dish into the database
                        $stmt = $conn->prepare("INSERT INTO dishes (name, category, description, price, image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssds", $dish_name, $category, $description, $price, $target_file);
                        
                        if ($stmt->execute()) {
                            header("Location: dish.php");
                            exit();
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
    } else {
        echo "File is not an image.";
    }
    
    $conn->close();
}
?>
