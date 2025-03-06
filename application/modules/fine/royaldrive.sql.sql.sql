-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2023 at 06:06 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `royaldrive`
--

-- --------------------------------------------------------

--
-- Table structure for table `cpnl_fine_details`
--

CREATE TABLE `cpnl_fine_details` (
  `find_id` int(11) NOT NULL,
  `find_master` int(11) NOT NULL DEFAULT '0',
  `find_billno` varchar(255) DEFAULT NULL,
  `find_billl_date` datetime DEFAULT NULL,
  `find_fine_category` int(11) NOT NULL DEFAULT '0',
  `find_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_sgst` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_sgst_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_cgst` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_cgst_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_igst` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_igst_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_grand_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `find_narration` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cpnl_fine_master`
--

CREATE TABLE `cpnl_fine_master` (
  `finm_id` int(11) NOT NULL,
  `finm_stock_id` int(11) NOT NULL DEFAULT '0',
  `finm_added_by` int(11) NOT NULL DEFAULT '0',
  `finm_added_on` datetime DEFAULT NULL,
  `finm_total_fine` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'With GST'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cpnl_fine_details`
--
ALTER TABLE `cpnl_fine_details`
  ADD PRIMARY KEY (`find_id`);

--
-- Indexes for table `cpnl_fine_master`
--
ALTER TABLE `cpnl_fine_master`
  ADD PRIMARY KEY (`finm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cpnl_fine_details`
--
ALTER TABLE `cpnl_fine_details`
  MODIFY `find_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpnl_fine_master`
--
ALTER TABLE `cpnl_fine_master`
  MODIFY `finm_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
