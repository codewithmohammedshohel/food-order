<?php
include('partials/menu.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch order details from database based on $id
    $sql = "SELECT * FROM tbl_order WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        // Fetch order details
        $order = mysqli_fetch_assoc($res);
        $food = htmlspecialchars($order['food']);
        $qty = $order['qty'];
        $status = $order['status'];
        $customer_name = htmlspecialchars($order['customer_name']);
        $customer_contact = htmlspecialchars($order['customer_contact']);
        $customer_email = htmlspecialchars($order['customer_email']);
        $customer_address = htmlspecialchars($order['customer_address']);
    } else {
        // Order not found, set session message and redirect
        $_SESSION['error'] = "Order not found.";
        header('location: ' . SITEURL . 'admin/manage-order.php');
        exit;
    }
} else {
    // Redirect to manage-order.php if id is not set
    header('location: ' . SITEURL . 'admin/manage-order.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        $status = $_POST['status'];
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];

        // Update order details in database
        $sql2 = "UPDATE tbl_order SET 
                    qty = '$qty', 
                    status = '$status', 
                    customer_name = '$customer_name', 
                    customer_contact = '$customer_contact', 
                    customer_email = '$customer_email', 
                    customer_address = '$customer_address' 
                WHERE id = $id";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2) {
            $_SESSION['update'] = "Order updated successfully.";
            header('location: ' . SITEURL . 'admin/manage-order.php');
            exit;
        } else {
            $_SESSION['error'] = "Failed to update order.";
        }
    }
}
?>

<!-- HTML form for updating order -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <!-- Form with fields for updating order details -->
        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Order Details</legend>

                <label for="food">Food:</label>
                <input type="text" name="food" id="food" class="input-responsive" value="<?php echo $food; ?>" readonly>

                <label for="qty">Quantity:</label>
                <input type="number" name="qty" id="qty" class="input-responsive" value="<?php echo $qty; ?>" min="1" required>

                <label for="status">Status:</label>
                <select name="status" id="status" class="input-responsive" required>
                    <option value="Ordered" <?php echo ($status == 'Ordered') ? 'selected' : ''; ?> class="status-ordered">Ordered</option>
                    <option value="Processing" <?php echo ($status == 'Processing') ? 'selected' : ''; ?> class="status-processing">Processing</option>
                    <option value="Cancelled" <?php echo ($status == 'Cancelled') ? 'selected' : ''; ?> class="status-cancelled">Cancelled</option>
                    <option value="Delivered" <?php echo ($status == 'Delivered') ? 'selected' : ''; ?> class="status-delivered">Delivered</option>
                </select>

                <label for="customer_name">Customer Name:</label>
                <input type="text" name="customer_name" id="customer_name" class="input-responsive" value="<?php echo $customer_name; ?>" required>

                <label for="customer_contact">Phone Number:</label>
                <input type="tel" name="customer_contact" id="customer_contact" class="input-responsive" value="<?php echo $customer_contact; ?>" required>

                <label for="customer_email">Email:</label>
                <input type="email" name="customer_email" id="customer_email" class="input-responsive" value="<?php echo $customer_email; ?>" required>

                <label for="customer_address">Address:</label>
                <textarea name="customer_address" id="customer_address" rows="5" class="input-responsive" required><?php echo $customer_address; ?></textarea>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Order" class="btn btn-primary">
            </fieldset>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<style>
   /* General Reset and Typography */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Container and Layout */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Main Content Styling */
.main-content {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.wrapper {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
}

/* Form Styling */
.order fieldset {
    border: 2px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.order legend {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.input-responsive {
    width: calc(100% - 20px);
    padding: 12px;
    font-size: 1rem;
    border: 2px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.input-responsive:focus {
    outline: none;
    border-color: #ff6b81;
    box-shadow: 0 0 8px rgba(255, 107, 129, 0.5);
}

/* Button Styling */
.btn {
    padding: 12px 24px;
    font-size: 1rem;
    background-color: #ff6b81;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #ff4757;
}

/* Responsive Design */
@media only screen and (max-width: 768px) {
    .container {
        padding: 10px;
    }

    .wrapper {
        width: 100%;
    }

    .input-responsive {
        width: calc(100% - 16px);
        padding: 10px;
    }
}

</style>
