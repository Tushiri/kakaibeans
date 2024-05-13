<?php

session_start();
include "connect.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=User name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        $pass = sha1($pass); // Assuming the passwords are stored as SHA-1 hashes in the database

        $sql = "SELECT * FROM admins WHERE name='$uname' AND password = '$pass'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['name'] === $uname && $row['password'] === $pass) {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['id'] = $row['id']; // This line sets the user_id in the session
                header("Location: home.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect user name or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect user name or password");
            exit();
        }
    }
} else {
    header("Location: home.php");
    exit();
}
