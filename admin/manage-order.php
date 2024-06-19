<?php
ob_start(); // Start output buffering

include('partials/menu.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to sort orders by date/time
function sortByDateTime($orders, $sortBy = 'DESC') {
    usort($orders, function($a, $b) use ($sortBy) {
        $dateA = strtotime($a['order_date']);
        $dateB = strtotime($b['order_date']);

        if ($sortBy == 'DESC') {
            return $dateB <=> $dateA;
        } else {
            return $dateA <=> $dateB;
        }
    });

    return $orders;
}

// Function to filter orders by status
function filterByStatus($orders, $status) {
    $filteredOrders = array_filter($orders, function($order) use ($status) {
        return strtolower($order['status']) == strtolower($status);
    });

    return $filteredOrders;
}

// Fetch all orders from the database
$sql = "SELECT * FROM tbl_order ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

$orders = []; // Array to store orders

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $orders[] = [
            'id' => $row['id'],
            'food' => $row['food'], // Replace 'food' with the actual column name from your database
            'price' => $row['price'],
            'qty' => $row['qty'],
            'total' => $row['total'],
            'order_date' => $row['order_date'],
            'status' => $row['status'],
            'customer_name' => $row['customer_name'],
            'customer_contact' => $row['customer_contact'],
            'customer_email' => $row['customer_email'],
            'customer_address' => $row['customer_address']
        ];
    }
}

// Handle sorting by date/time
if (isset($_GET['sort']) && $_GET['sort'] == 'datetime') {
    $orders = sortByDateTime($orders);
}

// Handle filtering by status
if (isset($_GET['status'])) {
    $statusFilter = $_GET['status'];
    if ($statusFilter != 'all') {
        $orders = filterByStatus($orders, $statusFilter);
    }
}

// Handle search functionality
if (isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
    $searchedOrders = [];
    foreach ($orders as $order) {
        // Customize search criteria based on your needs
        if (stripos($order['customer_name'], $searchQuery) !== false ||
            stripos($order['id'], $searchQuery) !== false || // Added search by Order ID
            stripos($order['customer_contact'], $searchQuery) !== false ||
            stripos($order['customer_email'], $searchQuery) !== false ||
            stripos($order['customer_address'], $searchQuery) !== false ||
            stripos($order['order_date'], $searchQuery) !== false || // Added search by Order Date
            stripos($order['status'], $searchQuery) !== false || // Added search by Status
            stripos($order['food'], $searchQuery) !== false) { // Added search by Food
            $searchedOrders[] = $order;
        }
    }
    $orders = $searchedOrders;
}

// Handle actions (mark as processing, mark as delivered, etc.)
if (isset($_POST['action']) && isset($_POST['order_id'])) {
    $action = $_POST['action'];
    $orderId = $_POST['order_id'];

    // Update order status based on action
    switch ($action) {
        case 'processing':
            updateOrderStatus($orderId, 'Processing');
            break;
        case 'delivered':
            updateOrderStatus($orderId, 'Delivered');
            break;
        case 'cancelled':
            updateOrderStatus($orderId, 'Cancelled');
            break;
        // Add more cases as needed for other actions
        default:
            // Handle default case
            break;
    }
}

// Function to update order status
function updateOrderStatus($orderId, $status) {
    global $conn;

    $sql = "UPDATE tbl_order SET status = '$status' WHERE id = $orderId";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['update'] = "<div class='success'>Order status updated successfully.</div>";
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update order status.</div>";
    }

    // Redirect to manage-order.php after updating
    header("Location: manage-order.php");
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><br>

        <?php
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <div style="margin-bottom: 10px;">
            <a href="?sort=datetime" class="btn">Sort by Date/Time</a>
            <form action="" method="GET" style="display: inline;">
                <label for="status">Filter by Status:</label>
                <select id="status" name="status" onchange="this.form.submit()">
                    <option value="all" <?php if (!isset($_GET['status']) || $_GET['status'] == 'all') echo 'selected'; ?>>All Statuses</option>
                    <option value="Ordered" <?php if (isset($_GET['status']) && $_GET['status'] == 'Ordered') echo 'selected'; ?>>Ordered</option>
                    <option value="Processing" <?php if (isset($_GET['status']) && $_GET['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                    <option value="Cancelled" <?php if (isset($_GET['status']) && $_GET['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    <option value="Delivered" <?php if (isset($_GET['status']) && $_GET['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                </select>
            </form>

            <!-- Search Form -->
            <form action="" method="POST" style="display: inline;">
                <label for="search" style="margin-right: 10px;">Search:</label>
                <input type="text" id="search" name="search" placeholder="Search by Name, Order ID, Contact, Email, Address, Order Date, Status, Food" class="input-search">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Order ID</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th class="actions-column">Actions</th>
            </tr>

            <?php 
                $sn = 1; // Serial number initialization

                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['food']; ?></td>
                            <td>$<?php echo $order['price']; ?></td>
                            <td><?php echo $order['qty']; ?></td>
                            <td>$<?php echo $order['total']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td class="status <?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></td>
                            <td><?php echo $order['customer_name']; ?></td>
                            <td><?php echo $order['customer_contact']; ?></td>
                            <td><?php echo $order['customer_email']; ?></td>
                            <td><?php echo $order['customer_address']; ?></td>
                            <td>
                                <form action="manage-order.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" name="action" value="processing" class="btn-action processing">Mark as Processing</button>
                                    <button type="submit" name="action" value="delivered" class="btn-action delivered">Mark as Delivered</button>
                                    <button type="submit" name="action" value="cancelled" class="btn-action cancelled">Mark as Cancelled</button>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $order['id']; ?>" class="btn-action update">Update Order</a>
                                </form>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='13' class='error'>No matching orders found.</td></tr>";
                }
            ?>

</table>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<style>
    .tbl-full th,
    .tbl-full td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-size: 14px;
    }

    .tbl-full th {
        background-color: #f2f2f2;
    }

    .tbl-full tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbl-full tr:hover {
        background-color: #f2f2f2;
    }

    .btn-action {
        display: inline-block;
        margin-right: 5px;
        padding: 8px 12px;
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
        font-size: 12px;
        transition: background-color 0.3s;
    }

    .btn-action.processing {
        background-color: #f39c12; /* Orange */
    }

    .btn-action.delivered {
        background-color: #2ecc71; /* Green */
    }

    .btn-action.cancelled {
        background-color: #e74c3c; /* Red */
    }

    .btn-action.update {
        background-color: #3498db; /* Blue */
    }

    .btn-action:hover {
        opacity: 0.8;
    }

    .status {
        font-weight: bold;
        display: inline-block;
        padding: 6px 10px;
        border-radius: 4px;
        text-transform: capitalize;
    }

    .status.ordered {
        color: #fff;
        background-color: #3498db; /* Blue */
    }

    .status.processing {
        color: #fff;
        background-color: #f39c12; /* Orange */
    }

    .status.cancelled {
        color: #fff;
        background-color: #e74c3c; /* Red */
    }

    .status.delivered {
        color: #fff;
        background-color: #2ecc71; /* Green */
    }

    .error {
        color: red;
        font-style: italic;
    }

    .success {
        color: green;
        font-style: italic;
    }

    .input-search {
        padding: 8px;
        margin-right: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 300px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .actions-column {
        width: 200px;
    }
</style>
