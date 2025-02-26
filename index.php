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

    if (isset($_POST['post'])) {
        $post = new Post($con, $loggedInUser);
        $post->submitPost($_POST['post_text'], 'none');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to swirlfeed</title>
        <link rel="stylesheet" href="assets/fontawesome/all.css">
        <script defer src="assets/fontawesome/all.js"></script>
        <link rel="stylesheet" href="css/index-style.css">
    </head>
    <body>
        <?php include "includes/header.php"; ?>
        <div class="wrapper">
            <div class="sidebar">
                <div class="profile">
                    <img src="<?php echo $row['users_profile_pic']; ?>">
                    <div class="profile-name">
                        <a href="<?php echo $loggedInUser; ?>"><?php echo $row['users_first_name'] . " " . $row['users_last_name']; ?></a>
                        <p>Posts: <?php echo $row['users_num_posts']; ?></p>
                        <p>Likes: <?php echo $row['users_num_likes']; ?></p>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="main-content-top-area">
                    <form action="index.php" method="post">
                        <textarea placeholder="Post a swirl!" name="post_text"></textarea>
                        <button type="submit" name="post">Swirl!</button>
                    </form>
                    <hr>
                </div>
                <?php $post = new Post($con, $loggedInUser);
                $post->loadFriendsPosts('none'); ?>
            </div>
        </div>
    </body>
</html>