-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2026 at 07:08 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_qr_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_siswa` int NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `status` enum('hadir','terlambat') NOT NULL,
  `id_petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_sliders`
--

CREATE TABLE `frontend_sliders` (
  `id_slider` int NOT NULL,
  `tipe_media` enum('image','video') NOT NULL DEFAULT 'image',
  `file_media` varchar(255) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `teks_tombol` varchar(50) DEFAULT 'Mulai Sekarang',
  `link_tombol` varchar(255) DEFAULT '#',
  `status` enum('aktif','tidak') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `frontend_sliders`
--

INSERT INTO `frontend_sliders` (`id_slider`, `tipe_media`, `file_media`, `judul`, `deskripsi`, `teks_tombol`, `link_tombol`, `status`) VALUES
(1, 'video', 'https://youtu.be/MZmTZz2U5C8?si=wugZ2osgmWHZh1bX', 'Sistem Absensi Pintar Berbasis QR', 'Pantau kedatangan siswa secara seketika.', 'Masuk Portal', 'auth', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_kelas`
--

CREATE TABLE `m_kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_kelas`
--

INSERT INTO `m_kelas` (`id_kelas`, `nama_kelas`, `tingkat`) VALUES
(1, 'X IPA 1', 'X'),
(2, 'XI MULTIMEDIA', 'XI'),
(3, 'XII TKJ 2', 'XII');

-- --------------------------------------------------------

--
-- Table structure for table `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id_orangtua` int NOT NULL,
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orang_tua`
--

INSERT INTO `orang_tua` (`id_orangtua`, `id_user`, `nama`, `hp`, `email`) VALUES
(1, 2, 'Budi Santoso', '081200000001', 'azmi@gmail.com'),
(2, 3, 'Siti Aminah', '081200000002', 'siti@sekolah.com'),
(3, 4, 'Andi Wijaya', '081200000003', 'andi@sekolah.com'),
(4, 5, 'Rina Susanti', '081200000004', 'rina@sekolah.com'),
(5, 6, 'Hendra Gunawan', '081200000005', 'hendra@sekolah.com');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `nama_pengaturan` varchar(50) NOT NULL,
  `nilai` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_pengaturan`, `nilai`) VALUES
(1, 'jam_masuk', '07:15:00'),
(6, 'notif_whatsapp', 'aktif'),
(7, 'notif_telegram', 'tidak_aktif'),
(8, 'notif_email', 'tidak_aktif'),
(9, 'template_notif', 'Assalamu\'alaikum Wr. Wb. Pemberitahuan: Anak Anda, {nama} ({nis}), kelas {kelas}, telah hadir di sekolah pada tanggal {tanggal} pukul {jam} WIB dengan status {status}. Terima kasih.');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `id_orangtua` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama`, `kelas`, `qr_code`, `id_orangtua`) VALUES
(1, 'SIS001', 'Ahmad Budi', 'X IPA 1', '7b1e64db79d76d130f4faecf00ed412a', 1),
(2, 'SIS002', 'Aisyah Siti', 'X IPS 1', '3d95167e7dd97498be4eed82677330a7', 2),
(3, 'SIS003', 'Dimas Andi', 'XI IPA 1', '1c74656c403fcc91a1656c70da95c4bd', 3),
(4, 'SIS004', 'Putri Rina', 'XI IPS 1', '5170af0da1a4e63d6171ca553253fade', 4),
(5, 'SIS005', 'Kevin Hendra', 'XII IPA 1', '8c83b62348d53e9047627f3310ed9647', 5);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_kelas`
--

CREATE TABLE `siswa_kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa_kelas`
--

INSERT INTO `siswa_kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'X IPA 1'),
(2, 'X IPS 1'),
(3, 'XI IPA 1'),
(4, 'XI IPS 1'),
(5, 'XII IPA 1');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun` int NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `status` enum('aktif','tidak_aktif') DEFAULT 'tidak_aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun`, `tahun_ajaran`, `status`) VALUES
(1, '2025/2026', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','orangtua') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `foto`, `created_at`) VALUES
(1, 'Administrator', 'admin@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'avatar_1_1780765139.jpeg', '2026-06-06 15:33:47'),
(2, 'ulul azmi', 'azmi@gmail.com', '$2y$10$rIDfzpWdhETFjcABuWbP5uXBSrQD3k5lmuWs/8rgf5NeKYEE0Qpny', 'petugas', NULL, '2026-06-06 15:58:04'),
(3, 'Budi Santoso', 'budi@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orangtua', NULL, '2026-06-06 16:06:12'),
(4, 'Siti Aminah', 'siti@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orangtua', NULL, '2026-06-06 16:06:12'),
(5, 'Andi Wijaya', 'andi@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orangtua', NULL, '2026-06-06 16:06:12'),
(6, 'Rina Susanti', 'rina@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orangtua', NULL, '2026-06-06 16:06:12'),
(7, 'Hendra Gunawan', 'hendra@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orangtua', NULL, '2026-06-06 16:06:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `frontend_sliders`
--
ALTER TABLE `frontend_sliders`
  ADD PRIMARY KEY (`id_slider`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id_orangtua`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `qr_code` (`qr_code`),
  ADD KEY `id_orangtua` (`id_orangtua`);

--
-- Indexes for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_sliders`
--
ALTER TABLE `frontend_sliders`
  MODIFY `id_slider` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kelas`
--
ALTER TABLE `m_kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id_orangtua` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_tahun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD CONSTRAINT `orang_tua_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_orangtua`) REFERENCES `orang_tua` (`id_orangtua`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
