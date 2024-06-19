<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include menu.php to access constants and database connection
include_once('partials-front/menu.php');

// Check if food_id is set in GET parameters
if (isset($_GET['food_id'])) {
    // Get food_id from GET parameter and sanitize it
    $food_id = mysqli_real_escape_string($conn, $_GET['food_id']);

    // Fetch food details from the database
    $sql = "SELECT * FROM tbl_food WHERE id = '$food_id' AND active = 'Yes'";
    $res = mysqli_query($conn, $sql);

    // Check if data is available
    if ($res) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // Food found, fetch details
            $row = mysqli_fetch_assoc($res);
            $food_title = htmlspecialchars($row['title']);
            $food_price = $row['price'];
            $food_image = $row['image_name'];
        } else {
            // Redirect to homepage if food not found or inactive
            $_SESSION['error'] = "The selected food item is not available.";
            header('location: ' . SITEURL);
            exit;
        }
    } else {
        // Error fetching food details
        $_SESSION['error'] = "Failed to fetch food details. Please try again.";
        header('location: ' . SITEURL);
        exit;
    }
} else {
    // Redirect to homepage if food_id is not set
    $_SESSION['error'] = "No food item selected.";
    header('location: ' . SITEURL);
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate form data
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Calculate total price
    $total_price = $food_price * $qty;

    // Insert order into database
    $sql_order = "INSERT INTO `tbl_order` (`food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`)
                  VALUES ('$food_title', '$food_price', '$qty', '$total_price', NOW(), 'Ordered', '$full_name', '$contact', '$email', '$address')";

    $res_order = mysqli_query($conn, $sql_order);

    if ($res_order) {
        // Order placed successfully
        $_SESSION['success'] = "Order placed successfully. Your order will be delivered soon.";
        header('location: ' . SITEURL . 'order-success.php');
        exit;
    } else {
        // Failed to place order
        $_SESSION['error'] = "Failed to place order. Please try again.";
        header('location: ' . SITEURL);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - <?php echo htmlspecialchars($food_title); ?></title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    <style>
        /* Additional styles can be added here specific to this page */
        .food-search {
            padding: 50px 0;
        }

        .food-menu-img {
            text-align: center;
        }

        .food-menu-img img {
            max-width: 100%;
            height: auto;
        }

        .food-menu-desc {
            margin-top: 20px;
        }

        .food-menu-desc h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .food-menu-desc .food-price {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .order-label {
            font-weight: bold;
            margin-top: 10px;
        }

        .input-responsive {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-style: italic;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- FOOD SEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            <?php
            // Display error messages if set in session
            if (isset($_SESSION['error'])) {
                echo "<div class='error'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>

            <h2 class="text-center text-white">Fill this form to confirm your order for <?php echo htmlspecialchars($food_title); ?>.</h2>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?food_id=' . $food_id; ?>" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php if (!empty($food_image)) : ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>" alt="<?php echo htmlspecialchars($food_title); ?>" class="img-responsive img-curve">
                        <?php else : ?>
                            <div class='error'>Image not found.</div>
                        <?php endif; ?>
                    </div>

                    <div class="food-menu-desc">
                        <h3><?php echo htmlspecialchars($food_title); ?></h3>

                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                        <input type="hidden" name="food_title" value="<?php echo htmlspecialchars($food_title); ?>">
                        <input type="hidden" name="food_price" value="<?php echo $food_price; ?>">

                        <p class="food-price">$<?php echo $food_price; ?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" min="1" required>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your full name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="Enter your mobile number" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="Enter your email address" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="5" placeholder="Enter your delivery address" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
            </form>
        </div>
    </section>
    <!-- FOOD SEARCH Section Ends Here -->

    <?php include_once('partials-front/footer.php'); ?>
</body>
</html>
