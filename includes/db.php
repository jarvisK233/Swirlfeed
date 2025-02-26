<?php
$con = mysqli_connect("localhost", "root", "", "swirlfeed");
if (mysqli_connect_errno()){
    echo "Failed to connect: " . mysqli_connect_errno();
}