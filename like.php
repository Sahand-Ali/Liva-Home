<?php
session_start();
include 'db_connection.php';

// Check if the request method is POST and if the image_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["image_id"])) {
    // Sanitize and validate the image ID
    $image_id = mysqli_real_escape_string($conn, $_POST["image_id"]);

    // Insert a new like for the image
    $sql_insert_like = "INSERT INTO likes (image_id) VALUES ('$image_id')";
    mysqli_query($conn, $sql_insert_like);
}

// Redirect the user back to the home page after liking the image
header("Location: index.php");
exit();
?>
