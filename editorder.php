<?php
include("connect.php");

// Check if edit_id is set in the URL
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];

    // Fetch the order details from the database
    $selectQuery = "SELECT * FROM orders WHERE id = $editId";
    $selectResult = mysqli_query($conn, $selectQuery);

    if ($selectResult && mysqli_num_rows($selectResult) > 0) {
        $orderDetails = mysqli_fetch_assoc($selectResult);
    } else {
        // Redirect to the orders list if the order is not found
        header("Location: orders.php");
        exit();
    }
} else {
    // Redirect to the orders list if edit_id is not set
    header("Location: orders.php");
    exit();
}

// Handle form submission for updating the order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = mysqli_real_escape_string($conn, $_POST["customer_name"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $cellphoneNumber = mysqli_real_escape_string($conn, $_POST["cellphone_number"]);
    $productName = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $quantity = intval($_POST["quantity"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    // Update the order in the database
    $updateQuery = "UPDATE orders SET customer_name = '$customerName', address = '$address', cellphone_number = '$cellphoneNumber', product_name = '$productName', quantity = $quantity, status = '$status' WHERE id = $editId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Move to history and delete from orders if status is 'Complete'
        if ($status === 'Complete') {
            // Check if the order already exists in the history table
            $checkHistoryQuery = "SELECT * FROM history WHERE id = $editId";
            $checkHistoryResult = mysqli_query($conn, $checkHistoryQuery);

            if ($checkHistoryResult && mysqli_num_rows($checkHistoryResult) == 0) {
                $insertHistoryQuery = "INSERT INTO history SELECT * FROM orders WHERE id = $editId";
                mysqli_query($conn, $insertHistoryQuery);
            }

            $deleteOrderQuery = "DELETE FROM orders WHERE id = $editId";
            mysqli_query($conn, $deleteOrderQuery);

            header("Location: history.php");
        } else {
            header("Location: orders.php");
        }
        exit();
    } else {
        $error = "Error updating order: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Order</title>
</head>
<body>
    <div class="container mt-5">
        <h3>Edit Order</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?edit_id=$editId"); ?>">
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $orderDetails['customer_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" required><?php echo $orderDetails['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="cellphone_number">Cellphone Number:</label>
                <input type="text" class="form-control" id="cellphone_number" name="cellphone_number" value="<?php echo $orderDetails['cellphone_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $orderDetails['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $orderDetails['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="To Ship" <?php echo ($orderDetails['status'] == 'To Ship') ? 'selected' : ''; ?>>To Ship</option>
                    <option value="Cancelled" <?php echo ($orderDetails['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    <option value="Ongoing" <?php echo ($orderDetails['status'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                    <option value="Complete"<?php echo ($orderDetails['status'] == 'Complete') ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="orders.php" class="btn btn-secondary">Cancel</a>
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='mt-3 alert alert-danger'>$error</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
