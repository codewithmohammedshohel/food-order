<?php include('partials/menu.php'); ?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>

        <?php
        // Display session messages if set and then unset them
        $session_variables = ['add', 'remove', 'delete', 'no-category-found', 'update', 'failed-remove'];

        foreach ($session_variables as $session_variable) {
            if (isset($_SESSION[$session_variable])) {
                echo $_SESSION[$session_variable];
                unset($_SESSION[$session_variable]);
            }
        }
        ?>
        <br><br>

        <!-- Button to add category -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all categories from the database
            $sql = "SELECT * FROM tbl_category";
            // Execute query
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            // Check whether we have data in the database or not
            if ($count > 0) {
                // We have data in the database 
                // Get the data and display
                $sn = 1; // Create a variable to store serial number
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?>.</td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php
                            // Check whether the image name is available or not
                            if ($image_name != "") {
                                // Check if the file exists
                                $image_path = "../images/category/" . $image_name;
                                if (file_exists($image_path)) {
                                    // Display the image
                            ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                            <?php
                                } else {
                                    // Display the message
                                    echo "<div class='error'>Image not found.</div>";
                                }
                            } else {
                                // Display the message
                                echo "<div class='error'>Image not added.</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                // We do not have data in the database
                // We will display the message inside the table
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Category Added</div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>
