<?php
session_start();
include('partials/menu.php');

// Check if the ID and image_name are set in the URL
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get the ID and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image file if it exists
    if ($image_name != "") {
        // Image path
        $path = "../images/food/" . $image_name;
        
        // Remove the image
        $remove = unlink($path);

        // If failed to remove image then add an error message and stop the process
        if ($remove == false) {
            // Set the session message
            $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
            // Redirect to Manage Food page
            header('location:' . SITEURL . 'admin/manage-food.php');
            // Stop the process
            exit();
        }
    }

    // Delete food from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully
    if ($res == true) {
        // Set success message and redirect
        $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        // Set failure message and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to delete food. Try again later.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
} else {
    // Redirect to Manage Food page if ID or image_name not set
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
