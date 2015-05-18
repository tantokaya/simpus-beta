-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2014 at 03:51 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simkesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `status_marital`
--

DROP TABLE IF EXISTS `status_marital`;
CREATE TABLE IF NOT EXISTS `status_marital` (
  `kd_status_marital` int(3) NOT NULL AUTO_INCREMENT,
  `status_marital` varchar(50) NOT NULL,
  PRIMARY KEY (`kd_status_marital`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status_marital`
--

INSERT INTO `status_marital` (`kd_status_marital`, `status_marital`) VALUES
(1, 'Belum Menikah'),
(2, 'Menikah'),
(3, 'Cerai Hidup'),
(4, 'Cerai Mati');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
