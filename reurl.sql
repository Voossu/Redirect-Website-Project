-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 06, 2019 at 01:09 AM
-- Server version: 8.0.12
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reurl`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientip`
--

CREATE TABLE `clientip` (
  `ip_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `client_ip` varchar(1024) NOT NULL,
  `client_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `client_key` varchar(16) NOT NULL,
  `client_agent` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `redirectmeta`
--

CREATE TABLE `redirectmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `redirect_id` bigint(20) UNSIGNED NOT NULL,
  `redirect_client` bigint(20) UNSIGNED NOT NULL,
  `redirect_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `redirectmeta`
--
DELIMITER $$
CREATE TRIGGER `redirect_count` AFTER INSERT ON `redirectmeta` FOR EACH ROW UPDATE redirects
SET redirect_usecount = redirect_usecount + 1
WHERE redirect_id = NEW.redirect_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `redirects`
--

CREATE TABLE `redirects` (
  `redirect_id` bigint(20) UNSIGNED NOT NULL,
  `redirect_url` varchar(2048) NOT NULL,
  `redirect_visitor` bigint(20) UNSIGNED DEFAULT NULL,
  `redirect_disable` tinyint(1) NOT NULL DEFAULT '0',
  `redirect_usecount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `redirect_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientip`
--
ALTER TABLE `clientip`
  ADD PRIMARY KEY (`ip_id`),
  ADD KEY `visitor_id` (`client_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `redirectmeta`
--
ALTER TABLE `redirectmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `redirect_id` (`redirect_id`),
  ADD KEY `meta_visitor` (`redirect_client`);

--
-- Indexes for table `redirects`
--
ALTER TABLE `redirects`
  ADD PRIMARY KEY (`redirect_id`),
  ADD KEY `redirect_visitor` (`redirect_visitor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientip`
--
ALTER TABLE `clientip`
  MODIFY `ip_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `redirectmeta`
--
ALTER TABLE `redirectmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `redirects`
--
ALTER TABLE `redirects`
  MODIFY `redirect_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
