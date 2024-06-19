<?php
// Include the menu file which might contain header information or navigation
// Include the constants file for database connection
include('partials/menu.php');


// SQL queries to fetch data
$sqlCategory = "SELECT COUNT(id) AS total_categories FROM tbl_category";
$sqlFood = "SELECT COUNT(id) AS total_foods FROM tbl_food";
$sqlTotalOrders = "SELECT COUNT(id) AS total_orders FROM tbl_order";
$sqlProcessingOrders = "SELECT COUNT(id) AS processing_orders FROM tbl_order WHERE status = 'Processing'";
$sqlDeliveredOrders = "SELECT COUNT(id) AS delivered_orders FROM tbl_order WHERE status = 'Delivered'";
$sqlOrderedOrders = "SELECT COUNT(id) AS ordered_orders FROM tbl_order WHERE status = 'Ordered'";
$sqlCancelledOrders = "SELECT COUNT(id) AS cancelled_orders FROM tbl_order WHERE status = 'Cancelled'";
$sqlRevenue = "SELECT SUM(total) AS total_revenue FROM tbl_order WHERE status = 'Delivered'";

// Execute SQL queries to fetch data
$resultCategory = mysqli_query($conn, $sqlCategory);
$resultFood = mysqli_query($conn, $sqlFood);
$resultTotalOrders = mysqli_query($conn, $sqlTotalOrders);
$resultProcessingOrders = mysqli_query($conn, $sqlProcessingOrders);
$resultDeliveredOrders = mysqli_query($conn, $sqlDeliveredOrders);
$resultOrderedOrders = mysqli_query($conn, $sqlOrderedOrders);
$resultCancelledOrders = mysqli_query($conn, $sqlCancelledOrders);
$resultRevenue = mysqli_query($conn, $sqlRevenue);

// Function to fetch count from query result
function fetchCount($result) {
    global $conn;
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row[array_key_first($row)]; // Return the count value
    }
    return 0; // Return 0 if no rows found or query failed
}

// Function to fetch total revenue from query result
function fetchTotalRevenue($result) {
    global $conn;
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_revenue']; // Return the total revenue value
    }
    return 0; // Return 0 if no rows found or query failed
}

// Initialize variables to hold fetched data
$totalCategories = fetchCount($resultCategory);
$totalFoods = fetchCount($resultFood);
$totalOrders = fetchCount($resultTotalOrders);
$processingOrders = fetchCount($resultProcessingOrders);
$deliveredOrders = fetchCount($resultDeliveredOrders);
$orderedOrders = fetchCount($resultOrderedOrders);
$cancelledOrders = fetchCount($resultCancelledOrders);
$totalRevenue = fetchTotalRevenue($resultRevenue);

// Function to generate dynamic background color based on a string input
function generateColor($str) {
    $colors = ['#2980b9', '#c0392b', '#27ae60', '#f39c12', '#8e44ad', '#2c3e50', '#16a085']; // Array of predefined colors
    $index = crc32($str) % count($colors); // Generate an index based on the hash of the input string
    return $colors[$index]; // Return color from the array based on the index
}
?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <div class="dashboard-cards">
            <!-- Displaying different dashboard cards with dynamic styles -->
            <div class="dashboard-card category" style="background-color: <?php echo generateColor('Categories'); ?>">
                <h2 style="color: #fff;"><?php echo $totalCategories; ?></h2>
                <p style="color: #fff;">Categories</p>
            </div>

            <div class="dashboard-card foods" style="background-color: <?php echo generateColor('Foods'); ?>">
                <h2 style="color: #fff;"><?php echo $totalFoods; ?></h2>
                <p style="color: #fff;">Food Added </p>
            </div>

          
            <div class="dashboard-card processing-orders" style="background-color: <?php echo generateColor('Processing Orders'); ?>">
                <h2 style="color: #fff;"><?php echo $processingOrders; ?></h2>
                <p style="color: #fff;">Orders in Processing</p>
            </div>


            <div class="dashboard-card ordered-orders" style="background-color: <?php echo generateColor('Ordered Orders'); ?>">
                <h2 style="color: #fff;"><?php echo $orderedOrders; ?></h2>
                <p style="color:cornsilk;">Orders placed and awaiting processing</p>
            </div>

            <div class="dashboard-card cancelled-orders" style="background-color: <?php echo generateColor('Cancelled Orders'); ?>">
                <h2 style="color: #fff;"><?php echo $cancelledOrders; ?></h2>
                <p style="color: #fff;">Cancelled Orders</p>
            </div>

            <div class="dashboard-card total-orders" style="background-color: <?php echo generateColor('Total Orders'); ?>">
                <h2 style="color: #fff;"><?php echo $totalOrders; ?></h2>
                <p style="color: #fff;">Total Orders</p>
            </div>

            <div class="dashboard-card delivered-orders" style="background-color: <?php echo generateColor('Delivered Orders'); ?>">
                <h2 style="color: #fff;"><?php echo $deliveredOrders; ?></h2>
                <p style="color: #fff;">Successfully Delivered</p>
            </div>


            <div class="dashboard-card revenue" style="background-color: <?php echo generateColor('Total Revenue'); ?>">
                <h2 style="color: #fff;">$<?php echo $totalRevenue; ?></h2>
                <p style="color: #fff;">Revenue Generated</p>
            </div>
        </div>

        <div class="clearfix"></div> <!-- to fix floating categories in horizontal line -->
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>

<style>
    /* Basic styling for dashboard cards */
.dashboard-cards {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-top: 20px;
}

.dashboard-card {
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    width: 200px;
    margin: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: #fff;
}

.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
}

.dashboard-card h2 {
    font-size: 2.5rem;
    margin: 0;
    font-weight: 600;
}

.dashboard-card p {
    font-size: 1.2rem;
    margin-top: 10px;
    color: #666;
}

.dashboard-card.category {
    background-color: #2980b9; /* Blue color */
}

.dashboard-card.foods {
    background-color: #c0392b; /* Red color */
}

.dashboard-card.total-orders {
    background-color: #27ae60; /* Green color */
}

.dashboard-card.processing-orders {
    background-color: #f39c12; /* Orange color */
}

.dashboard-card.delivered-orders {
    background-color: #8e44ad; /* Purple color */
}

.dashboard-card.ordered-orders {
    background-color: #2c3e50; /* Dark blue color */
}

.dashboard-card.cancelled-orders {
    background-color: #16a085; /* Turquoise color */
}

.dashboard-card.revenue {
    background-color: #f1c40f; /* Yellow color */
}

</style>
