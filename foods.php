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
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>
    </section>
    <!-- FOOD SEARCH Section Ends Here -->

    <!-- FOOD MENU Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            // SQL query to select active foods
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
            
            // Execute the query
            $res = mysqli_query($conn, $sql);
            
            // Check if foods are available
            if ($res) {
                $count = mysqli_num_rows($res);
                
                if ($count > 0) {
                    // Foods available
                    while ($row = mysqli_fetch_assoc($res)) {
                        // Get food details
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php if (!empty($image_name)) : ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                <?php else : ?>
                                    <div class='error'>Image not available.</div>
                                <?php endif; ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo htmlspecialchars($title); ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail"><?php echo htmlspecialchars($description); ?></p>
                                <br>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // No foods found
                    echo "<div class='error'>No foods found.</div>";
                }
            } else {
                // Query execution failed
                echo "<div class='error'>Failed to retrieve foods.</div>";
            }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- FOOD MENU Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
</body>
</html>
