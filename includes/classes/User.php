<?php
    class User {
        private $user;
        private $con;

        public function __construct($con, $username) {
            $this->con = $con;
            $userDetailsQuery = mysqli_query($con, "SELECT * FROM users WHERE users_username='$username'");
            $this->user = mysqli_fetch_array($userDetailsQuery);
        }

        public function getFirstAndLastName() {
            return $this->user['users_first_name'] . " " . $this->user['users_last_name'];
        }

        public function getNumPosts() {
            return $this->user['users_num_posts'];
        }

        public function getUsername(){
            return $this->user['users_username'];
        }
    }