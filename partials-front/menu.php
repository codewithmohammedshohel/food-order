<?php
    // Include constants 
    include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="navbar-content">
                <div class="logo">
                    <a href="<?php echo SITEURL; ?>" title="Logo">
                        <img src="<?php echo SITEURL; ?>images/logo1.png" alt="Restaurant Logo" class="img-responsive">
                    </a>
                </div>

                <div class="menu">
                    <ul>
                        <li>
                            TASTE AWESOME FOOD
                        </li>
                        
                        <li>
                            <a href="<?php echo SITEURL; ?>">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL; ?>foods.php">Foods</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

</body>
</html>
