<?php
include("connect.php");

if (isset($_POST['upload'])) {
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productType = mysqli_real_escape_string($conn, $_POST['productType']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $weightUnit = mysqli_real_escape_string($conn, $_POST['weightUnit']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    $insert_query = "INSERT INTO products (name, type, weight, price, quantity) VALUES ('$productName', '$productType', '$weight $weightUnit', '$price', '$quantity')";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: product1.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>