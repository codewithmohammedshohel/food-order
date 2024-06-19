<?php include('partials/menu.php'); ?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            if (stripos($_SESSION['add'], 'Successfully') !== false) {
                echo "<div class='success'>" . $_SESSION['add'] . "</div>";
            } else {
                echo "<div class='error'>" . $_SESSION['add'] . "</div>";
                echo "<meta http-equiv='refresh' content='4;url=" . SITEURL . "admin/manage-admin.php'>";
            }
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your full name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>

<?php
// Process the value from form and save it in the database
// Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    // Button clicked
    // Get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password encryption with md5

    // SQL query to check if the username exists
    $sql_check = "SELECT * FROM tbl_admin WHERE username='$username'";
    $res_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($res_check) > 0) {
        // Username exists
        $_SESSION['add'] = "Username already exists. Please choose a different username.";
        // Redirect to add admin page
        header("location:" . SITEURL . 'admin/add-admin.php');
    } else {
        // SQL query to save the data into the database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'";

        // Execute query and save data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // Check whether the query is executed and data is inserted or not
        if ($res == TRUE) {
            // Data inserted
            $_SESSION['add'] = "Admin Added Successfully";
            // Redirect to manage admin page
            header("location:" . SITEURL . 'admin/manage-admin.php');
        } else {
            // Failed to insert data
            $_SESSION['add'] = "Failed to Add Admin";
            // Redirect to add admin page
            header("location:" . SITEURL . 'admin/add-admin.php');
        }
    }
}
?>
