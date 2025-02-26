<?php
    include "includes/db.php";
    $fName = "";
    $lName = "";
    $email = "";
    $emailConf = "";
    $pwd = "";
    $pwdConf = "";
    $username = "";
    $profilePic = "";
    $errorArray = [];
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
    if (isset($_POST['submit'])) {
        $fName = strip_tags($_POST['fname']);
        $fName = str_replace(' ', '', $fName);
        $lName = strip_tags($_POST['lname']);
        $lName = str_replace(' ', '', $lName);
        $email = strip_tags($_POST['email']);
        $emailConf = strip_tags($_POST['emailconf']);
        $pwd = strip_tags($_POST['pwd']);
        $pwdConf = strip_tags($_POST['pwdconf']);

        if (strlen($fName) > 25 || strlen($fName) < 2) {
            array_push($errorArray, "First name must contain 2 to 25 characters!<br>");
        }

        if (strlen($lName) > 25 || strlen($lName) < 2) {
            array_push($errorArray, "Last name must contain 2 to 25 characters!<br>");
        }

        if ($email != $emailConf) {
            array_push($errorArray, "Emails doesn't match!<br>");
        }

        $eCheck = mysqli_query($con, "SELECT users_email FROM users WHERE users_email = '$email'");
        $numRows = mysqli_num_rows($eCheck);

        if ($numRows > 0 ) {
            array_push($errorArray, "Email already in use!<br>");
        }

        if ($pwd != $pwdConf) {
            array_push($errorArray, "Passwords doesn't match!<br>");
        }

        if (strlen($pwd) > 30 || strlen($pwd) < 5) {
            array_push($errorArray, "Password must contain 5 to 30 characters<br>");
        }

        if (empty($errorArray)) {
            $pwd = md5($pwd);

            $username = strtolower($fName . "_" . $lName);
            $checkUsername = mysqli_query($con, "SELECT users_username FROM users WHERE users_username='$username'");
            $i = 0;
            while (mysqli_num_rows($checkUsername) != 0) {
                $i++;
                $username = $username . "_" . $i;
                $checkUsername = mysqli_query($con, "SELECT users_username FROM users WHERE users_username='$username'");
            }

            $profilePic = "images/profile-pics/defauls/head_alizarin.png";
            $date = date("Y-m-d");
            $insertQuery = mysqli_query($con, "INSERT INTO users VALUES (NULL, '$fName', '$lName', '$username', '$email', '$pwd', '$date', '$profilePic', 0, 0, '')");

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/register-style.css">
        <title>Register on swirlfeed</title>
    </head>
    <body>
        <div class="logindiv">
            <div class="logintitle">
                <h1>Swirlfeed!</h1>
                <p>Login or sign up below!</p>
            </div>
            <div class="formdiv">
                <form action="register.php" method="post">
                    <input type="text" name="fname" placeholder="First Name" required>
                    <?php if (in_array("First name must contain 2 to 25 characters!<br>", $errorArray))
                        echo "<span style='color: #DC3545'>First name must contain 2 to 25 characters!</span>" ?>
                    <input type="text" name="lname" placeholder="Last Name" required>
                    <?php if (in_array("Last name must contain 2 to 25 characters!<br>", $errorArray))
                        echo "<span style='color: #DC3545'>Last name must contain 2 to 25 characters!</span>" ?>
                    <input type="email" name="email" placeholder="Email address" required>
                    <?php if (in_array("Emails doesn't match!<br>", $errorArray))
                        echo "<span style='color: #DC3545'>Emails doesn't match!<br></span>";
                    if (in_array("Email already in use!<br>", $errorArray))
                        echo "<span style='color: #DC3545'>Email already in use!</span>" ?>
                    <input type="email" name="emailconf" placeholder="Confirm Email address" required>
                    <input type="password" name="pwd" placeholder="Password" required>
                    <?php if (in_array("Passwords doesn't match!<br>", $errorArray))
                        echo "<span style='color: #DC3545'>Passwords doesn't match!<br></span>";
                        if (in_array("Password must contain 5 to 30 characters<br>", $errorArray))
                            echo "<span style='color: #DC3545'>Password must contain 5 to 30 characters</span>"?>
                    <input type="password" name="pwdconf" placeholder="Confirm Password" required>
                    <input type="submit" name="submit" value="Register">
                    <?php if (isset($insertQuery) && $insertQuery==true) echo "<span style='color: #28A745'>Congrats! you can login now</span>" ?>
                </form>
            </div>
            <a href="login.php">Already have an account? Login here!</a>
        </div>
    </body>
</html>