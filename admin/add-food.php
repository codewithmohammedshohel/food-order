<?php 
session_start(); // Start session to use session variables
include('partials/menu.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']); // Clear session after displaying
        }
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); // Clear session after displaying
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food" required>
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food" required></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" step="0.01" required>
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" required>
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" required>
                            <option value="" selected disabled>Select Category</option>
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$id'>$title</option>";
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
                        <input type="radio" name="featured" value="Yes" required> Yes
                        <input type="radio" name="featured" value="No" required> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" required> Yes
                        <input type="radio" name="active" value="No" required> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Function to sanitize and validate inputs
            function sanitize_input($data)
            {
                global $conn; // Access the global connection variable

                $data = mysqli_real_escape_string($conn, trim($data));
                return $data;
            }

            // Validate and sanitize inputs
            $title = sanitize_input($_POST['title']);
            $description = sanitize_input($_POST['description']);
            $price = floatval($_POST['price']); // Convert to float
            $category = intval($_POST['category']); // Convert to integer
            $featured = isset($_POST['featured']) ? sanitize_input($_POST['featured']) : "No";
            $active = isset($_POST['active']) ? sanitize_input($_POST['active']) : "No";

            // Validate image upload
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_size = $_FILES['image']['size'];
                $file_type = $_FILES['image']['type'];

                // Check file size (max 5MB)
                $max_file_size = 5 * 1024 * 1024; // 5 MB in bytes
                if ($file_size > $max_file_size) {
                    $_SESSION['upload'] = "<div class='error'>File size exceeds maximum limit (5MB).</div>";
                    header('location:' . SITEURL . 'admin/add-food.php');
                    exit();
                }

                // Ensure uploaded file is an image
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (!in_array($file_ext, $allowed_types)) {
                    $_SESSION['upload'] = "<div class='error'>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    header('location:' . SITEURL . 'admin/add-food.php');
                    exit();
                }

                // Generate a unique file name to prevent conflicts
                $new_file_name = "Food_" . uniqid() . "." . $file_ext;

                // Destination path for the uploaded file
                $upload_path = "../images/food/" . $new_file_name;

                // Move uploaded file to destination directory
                if (!move_uploaded_file($file_tmp, $upload_path)) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image. Please try again.</div>";
                    header('location:' . SITEURL . 'admin/add-food.php');
                    exit();
                }
            } else {
                $_SESSION['upload'] = "<div class='error'>Error uploading image: " . $_FILES['image']['error'] . "</div>";
                header('location:' . SITEURL . 'admin/add-food.php');
                exit();
            }

            // Insert into database using prepared statement to prevent SQL injection
            $sql = "INSERT INTO tbl_food (title, description, price, image_name, category_id, featured, active) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['add'] = "<div class='error'>SQL Error: " . mysqli_error($conn) . "</div>";
                header('location:' . SITEURL . 'admin/add-food.php');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ssdssss", $title, $description, $price, $new_file_name, $category, $featured, $active);
                mysqli_stmt_execute($stmt);

                // Check whether data inserted or not
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    exit();
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:' . SITEURL . 'admin/add-food.php');
                    exit();
                }
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
