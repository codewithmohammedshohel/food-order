<?php include_once('partials-front/menu.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- FOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <h2>Foods on Your Search "<a href="#" class="text-white"><?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?></a>"</h2>
        </div>
    </section>
    <!-- FOOD SEARCH Section Ends Here -->

    <!-- FOOD MENU Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            // Check if $_POST['search'] is set
            if (isset($_POST['search'])) {
                // Get the search keyword and sanitize it
                $search = mysqli_real_escape_string($conn, $_POST['search']);

                // SQL query to get food based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Check whether the foods are available or not
                if ($res) {
                    $count = mysqli_num_rows($res);

                    if ($count > 0) {
                        // Foods available
                        while ($row = mysqli_fetch_assoc($res)) {
                            // Get the values
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $description = $row['description'];
                            $image_name = $row['image_name'];
                            ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php if ($image_name == "") : ?>
                                        <div class='error'>Image not available.</div>
                                    <?php else : ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                    <?php endif; ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo htmlspecialchars($title); ?></h4>
                                    <p class="food-price">$<?php echo $price; ?></p>
                                    <p class="food-detail">
                                        <?php echo htmlspecialchars($description); ?>
                                    </p>
                                    <br>

                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Food not available
                        echo "<div class='error'>Food not found.</div>";
                    }
                } else {
                    // Error executing query
                    echo "<div class='error'>Error fetching food details.</div>";
                }

                // Free result set
                mysqli_free_result($res);
            } else {
                // $_POST['search'] is not set
                echo "<div class='error'>No search keyword provided.</div>";
            }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- FOOD MENU Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
</body>
</html>
