<?php
include('../config/constants.php');  // Adjust the path according to the actual location

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the login button is clicked
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // SQL query to check if the user with the given username and password exists
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($res) {
        // Check if any rows were returned
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // User exists and login is successful
            $_SESSION['login'] = "<div class='success text-center'>Login Successful</div>";
            

            //to check whether the user is logged in or not and logout will unset it         
            $_SESSION['user'] = $username; 
            
            
                    

            // Redirect to the dashboard or desired page
            header("Location:" . SITEURL . "admin/index.php");
            exit(); // Exit to prevent further execution
        } else {
            // User does not exist, display error message or redirect back to login page
            $_SESSION['login'] = "<div class='error text-center'>Invalid Username or Password</div>";
            header("Location:" . SITEURL . "admin/login.php");
            exit(); // Exit to prevent further execution
        }
    } else {
        // Query execution failed
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Taste Awesome Food</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="login">
    <br><br>
    <h1 class="text-center">Login</h1>

    <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }


        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }



    ?>

    <!-- Login Form Starts Here -->
    <form action="" method="POST" class="text-center">
        <label for="username">Username:</label> <br>
        <input type="text" id="username" name="username" placeholder="Enter Username" required><br><br>

        <label for="password">Password:</label> <br>
        <input type="password" id="password" name="password" placeholder="Enter Password" required> <br><br>

        <input type="submit" name="login" value="Login" class="btn-primary">
        <br><br>
    </form>
    <!-- Login Form Ends Here -->

    <p class="text-center">Developed by - <a href="#">Mohammed Shohel</a></p>
</div>

</body>
</html>
