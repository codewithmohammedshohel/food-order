<?php
include('../config/constants.php');  // Adjust the path according to the actual location
include('login-check.php');
?>

<html>

<head>
    <title>Control Panel - TASTE ASWESOME FOOD</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        /* CSS for the logo and menu */
        .menu {
            text-align: center;
        }
        .menu .wrapper {
            display: inline-block;
        }
        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .menu ul li {
            display: inline-block;
            margin-right: 20px;
            vertical-align: middle;
        }
        .menu ul li img {
            width: 100px;
            height: auto;
        }
        .menu ul li:nth-child(2) {
            font-size: 24px;
            font-weight: bold;
            animation: text-animation 2s infinite alternate;
        }
        .menu ul li a {
            text-decoration: none;
            color: black; /* Change color as per your design */
        }
        @keyframes text-animation {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<body>

    <!-- Menu section starts here -->
    <div class="menu">
        <div class="wrapper">
            <ul>
                <li>
                    <img src="<?php echo SITEURL; ?>images/logo1.png" alt="Restaurant Logo">
                </li>
                <li>
                    TASTE AWESOME FOOD
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="manage-admin.php">Admin</a></li>
                <li><a href="manage-category.php">Manage Category</a></li>
                <li><a href="manage-food.php">Manage Food</a></li>
                <li><a href="manage-order.php">Manage Order</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- Menu section ends here -->

</body>

</html>
