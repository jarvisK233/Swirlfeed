<?php
    include "includes/db.php";
    session_start();
    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $queryResult = mysqli_query($con, "SELECT * FROM users WHERE users_username = '$loggedInUser'");
        $row = mysqli_fetch_array($queryResult);
        $id = $row['users_id'];
        $fName = $row['users_first_name'];
        $lName = $row['users_last_name'];
        $email = $row['users_email'];
    }
    else {
        header("Location: login.php");
    }

    if (isset($_POST['submitform1'])) {
        $fname = $_POST['fName'];
        $lname = $_POST['lName'];
        if (empty($fname)) {
            $fname = $fName;
        }
        if (empty($lname)) {
            $lname = $lName;
        }
        $query = mysqli_query($con, "UPDATE users SET users_first_name = '$fname', users_last_name = '$lname' WHERE users_id = '$id'");
    }

    $pwdArrError = [];
    if (isset($_POST['submitform2'])) {
        $oldpwd = md5($_POST['oldpwd']);
        $newpwd = md5($_POST['newpwd']);
        if (!empty($oldpwd) && !empty($newpwd)) {
            $checkQuery = mysqli_query($con, "SELECT users_password FROM users WHERE users_id = '$id'");
            $row = mysqli_fetch_array($checkQuery);
            $oldPasswordFromDb = $row['users_password'];
            if ($oldPasswordFromDb == $oldpwd){
                $query = mysqli_query($con, "UPDATE users SET users_password = '$newpwd' WHERE users_id = '$id'");
            }
            else {
                array_push($pwdArrError, "Old password is incorrect");
            }

        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Settings</title>
        <link rel="stylesheet" href="assets/fontawesome/all.css">
        <script defer src="assets/fontawesome/all.js"></script>
        <link rel="stylesheet" href="css/settings-style.css">
    </head>
    <body>
        <?php include "includes/header.php"; ?>
        <div class="wrapper">
            <div class="main-content">
                <form action="settings.php" method="post" class="form1">
                    <label for="fName">First Name: </label>
                    <input type="text" id="fName" value="<?php echo $fName?>" name="fName"><br><br>
                    <label for="lName">Last Name: </label>
                    <input type="text" id="lName" value="<?php echo $lName?>" name="lName"><br><br>
                    <input type="submit" name="submitform1" value="Update Details">
                </form>
                <h3>Change Password</h3>
                <form action="settings.php" method="post" class="form2">
                    <label for="oldpwd">Old Password: </label>
                    <input type="password" id="oldpwd" name="oldpwd"><br><br>
                    <?php if (isset($_POST['submitform2'])) {
                        if (in_array("Old password is incorrect", $pwdArrError)) {
                            echo "<span style='color: #DC3545'>Old password is incorrect</span><br>";
                        }
                    }?>
                    <label for="newpwd">New Password: </label>
                    <input type="password" id="newpwd" name="newpwd"><br><br>
                    <input type="submit" name="submitform2" value="Update Password">
                </form>
            </div>
        </div>
    </body>
</html>