<?php
    include "User.php";
    class Post{
        private $user_obj;
        private $con;

        public function __construct($con, $user)
        {
            $this->user_obj = new User($con, $user);
            $this->con = $con;
        }

        public function submitPost($body, $user_to){
            $body = strip_tags($body);
            $body = mysqli_real_escape_string($this->con, $body);
            $check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces

            if ($check_empty != "") {
                $added_date = date("Y-m-d H:i:s");
                $added_by = $this->user_obj->getUsername();
                if ($user_to == $added_by) {
                    $user_to = "none";
                }

                $query = mysqli_query($this->con, "INSERT INTO posts VALUES(NULL, '$body', '$added_by', '$user_to', '$added_date', 0)");
                $returnedId = mysqli_insert_id($this->con);

                $numPosts = $this->user_obj->getNumPosts();
                $numPosts++;
                $updateQuery = mysqli_query($this->con, "UPDATE users SET users_num_posts = '$numPosts' WHERE users_username = '$added_by'");
            }
        }

        public function loadFriendsPosts($posts_added_by){
            if ($posts_added_by == 'none'){
                $data_query = mysqli_query($this->con, "SELECT * FROM posts ORDER BY posts_id DESC");
            }
            else {
                $data_query  = mysqli_query($this->con, "SELECT * FROM posts WHERE posts_added_by ='$posts_added_by' ORDER BY posts_id DESC");
            }
            $str = ""; //String to return


            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['posts_id'];
                $body = $row['posts_body'];
                $added_by = $row['posts_added_by'];
                $date_time = $row['posts_added_date'];


                //Prepare user_to string so it can be included even if not posted to a user
                if ($row['posts_to'] == "none") {
                    $user_to = "";
                } else {
                    $user_to_obj = new User($this->con, $row['posts_to']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to = "to <a href='" . $row['posts_to'] . "'>" . $user_to_name . "</a>";
                }
                $userDetailsQuery = mysqli_query($this->con, "SELECT users_first_name, users_last_name, users_profile_pic, users_username FROM users WHERE users_username='$added_by'");
                $userRow = mysqli_fetch_array($userDetailsQuery);
                $user_first_name = $userRow['users_first_name'];
                $user_last_name = $userRow['users_last_name'];
                $user_profile_pic = $userRow['users_profile_pic'];
                $user_username = $userRow['users_username'];

                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($date_time); //Time of post
                $end_date = new DateTime($date_time_now); //Current time
                $interval = $start_date->diff($end_date); //Difference between dates
                if($interval->y >= 1) {
                    if($interval == 1)
                        $time_message = $interval->y . " year ago"; //1 year ago
                    else
                        $time_message = $interval->y . " years ago"; //1+ year ago
                }
                else if ($interval->m >= 1) {
                    if($interval->d == 0) {
                        $days = " ago";
                    }
                    else if($interval->d == 1) {
                        $days = $interval->d . " day ago";
                    }
                    else {
                        $days = $interval->d . " days ago";
                    }


                    if($interval->m == 1) {
                        $time_message = $interval->m . " month". $days;
                    }
                    else {
                        $time_message = $interval->m . " months". $days;
                    }

                }
                else if($interval->d >= 1) {
                    if($interval->d == 1) {
                        $time_message = "Yesterday";
                    }
                    else {
                        $time_message = $interval->d . " days ago";
                    }
                }
                else if($interval->h >= 1) {
                    if($interval->h == 1) {
                        $time_message = $interval->h . " hour ago";
                    }
                    else {
                        $time_message = $interval->h . " hours ago";
                    }
                }
                else if($interval->i >= 1) {
                    if($interval->i == 1) {
                        $time_message = $interval->i . " minute ago";
                    }
                    else {
                        $time_message = $interval->i . " minutes ago";
                    }
                }
                else {
                    if($interval->s < 30) {
                        $time_message = "Just now";
                    }
                    else {
                        $time_message = $interval->s . " seconds ago";
                    }
                }

                $likeOrUnlikeStr = "";
                $loggedInUser = "";
                if (isset($_SESSION['username'])) {
                    $loggedInUser = $_SESSION['username'];
                    $likeOrUnlikeQuery = mysqli_query($this->con, "SELECT * FROM likes WHERE likes_users_username = '$loggedInUser' AND likes_posts_id
='$id'");
                    if (mysqli_num_rows($likeOrUnlikeQuery) == 0){
                        $likeOrUnlikeStr.="Like";
                    }
                    else {
                        $likeOrUnlikeStr.="Unlike";
                    }
                }

                $numLikesQuery = mysqli_query($this->con, "SELECT * FROM likes WHERE likes_posts_id = '$id'");
                $numLikes = mysqli_num_rows($numLikesQuery);



                $str.= "<div class='post'>
                    <div class='post-name-content-date'>
                        <img src='$user_profile_pic' width='50px' height='50px'>
                        <a href='$user_username'>$user_first_name $user_last_name</a>$user_to<span>&nbsp;&nbsp;&nbsp; $time_message</span>
                        <p>$body</p>
                    </div>
                    <div class='post-comments-likes'>
                        <form action='includes/likes.php' method='get'>
                            <input type='hidden' name= 'post_id' value='$id'>
                            <input type='hidden' name= 'user_id' value='$loggedInUser'>
                            <input type='hidden' name= 'val' value='$likeOrUnlikeStr'>
                            <input type='submit' name='submit' value='$likeOrUnlikeStr'><span>&nbsp;&nbsp;&nbsp; $numLikes Likes</span>
                        </form>
                    </div>
                    <hr>
                </div>";

            }
            echo $str;
        }
    }
