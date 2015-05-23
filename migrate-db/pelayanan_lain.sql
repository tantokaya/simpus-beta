-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2014 at 02:54 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simkesmas_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelayanan_lain`
--

CREATE TABLE IF NOT EXISTS `pelayanan_lain` (
  `id_pelayanan_lain` int(5) NOT NULL,
  `jenis_pelayanan_lain` text NOT NULL,
  `harga` int(8) NOT NULL,
  `detail_pelayanan_lain` text NOT NULL,
  PRIMARY KEY (`id_pelayanan_lain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelayanan_lain`
--

INSERT INTO `pelayanan_lain` (`id_pelayanan_lain`, `jenis_pelayanan_lain`, `harga`, `detail_pelayanan_lain`) VALUES
(1, 'KIR Keterangan Sehat untuk Umum', 10000, 'Pelayanan Pengujian Kesehatan'),
(2, 'KIR Keterangan Sehat untuk Anak Sekolah (SD s.d. SMA/SMK/MAN)', 3000, 'Pelayanan Pengujian Kesehatan'),
(3, 'Pemeriksaan Kesehatan untuk Kepentingan Perusahaan\nAsuransi Jiwa bagi Calon Pemegang Polis (di luar pemeriksaan penunjang)', 30000, 'Pelayanan Pengujian Kesehatan'),
(4, 'Paket Pemeriksaan Kesehatan Karyawan Penjamah Makanan Besar (rectal swab, usap alat, pemeriksaan lab. Salmonela, dan E-coli)', 300000, 'Pelayanan Pengujian Kesehatan'),
(5, 'Pemberian Imunisasi Vaksin TT', 15000, 'Pelayanan Pengujian Kesehatan'),
(6, 'Pemeriksaan Kesehatan Calon Haji (tanpa pemeriksaan laboratorium)', 25000, 'Pelayanan Pengujian Kesehatan'),
(7, 'Dalam Kota', 150000, 'Pelayanan Ambulans (di Luar Bahan Bakar Minyak (BBM) dan Biaya Tol)');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
