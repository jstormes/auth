-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 11, 2017 at 07:01 PM
-- Server version: 10.2.10-MariaDB-10.2.10+maria~jessie
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ezoauth2`
--
--CREATE DATABASE IF NOT EXISTS `ezoauth2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
--USE `ezoauth2`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` bigint(20) NOT NULL,
  `client_name` varchar(50) COLLATE utf8mb4_bin NOT NULL COMMENT 'Name of client applicaiton'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `client`
--

INSERT IGNORE INTO `client` (`client_id`, `client_name`) VALUES
(1, 'auth');

-- --------------------------------------------------------

--
-- Table structure for table `contact_method`
--

CREATE TABLE `contact_method` (
  `contact_method_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_value` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `contact_method_type` varchar(50) COLLATE utf8mb4_bin NOT NULL DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `contact_method`
--

INSERT IGNORE INTO `contact_method` (`contact_method_id`, `user_id`, `contact_value`, `contact_method_type`) VALUES
(1, 2, '817-676-4291', 'landline');

-- --------------------------------------------------------

--
-- Table structure for table `contact_method_type`
--

CREATE TABLE `contact_method_type` (
  `contact_method_type` varchar(50) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `contact_method_type`
--

INSERT IGNORE INTO `contact_method_type` (`contact_method_type`) VALUES
('email'),
('landline'),
('mobile'),
('skype'),
('unknown');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_bin NOT NULL COMMENT 'Email Address',
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Password Hash',
  `full_name` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Formal Name',
  `name_addressed_by` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Informal (First Name)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='OAuth2 User Profile Data';

--
-- Dumping data for table `user`
--

INSERT IGNORE INTO `user` (`user_id`, `user_name`, `password`, `full_name`, `name_addressed_by`) VALUES
(2, 'jstormes@stormes.net', '', 'James W Stormes', 'Ã£Æ’Â«Ã£Æ’â€œ Ã£Æ’Â³Ã£Æ’â€žÃ£â€šÂ¢ Ã£â€šÂ¦Ã£â€šÂ§Ã£Æ’â€“Ã£â€šÂ¢ Ã£ÂÂµÃ£ÂÂ¹Ã£Ââ€¹Ã£â€šâ€°Ã£ÂÅ¡ Ã£â€šÂ»Ã£â€šÂ·Ã£Æ’â€œÃ£Æ’ÂªÃ£Æ’â€ '),
(3, 'jstormes@yahoo.com', '', 'James Stormes', 'James'),
(4, 'tom@tome.com', 'password', 'Tom Man', 'Tom'),
(6, 'test@test.com', '', 'Ã£â€šÂ¤Ã£Æ’â€°Ã£Æ’Â©Ã£â€šÂ¤Ã£Æ’Â³ Ã£â€šÂªÃ£Æ’â€“Ã£â€šÂ¸Ã£â€šÂ§Ã£â€šÂ¯', 'test'),
(7, 'test2@test.com', '', 'Ãâ€ºÃÂ¾Ã‘â‚¬ÃÂµÃÂ¼ ÃÂ¸ÃÂ¿Ã‘ÂÃ‘Æ’ÃÂ¼', 'test'),
(20, 'test3@test.com', 'password', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_to_client`
--

CREATE TABLE `user_to_client` (
  `user_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_name` (`client_name`);

--
-- Indexes for table `contact_method`
--
ALTER TABLE `contact_method`
  ADD PRIMARY KEY (`contact_method_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contact_method_type` (`contact_method_type`);

--
-- Indexes for table `contact_method_type`
--
ALTER TABLE `contact_method_type`
  ADD PRIMARY KEY (`contact_method_type`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);
ALTER TABLE `user` ADD FULLTEXT KEY `user_fulltext` (`full_name`,`name_addressed_by`,`user_name`);

--
-- Indexes for table `user_to_client`
--
ALTER TABLE `user_to_client`
  ADD PRIMARY KEY (`user_id`,`client_id`),
  ADD KEY `client` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_method`
--
ALTER TABLE `contact_method`
  MODIFY `contact_method_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_method`
--
ALTER TABLE `contact_method`
  ADD CONSTRAINT `contact_method_type` FOREIGN KEY (`contact_method_type`) REFERENCES `contact_method_type` (`contact_method_type`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_to_client`
--
ALTER TABLE `user_to_client`
  ADD CONSTRAINT `client` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

--
-- Table structure for table `translate`
--

CREATE TABLE IF NOT EXISTS `translate` (
  `original_string` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `en` text COLLATE utf8mb4_bin DEFAULT NULL,
  `ft` text COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`original_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
COMMIT;

