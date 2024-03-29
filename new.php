<?php
session_start();
include 'db_connection.php';

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $image_name = $_FILES["image"]["name"];
    $temp_name = $_FILES["image"]["tmp_name"];
    
    // Get the current date and time
    $current_date = date('Y-m-d H:i:s');

    // Move the uploaded file to the desired location
    move_uploaded_file($temp_name, "images/" . $image_name);
    
    // Insert the image details into the database along with the creation date
    $sql = "INSERT INTO images (image_name, created_at) VALUES ('$image_name', '$current_date')";
    $result = mysqli_query($conn, $sql);

    // Redirect to index.php after uploading the image
    header("Location: index.php");
    exit();
}
?>
