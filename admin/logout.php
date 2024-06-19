<?php
    // Include constants.php for SITEURL
    include('../config/constants.php');
    
    // 1. Destroy the session
    session_destroy(); //unset $_session ['user'] and it will logout our system

    // 2. Redirect to login page
    header('Location: ' . SITEURL . 'admin/login.php');
    exit(); // It's a good practice to call exit after a header redirect
?>
