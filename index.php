<?php
include_once('partials-front/menu.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASTE AWESOME FOOD</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
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

    <?php
    // Display order message if set in session
    if(isset($_SESSION['order'])) {
        echo "<div class='success'>" . $_SESSION['order'] . "</div>";
        unset($_SESSION['order']);
    }
    ?>

    <!-- CATEGORIES Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            // SQL query to select active and featured categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 6";
            // Execute the query
            $res = mysqli_query($conn, $sql);
            // Check if categories are available
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                // Categories available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get category details
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>

                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php if (!empty($image_name)) : ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                            <?php else : ?>
                                <div class='error'>Image not available</div>
                            <?php endif; ?>
                            <h3 class="float-text text-white"><?php echo htmlspecialchars($title); ?></h3>
                        </div>
                    </a>
                    <?php
                }
            } else {
                // No categories found
                echo "<div class='error'>No categories found.</div>";
            }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- CATEGORIES Section Ends Here -->

    <!-- FOOD MENU Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            // SQL query to select active and featured foods
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
            // Execute the query
            $res2 = mysqli_query($conn, $sql2);
            // Check if foods are available
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {
                // Foods available
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    // Get food details
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php if (!empty($image_name)) : ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                            <?php else : ?>
                                <div class='error'>Image not available</div>
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
            ?>

            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- FOOD MENU Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>

</body>
</html>
