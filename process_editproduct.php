<?php
include("connect.php");

if (isset($_POST['update'])) {
    $edit_id = $_POST['edit_id'];
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productType = mysqli_real_escape_string($conn, $_POST['productType']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $weightUnit = mysqli_real_escape_string($conn, $_POST['weightUnit']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    $update_query = "UPDATE products SET name = '$productName', type = '$productType', weight = '$weight $weightUnit', price = '$price', quantity = '$quantity' WHERE product_id = '$edit_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: product1.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
