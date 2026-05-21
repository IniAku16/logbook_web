-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2026 at 10:12 AM
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
-- Database: `logbook_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `id_area` int(11) DEFAULT NULL,
  `jenis` enum('Check List-Routine','Complain','Perbaikan/Perawatan','Ganti Baru') NOT NULL,
  `target` enum('Menunggu Proses','Lanjut','Selesai') NOT NULL,
  `material` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_area`
--

CREATE TABLE `tb_area` (
  `id_area` int(11) NOT NULL,
  `nama_area` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_area`
--

INSERT INTO `tb_area` (`id_area`, `nama_area`) VALUES
(1, 'HAP-HO'),
(2, 'HO LT.1'),
(3, 'HO LT.2'),
(4, 'HO LT.3'),
(5, 'HO LT.4'),
(6, 'KANTIN LT.1'),
(7, 'KANTIN LT.2'),
(8, 'POLIKLINIK'),
(9, 'GENSET'),
(10, 'TRAFO'),
(11, 'TAMAN'),
(12, 'WORKSHOP'),
(13, 'TOKO KOPERASI'),
(14, 'OFFICE KOPERASI'),
(15, 'WAREHOUSE'),
(16, 'CABANG JAKARTA'),
(17, 'TRAINING CENTER'),
(18, 'PUMP ROOM'),
(19, 'YARD'),
(20, 'MASJID'),
(21, 'PARKIR MOTOR LT.1'),
(22, 'PARKIR MOTOR LT.2'),
(23, 'PARKIR MOTOR LT.3'),
(24, 'PARKIR MOTOR TAMU'),
(25, 'POS SECURITY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `last_activity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`, `last_activity`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$ZES4oFK0zSWUQI6/0/756.4YG.EF/fGhreFwyU1MotQgY2MsSUKkm', 'admin', '2026-05-21 08:39:49'),
(6, 'wola', 'eunwobila@gmail.com', '$2y$10$wG/nfT8glZcvi48rxv28nu/yeDxzqsR5biWNzL3xKmGjTcRnyjPQ.', 'user', NULL),
(7, 'reyna', 'reyna@gmail.com', '$2y$10$4DcPCt26EdJ2LzQCB2lfOurCUi8ws0FxFnEqrCi8Onl1ZbnhjrCmu', 'user', '2026-05-21 08:46:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
