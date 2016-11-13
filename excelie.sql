-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2016 at 07:46 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `excelie`
--

-- --------------------------------------------------------

--
-- Table structure for table `telpnumber`
--

CREATE TABLE `telpnumber` (
  `idtelpnumber` bigint(20) NOT NULL,
  `telpnumber` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `telpnumber`
--

INSERT INTO `telpnumber` (`idtelpnumber`, `telpnumber`) VALUES
(1, '08948475743'),
(2, '08948475744'),
(3, '08948475745'),
(4, '08948475746'),
(5, '08948475747');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `telpnumber`
--
ALTER TABLE `telpnumber`
  ADD PRIMARY KEY (`idtelpnumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `telpnumber`
--
ALTER TABLE `telpnumber`
  MODIFY `idtelpnumber` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
