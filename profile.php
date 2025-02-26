<?php
    include "includes/db.php";
    include "includes/classes/Post.php";

    session_start();
    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $queryResult = mysqli_query($con, "SELECT * FROM users WHERE users_username = '$loggedInUser'");
        $row = mysqli_fetch_array($queryResult);
    }
    else {
        header("Location: login.php");
    }
    $profileUsername = $_GET['profile_username'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE users_username ='$profileUsername'");
    $row = mysqli_fetch_array($query);
    $img = $row['users_profile_pic'];
    $numPosts = $row['users_num_posts'];
    $numLikes = $row['users_num_likes'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $row['users_first_name'] . " " . $row['users_last_name']?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="assets/fontawesome/all.css">
        <script defer src="assets/fontawesome/all.js"></script>
        <link rel="stylesheet" href="css/profile-style.css">
    </head>
    <body>
        <?php include "includes/header.php"; ?>

        <div class="nav-bar">
            <img src="<?php echo $img ?>" width="85px" height="85px">
            <div class="navbar-post-num">
                <span>Posts: <?php echo $numPosts ?></span>
                <span>Likes: <?php echo $numLikes ?></span>
            </div>
        </div>

        <div class="tablist">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-swirl" role="tab" aria-controls="nav-swirl" aria-selected="true">Swirlfeed</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">About</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-msg" role="tab" aria-controls="nav-msg" aria-selected="false">Message</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-swirl" role="tabpanel" aria-labelledby="nav-home-tab">
                    <?php
                        $post = new Post($con, $loggedInUser);
                        $post->loadFriendsPosts($profileUsername);
                    ?>
                </div>
                <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                <div class="tab-pane fade" id="nav-msg" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
            </div>
        </div>

        <script src="assets/bootstrap/js/jquery-3.4.1.js"></script>
        <script src="assets/bootstrap/js/popper.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.js"></script>
    </body>
</html>