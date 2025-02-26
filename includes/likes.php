<?php
include "db.php";
    if (isset($_GET['post_id'])) {
        if (isset($_GET['user_id'])) {
            if (isset($_GET['val'])) {
                $postId = $_GET['post_id'];
                $userId = $_GET['user_id'];
                $val = $_GET['val'];
                $val = strtolower($val);
                if ($val == 'like') {
                    $insertQuery = mysqli_query($con, "INSERT INTO likes VALUES(NULL, '$userId', '$postId')");
                    $getAddedBy = mysqli_query($con, "SELECT posts_added_by FROM posts WHERE posts_id = '$postId'");
                    $row = mysqli_fetch_array($getAddedBy);
                    $addedBy = $row['posts_added_by'];
                    $getNumLikes = mysqli_query($con, "SELECT users_num_likes FROM users WHERE users_username = '$addedBy'");
                    $row = mysqli_fetch_array($getNumLikes);
                    $numLikes = intval($row['users_num_likes']);
                    $numLikes++;
                    $updateNumPostsQuery = mysqli_query($con, "UPDATE users SET users_num_likes = '$numLikes' WHERE users_username = '$addedBy'");
                }
                else {
                    $insertQuery = mysqli_query($con, "DELETE FROM likes WHERE likes_users_username = '$userId' AND likes_posts_id = '$postId'");
                    $getAddedBy = mysqli_query($con, "SELECT posts_added_by FROM posts WHERE posts_id = '$postId'");
                    $row = mysqli_fetch_array($getAddedBy);
                    $addedBy = $row['posts_added_by'];
                    $getNumLikes = mysqli_query($con, "SELECT users_num_likes FROM users WHERE users_username = '$addedBy'");
                    $row = mysqli_fetch_array($getNumLikes);
                    $numLikes = intval($row['users_num_likes']);
                    $numLikes--;
                    $updateNumPostsQuery = mysqli_query($con, "UPDATE users SET users_num_likes = '$numLikes' WHERE users_username = '$addedBy'");
                }
            }
        }
    }

    header("Location: ../index.php");