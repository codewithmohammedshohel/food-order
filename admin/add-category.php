<?php
// Start session
session_start();

// Include necessary files
include('partials/menu.php');

// Process form submission
if(isset($_POST['submit'])) {
    // Get form data
    $title = $_POST['title'];

    // Validate title
    if(empty($title)) {
        $_SESSION['add-fail'] = "<div class='error'>Title cannot be blank.</div>";
        header('location:'.SITEURL.'admin/add-category.php');
        exit();
    }

    // Handle image upload
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        $upload_path = "../images/category/";
        $uploaded = move_uploaded_file($image_tmp, $upload_path.$image_name);

        if(!$uploaded) {
            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
            header('location:'.SITEURL.'admin/add-category.php');
            exit();
        }
    } else {
        $_SESSION['upload'] = "<div class='error'>Image not selected.</div>";
        header('location:'.SITEURL.'admin/add-category.php');
        exit();
    }

    // Process radio inputs
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    // Insert into database (assuming $conn is your database connection)
    $sql = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES ('$title', '$image_name', '$featured', '$active')";
    $res = mysqli_query($conn, $sql);

    if($res) {
        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
        exit();
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
        header('location:'.SITEURL.'admin/add-category.php');
        exit();
    }
}
?>

<!-- HTML content -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <!-- Display session messages -->
        <?php
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['add-fail'])) {
            echo $_SESSION['add-fail'];
            unset($_SESSION['add-fail']);
        }
        ?>
        <br><br>

        <!-- Add category form starts here -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form ends here -->
    </div>
</div>

<!-- Include footer.php at the bottom -->
<?php include('partials/footer.php'); ?>
