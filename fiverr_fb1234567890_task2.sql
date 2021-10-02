-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 02, 2021 at 10:18 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiverr_fb1234567890_task2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tmg_trader_trades_year_month_v0`
--

DROP TABLE IF EXISTS `tmg_trader_trades_year_month_v0`;
CREATE TABLE IF NOT EXISTS `tmg_trader_trades_year_month_v0` (
  `Date` date DEFAULT NULL,
  `Identifier` varchar(255) DEFAULT NULL,
  `Portfolio_manager` varchar(255) DEFAULT NULL,
  `Tickers` varchar(255) DEFAULT NULL,
  `Type_Description` varchar(255) DEFAULT NULL,
  `Quantity` decimal(13,6) DEFAULT NULL,
  `Value` decimal(13,6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
