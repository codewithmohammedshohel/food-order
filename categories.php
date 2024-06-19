<?php include_once 'partials-front/menu.php'; ?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Include database connection and constants
        include_once 'config/constants.php';

        // Establish database connection
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // SQL query to fetch active categories
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
        $res = mysqli_query($conn, $sql);

        // Check if query executed successfully
        if ($res) {
            // Check if categories are available
            if (mysqli_num_rows($res) > 0) {
                // Iterate through categories
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>

                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php if (!empty($image_name)) { ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php } else { ?>
                                <div class='error'>Image not found.</div>
                            <?php } ?>
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            } else {
                // No categories found
                echo "<div class='error'>No categories found.</div>";
            }
        } else {
            // Failed to execute query
            echo "<div class='error'>Failed to retrieve categories.</div>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include 'partials-front/footer.php'; ?>
