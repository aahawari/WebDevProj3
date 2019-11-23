-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2019 at 03:54 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `registrants`
--

CREATE TABLE `registrants` (
  `umid` int(255) NOT NULL,
  `fnam` varchar(255) NOT NULL,
  `lnam` varchar(255) NOT NULL,
  `projtitle` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenum` varchar(255) NOT NULL,
  `period` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `availdate` date DEFAULT NULL,
  `availbegtime` time(6) DEFAULT NULL,
  `availendtime` time(6) DEFAULT NULL,
  `slotsremn` int(255) DEFAULT NULL,
  `perid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`availdate`, `availbegtime`, `availendtime`, `slotsremn`, `perid`) VALUES
('2019-12-09', '18:00:00.000000', '19:00:00.000000', 6, 1),
('2019-12-09', '19:00:00.000000', '20:00:00.000000', 6, 2),
('2019-12-09', '20:00:00.000000', '21:00:00.000000', 6, 3),
('2019-12-10', '18:00:00.000000', '19:00:00.000000', 6, 4),
('2019-12-10', '19:00:00.000000', '20:00:00.000000', 6, 5),
('2019-12-10', '20:00:00.000000', '21:00:00.000000', 6, 6);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
