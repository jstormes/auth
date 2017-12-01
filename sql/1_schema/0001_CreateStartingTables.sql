-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 01, 2017 at 05:06 PM
-- Server version: 10.2.10-MariaDB-10.2.10+maria~jessie
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ezoauth2`
--
CREATE DATABASE IF NOT EXISTS `ezoauth2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `ezoauth2`;

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
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `phone_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` enum('unknown','landline','mobile','') COLLATE utf8mb4_bin NOT NULL DEFAULT 'unknown',
  `phone_number` varchar(50) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `phone`
--

INSERT IGNORE INTO `phone` (`phone_id`, `user_id`, `type`, `phone_number`) VALUES
(1, 2, 'mobile', '817-676-4291');

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
(2, 'jstormes@stormes.net', 'Xtx!41365', 'James W Stormes', 'Jim2'),
(3, 'jstormes@yahoo.com', '', 'James Stormes', 'James'),
(4, 'tom@tome.com', 'password', 'Tom Man', 'Tom'),
(6, 'test@test.com', 'password', 'test user', 'test'),
(7, 'test2@test.com', 'Xtx!41365', 'test', 'test'),
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
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`phone_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `phone`
--
ALTER TABLE `phone`
  MODIFY `phone_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_to_client`
--
ALTER TABLE `user_to_client`
  ADD CONSTRAINT `client` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;
