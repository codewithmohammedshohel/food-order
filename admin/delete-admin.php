<?php
// Check if a session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // If not, start the session
    session_start();
}

// Include constants.php file here
include('../config/constants.php');

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    // Get the id of admin to be deleted
    $id = $_GET['id'];

    // Validate input: Ensure that $id is a non-empty integer
    if(!empty($id) && is_numeric($id)) {
        // Create SQL query to delete admin
        $sql = "DELETE FROM tbl_admin WHERE id=$id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed successfully or not
        if($res) {
            // Query executed successfully and admin deleted 
            $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";
        } else {
            // Failed to delete admin 
            $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again later</div>";
        }
    } else {
        // Invalid or missing 'id' parameter
        $_SESSION['delete'] = "<div class='error'>Invalid or missing 'id' parameter</div>";
    }
} else {
    // 'id' parameter is not set in the URL
    $_SESSION['delete'] = "<div class='error'>ID parameter missing</div>";
}

// Redirect to manage admin page with message (success/error)
header('Location: '.SITEURL.'admin/manage-admin.php');
exit(); // added exit() to prevent further execution
?>
