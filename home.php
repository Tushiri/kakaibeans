<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page or any other appropriate action
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    // Redirect to the login page or any other appropriate action after logout
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/homeStyle.css"> 
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Home</title>
</head>

<body style="background-color: #E48F45;">
    <div class="container-fluid" >
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky">
                    <div class="company-logo-container">
                        <img src="assets/logo.png" alt="KAKAIBEANS Logo" class="company-logo">
                        <b class="company-name">KAKAIBEANS</b>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="home.php">
                            <img src="assets/home.png" alt="Home Icon" width="20" height="20" style="margin-right: 10px;">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orders.php">
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

            <!-- Your content goes here -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <br>
  <h1  style="font-family: 'Arial Black', sans-serif;"><center>KAKAIBEANS</center></h1>
  <br>
<div class="responsive">
  <div class="gallery">
    <a target="_blank" href="assets/pic1.jpg">
      <img src="assets/pic1.jpg" alt="Cinque Terre" width="600" height="400">
    </a>
    <div class="desc" style="color:white;">Kakaibeans Flavored (120g)</div>
  </div>
</div>


<div class="responsive">
  <div class="gallery">
    <a target="_blank" href="assets/pic2.jpg">
      <img src="assets/pic2.jpg" alt="Forest" width="600" height="400">
    </a>
    <div class="desc" style="color:white;">Kakaibeans Barako (500g)</div>
  </div>
</div>

<div class="responsive">
  <div class="gallery">
    <a target="_blank" href="assets/pic3.jpg">
      <img src="assets/pic3.jpg" alt="Northern Lights" width="600" height="400">
    </a>
    <div class="desc" style="color:white;">Kakaibeans Classic (1kg)</div>
  </div>
</div>

<div class="responsive">
  <div class="gallery">
    <a target="_blank" href="assets/pic4.jpg">
      <img src="assets/pic4.jpg" alt="Mountains" width="600" height="400">
    </a>
    <div class="desc" style="color:white;">Kakaibeans Flavored (250g)</div>
  </div>
</div>

<div class="clearfix"></div>

<div style="padding:6px;">
<br><br>
  <h3 style="color:white;"><center>We know that you're looking for something new and exciting to make your events even more special. ✨</center></h3>
  <h4 style="color:white;"><center>We're thrilled to announce that we've expanded our services to include Kakaibeans Coffee Bar. ☕✨</center></h4>
</div>

            <div class="alert-container">
                    <div class="alert alert-default">
                      <br><br><br><br><br>
                        <p style="color:white;">&copy; 2023 Kakaibeans | All Rights Reserved | Designed by: OurGroup </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>