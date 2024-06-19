<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // If not, start session
    session_start();
}

// Include the menu
include('partials/menu.php');
?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br><br>

        <div>
            <?php
            // Check if session variables for add, delete, update, user-not-found, pwd-not-match, change-pwd are set and display messages if they are
            $session_vars = ['add', 'delete', 'update', 'user-not-found', 'pwd-not-match', 'change-pwd'];
            foreach ($session_vars as $var) {
                if (isset($_SESSION[$var])) {
                    // Assign appropriate class based on the session variable
                    $class = ($var == 'add') ? 'message-info' : (($var == 'update' || $var == 'change-pwd') ? 'success' : 'error');
                    echo "<div class='$class'>" . $_SESSION[$var] . "</div>"; // displaying session message with class
                    unset($_SESSION[$var]); // Clear session message after displaying it
                }
            }
            ?>
        </div>

        <br><br><br>

        <!-- Button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Database connection
            $conn = mysqli_connect('localhost', 'root', '', 'food-order') or die(mysqli_error($conn));

            // Query to get all admins
            $sql = "SELECT * FROM tbl_admin";
            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if ($res) {
                // Count rows to check whether we have data in the database or not
                $count = mysqli_num_rows($res); // Function to get all the rows in the database

                $sn = 1; // Create a variable and assign the value

                // Check the number of rows
                if ($count > 0) {
                    // We have data in the database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        // Using while loop to get all the data from the database
                        // and while loop will run as long as we have data in the database

                        // Get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        // Display the values in our table
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Update Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // We do not have data in the database
                    ?>
                    <tr>
                        <td colspan="4">No Admins Added Yet.</td>
                    </tr>
                    <?php
                }
            } else {
                // Query failed
                echo "<tr><td colspan='4' class='error'>Failed to Retrieve Admins.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>
