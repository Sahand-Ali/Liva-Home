<?php
session_start();
include 'db_connection.php';

// Check if image_id is provided and user is logged in
if (isset($_GET['id']) && isset($_SESSION['username'])) {
    $image_id = $_GET['id'];
    $username = $_SESSION['username'];

    // Check if the user has permission to delete the image (optional)
    // You may implement your own logic to check if the user is authorized to delete the image

    // Delete related likes first
    $deleteLikesQuery = "DELETE FROM likes WHERE image_id = $image_id";
    if (mysqli_query($conn, $deleteLikesQuery)) {
        // Likes deleted successfully, now delete the image
        $deleteImageQuery = "DELETE FROM images WHERE id = $image_id";
        if (mysqli_query($conn, $deleteImageQuery)) {
            // Image deleted successfully
            header("Location: index.php");
            exit();
        } else {
            // Error deleting image
            echo "Error deleting image: " . mysqli_error($conn);
        }
    } else {
        // Error deleting likes
        echo "Error deleting likes: " . mysqli_error($conn);
    }
} else {
    // Redirect to login page or handle error
    header("Location: login.php");
    exit();
}
?>
