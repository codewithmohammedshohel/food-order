<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // If not, start session
    session_start();
}

// Include the menu
include('partials/menu.php');

// Check if the ID is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Redirect to manage admin page if ID is not set
    header('location:'.SITEURL.'admin/manage-admin.php');
}
?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>

<?php
// Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    // 1. Get the data from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // 2. Check whether the user with current ID and current password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // Check whether data is available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // User exists and password can be changed
            // Check whether the new password and confirm password match or not
            if ($new_password == $confirm_password) {
                // Update the password
                $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the query executed or not
                if ($res2 == true) {
                    // Password changed successfully
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                    // Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                } else {
                    // Failed to change password
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                    // Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            } else {
                // Password did not match
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                // Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        } else {
            // User does not exist, set message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>The password you entered is incorrect.</div>";
            // Redirect the user
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
}
?>
