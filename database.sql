-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 07:59 AM
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
  `tanggal_lahir` date DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calon`
--

INSERT INTO `calon` (`id`, `kecamatan_id`, `nama`, `nomor_pendaftaran`, `jenis_kelamin`, `tanggal_lahir`, `nomor_telepon`) VALUES
(2, 2, 'NANDANG SURYANA ', 'KABCMS0001', 'LAKI-LAKI', '2023-01-12', '081221414 051'),
(3, 3, 'MUHAMAD HAESUNI', 'KABCMS0002', 'LAKI-LAKI', NULL, '081321442501'),
(4, 28, 'YAYAN KAMALUDIN', 'KABCMS0003', 'LAKI-LAKI', NULL, '081323209003'),
(5, 4, 'HENDRA GUNAWAN', 'KABCMS0004', 'LAKI-LAKI', NULL, '085221536532'),
(6, 18, 'MULYANA', 'KABCMS0005', 'LAKI-LAKI', NULL, '082115277108'),
(7, 29, 'BUBUN BUNYAMIN', 'KABCMS0006', 'LAKI-LAKI', NULL, '085 713 666 013'),
(8, 24, 'SYAEFUL NUGRAHA', 'KABCMS0007', 'LAKI-LAKI', NULL, '08112471761'),
(9, 15, 'GIAN NURALAM SYAH', 'KABCMS0008', 'LAKI-LAKI', NULL, '089662403844'),
(10, 24, 'RUDI ERNA SANTOSA', 'KABCMS0009', 'LAKI-LAKI', NULL, '085223203941'),
(11, 24, 'ATI SURTI', 'KABCMS0010', 'PEREMPUAN', NULL, '085212164199'),
(12, 3, 'BUDIYANA', 'KABCMS0011', 'LAKI-LAKI', NULL, '085314453427'),
(13, 5, 'MUHAMAD ARDAN HERNAWAN', 'KABCMS0012', 'LAKI-LAKI', NULL, '087820030439'),
(14, 5, 'RIA QODARIAH', 'KABCMS0013', 'PEREMPUAN', NULL, '081546796079'),
(15, 19, 'ODING NURJAEDIN', 'KABCMS0014', 'LAKI-LAKI', NULL, '0852315369291'),
(16, 17, 'DADAN MUHAMAD RAMDANI', 'KABCMS0015', 'LAKI-LAKI', NULL, '081914214654'),
(17, 17, 'FAHMI NURDIN ZAENI', 'KABCMS0016', 'LAKI-LAKI', NULL, '081512561066'),
(18, 5, 'BAHARI SIREGAR', 'KABCMS0017', 'LAKI-LAKI', NULL, '085318903385'),
(19, 14, 'ADE OBAN', 'KABCMS0018', 'LAKI-LAKI', NULL, '085320482315'),
(20, 5, 'AEP SAEPUL TRISNAWAN', 'KABCMS0019', 'LAKI-LAKI', NULL, '087885907299'),
(21, 19, 'DIKDIK LUKMANUDIN', 'KABCMS0020', 'LAKI-LAKI', NULL, '081336669674'),
(22, 5, 'YUDHI NATAJAYA', 'KABCMS0021', 'LAKI-LAKI', NULL, '081223029120'),
(23, 8, 'ISMA NURSYAMSIYAH', 'KABCMS0022', 'PEREMPUAN', NULL, '081223990009'),
(24, 21, 'OGIE ANGGARA', 'KABCMS0023', 'LAKI-LAKI', NULL, '081223990009'),
(25, 8, 'SHELAWATI APRIANI', 'KABCMS0024', 'PEREMPUAN', NULL, '081321564591'),
(26, 24, 'AGUSMAN', 'KABCMS0025', 'LAKI-LAKI', NULL, '082115751233');

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

--
-- Dumping data for table `calon_tahapan_nilai`
--

INSERT INTO `calon_tahapan_nilai` (`id`, `calon_id`, `tahapan_id`, `tahapan_nilai_id`) VALUES
(1, 19, 1, 3),
(2, 2, 1, 3),
(3, 2, 2, 5),
(4, 2, 3, 8);

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
(2, 'BANJARANYAR'),
(3, 'BANJARSARI'),
(4, 'BAREGBEG'),
(5, 'CIAMIS'),
(6, 'CIDOLOG'),
(7, 'CIHAURBEUTI'),
(8, 'CIJEUNGJING'),
(9, 'CIKONENG'),
(10, 'CIMARAGAS'),
(11, 'CIPAKU'),
(12, 'CISAGA'),
(14, 'JATINAGARA'),
(15, 'KAWALI'),
(16, 'LAKBOK'),
(17, 'LUMBUNG'),
(18, 'PAMARICAN'),
(19, 'PANAWANGAN'),
(20, 'PANJALU'),
(21, 'PANUMBANGAN'),
(22, 'PURWADADI'),
(23, 'RAJADESA'),
(24, 'RANCAH'),
(25, 'SADANANYA'),
(26, 'SUKADANA'),
(27, 'SUKAMANTRI'),
(28, 'TAMBAKSARI'),
(29, 'SINDANGKASIH');

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
(1, 1, 'Administrasi (Kelengkapan Berkas)'),
(2, 2, 'CAT'),
(3, 3, 'Wawancara');

-- --------------------------------------------------------

--
-- Table structure for table `tahapan_nilai`
--

CREATE TABLE `tahapan_nilai` (
  `id` int(11) NOT NULL,
  `tahapan_id` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `nilai` varchar(11) DEFAULT NULL,
  `nilai_nama` varchar(255) DEFAULT NULL,
  `nilai_dari` int(11) DEFAULT NULL,
  `nilai_sampai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahapan_nilai`
--

INSERT INTO `tahapan_nilai` (`id`, `tahapan_id`, `urutan`, `nilai`, `nilai_nama`, `nilai_dari`, `nilai_sampai`) VALUES
(2, 1, 2, 'B', 'KURANG LENGKAP', 60, 80),
(3, 1, 1, 'A', 'LENGKAP', 90, 100),
(4, 1, 3, 'C', 'TIDAK LENGKAP', 0, 50),
(5, 2, 1, 'A', 'BAGUS', 90, 100),
(6, 2, 2, 'B', 'CUKUP', 60, 80),
(7, 2, 3, 'C', 'KURANG', 0, 50),
(8, 3, 1, 'A', 'BAIK', 90, 100),
(9, 3, 2, 'B', 'KURANG ', 60, 80),
(10, 3, 3, 'C', 'CUKUP', 0, 50);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `calon_tahapan_nilai`
--
ALTER TABLE `calon_tahapan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tahapan`
--
ALTER TABLE `tahapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tahapan_nilai`
--
ALTER TABLE `tahapan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_1` FOREIGN KEY (`calon_id`) REFERENCES `calon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_2` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calon_tahapan_nilai_ibfk_3` FOREIGN KEY (`tahapan_nilai_id`) REFERENCES `tahapan_nilai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tahapan_nilai`
--
ALTER TABLE `tahapan_nilai`
  ADD CONSTRAINT `tahapan_nilai_ibfk_1` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
