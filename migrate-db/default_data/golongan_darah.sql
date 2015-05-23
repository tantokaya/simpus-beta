-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2014 at 03:53 PM
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
-- Table structure for table `golongan_darah`
--

DROP TABLE IF EXISTS `golongan_darah`;
CREATE TABLE IF NOT EXISTS `golongan_darah` (
  `kd_gol_darah` int(3) NOT NULL AUTO_INCREMENT,
  `gol_darah` varchar(10) NOT NULL,
  PRIMARY KEY (`kd_gol_darah`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `golongan_darah`
--

INSERT INTO `golongan_darah` (`kd_gol_darah`, `gol_darah`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'AB'),
(4, 'O'),
(5, 'A+'),
(6, 'A-'),
(7, 'B+'),
(8, 'B-'),
(9, 'AB+'),
(10, 'AB-'),
(11, 'O+'),
(12, 'O-'),
(13, 'Tidak Tahu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
