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
        <h1>Update Admin</h1>
        <br><br>

        <?php
        //1. get the id of the selected admin
        $id = $_GET['id'];

        //2. create SQL query to get the details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        //3. execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed or not
        if ($res == true) {
            // Check whether the data is available or not
            $count = mysqli_num_rows($res);

            // Check whether we have admin data or not
            if ($count == 1) {
                // Get the details
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                // Redirect to manage admin page
                header('location: ' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            // Redirect to manage admin page
            header('location: ' . SITEURL . 'admin/manage-admin.php');
        }
        ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>
<!-- Main Content ends here -->

<?php
// check whether the submit button clicked or not-->

if(isset($_POST['submit']))
{
    //echo "Button clicked";
    //Get all the value from form to update
    echo $id=$_POST['id'];
    echo $full_name=$_POST['full_name'];
    echo $username=$_POST['username'];


    //create a sql queary to update admin
    $sql="UPDATE tbl_admin SET
    full_name='$full_name',
    username='$username'
    WHERE id='$id'  
    
    ";

    //execute the query
    $res=mysqli_query($conn, $sql);

    //check whether the query executed succuessfully or not
    if($res==true)
    {
        //query executed and admin updated 
        $_SESSION['update']="<div class='success'>Admin updated successfully.</div>";


        //redirect to manage admin updated
        header('location: '.SITEURL.'admin/manage-admin.php');

    }
    else
    {
        //failed to update admin
        $_SESSION['update']="<div class='error'>Failed to delete Admin.</div>";


        //redirect to manage admin updated
        header('location: '.SITEURL.'admin/manage-admin.php');

    }
}
?>




<?php include('partials/footer.php'); ?>
