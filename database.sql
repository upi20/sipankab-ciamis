-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 06:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sipankab`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Administrator', 'admin@mail.com', '$2y$10$/hjs/k7jUC7fJxOs4x8b5Oo2.JMSaHBumcgHl8H.LdMrvjoEIrCye');

-- --------------------------------------------------------

--
-- Table structure for table `calon`
--

CREATE TABLE `calon` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nomor_pendaftaran` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calon`
--

INSERT INTO `calon` (`id`, `kecamatan_id`, `nama`, `nomor_pendaftaran`, `jenis_kelamin`, `alamat`, `nomor_telepon`) VALUES
(1, 2, 'Isep Lutpi Nur', '1', 'LAKI-LAKI', 'Cianjur', '+6285798132505');

-- --------------------------------------------------------

--
-- Table structure for table `calon_tahapan_nilai`
--

CREATE TABLE `calon_tahapan_nilai` (
  `id` int(11) NOT NULL,
  `calon_id` int(11) DEFAULT NULL,
  `tahapan_id` int(11) DEFAULT NULL,
  `tahapan_nilai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama`) VALUES
(2, 'Banjaranyar');

-- --------------------------------------------------------

--
-- Table structure for table `tahapan`
--

CREATE TABLE `tahapan` (
  `id` int(11) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahapan`
--

INSERT INTO `tahapan` (`id`, `urutan`, `nama`) VALUES
(1, 1, 'Administrasi (Kelengkapan Berkas)');

-- --------------------------------------------------------

--
-- Table structure for table `tahapan_nilai`
--

CREATE TABLE `tahapan_nilai` (
  `id` int(11) NOT NULL,
  `tahapan_id` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `nilai_nama` varchar(255) DEFAULT NULL,
  `nilai_dari` int(11) DEFAULT NULL,
  `nilai_sampai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- Indexes for table `calon_tahapan_nilai`
--
ALTER TABLE `calon_tahapan_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calon_id` (`calon_id`),
  ADD KEY `tahapan_id` (`tahapan_id`),
  ADD KEY `tahapan_nilai_id` (`tahapan_nilai_id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahapan`
--
ALTER TABLE `tahapan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahapan_nilai`
--
ALTER TABLE `tahapan_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahapan_id` (`tahapan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `calon`
--
ALTER TABLE `calon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `calon_tahapan_nilai`
--
ALTER TABLE `calon_tahapan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tahapan`
--
ALTER TABLE `tahapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tahapan_nilai`
--
ALTER TABLE `tahapan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calon`
--
ALTER TABLE `calon`
  ADD CONSTRAINT `calon_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`);

--
-- Constraints for table `calon_tahapan_nilai`
--
ALTER TABLE `calon_tahapan_nilai`
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_1` FOREIGN KEY (`calon_id`) REFERENCES `calon` (`id`),
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_2` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapan` (`id`),
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_3` FOREIGN KEY (`tahapan_nilai_id`) REFERENCES `tahapan_nilai` (`id`);

--
-- Constraints for table `tahapan_nilai`
--
ALTER TABLE `tahapan_nilai`
  ADD CONSTRAINT `tahapan_nilai_ibfk_1` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapan` (`id`);
COMMIT;
