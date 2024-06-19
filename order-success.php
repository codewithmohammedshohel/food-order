<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // If not, start session
    session_start();
}

// Include menu.php to access constants and database connection
include_once('partials-front/menu.php');

// Redirect to homepage if success message is not set
if (!isset($_SESSION['success'])) {
    header('location: ' . SITEURL);
    exit;
}

// Clear success message from session after displaying
$success_message = $_SESSION['success'];
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Food Order</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .order-success {
            padding: 50px 0;
            text-align: center;
        }

        .success-message {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }

        .success-message h2 {
            color: #4CAF50;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .success-message p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .btn-primary:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Success Message Section -->
    <section class="order-success">
        <div class="container">
            <div class="success-message">
                <h2>Order Placed Successfully!</h2>
                <p><?php echo $success_message; ?></p>
                <a href="<?php echo SITEURL; ?>" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </section>
    <!-- End Success Message Section -->

    <?php include_once('partials-front/footer.php'); ?>
</body>
</html>
