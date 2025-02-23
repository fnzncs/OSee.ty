-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 01:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osee_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_requests`
--

CREATE TABLE `cancellation_requests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `venue` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `reason` text NOT NULL,
  `status` enum('REQUEST','CANCELLED','DENIED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancellation_requests`
--

INSERT INTO `cancellation_requests` (`id`, `title`, `fullname`, `email`, `company_name`, `start_datetime`, `end_datetime`, `venue`, `description`, `reason`, `status`) VALUES
(5, 'Summer Party', 'Ann Rachel', 'ann.rachel@olivarezcollege.edu.ph', 'BEED', '2024-06-20 08:00:00', '2024-06-20 17:30:00', 'Convention', '', 'Re-Sched', 'CANCELLED');

-- --------------------------------------------------------

--
-- Table structure for table `historyschedule_list`
--

CREATE TABLE `historyschedule_list` (
  `id` int(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `company_name` varchar(8) NOT NULL,
  `title` text NOT NULL,
  `venue` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `reason` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `status` enum('ACCEPTED','DENIED','CANCELLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `historyschedule_list`
--

INSERT INTO `historyschedule_list` (`id`, `fullname`, `email`, `company_name`, `title`, `venue`, `description`, `reason`, `start_datetime`, `end_datetime`, `status`) VALUES
(1, 'Jan Vincent Naces', 'janvincent.naces@olivarezcollege.edu.ph', 'BSTM', 'Next Destination', 'Ampi-Theater', 'Seminar Tour', '', '2024-06-22 08:00:00', '2024-06-22 12:00:00', 'ACCEPTED'),
(2, 'Franz Naces', 'franzkenneth.naces@olivarezcollege.edu.ph', 'BSIT', 'Meeting Department Course', 'Avr', 'Meeting Officer with Dept. Head and Faculty', '', '2024-06-22 08:00:00', '2024-06-22 12:00:00', 'ACCEPTED'),
(3, 'Cydnel Aves', 'cydnell.aves@olivarezcollege.edu.ph', 'BSIT', 'Training SportFest', 'Gym', 'Scouting for Foundation Week', '', '2024-06-21 08:00:00', '2024-06-21 18:00:00', 'ACCEPTED'),
(4, 'Mark Christopher Borromeo', 'markchistopher.borromeo@olivarezcollege.edu.ph', 'BSN', 'Training SportFest', 'Opencourt', 'Scouting for Foundation Week', '', '2024-06-21 13:00:00', '2024-06-21 18:00:00', 'ACCEPTED'),
(5, 'Ann Rachel', 'ann.rachel@olivarezcollege.edu.ph', 'BEED', 'Summer Party', 'Convention', 'BEED Rest Day/ Celebration', '', '2024-06-20 08:00:00', '2024-06-20 17:30:00', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `processschedule_list`
--

CREATE TABLE `processschedule_list` (
  `id` int(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `company_name` varchar(8) NOT NULL,
  `title` text NOT NULL,
  `venue` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `reason` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `status` enum('ACCEPTED','DENIED','CANCELLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `processschedule_list`
--

INSERT INTO `processschedule_list` (`id`, `fullname`, `email`, `company_name`, `title`, `venue`, `description`, `reason`, `start_datetime`, `end_datetime`, `status`) VALUES
(1, 'Jan Vincent Naces', 'janvincent.naces@olivarezcollege.edu.ph', 'BSTM', 'Next Destination', 'Ampi-Theater', 'Seminar Tour', '', '2024-06-22 08:00:00', '2024-06-22 12:00:00', 'ACCEPTED'),
(2, 'Franz Naces', 'franzkenneth.naces@olivarezcollege.edu.ph', 'BSIT', 'Meeting Department Course', 'Avr', 'Meeting Officer with Dept. Head and Faculty', '', '2024-06-22 08:00:00', '2024-06-22 12:00:00', 'ACCEPTED'),
(3, 'Cydnel Aves', 'cydnell.aves@olivarezcollege.edu.ph', 'BSIT', 'Training SportFest', 'Gym', 'Scouting for Foundation Week', '', '2024-06-21 08:00:00', '2024-06-21 18:00:00', 'ACCEPTED'),
(4, 'Mark Christopher Borromeo', 'markchistopher.borromeo@olivarezcollege.edu.ph', 'BSN', 'Training SportFest', 'Opencourt', 'Scouting for Foundation Week', '', '2024-06-21 13:00:00', '2024-06-21 18:00:00', 'ACCEPTED'),
(5, 'Ann Rachel', 'ann.rachel@olivarezcollege.edu.ph', 'BEED', 'Summer Party', 'Convention', 'BEED Rest Day/ Celebration', '', '2024-06-20 08:00:00', '2024-06-20 17:30:00', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `company_name` varchar(8) NOT NULL,
  `title` text NOT NULL,
  `venue` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `status` enum('PENDING','ACCEPTED','DENIED','CANCELLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cancellation_requests`
--
ALTER TABLE `cancellation_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historyschedule_list`
--
ALTER TABLE `historyschedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processschedule_list`
--
ALTER TABLE `processschedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historyschedule_list`
--
ALTER TABLE `historyschedule_list`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `processschedule_list`
--
ALTER TABLE `processschedule_list`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
