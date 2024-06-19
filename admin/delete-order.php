<?php
include('partials/menu.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    // Check if id is set and valid
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];

        // Attempt to delete order
        $sql = "DELETE FROM tbl_order WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Deletion successful
            $_SESSION['success'] = "Order deleted successfully.";
        } else {
            // Deletion failed
            $_SESSION['error'] = "Failed to delete order. Please try again.";
        }

        // Redirect to manage-order.php after deletion attempt
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    } else {
        // Redirect to manage-order.php if id is missing or invalid
        $_SESSION['error'] = "Invalid order ID.";
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    }
} else if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Redirect to manage-order.php if id is not set or invalid in GET request
    header('location: ' . SITEURL . 'admin/manage-order.php');
    exit;
}
?>

<!-- HTML content for delete-order.php with confirmation message -->
<div class="main-content">
    <div class="wrapper">
        <h1>Delete Order</h1>
        <br><br>

        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <p>Are you sure you want to delete this order?</p>

        <!-- Form for confirmation of deletion -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Delete Order" class="btn btn-danger">
            <a href="<?php echo SITEURL; ?>admin/manage-order.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
