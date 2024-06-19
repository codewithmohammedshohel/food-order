<?php 
include_once('partials-front/menu.php');

// Check if category_id is set in the URL
if(isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch the category title based on category_id using prepared statement
    $sql = "SELECT title FROM tbl_category WHERE id = ? AND active = 'Yes'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if($res) {
        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $category_title = $row['title'];

            // Display the category title in the heading
            echo "<section class='food-search text-center'>
                    <div class='container'>
                        <h2>Foods on <a href='#' class='text-white'>\"$category_title\"</a> Category</h2>
                    </div>
                </section>";

            // SQL query to fetch foods based on category_id using prepared statement
            $sql_foods = "SELECT * FROM tbl_food WHERE category_id = ? AND active = 'Yes'";
            $stmt_foods = mysqli_prepare($conn, $sql_foods);
            mysqli_stmt_bind_param($stmt_foods, 'i', $category_id);
            mysqli_stmt_execute($stmt_foods);
            $res_foods = mysqli_stmt_get_result($stmt_foods);

            if(mysqli_num_rows($res_foods) > 0) {
                // Foods available
                echo "<section class='food-menu'>
                        <div class='container'>
                            <h2 class='text-center'>Food Menu</h2>";

                while($row_food = mysqli_fetch_assoc($res_foods)) {
                    $food_id = $row_food['id'];
                    $food_title = $row_food['title'];
                    $food_price = $row_food['price'];
                    $food_description = $row_food['description'];
                    $food_image_name = $row_food['image_name'];
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image_name; ?>" alt="<?php echo htmlspecialchars($food_title); ?>" class="img-responsive img-curve">
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo htmlspecialchars($food_title); ?></h4>
                            <p class="food-price">$<?php echo $food_price; ?></p>
                            <p class="food-detail">
                                <?php echo htmlspecialchars($food_description); ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    <?php
                }

                echo "<div class='clearfix'></div>
                    </div>
                </section>";
            } else {
                // No foods found in the category
                echo "<div class='container'>
                        <p class='error'>No foods found in this category.</p>
                    </div>";
            }
        } else {
            // Category not found or inactive
            echo "<div class='container'>
                    <p class='error'>Category not found or inactive.</p>
                </div>";
        }
    } else {
        // Error executing query for category title
        echo "<div class='container'>
                <p class='error'>Error fetching category title.</p>
            </div>";
    }

    // Close prepared statements
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt_foods);
} else {
    // If category_id is not set, redirect to home page
    header('location: ' . SITEURL);
    exit; // Ensure no further execution after redirection
}

include_once('partials-front/footer.php');
?>
