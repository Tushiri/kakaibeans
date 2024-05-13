<?php
include("connect.php");

session_start();

if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page or any other appropriate action
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    // Redirect to the login page or any other appropriate action after logout
    header("Location: index.php");
    exit();
}

$select_query = "SELECT * FROM orders";
$select_result = mysqli_query($conn, $select_query);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM orders WHERE id = '$delete_id'";
    mysqli_query($conn, $delete_query);

    header("Location: orders.php");
    exit(); // Make sure to exit after redirecting
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/homeStyle.css"> 
    <link rel="stylesheet" href="css/font.css"> 
    <link rel="stylesheet" href="css/docs.css">
    <title>Orders</title>
</head>
<style>
    /* Add your custom styles here */
    .actions-btns {
        display: flex;
        justify-content: space-between;
    }
</style>
<body style="background-color: #E48F45;">
<div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky">
                    <div class="company-logo-container">
                        <img src="assets/logo.png" alt="KAKAIBEANS Logo" class="company-logo">
                        <b class="company-name">KAKAIBEANS</b>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                            <img src="assets/home.png" alt="Home Icon" width="20" height="20" style="margin-right: 10px;">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="orders.php">
                            <img src="assets/order.png" alt="Orders Icon" width="20" height="20" style="margin-right: 10px;"> 
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product1.php">
                            <img src="assets/product.png" alt="Product Icon" width="20" height="20" style="margin-right: 10px;"> 
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="history.php">
                            <img src="assets/history.png" alt="Product Icon" width="20" height="20" style="margin-right: 10px;"> 
                                History
                            </a>
                        </li>
                    </ul>
                    <hr class="dropdown-divider">
                    <ul class="nav flex-column mt-auto">
                    <form method="post">
                      <button type="submit" name="logout" style="background-color:#946d4b;">Logout</button>
                    </form>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <center>
                    <br>
                    <h3 class="black"><strong>Orders Management</strong> </h3>
                    <br><br>
                    <div class="text-center">
                    <a class="btn btn-primary" href="add_orders.php" role="button">Add Order</a>
                    </div>
                    <br>
                </center>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Cellphone Number</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($select_result) > 0) {
                            while ($row = mysqli_fetch_assoc($select_result)) {
                                ?>
                                <tr>
                                    <td class="single-line" style="color:white;"><?php echo $row['customer_name']; ?></td>
                                    <td class="single-line" style="color:white;"><?php echo $row['address']; ?></td>
                                    <td class="single-line" style="color:white;"><?php echo $row['cellphone_number']; ?></td>
                                    <td class="single-line" style="color:white;"><?php echo getProductNames($row['product_name']); ?></td>
                                    <td class="single-line" style="color:white;"><?php echo $row['quantity']; ?></td>
                                    <td class="single-line" style="color:white;"><?php echo $row['total_price']; ?></td>
                                    <td class="single-line" style="color:white;"><?php echo $row['status']; ?></td>
                                    <td>
                                    <a class="btn btn-info" href="editorder.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('Are you sure to update this order?')">
                                        <span class='glyphicon glyphicon-pencil'></span> Update
                                    </a>
                                    &nbsp;&nbsp;
                                    <a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('Are you sure to remove this order?')">
                                        <span class='glyphicon glyphicon-trash'></span> Remove
                                    </a>
                                </td>

                                </tr>
                                <?php
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<br />";
    echo '<div class="alert">
    </div>';
    echo "</div>";
} else {
    ?>
    <div class="col-xs-12">
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
        </div>
    </div>
    <?php
}
?>
</div>
</div>
</div>
</div>

                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function updateOrder(orderId) {
            // Implement your update logic here
            console.log('Update Order:', orderId);
        }

        function removeOrder(orderId) {
            // Implement your remove logic here
            console.log('Remove Order:', orderId);
        }
    </script>

    <?php
    // Function to get product names based on product IDs
    function getProductNames($productNames) {
        $productNamesArray = explode(",", $productNames);
        $productNamesResult = [];
    
        foreach ($productNamesArray as $productName) {
            $productNamesResult[] = $productName;
        }
    
        return implode(", ", $productNamesResult);
    }
    ?>
</body>
</html>
