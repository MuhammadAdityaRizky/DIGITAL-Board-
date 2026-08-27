-- phpMyAdmin SQL Dump
-- Database: `digital_board`
-- Created from ER Diagram Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
CREATE DATABASE IF NOT EXISTS `digital_board`;
USE `digital_board`;

SET FOREIGN_KEY_CHECKS = 0;

-- DROP TABLES IN REVERSE ORDER TO AVOID FK CONSTRAINTS ERRORS
DROP TABLE IF EXISTS `peserta_agenda`;
DROP TABLE IF EXISTS `perizinan`;
DROP TABLE IF EXISTS `absensi`;
DROP TABLE IF EXISTS `agenda`;
DROP TABLE IF EXISTS `pengumuman`;
DROP TABLE IF EXISTS `laboratorium`;
DROP TABLE IF EXISTS `mahasiswa`;
DROP TABLE IF EXISTS `dosen`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `kelas`;
DROP TABLE IF EXISTS `prodi`;
DROP TABLE IF EXISTS `fakultas`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `migrations`;

-- --------------------------------------------------------
-- Table structure for table `fakultas`
-- --------------------------------------------------------
CREATE TABLE `fakultas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `fakultas` (`id`, `nama_fakultas`, `created_at`) VALUES
(1, 'Fakultas Teknik & Ilmu Komputer', CURRENT_TIMESTAMP),
(2, 'Fakultas Ekonomi & Bisnis', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `prodi`
-- --------------------------------------------------------
CREATE TABLE `prodi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `fakultas_id` bigint UNSIGNED NOT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `prodi_fakultas_id_foreign` (`fakultas_id`),
  CONSTRAINT `prodi_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `prodi` (`id`, `fakultas_id`, `nama_prodi`, `created_at`) VALUES
(1, 1, 'Teknik Informatika', CURRENT_TIMESTAMP),
(2, 1, 'Sistem Informasi', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `kelas`
-- --------------------------------------------------------
CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`) VALUES
(1, 'IF-A 2023', CURRENT_TIMESTAMP),
(2, 'SI-B 2023', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dosen','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin1', '$2y$12$xySII.1WmykSPpWIvhZyoOfZiIPPBdM1FNqzqdEcn2IJsIyXZBDA6', 'admin', CURRENT_TIMESTAMP),
(2, '198501012010121001', '$2y$12$4GEz3sKdWhhuhrdL75urAuQUeqT87VFKx4p.4hYBQZ9aidQijZbwK', 'dosen', CURRENT_TIMESTAMP),
(3, '2023001001', '$2y$12$Vg03RAUVsIhHO5BwMvcWh.U/jy735wxQ2v20wW8dYXS5KD7PzkLqe', 'mahasiswa', CURRENT_TIMESTAMP),
(4, '2023001002', '$2y$12$4ceAVczL5lih1JOK7kqLDuxLDS3lMFcfgj7YgrmryHCqoAUlkKxOK', 'mahasiswa', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `dosen`
-- --------------------------------------------------------
CREATE TABLE `dosen` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Tetap','Tidak Tetap','Honorer','Cuti') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tetap',
  `id_fakultas` bigint UNSIGNED DEFAULT NULL,
  `id_prodi` bigint UNSIGNED DEFAULT NULL,
  `kompetensi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dosen_nip_unique` (`nip`),
  KEY `dosen_user_id_foreign` (`user_id`),
  KEY `dosen_id_fakultas_foreign` (`id_fakultas`),
  KEY `dosen_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dosen_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `dosen_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dosen` (`id`, `user_id`, `nip`, `nama`, `status`, `id_fakultas`, `id_prodi`, `kompetensi`, `created_at`) VALUES
(1, 2, '198501012010121001', 'Dr. Budi Santoso, M.T.', 'Tetap', 1, 1, 'Pemrograman Web, Rekayasa Perangkat Lunak', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `mahasiswa`
-- --------------------------------------------------------
CREATE TABLE `mahasiswa` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` bigint UNSIGNED DEFAULT NULL,
  `id_prodi` bigint UNSIGNED DEFAULT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_nim_unique` (`nim`),
  KEY `mahasiswa_user_id_foreign` (`user_id`),
  KEY `mahasiswa_id_fakultas_foreign` (`id_fakultas`),
  KEY `mahasiswa_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mahasiswa_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `mahasiswa_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mahasiswa` (`id`, `user_id`, `nim`, `nama_lengkap`, `id_fakultas`, `id_prodi`, `kelas`, `semester`, `created_at`) VALUES
(1, 3, '2023001001', 'Ahmad Rizky', 1, 1, 'IF-A 2023', 4, CURRENT_TIMESTAMP),
(2, 4, '2023001002', 'Siti Nurhaliza', 1, 1, 'IF-A 2023', 4, CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `laboratorium`
-- --------------------------------------------------------
CREATE TABLE `laboratorium` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_lab` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL DEFAULT '40',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `laboratorium` (`id`, `nama_lab`, `lokasi`, `kapasitas`, `created_at`) VALUES
(1, 'Laboratorium Komputer 1', 'Gedung B Lantai 2', 40, CURRENT_TIMESTAMP),
(2, 'Laboratorium Sistem Informasi', 'Gedung C Lantai 1', 35, CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `pengumuman`
-- --------------------------------------------------------
CREATE TABLE `pengumuman` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_pengumuman` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengumuman_admin_id_foreign` (`admin_id`),
  CONSTRAINT `pengumuman_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pengumuman` (`id`, `admin_id`, `judul`, `isi_pengumuman`, `foto_url`, `created_at`) VALUES
(1, 1, 'Pemeliharaan Jaringan Lab', 'Akan dilakukan perawatan jaringan lokal pada pukul 16:00 WIB.', NULL, CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `agenda`
-- --------------------------------------------------------
CREATE TABLE `agenda` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `lab_id` bigint UNSIGNED NOT NULL,
  `mata_kuliah` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_agenda` enum('Akan Datang','Berlangsung','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Akan Datang',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `materi_realisasi` text COLLATE utf8mb4_unicode_ci,
  `dosen_waktu_masuk` timestamp NULL DEFAULT NULL,
  `qr_code_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agenda_qr_code_token_unique` (`qr_code_token`),
  KEY `agenda_dosen_id_foreign` (`dosen_id`),
  KEY `agenda_lab_id_foreign` (`lab_id`),
  CONSTRAINT `agenda_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `agenda_lab_id_foreign` FOREIGN KEY (`lab_id`) REFERENCES `laboratorium` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `agenda` (`id`, `dosen_id`, `lab_id`, `mata_kuliah`, `kelas`, `semester`, `jurusan`, `fakultas`, `tanggal`, `jam_mulai`, `jam_selesai`, `status_agenda`, `catatan`, `materi_realisasi`, `dosen_waktu_masuk`, `qr_code_token`, `created_at`) VALUES
(1, 1, 1, 'Praktikum Pemrograman Web', 'IF-A 2023', 'Semester 4', 'Teknik Informatika', 'Fakultas Teknik & Ilmu Komputer', CURRENT_DATE, '08:00:00', '10:30:00', 'Berlangsung', 'Membahas integrasi MySQL dan PHP', 'Selesai menjelaskan koneksi database & CRUD sederhana', CURRENT_TIMESTAMP, 'TOKEN_QR_AGENDA_1_20260811', CURRENT_TIMESTAMP);

-- --------------------------------------------------------
-- Table structure for table `absensi`
-- --------------------------------------------------------
CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `agenda_id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `waktu_masuk` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_kehadiran` enum('Hadir','Terlambat','Izin','Sakit','Alpa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_absensi_per_agenda` (`agenda_id`,`mahasiswa_id`),
  KEY `absensi_mahasiswa_id_foreign` (`mahasiswa_id`),
  CONSTRAINT `absensi_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `absensi_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `absensi` (`id`, `agenda_id`, `mahasiswa_id`, `waktu_masuk`, `status_kehadiran`) VALUES
(1, 1, 1, CURRENT_TIMESTAMP, 'Hadir'),
(2, 1, 2, CURRENT_TIMESTAMP, 'Hadir');

-- --------------------------------------------------------
-- Table structure for table `perizinan`
-- --------------------------------------------------------
CREATE TABLE `perizinan` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `agenda_id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `kategori` enum('Izin','Sakit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_persetujuan` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `perizinan_agenda_id_foreign` (`agenda_id`),
  KEY `perizinan_mahasiswa_id_foreign` (`mahasiswa_id`),
  CONSTRAINT `perizinan_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perizinan_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_08_11_000001_create_digital_board_tables', 1);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
