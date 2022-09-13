-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2022 at 12:06 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `recipient_id`, `description`, `created`, `modified`) VALUES
(1, 2, 1, 'fasfasfas', '2022-09-12 12:11:11', '2022-09-12 12:11:11'),
(2, 2, 2, 'testse est estses', '2022-09-13 02:48:37', '2022-09-13 02:48:37'),
(6, 1, 1, 'sdfasfas', '2022-09-13 10:22:32', '2022-09-13 10:22:32'),
(7, 1, 1, 'sfasfsaf', '2022-09-13 10:22:34', '2022-09-13 10:22:34'),
(9, 1, 1, 'sfasfsafasf', '2022-09-13 10:25:37', '2022-09-13 10:25:37'),
(10, 1, 1, 'fdsfasfasd', '2022-09-13 10:25:42', '2022-09-13 10:25:42'),
(11, 1, 1, 'dsfasfasf', '2022-09-13 10:25:45', '2022-09-13 10:25:45'),
(13, 1, 1, '223', '2022-09-13 10:49:30', '2022-09-13 10:49:30'),
(14, 1, 1, '223344', '2022-09-13 10:49:38', '2022-09-13 10:49:38'),
(15, 1, 1, '123456', '2022-09-13 10:49:45', '2022-09-13 10:49:45'),
(16, 1, 1, '1122334455', '2022-09-13 10:49:50', '2022-09-13 10:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profile_pic_path` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('0','1') DEFAULT '0',
  `hubby` text DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `profile_pic_path`, `birthdate`, `gender`, `hubby`, `created`, `modified`) VALUES
(1, 1, 'profile/12022_09_13_14_32.png', '2022-09-12', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-09-12 17:06:09', '2022-09-13 14:33:19'),
(2, 2, 'profile/22022_09_12_17_15.jpeg', '1994-02-06', '0', 'testing', '2022-09-12 17:13:52', '2022-09-12 17:16:21'),
(3, 3, 'profile/32022_09_13_10_41.jpeg', '2022-09-13', '0', 'dsfsdfsdf', '2022-09-13 09:25:26', '2022-09-13 10:41:51'),
(4, 14, 'profile/142022_09_13_17_29.png', '2022-09-13', '0', 'sdfsafasf', '2022-09-13 17:23:09', '2022-09-13 17:29:35'),
(5, 15, 'profile/152022_09_13_18_02.jpeg', '2022-09-13', '0', 'dfsfs', '2022-09-13 17:49:00', '2022-09-13 18:02:06'),
(6, 16, NULL, NULL, '0', NULL, '2022-09-13 18:02:55', '2022-09-13 18:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `user_id`, `message_id`, `description`, `created`, `modified`) VALUES
(1, 3, 1, 'test est et se ', '2022-09-13 04:30:01', '2022-09-13 04:30:01'),
(2, 3, 1, 'resesre srs resr', '2022-09-13 04:30:32', '2022-09-13 04:30:32'),
(3, 3, 1, 'sdfsfsf ds fsfs', '2022-09-13 04:34:27', '2022-09-13 04:34:27'),
(4, 3, 2, 'fsdfsdfs', '2022-09-13 05:03:09', '2022-09-13 05:03:09'),
(5, 3, 2, 'sfdsfsd', '2022-09-13 05:05:22', '2022-09-13 05:05:22'),
(6, 3, 2, 'dfsfs', '2022-09-13 05:06:58', '2022-09-13 05:06:58'),
(7, 3, 2, 'dfsfsafdsfs', '2022-09-13 05:08:59', '2022-09-13 05:08:59'),
(8, 3, 2, 'dfsfsafdsfs', '2022-09-13 05:09:27', '2022-09-13 05:09:27'),
(9, 3, 2, 'dfsfsafdsfs', '2022-09-13 05:10:01', '2022-09-13 05:10:01'),
(10, 3, 2, 'dfsfsafdsfs', '2022-09-13 05:10:16', '2022-09-13 05:10:16'),
(11, 3, 2, 'dfsfsafdsfs', '2022-09-13 05:16:47', '2022-09-13 05:16:47'),
(12, 3, 2, 'fasfafda testing 123', '2022-09-13 05:17:38', '2022-09-13 05:17:38'),
(13, 3, 2, 'sdfasfa das as', '2022-09-13 05:19:59', '2022-09-13 05:19:59'),
(14, 3, 2, 'sdsdsadasdas', '2022-09-13 05:21:48', '2022-09-13 05:21:48'),
(15, 3, 2, 'asdfasdf asd as fas sa fas', '2022-09-13 05:23:30', '2022-09-13 05:23:30'),
(16, 3, 2, 'fdasfsa', '2022-09-13 05:25:59', '2022-09-13 05:25:59'),
(17, 3, 2, 'asdfaf adsf asd fsd', '2022-09-13 05:26:47', '2022-09-13 05:26:47'),
(18, 3, 2, 'edited', '2022-09-13 05:26:54', '2022-09-13 05:26:54'),
(19, 3, 2, 'dfafafd hogng', '2022-09-13 05:29:19', '2022-09-13 05:29:19'),
(20, 3, 2, 'sdfasfas', '2022-09-13 05:29:47', '2022-09-13 05:29:47'),
(21, 3, 2, 'dfafas', '2022-09-13 05:29:54', '2022-09-13 05:29:54'),
(22, 3, 2, 'sdfasd', '2022-09-13 05:34:17', '2022-09-13 05:34:17'),
(23, 3, 2, 'sdfsfa', '2022-09-13 05:34:23', '2022-09-13 05:34:23'),
(24, 2, 2, 'sdfaf', '2022-09-13 05:34:54', '2022-09-13 05:34:54'),
(25, 2, 2, 'edited nasad sdf\r\na \r\nasf \r\nas \r\nas', '2022-09-13 05:50:17', '2022-09-13 08:12:02'),
(26, 2, 2, 'edited 12323dd d d', '2022-09-13 05:50:22', '2022-09-13 08:27:22'),
(27, 2, 1, 'dfa', '2022-09-13 06:47:57', '2022-09-13 06:47:57'),
(43, 1, 2, 'fdfafasd', '2022-09-13 09:36:22', '2022-09-13 09:36:22'),
(65, 15, 1, 'asdfsa', '2022-09-13 11:56:36', '2022-09-13 11:56:36'),
(66, 15, 1, 'fgdgd', '2022-09-13 11:57:06', '2022-09-13 11:57:06'),
(67, 15, 1, 'sdfasfasdf', '2022-09-13 12:02:17', '2022-09-13 12:02:17'),
(68, 16, 1, 'asdfasf', '2022-09-13 12:03:15', '2022-09-13 12:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `created_ip` varchar(100) NOT NULL,
  `modified_ip` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `last_login`, `created_ip`, `modified_ip`, `created`, `modified`) VALUES
(1, 'Diana Marites', 'tudixub@mailinator.com', '$2a$10$nz5VfRyXsE.Fy.v.ivIMG.hyyA2JwDv7Duh/pGk0DrhBCZYnUM2Gi', '2022-09-13 17:04:44', '', '', '2022-09-12 17:06:09', '2022-09-13 17:04:44'),
(2, 'risesavuj test', 'zuvofav@mailinator.com', '2d26bf0766212b87e8f09fa88a834a9b288c6ee7', '2022-09-13 11:34:46', '', '', '2022-09-12 17:13:52', '2022-09-13 14:31:01'),
(3, 'pamojimun', 'toriwovyme@mailinator.com', '8110ae0427faa2e8f9217e3d7c09e8c4d86cd295', '2022-09-13 10:48:06', '', '', '2022-09-13 09:25:26', '2022-09-13 10:48:06'),
(4, 'zopazikeku', 'wycupyfuw@mailinator.com', '$2a$10$qvKJskLAbWBOq20zK3wUrOEZFaWz0aoxouraXYvf.WKjtNEGD/8wm', '2022-09-13 17:15:35', '', '', '2022-09-13 17:15:35', '2022-09-13 17:15:35'),
(5, 'kaxyfybepo', 'huwura@mailinator.com', '$2a$10$zJ6rHjXUcjimrq2vnq/cFudUqJXe7O.ZMOOtxMfA0uXfAooG2cxTK', '2022-09-13 17:17:14', '', '', '2022-09-13 17:17:14', '2022-09-13 17:17:14'),
(6, 'telewyj', 'zifiwyv@mailinator.com', '$2a$10$wAxNvtRDEe4yUAkboJlSQeeooWGmG5vqukhGRALrsNzHU6K.1w51m', '2022-09-13 17:17:45', '', '', '2022-09-13 17:17:45', '2022-09-13 17:17:45'),
(7, 'fyzaxi', 'wekuxeruza@mailinator.com', '$2a$10$wCaaN.XloD9JwVzYijq1nOUzkdyUJOBByEa3ENXK6x.Ldw2LYkdki', '2022-09-13 17:18:24', '', '', '2022-09-13 17:18:24', '2022-09-13 17:18:24'),
(8, 'dujeneb', 'vafud@mailinator.com', '$2a$10$/1iyvMXUgEi6ej3X4M0Ay.iBibFWqXUe5kUwArQc73ncC3Rlhizx2', '2022-09-13 17:18:33', '', '', '2022-09-13 17:18:33', '2022-09-13 17:18:33'),
(9, 'boxys', 'selekexi@mailinator.com', '$2a$10$5fLYtw8aImlU/r67hmyHp.XLJ/sMgt68fEhzF.yDplcswKUpJDJNK', '2022-09-13 17:19:33', '', '', '2022-09-13 17:19:33', '2022-09-13 17:19:33'),
(10, 'pyloxyzymy', 'cykohyle@mailinator.com', '$2a$10$pAvSMXdPH/j/aB6qeQksqe4fL0gjJgUWt6ZmUn.2Zo.w06GesEnGy', '2022-09-13 17:20:06', '', '', '2022-09-13 17:20:06', '2022-09-13 17:20:06'),
(11, 'telodogu', 'cybalu@mailinator.com', '$2a$10$Mus/7PJy4OpzWHXOomdrOe4EV/T6s9CoSaI4jErbz4KcnUXuKClcu', '2022-09-13 17:20:34', '', '', '2022-09-13 17:20:34', '2022-09-13 17:20:34'),
(12, 'dafacyti', 'vyxizigu@mailinator.com', '$2a$10$I475HSojaNAnUnzPo9HVm.mCf/uFiclZJ0jm8JeXMCFK.MmETZXji', '2022-09-13 17:20:55', '', '', '2022-09-13 17:20:55', '2022-09-13 17:20:55'),
(13, 'gidysada', 'teduqulepo@mailinator.com', '$2a$10$2e0./S.Jm3fSzU8NJg1x/eCcUtg5R/tFirOc6aKderE0njP.6wkem', '2022-09-13 17:22:47', '', '', '2022-09-13 17:22:48', '2022-09-13 17:22:48'),
(14, 'rafysumy', 'tinihoq@mailinator.com', '$2a$10$xSXZKodkRmy7WTj72XY38.NW2WZvXghA4L3vk6bl2zVTieAbMJ8Zi', '2022-09-13 17:43:05', '', '', '2022-09-13 17:23:09', '2022-09-13 17:43:05'),
(15, 'huzili', 'jelicypoza@mailinator.com', '$2a$10$gMIpcYsQJNjfLjcQgC20Kew9zycsuGI2uwkVVeQdkmTac2XOz6XnW', '2022-09-13 17:49:00', '::1', '::1', '2022-09-13 17:49:00', '2022-09-13 18:02:06'),
(16, 'lyfakibe', 'sofy@mailinator.com', '$2a$10$kb6N6P5ZJcTAJutdA1llFuO1.JBRk7kkPGFq7OywFL/..D1.2Iysi', '2022-09-13 18:02:55', '::1', NULL, '2022-09-13 18:02:55', '2022-09-13 18:02:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
