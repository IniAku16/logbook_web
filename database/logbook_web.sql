-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 09:55 AM
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
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `data_old` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data_old`)),
  `data_new` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data_new`)),
  `ip_address` varchar(255) NOT NULL,
  `user_agent` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `user_id` int(11) NOT NULL,
  `foto_before` varchar(255) DEFAULT NULL,
  `foto_after` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`date`, `description`, `id_area`, `jenis`, `target`, `material`, `id`, `user_id`, `foto_before`, `foto_after`) VALUES
('2026-06-11', 'AAAA', 1, 'Ganti Baru', 'Lanjut', 'AAA,BBB,CCC', 14, 22, 'BEFORE_1781149786_6a2a305a3709d.png', 'AFTER_1781149908_6a2a30d460406.png'),
('2026-06-11', 'DFF', 3, 'Complain', 'Lanjut', 'FVFV', 16, 23, 'BEFORE_1781150374_6a2a32a631b52.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_requests`
--

CREATE TABLE `reset_password_requests` (
  `id` int(11) NOT NULL,
  `username_email` varchar(255) NOT NULL,
  `status` enum('pending','selesai') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `last_activity` datetime DEFAULT NULL,
  `is_first_login` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`, `last_activity`, `is_first_login`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$813ywg5MvsDMR3DWc.nUd.oLvO2rSB7scT/AtxTiYD8xlSkbaM/k2', 'admin', '2026-06-11 14:08:01', 0),
(25, 'biya', 'biya@gmail.com', '$2y$10$swt7RY35hTdJTqJz/wUcn.AXYqrZisujOh0lbwBGDG2UNdy.OEH1.', 'user', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password_requests`
--
ALTER TABLE `reset_password_requests`
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
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reset_password_requests`
--
ALTER TABLE `reset_password_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
