-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2019 at 06:03 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swirlfeed`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likes_id` int(11) NOT NULL,
  `likes_users_username` varchar(60) NOT NULL,
  `likes_posts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likes_id`, `likes_users_username`, `likes_posts_id`) VALUES
(13, 'ala_benyahia', 4),
(14, 'ala_benyahia', 3),
(17, 'atef_benyahia', 4),
(18, 'atef_benyahia', 6),
(19, 'abir_benyahia', 4),
(20, 'abir_benyahia', 6),
(21, 'ala_benyahia', 6);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `posts_id` int(11) NOT NULL,
  `posts_body` text NOT NULL,
  `posts_added_by` varchar(60) NOT NULL,
  `posts_to` varchar(60) NOT NULL,
  `posts_added_date` datetime NOT NULL,
  `posts_num_likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`posts_id`, `posts_body`, `posts_added_by`, `posts_to`, `posts_added_date`, `posts_num_likes`) VALUES
(2, 'This is the first post!', 'ala_benyahia', 'none', '2019-11-08 18:08:25', 0),
(3, 'This is the second post', 'ala_benyahia', 'none', '2019-11-09 14:00:06', 0),
(4, 'This is the third post!', 'ala_benyahia', 'none', '2019-11-09 14:01:35', 0),
(5, 'Yaaaa ateffff', 'ala_benyahia', 'none', '2019-11-09 14:15:29', 0),
(6, 'waaa ala', 'atef_benyahia', 'none', '2019-11-09 14:18:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_first_name` varchar(25) NOT NULL,
  `users_last_name` varchar(25) NOT NULL,
  `users_username` varchar(100) NOT NULL,
  `users_email` varchar(100) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `users_signup_date` date NOT NULL,
  `users_profile_pic` varchar(255) NOT NULL,
  `users_num_posts` int(11) NOT NULL,
  `users_num_likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_first_name`, `users_last_name`, `users_username`, `users_email`, `users_password`, `users_signup_date`, `users_profile_pic`, `users_num_posts`, `users_num_likes`) VALUES
(1, 'Ala', 'Ben yahia', 'ala_benyahia', 'ala@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2019-11-07', 'images/profile-pics/defaults/head_alizarin.png', 4, 4),
(2, 'Atef', 'Ben yahia', 'atef_benyahia', 'atef@live.fr', '36e3b4b814a4c7811096ffe037a01940', '2019-11-07', 'images/profile-pics/defaults/head_alizarin.png', 1, 3),
(6, 'abir', 'benyahia', 'abir_benyahia', 'abir@hotmail.com', '05d50eb3518ed5a53e44d671cde9d4c0', '2019-11-07', 'images/profile-pics/defaults/head_alizarin.png', 0, 0),
(7, 'sarra', 'amdouni', 'sarra_amdouni', 'sarraamdouni@live.fr', '99af84c68b2ff02f4d22991a92849474', '2019-11-07', 'images/profile-pics/defaults/head_alizarin.png', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likes_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`posts_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `posts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
