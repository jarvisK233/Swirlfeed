<?php
    include "includes/db.php";
    $email = "";
    $pwd = "";
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $pwd = md5($pwd);
        $checkQuery = mysqli_query($con, "SELECT * FROM users WHERE users_email = '$email' AND users_password = '$pwd'");
        $queryNumRows = mysqli_num_rows($checkQuery);

        if ($queryNumRows == 1 ) {
            $row = mysqli_fetch_array($checkQuery);
            $username = $row['users_username'];
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/login-style.css">
        <title>Login to swirlfeed</title>
    </head>
    <body>
        <div class="logindiv">
            <div class="logintitle">
                <h1>Swirlfeed!</h1>
                <p>Login or sign up below!</p>
            </div>
            <div class="formdiv">
                <form action="login.php" method="post">
                    <input type="email" name="email" placeholder="Email address" required>
                    <input type="password" name="pwd" placeholder="Password" required>
                    <input type="submit" name="submit" value="Login">
                    <?php if (isset($queryNumRows) and $queryNumRows == 0) echo "<span style='color: #DC3545'>Password or email are invalid!</span>"?>
                </form>
            </div>
            <a href="register.php">Need an account? Register here!</a>
        </div>
    </body>
</html>