<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food</title>
    <style>
        .tbl-full {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .tbl-full th, .tbl-full td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .tbl-full th {
            background-color: #007bff;
            color: #ffffff;
            text-transform: uppercase;
        }
        .tbl-full tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .tbl-full tr:hover {
            background-color: #f1f1f1;
        }
        .tbl-full td img {
            border-radius: 5px;
        }
        .btn-primary, .btn-secondary, .btn-danger {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Centered search bar styles */
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .search-container input[type="text"] {
            width: 300px;
            padding: 10px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ddd;
            outline: none;
        }
        .search-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 0 5px 5px 0;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .search-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include('partials/menu.php'); ?>

<!-- Main Content starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br>
        <!-- Button to add food -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br><br>

        <!-- Search form -->
        <div class="search-container">
            <form action="" method="POST">
                <input type="text" name="search" placeholder="Search for food...">
                <input type="submit" name="submit" value="Search">
            </form>
        </div>
        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo "<div class='success'>" . $_SESSION['add'] . "</div>";
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo "<div class='success'>" . $_SESSION['delete'] . "</div>";
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo "<div class='success'>" . $_SESSION['update'] . "</div>";
            unset($_SESSION['update']);
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT f.*, c.title AS category_title FROM tbl_food f INNER JOIN tbl_category c ON f.category_id = c.id";

            // Check if the search form was submitted
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $sql .= " WHERE f.title LIKE '%$search%' OR f.description LIKE '%$search%' OR c.title LIKE '%$search%'";
            }

            $res = mysqli_query($conn, $sql);
            $sn = 1;

            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $category = $row['category_title'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>

                    <tr>
                        <td><?php echo $sn++; ?>.</td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <?php 
                            if ($image_name != "") {
                                echo "<img src='" . SITEURL . "images/food/$image_name' width='100px'>";
                            } else {
                                echo "<div class='error'>Image not added.</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>

                    <?php
                }
            } else {
                echo "<tr><td colspan='9' class='error'>Food not found.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content ends here -->

<?php include('partials/footer.php'); ?>

</body>
</html>
