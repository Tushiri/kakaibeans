<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/loginStyle.css">
    <title>LoginPage</title>
</head>
<body>
<form action="login.php" method="post">
        <h2>LOG IN</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error'];?></p>

        <?php } ?>
        <label>Account Name</label>
        <input type="text" name="uname" placeholder="Account Name"> <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password"> <br>

        <button type="submit">Login</button>
    </form>
    
</body>
</html>