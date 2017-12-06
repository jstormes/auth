-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 06, 2017 at 04:21 PM
-- Server version: 10.2.11-MariaDB-10.2.11+maria~jessie
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

CREATE TABLE IF NOT EXISTS `client` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) COLLATE utf8mb4_bin NOT NULL COMMENT 'Name of client applicaiton',
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_name` (`client_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `client`
--

INSERT IGNORE INTO `client` (`client_id`, `client_name`) VALUES
(1, 'auth');

-- --------------------------------------------------------

--
-- Table structure for table `contact_method`
--

CREATE TABLE IF NOT EXISTS `contact_method` (
  `contact_method_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` enum('unknown','landline','mobile','skype') COLLATE utf8mb4_bin NOT NULL DEFAULT 'unknown',
  `contact_value` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`contact_method_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `contact_method`
--

INSERT IGNORE INTO `contact_method` (`contact_method_id`, `user_id`, `type`, `contact_value`) VALUES
(1, 2, 'mobile', '817-676-4291');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8mb4_bin NOT NULL COMMENT 'Email Address',
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Password Hash',
  `full_name` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Formal Name',
  `name_addressed_by` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Informal (First Name)',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='OAuth2 User Profile Data';

--
-- Dumping data for table `user`
--

INSERT IGNORE INTO `user` (`user_id`, `user_name`, `password`, `full_name`, `name_addressed_by`) VALUES
(2, 'jstormes@stormes.net', '', 'James W Stormes', 'ãƒ«ãƒ“ ãƒ³ãƒ„ã‚¢ ã‚¦ã‚§ãƒ–ã‚¢ ãµã¹ã‹ã‚‰ãš ã‚»ã‚·ãƒ“ãƒªãƒ†'),
(3, 'jstormes@yahoo.com', '', 'James Stormes', 'James'),
(4, 'tom@tome.com', 'password', 'Tom Man', 'Tom'),
(6, 'test@test.com', '', 'ã‚¤ãƒ‰ãƒ©ã‚¤ãƒ³ ã‚ªãƒ–ã‚¸ã‚§ã‚¯', 'test'),
(7, 'test2@test.com', '', 'Ð›Ð¾Ñ€ÐµÐ¼ Ð¸Ð¿ÑÑƒÐ¼', 'test'),
(20, 'test3@test.com', 'password', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_to_client`
--

CREATE TABLE IF NOT EXISTS `user_to_client` (
  `user_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`,`client_id`),
  KEY `client` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user` ADD FULLTEXT KEY `user_fulltext` (`full_name`,`name_addressed_by`,`user_name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_method`
--
ALTER TABLE `contact_method`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_to_client`
--
ALTER TABLE `user_to_client`
  ADD CONSTRAINT `client` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;


CREATE USER 'ezoauth2'@'%' IDENTIFIED VIA mysql_native_password USING 'oauthuser';
GRANT USAGE ON *.* TO 'ezoauth2'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON  `ezoauth2`.* TO 'ezoauth2'@'%' WITH GRANT OPTION;
