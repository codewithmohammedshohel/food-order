<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // If not, start session
    session_start();
}

// Create constants to store non-repeating values
define('SITEURL', 'http://localhost/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');

// Database connection
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

// Selecting database
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

// You can execute your queries here
// $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));
?>
