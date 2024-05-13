<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Edit Product</h2>

    <?php
    include("connect.php");

    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];

        $select_query = "SELECT * FROM products WHERE product_id = '$edit_id'";
        $select_result = mysqli_query($conn, $select_query);

        if ($select_result) {
            $row = mysqli_fetch_assoc($select_result);
    ?>
    
    <form id="editProductForm" action="process_editproduct.php" method="post">
        <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">

        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $row['name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="productType">Product Type:</label>
            <select class="form-control" id="productType" name="productType" required>
                <option value="flavored" <?php echo ($row['type'] == 'flavored') ? 'selected' : ''; ?>>Flavored</option>
                <option value="classic" <?php echo ($row['type'] == 'classic') ? 'selected' : ''; ?>>Classic</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Weight:</label>
            <div class="input-group">
                <input type="number" class="form-control" id="weight" name="weight" value="<?php echo $row['weight']; ?>" required>
                <div class="input-group-append">
                    <select class="custom-select" id="weightUnit" name="weightUnit" required>
                        <option value="grams" <?php echo ($row['weightUnit'] == 'grams') ? 'selected' : ''; ?>>grams</option>
                        <option value="kg" <?php echo ($row['weightUnit'] == 'kg') ? 'selected' : ''; ?>>kg</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="update">Update</button>
            <a href="product1.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <?php
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
