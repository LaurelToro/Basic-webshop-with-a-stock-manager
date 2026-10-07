-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 01:50 PM
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
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bog`
--

CREATE TABLE `bog` (
  `ID` int(11) NOT NULL,
  `Titel` varchar(120) NOT NULL,
  `Antal` int(100) NOT NULL,
  `Pris` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kunder`
--

CREATE TABLE `kunder` (
  `Fornavn` varchar(50) NOT NULL,
  `Efternavn` varchar(50) NOT NULL,
  `Adresse` varchar(50) NOT NULL,
  `Nummer` varchar(12) NOT NULL,
  `Kunder-ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order-list`
--

CREATE TABLE `order-list` (
  `Kunde-ID` int(11) NOT NULL,
  `Bog-ID` int(11) NOT NULL,
  `Antal` int(11) NOT NULL,
  `Dato` datetime NOT NULL,
  `Order-linje-ID` int(11) NOT NULL,
  `Pris-ved-kob` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Order-ID` int(11) DEFAULT NULL,
  `Afsendt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordrer`
--

CREATE TABLE `ordrer` (
  `Order-ID` int(11) NOT NULL,
  `Kunde-ID` int(11) NOT NULL,
  `Dato` datetime NOT NULL DEFAULT current_timestamp(),
  `Afsendt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bog`
--
ALTER TABLE `bog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kunder`
--
ALTER TABLE `kunder`
  ADD PRIMARY KEY (`Kunder-ID`);

--
-- Indexes for table `order-list`
--
ALTER TABLE `order-list`
  ADD PRIMARY KEY (`Order-linje-ID`);

--
-- Indexes for table `ordrer`
--
ALTER TABLE `ordrer`
  ADD PRIMARY KEY (`Order-ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bog`
--
ALTER TABLE `bog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kunder`
--
ALTER TABLE `kunder`
  MODIFY `Kunder-ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order-list`
--
ALTER TABLE `order-list`
  MODIFY `Order-linje-ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordrer`
--
ALTER TABLE `ordrer`
  MODIFY `Order-ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
