<?php

ob_start(); // Start output buffering
session_start();
include('partials/menu.php');

// Check whether the ID is set or not
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $description = $row['description'];
    $price = $row['price'];
    $current_image = $row['image_name'];
    $current_category = $row['category_id'];
    $featured = $row['featured'];
    $active = $row['active'];
} else {
    // Redirect to Manage Food page
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" required><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>" step="0.01" required>
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            echo "<img src='" . SITEURL . "images/food/" . $current_image . "' width='150px'>";
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
                    <td>Category:</td>
                    <td>
                        <select name="category" required>
                            <?php
                            $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($res2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                    $category_id = $row2['id'];
                                    $category_title = $row2['title'];
                                    ?>
                                    <option <?php if ($current_category == $category_id) echo "selected"; ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            } else {
                                echo "<option value='0'>No Category Found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") echo "checked"; ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") echo "checked"; ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") echo "checked"; ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") echo "checked"; ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = floatval($_POST['price']);
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Check if the image is selected
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_size = $_FILES['image']['size'];

                // Check file size (max 5MB)
                $max_file_size = 5 * 1024 * 1024; // 5 MB in bytes
                if ($file_size > $max_file_size) {
                    $_SESSION['upload'] = "<div class='error'>File size exceeds maximum limit (5MB).</div>";
                    header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                    exit();
                }

                // Ensure uploaded file is an image
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (!in_array($file_ext, $allowed_types)) {
                    $_SESSION['upload'] = "<div class='error'>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                    exit();
                }

                // Generate a unique file name to prevent conflicts
                $new_file_name = "Food_" . uniqid() . "." . $file_ext;

                // Destination path for the uploaded file
                $upload_path = "../images/food/" . $new_file_name;

                // Check if the directory exists and has the correct permissions
                if (!is_dir("../images/food/") || !is_writable("../images/food/")) {
                    $_SESSION['upload'] = "<div class='error'>Upload directory is not writable. Please check permissions.</div>";
                    header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                    exit();
                }

                // Move uploaded file to destination directory
                if (!move_uploaded_file($file_tmp, $upload_path)) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image. Please try again.</div>";
                    header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                    exit();
                }

                // Remove the current image if available
                if ($current_image != "") {
                    $remove_path = "../images/food/" . $current_image;
                    if (!unlink($remove_path)) {
                        $_SESSION['upload'] = "<div class='error'>Failed to remove current image.</div>";
                        header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                        exit();
                    }
                }

                // Update the new image name
                $image_name = $new_file_name;
            } else {
                $image_name = $current_image;
            }

            // Update the database
            $sql3 = "UPDATE tbl_food SET 
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                WHERE id=$id";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3) {
                $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
ob_end_flush(); // Flush the output from the buffer
?>
