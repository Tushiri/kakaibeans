<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Products</title>
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
    <h2 class="mb-4">Add Products</h2>
    
    <form id="addProductForm" action="process_addproduct.php" method="post">
        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" class="form-control" id="productName" name="productName" required>
        </div>

        <div class="form-group">
            <label for="productType">Product Type:</label>
            <select class="form-control" id="productType" name="productType" required>
                <option value="flavored">Flavored</option>
                <option value="classic">Classic</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Weight:</label>
            <div class="input-group">
                <input type="number" class="form-control" id="weight" name="weight" required>
                <div class="input-group-append">
                    <select class="custom-select" id="weightUnit" name="weightUnit" required>
                        <option value="grams">grams</option>
                        <option value="kg">kg</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="upload">Upload</button>
            <a href="product1.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
