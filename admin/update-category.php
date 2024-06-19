<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        // Display session messages if set
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        // Check whether the ID is set or not
        if (isset($_GET['id'])) {
            // Get the ID and all other details
            $id = $_GET['id'];

            // Create SQL query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count the rows to check whether the ID is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                // Redirect to manage category with session message 
                $_SESSION["no-category-found"] = "<div class='error'>Category not found.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
                die();
            }
        } else {
            // Redirect to manage category
            header('location:' . SITEURL . 'admin/manage-category.php');
            die();
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            // Display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php
                        } else {
                            echo "<div class='error'>Image not added.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get all the values from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Check whether the image is selected or not
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Image is selected
                $image_name = $_FILES['image']['name'];

                // Auto rename the image to avoid duplicate image names
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/" . $image_name;

                // Finally, upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                if ($upload == false) {
                    // Set message
                    $_SESSION['upload'] = "<div class='error'>Failed to upload the image.</div>";
                    // Redirect to add category page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                    // Stop the process
                    die();
                }

                // Remove current image if available
                if ($current_image != "") {
                    $remove_path = "../images/category/" . $current_image;
                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    if ($remove == false) {
                        // Failed to remove image
                        $_SESSION['failed-remove'] = "<div class='error'>Failed to remove the current image.</div>";
                        // Redirect to manage category page
                        header('location:' . SITEURL . 'admin/manage-category.php');
                        // Stop the process
                        die();
                    }
                }
            } else {
                $image_name = $current_image;
            }

            // Create SQL query to update category
            $sql2 = "UPDATE tbl_category SET 
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active' 
                WHERE id=$id";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Check whether the query executed or not
            if ($res2 == true) {
                // Category updated
                $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
                // Redirect to manage category page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                // Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
                // Redirect to update category page
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
