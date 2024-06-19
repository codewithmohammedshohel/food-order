<?php
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Validate status to avoid any unauthorized or incorrect input
    $validStatuses = array('Ordered', 'Processing', 'Delivered', 'Cancelled');
    if (!in_array($status, $validStatuses)) {
        $_SESSION['error'] = "Invalid status.";
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    }

    // Update order status in the database
    $sql = "UPDATE tbl_order SET status = '$status' WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['update'] = "Order status updated successfully.";
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    } else {
        $_SESSION['error'] = "Failed to update order status.";
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header('location: ' . SITEURL . 'admin/manage-order.php');
    exit;
}
?>
