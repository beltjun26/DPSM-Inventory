-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2017 at 08:05 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpsm_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `property_number` varchar(30) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `equipment_status` varchar(15) NOT NULL,
  `date_added` date NOT NULL,
  `encoder` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_log`
--

CREATE TABLE `equipment_log` (
  `log_num` int(11) NOT NULL,
  `property_number` varchar(30) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `borrower_name` varchar(30) NOT NULL,
  `borrow_time` datetime NOT NULL,
  `due_time` datetime NOT NULL,
  `status` varchar(11) NOT NULL,
  `time_returned` datetime NOT NULL,
  `encoder` varchar(20) NOT NULL,
  `returned_to` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supply_id` int(11) NOT NULL,
  `supply_name` varchar(60) NOT NULL,
  `brand` varchar(60) NOT NULL,
  `encoder` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(60) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply_log`
--

CREATE TABLE `supply_log` (
  `log_num` int(11) NOT NULL,
  `supply_id` int(11) NOT NULL,
  `imbursed_by` varchar(20) NOT NULL,
  `date_imbursed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `imbursed_to` varchar(60) NOT NULL,
  `quantity_out` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`property_number`),
  ADD KEY `encoder` (`encoder`);

--
-- Indexes for table `equipment_log`
--
ALTER TABLE `equipment_log`
  ADD PRIMARY KEY (`log_num`),
  ADD KEY `property_number` (`property_number`),
  ADD KEY `encoder` (`encoder`),
  ADD KEY `returned_to` (`returned_to`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `encoder` (`encoder`);

--
-- Indexes for table `supply_log`
--
ALTER TABLE `supply_log`
  ADD PRIMARY KEY (`log_num`),
  ADD KEY `supply_id` (`supply_id`),
  ADD KEY `imbursed_by` (`imbursed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment_log`
--
ALTER TABLE `equipment_log`
  MODIFY `log_num` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `supply_log`
--
ALTER TABLE `supply_log`
  MODIFY `log_num` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`encoder`) REFERENCES `users` (`username`);

--
-- Constraints for table `equipment_log`
--
ALTER TABLE `equipment_log`
  ADD CONSTRAINT `equipment_log_ibfk_1` FOREIGN KEY (`encoder`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `equipment_log_ibfk_2` FOREIGN KEY (`returned_to`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `equipment_log_ibfk_3` FOREIGN KEY (`property_number`) REFERENCES `equipment` (`property_number`);

--
-- Constraints for table `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`encoder`) REFERENCES `users` (`username`);

--
-- Constraints for table `supply_log`
--
ALTER TABLE `supply_log`
  ADD CONSTRAINT `supply_log_ibfk_1` FOREIGN KEY (`supply_id`) REFERENCES `supply` (`supply_id`),
  ADD CONSTRAINT `supply_log_ibfk_2` FOREIGN KEY (`imbursed_by`) REFERENCES `users` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
