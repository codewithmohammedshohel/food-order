<?php
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Authorization - access control

    // Check whether the user is logged in or not
    if (!isset($_SESSION['user'])) { // Corrected the logic to check if the user session is not set
        // User is not logged in

        // Redirect to login page with a message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
        // Redirect to login page
        header('Location: ' . SITEURL . 'admin/login.php');
        exit(); // It's a good practice to call exit after a header redirect
    }
?>
