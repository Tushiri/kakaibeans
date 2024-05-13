<?php
include("connect.php");

// Initialize $availableQuantity
$availableQuantity = 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $customerName = mysqli_real_escape_string($conn, $_POST["customer_name"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $cellphoneNumber = mysqli_real_escape_string($conn, $_POST["cellphone_number"]);
    $productName = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $selectedQuantity = intval($_POST["quantity"]); // Ensure it's an integer
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    // Validate product name
    $productQuery = "SELECT * FROM products WHERE name = '$productName'";
    $productResult = mysqli_query($conn, $productQuery);

    if ($productResult) {
        $productRow = mysqli_fetch_assoc($productResult);

        if ($productRow && isset($productRow["name"])) {
            $availableQuantity = $productRow["quantity"];
    
            if ($selectedQuantity > 0 && $selectedQuantity <= $availableQuantity) {
                // Calculate total price
                $totalPrice = $selectedQuantity * $productRow["price"];
    
                // Insert order into the database
                $insertQuery = "INSERT INTO orders (customer_name, address, cellphone_number, product_name, quantity, total_price, status) VALUES ('$customerName', '$address', '$cellphoneNumber', '$productName', $selectedQuantity, $totalPrice, '$status')";
                $insertResult = mysqli_query($conn, $insertQuery);
    
                if ($insertResult) {
                    // Update product quantity in the products table
                    $newQuantity = $availableQuantity - $selectedQuantity;
                    $updateProductQuery = "UPDATE products SET quantity = $newQuantity WHERE name = '$productName'";
                    mysqli_query($conn, $updateProductQuery);
    
                    // Check if the order status is "Complete"
                    if ($status === 'Complete') {
                        // Retrieve the last inserted order ID
                        $lastInsertId = mysqli_insert_id($conn);
    
                        // Move the completed order to the history table
                        $insertHistoryQuery = "INSERT INTO history (customer_name, address, cellphone_number, product_name, quantity, total_price, status) VALUES ('$customerName', '$address', '$cellphoneNumber', '$productName', $selectedQuantity, $totalPrice, '$status')";
                        mysqli_query($conn, $insertHistoryQuery);
    
                        // Delete the order from the orders table
                        $deleteOrderQuery = "DELETE FROM orders WHERE id = $lastInsertId";
                        mysqli_query($conn, $deleteOrderQuery);
    
                        // Redirect to history.php after adding the order
                        header("Location: history.php");
                        exit();
                    } else {
                        // Redirect to orders.php after adding the order
                        header("Location: orders.php");
                        exit();
                    }
                } else {
                    $error = "Error inserting order: " . mysqli_error($conn);
                }
            } else {
                $error = "Invalid quantity or exceeds available quantity for the product.";
            }
        } else {
            $error = "Product name is not set in the database.";
        }
    } else {
        $error = "Product not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add Orders</title>
    <script>
        function updateMaxQuantity() {
            var productSelect = document.getElementById("product_name");
            var quantityInput = document.getElementById("quantity");
            var selectedProductOption = productSelect.options[productSelect.selectedIndex];

            // Check if the selected option has the 'data-max' attribute
            if (selectedProductOption.hasAttribute("data-max")) {
                var maxQuantity = selectedProductOption.getAttribute("data-max");
                quantityInput.setAttribute("max", maxQuantity);
            } else {
                // If 'data-max' attribute is not present, set max to an arbitrary large value
                quantityInput.setAttribute("max", "1000000");
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h3>Add Order</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="cellphone_number">Cellphone Number:</label>
                <input type="text" class="form-control" id="cellphone_number" name="cellphone_number" required>
            </div>
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <select class="form-control" id="product_name" name="product_name" onchange="updateMaxQuantity()" required>
    <?php
    $productsQuery = "SELECT name, quantity FROM products";
    $productsResult = mysqli_query($conn, $productsQuery);

    while ($productRow = mysqli_fetch_assoc($productsResult)) {
        echo "<option value='" . $productRow["name"] . "' data-max='" . $productRow["quantity"] . "'>" . $productRow["name"] . "</option>";
    }
    ?>
</select>

            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="To Ship">To Ship</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Complete">Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Order</button>
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