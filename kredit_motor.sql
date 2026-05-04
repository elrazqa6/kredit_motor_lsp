-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2026 at 01:26 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kredit_motor`
--

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kredit` bigint UNSIGNED DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `angsuran_ke` int DEFAULT NULL,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `total_bayar` double DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id`, `id_kredit`, `tgl_bayar`, `angsuran_ke`, `tgl_jatuh_tempo`, `total_bayar`, `keterangan`, `created_at`, `updated_at`) VALUES
(26, 9, '2026-04-26', 1, '2026-05-25', 2846317, 'Pembayaran gagal - status: expire', '2026-04-24 23:23:12', '2026-04-25 23:15:29'),
(27, 9, '2026-04-27', 2, '2026-06-25', 2846317, 'Angsuran ke-2', '2026-04-24 23:23:12', '2026-04-27 05:02:05'),
(28, 9, NULL, 3, '2026-07-25', 2846317, 'Angsuran ke-3', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(29, 9, NULL, 4, '2026-08-25', 2846317, 'Angsuran ke-4', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(30, 9, NULL, 5, '2026-09-25', 2846317, 'Angsuran ke-5', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(31, 9, NULL, 6, '2026-10-25', 2846317, 'Angsuran ke-6', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(32, 9, NULL, 7, '2026-11-25', 2846317, 'Angsuran ke-7', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(33, 9, NULL, 8, '2026-12-25', 2846317, 'Angsuran ke-8', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(34, 9, NULL, 9, '2027-01-25', 2846317, 'Angsuran ke-9', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(35, 9, NULL, 10, '2027-02-25', 2846317, 'Angsuran ke-10', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(36, 9, NULL, 11, '2027-03-25', 2846317, 'Angsuran ke-11', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(37, 9, NULL, 12, '2027-04-25', 2846317, 'Angsuran ke-12', '2026-04-24 23:23:12', '2026-04-24 23:23:12'),
(38, 10, '2026-04-26', 1, '2026-05-25', 943089, 'Pembayaran sukses via Midtrans - capture', '2026-04-25 10:21:34', '2026-04-26 00:56:32'),
(39, 10, '2026-04-27', 2, '2026-06-25', 943089, 'Angsuran ke-2', '2026-04-25 10:21:34', '2026-04-26 20:55:40'),
(40, 10, NULL, 3, '2026-07-25', 943089, 'Angsuran ke-3', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(41, 10, NULL, 4, '2026-08-25', 943089, 'Angsuran ke-4', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(42, 10, NULL, 5, '2026-09-25', 943089, 'Angsuran ke-5', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(43, 10, NULL, 6, '2026-10-25', 943089, 'Angsuran ke-6', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(44, 10, NULL, 7, '2026-11-25', 943089, 'Angsuran ke-7', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(45, 10, NULL, 8, '2026-12-25', 943089, 'Angsuran ke-8', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(46, 10, NULL, 9, '2027-01-25', 943089, 'Angsuran ke-9', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(47, 10, NULL, 10, '2027-02-25', 943089, 'Angsuran ke-10', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(48, 10, NULL, 11, '2027-03-25', 943089, 'Angsuran ke-11', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(49, 10, NULL, 12, '2027-04-25', 943089, 'Angsuran ke-12', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(50, 10, NULL, 13, '2027-05-25', 943089, 'Angsuran ke-13', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(51, 10, NULL, 14, '2027-06-25', 943089, 'Angsuran ke-14', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(52, 10, NULL, 15, '2027-07-25', 943089, 'Angsuran ke-15', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(53, 10, NULL, 16, '2027-08-25', 943089, 'Angsuran ke-16', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(54, 10, NULL, 17, '2027-09-25', 943089, 'Angsuran ke-17', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(55, 10, NULL, 18, '2027-10-25', 943089, 'Angsuran ke-18', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(56, 10, NULL, 19, '2027-11-25', 943089, 'Angsuran ke-19', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(57, 10, NULL, 20, '2027-12-25', 943089, 'Angsuran ke-20', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(58, 10, NULL, 21, '2028-01-25', 943089, 'Angsuran ke-21', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(59, 10, NULL, 22, '2028-02-25', 943089, 'Angsuran ke-22', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(60, 10, NULL, 23, '2028-03-25', 943089, 'Angsuran ke-23', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(61, 10, NULL, 24, '2028-04-25', 943089, 'Angsuran ke-24', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(62, 10, NULL, 25, '2028-05-25', 943089, 'Angsuran ke-25', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(63, 10, NULL, 26, '2028-06-25', 943089, 'Angsuran ke-26', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(64, 10, NULL, 27, '2028-07-25', 943089, 'Angsuran ke-27', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(65, 10, NULL, 28, '2028-08-25', 943089, 'Angsuran ke-28', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(66, 10, NULL, 29, '2028-09-25', 943089, 'Angsuran ke-29', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(67, 10, NULL, 30, '2028-10-25', 943089, 'Angsuran ke-30', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(68, 10, NULL, 31, '2028-11-25', 943089, 'Angsuran ke-31', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(69, 10, NULL, 32, '2028-12-25', 943089, 'Angsuran ke-32', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(70, 10, NULL, 33, '2029-01-25', 943089, 'Angsuran ke-33', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(71, 10, NULL, 34, '2029-02-25', 943089, 'Angsuran ke-34', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(72, 10, NULL, 35, '2029-03-25', 943089, 'Angsuran ke-35', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(73, 10, NULL, 36, '2029-04-25', 943089, 'Angsuran ke-36', '2026-04-25 10:21:34', '2026-04-25 10:21:34'),
(74, 11, '2026-04-27', 1, '2026-05-26', 3186000, 'Angsuran ke-1', '2026-04-25 20:54:34', '2026-04-26 19:25:32'),
(75, 11, '2026-04-27', 2, '2026-06-26', 3186000, 'Angsuran ke-2', '2026-04-25 20:54:34', '2026-04-27 05:17:15'),
(76, 11, NULL, 3, '2026-07-26', 3186000, 'Angsuran ke-3', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(77, 11, NULL, 4, '2026-08-26', 3186000, 'Angsuran ke-4', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(78, 11, NULL, 5, '2026-09-26', 3186000, 'Angsuran ke-5', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(79, 11, NULL, 6, '2026-10-26', 3186000, 'Angsuran ke-6', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(80, 11, NULL, 7, '2026-11-26', 3186000, 'Angsuran ke-7', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(81, 11, NULL, 8, '2026-12-26', 3186000, 'Angsuran ke-8', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(82, 11, NULL, 9, '2027-01-26', 3186000, 'Angsuran ke-9', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(83, 11, NULL, 10, '2027-02-26', 3186000, 'Angsuran ke-10', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(84, 11, NULL, 11, '2027-03-26', 3186000, 'Angsuran ke-11', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(85, 11, NULL, 12, '2027-04-26', 3186000, 'Angsuran ke-12', '2026-04-25 20:54:34', '2026-04-25 20:54:34'),
(86, 12, '2026-04-27', 1, '2026-05-27', 3186000, 'Angsuran ke-1', '2026-04-26 21:25:01', '2026-04-27 04:56:09'),
(87, 12, '2026-04-27', 2, '2026-06-27', 3186000, 'Angsuran ke-2', '2026-04-26 21:25:01', '2026-04-27 05:24:35'),
(88, 12, NULL, 3, '2026-07-27', 3186000, 'Angsuran ke-3', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(89, 12, '2026-04-28', 4, '2026-08-27', 3186000, 'Angsuran ke-4', '2026-04-26 21:25:01', '2026-04-27 21:24:58'),
(90, 12, NULL, 5, '2026-09-27', 3186000, 'Angsuran ke-5', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(91, 12, NULL, 6, '2026-10-27', 3186000, 'Angsuran ke-6', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(92, 12, NULL, 7, '2026-11-27', 3186000, 'Angsuran ke-7', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(93, 12, NULL, 8, '2026-12-27', 3186000, 'Angsuran ke-8', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(94, 12, NULL, 9, '2027-01-27', 3186000, 'Angsuran ke-9', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(95, 12, NULL, 10, '2027-02-27', 3186000, 'Angsuran ke-10', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(96, 12, NULL, 11, '2027-03-27', 3186000, 'Angsuran ke-11', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(97, 12, NULL, 12, '2027-04-27', 3186000, 'Angsuran ke-12', '2026-04-26 21:25:01', '2026-04-26 21:25:01'),
(98, 13, '2026-04-30', 1, '2026-05-28', 1521533, 'Angsuran ke-1', '2026-04-28 00:07:00', '2026-04-30 02:03:52'),
(99, 13, NULL, 2, '2026-06-28', 1521533, 'Angsuran ke-2', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(100, 13, NULL, 3, '2026-07-28', 1521533, 'Angsuran ke-3', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(101, 13, NULL, 4, '2026-08-28', 1521533, 'Angsuran ke-4', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(102, 13, NULL, 5, '2026-09-28', 1521533, 'Angsuran ke-5', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(103, 13, NULL, 6, '2026-10-28', 1521533, 'Angsuran ke-6', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(104, 13, NULL, 7, '2026-11-28', 1521533, 'Angsuran ke-7', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(105, 13, NULL, 8, '2026-12-28', 1521533, 'Angsuran ke-8', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(106, 13, NULL, 9, '2027-01-28', 1521533, 'Angsuran ke-9', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(107, 13, NULL, 10, '2027-02-28', 1521533, 'Angsuran ke-10', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(108, 13, NULL, 11, '2027-03-28', 1521533, 'Angsuran ke-11', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(109, 13, NULL, 12, '2027-04-28', 1521533, 'Angsuran ke-12', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(110, 13, NULL, 13, '2027-05-28', 1521533, 'Angsuran ke-13', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(111, 13, NULL, 14, '2027-06-28', 1521533, 'Angsuran ke-14', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(112, 13, NULL, 15, '2027-07-28', 1521533, 'Angsuran ke-15', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(113, 13, NULL, 16, '2027-08-28', 1521533, 'Angsuran ke-16', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(114, 13, NULL, 17, '2027-09-28', 1521533, 'Angsuran ke-17', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(115, 13, NULL, 18, '2027-10-28', 1521533, 'Angsuran ke-18', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(116, 13, NULL, 19, '2027-11-28', 1521533, 'Angsuran ke-19', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(117, 13, NULL, 20, '2027-12-28', 1521533, 'Angsuran ke-20', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(118, 13, NULL, 21, '2028-01-28', 1521533, 'Angsuran ke-21', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(119, 13, NULL, 22, '2028-02-28', 1521533, 'Angsuran ke-22', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(120, 13, NULL, 23, '2028-03-28', 1521533, 'Angsuran ke-23', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(121, 13, NULL, 24, '2028-04-28', 1521533, 'Angsuran ke-24', '2026-04-28 00:07:00', '2026-04-28 00:07:00'),
(122, 14, NULL, 1, '2026-05-30', 3186000, 'Angsuran ke-1', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(123, 14, NULL, 2, '2026-06-30', 3186000, 'Angsuran ke-2', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(124, 14, NULL, 3, '2026-07-30', 3186000, 'Angsuran ke-3', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(125, 14, NULL, 4, '2026-08-30', 3186000, 'Angsuran ke-4', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(126, 14, NULL, 5, '2026-09-30', 3186000, 'Angsuran ke-5', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(127, 14, NULL, 6, '2026-10-30', 3186000, 'Angsuran ke-6', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(128, 14, NULL, 7, '2026-11-30', 3186000, 'Angsuran ke-7', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(129, 14, NULL, 8, '2026-12-30', 3186000, 'Angsuran ke-8', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(130, 14, NULL, 9, '2027-01-30', 3186000, 'Angsuran ke-9', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(131, 14, NULL, 10, '2027-03-02', 3186000, 'Angsuran ke-10', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(132, 14, NULL, 11, '2027-03-30', 3186000, 'Angsuran ke-11', '2026-04-30 04:34:55', '2026-04-30 04:34:55'),
(133, 14, NULL, 12, '2027-04-30', 3186000, 'Angsuran ke-12', '2026-04-30 04:34:55', '2026-04-30 04:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `asuransi`
--

CREATE TABLE `asuransi` (
  `id` int NOT NULL,
  `nama_asuransi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` decimal(15,0) NOT NULL DEFAULT '0',
  `margin_asuransi` decimal(5,2) NOT NULL DEFAULT '0.00',
  `no_rekening` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_logo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asuransi`
--

INSERT INTO `asuransi` (`id`, `nama_asuransi`, `nama_perusahaan`, `biaya`, `margin_asuransi`, `no_rekening`, `url_logo`, `created_at`, `updated_at`) VALUES
(1, 'Asuransi Kendaraan', 'Jasindo', 5000000, 20.00, '1289281276', 'asuransi/C2eCv3qOH1ZdfxUSu6ZARDS2Gg2u0syMonGmTL0z.png', '2026-04-20 18:59:26', '2026-04-20 18:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero`
--

CREATE TABLE `hero` (
  `id` int NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `sub_judul` text,
  `gambar` varchar(255) DEFAULT NULL,
  `tombol_teks` varchar(100) DEFAULT 'Lihat Selengkapnya',
  `tombol_link` varchar(255) DEFAULT '#',
  `urutan` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`id`, `judul`, `sub_judul`, `gambar`, `tombol_teks`, `tombol_link`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kredit Terpercaya', 'Website kredit terpercaya Indonesia', 'hero/1777512027_hero_eaa.jpg', 'Lihat Selengkapnya', '#', 1, 1, '2026-04-28 21:32:45', '2026-04-29 18:20:27'),
(2, 'Berkah Digital Kredit', 'Bismillah Berhasil', 'hero/1777512072_hero_esss.jpg', 'Pelajari Selengkapnya', '#', 2, 1, '2026-04-28 21:34:52', '2026-04-29 18:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_cicilan`
--

CREATE TABLE `jenis_cicilan` (
  `id` bigint UNSIGNED NOT NULL,
  `lama_cicilan` int NOT NULL COMMENT 'Lama cicilan dalam bulan',
  `margin_kredit` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT 'Margin kredit dalam persen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_cicilan`
--

INSERT INTO `jenis_cicilan` (`id`, `lama_cicilan`, `margin_kredit`, `created_at`, `updated_at`) VALUES
(1, 12, 8.50, '2026-04-20 19:16:59', '2026-04-20 19:16:59'),
(2, 12, 8.00, '2026-04-21 13:24:08', '2026-04-21 13:24:08'),
(3, 24, 8.00, '2026-04-21 13:24:08', '2026-04-21 13:24:08'),
(4, 36, 8.00, '2026-04-21 13:24:08', '2026-04-21 13:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_motor`
--

CREATE TABLE `jenis_motor` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_motor`
--

INSERT INTO `jenis_motor` (`id`, `nama_jenis`, `created_at`, `updated_at`) VALUES
(1, 'Matic', NULL, NULL),
(2, 'Sport', NULL, NULL),
(3, 'Bebek', NULL, NULL),
(4, 'Skuter', NULL, NULL),
(5, 'Dual Sport', NULL, NULL),
(6, 'Naked Sport', NULL, NULL),
(7, 'Sport Bike', NULL, NULL),
(8, 'Retro', NULL, NULL),
(9, 'Cruiser', NULL, NULL),
(10, 'Sport Touring', NULL, NULL),
(11, 'Dirt Bike', NULL, NULL),
(12, 'Motocross', NULL, NULL),
(13, 'Scrambler', NULL, NULL),
(14, 'ATV', NULL, NULL),
(15, 'Motor Adventure', NULL, NULL),
(16, 'Lainnya', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kredit`
--

CREATE TABLE `kredit` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pengajuan_kredit` bigint UNSIGNED DEFAULT NULL,
  `id_metode_bayar` bigint UNSIGNED DEFAULT NULL,
  `tgl_mulai_kredit` date DEFAULT NULL,
  `tgl_selesai_kredit` date DEFAULT NULL,
  `sisa_kredit` double DEFAULT NULL,
  `status_kredit` enum('Dicicil','Macet','Lunas') DEFAULT 'Dicicil',
  `keterangan_status_kredit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kredit`
--

INSERT INTO `kredit` (`id`, `id_pengajuan_kredit`, `id_metode_bayar`, `tgl_mulai_kredit`, `tgl_selesai_kredit`, `sisa_kredit`, `status_kredit`, `keterangan_status_kredit`, `created_at`, `updated_at`) VALUES
(9, 8, 1, '2026-04-25', '2027-04-25', 22770532, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-24 23:23:12', '2026-04-27 05:02:05'),
(10, 9, 1, '2026-04-25', '2029-04-25', 32065022, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-25 10:21:34', '2026-04-26 20:55:40'),
(11, 10, 1, '2026-04-26', '2027-04-26', 25488000, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-25 20:54:34', '2026-04-27 05:17:15'),
(12, 11, 1, '2026-04-27', '2027-04-27', 25488000, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-26 21:25:01', '2026-04-27 21:24:58'),
(13, 12, 1, '2026-04-28', '2028-04-28', 28909135, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-28 00:07:00', '2026-04-30 02:03:52'),
(14, 13, 1, '2026-04-30', '2027-04-30', 38232000, 'Dicicil', 'Kredit aktif dari pengajuan yang disetujui', '2026-04-30 04:34:55', '2026-04-30 04:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `metode_bayar`
--

CREATE TABLE `metode_bayar` (
  `id` bigint UNSIGNED NOT NULL,
  `metode_pembayaran` varchar(30) DEFAULT NULL,
  `tempat_bayar` varchar(50) DEFAULT NULL,
  `no_rekening` varchar(25) DEFAULT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `metode_bayar`
--

INSERT INTO `metode_bayar` (`id`, `metode_pembayaran`, `tempat_bayar`, `no_rekening`, `url_logo`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 'Kantor Dealer', NULL, NULL, '2026-04-22 02:15:24', '2026-04-22 02:15:24'),
(2, 'Transfer BCA', 'BCA', '1234567890', NULL, '2026-04-22 02:15:24', '2026-04-22 02:15:24'),
(3, 'Transfer Mandiri', 'Bank Mandiri', '0987654321', NULL, '2026-04-22 02:15:24', '2026-04-22 02:15:24'),
(4, 'Transfer BRI', 'BRI', '1122334455', NULL, '2026-04-22 02:15:24', '2026-04-22 02:15:24'),
(5, 'Auto Debit BNI', 'BNI', '5566778899', NULL, '2026-04-22 02:15:24', '2026-04-22 02:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_05_090512_create_motors_table', 1),
(5, '2026_04_05_090513_create_jenis_motors_table', 1),
(6, '2026_04_05_090514_create_pelanggans_table', 1),
(7, '2026_04_05_090515_create_kredits_table', 1),
(8, '2026_04_05_090515_create_pengajuan_kredits_table', 1),
(9, '2026_04_05_090516_create_angsurans_table', 1),
(10, '2026_04_05_090517_create_pembayarans_table', 1),
(11, '2026_04_05_090518_create_metode_bayars_table', 1),
(12, '2026_04_05_090519_create_jenis_cicilans_table', 1),
(13, '2026_04_05_090520_create_pengirimen_table', 1),
(14, '2026_04_05_090536_create_asuransis_table', 1),
(15, '2026_04_22_120919_create_pembayaran_table', 2),
(16, '2026_04_24_133443_add_tgl_jatuh_tempo_to_angsuran_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `motor`
--

CREATE TABLE `motor` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_motor` varchar(100) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `jenis_id` bigint UNSIGNED DEFAULT NULL,
  `harga_cash` int DEFAULT NULL,
  `harga_jual` int DEFAULT NULL,
  `deskripsi_motor` text,
  `warna` varchar(50) DEFAULT NULL,
  `kapasitas_mesin` varchar(10) DEFAULT NULL,
  `tahun_produksi` varchar(4) DEFAULT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `motor`
--

INSERT INTO `motor` (`id`, `nama_motor`, `merk`, `jenis_id`, `harga_cash`, `harga_jual`, `deskripsi_motor`, `warna`, `kapasitas_mesin`, `tahun_produksi`, `foto1`, `foto2`, `foto3`, `stok`, `created_at`, `updated_at`) VALUES
(1, 'Variio 160', 'Vario', 1, 31000000, 33100000, NULL, 'Biru Dongker', NULL, '2019', 'motor/4Ysv8xN6AdN20cqO5qpnn1jR7zFVp926uofQyu9S.jpg', NULL, NULL, 3, '2026-04-19 23:02:46', '2026-04-19 23:02:46'),
(3, 'Nmax 155', 'Yamaha', 1, 36000000, 38000000, NULL, 'Hitam', NULL, '2021', 'motor/Ooc7YJDm9n9TGbBDF4pploTzqsLWnbYiXNTLtDYy.png', NULL, NULL, 1, '2026-04-20 00:57:22', '2026-04-20 00:57:22'),
(4, 'Filano Hybrid', 'Yamaha', 1, 28000000, 29000000, NULL, 'Putih', NULL, '2023', 'motor/yN3TQD4Wco3B1GOQ8N1r7oOdM2IxtISklkscBK2J.jpg', NULL, NULL, 1, '2026-04-20 01:00:14', '2026-04-20 01:00:14'),
(5, 'Honda PCX CBS Exceptional Black', 'Honda', NULL, 34000000, 35989000, NULL, 'Hitam', NULL, NULL, 'motor/Bc0nybWp1bJfW3P3Y8BCFRl7Bdl4mwXBq5jXjiCb.jpg', NULL, NULL, 4, '2026-04-26 01:25:34', '2026-04-26 01:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat1` varchar(255) DEFAULT NULL,
  `kota1` varchar(100) DEFAULT NULL,
  `provinsi1` varchar(100) DEFAULT NULL,
  `kodepos1` varchar(10) DEFAULT NULL,
  `alamat2` varchar(255) DEFAULT NULL,
  `kota2` varchar(100) DEFAULT NULL,
  `provinsi2` varchar(100) DEFAULT NULL,
  `kodepos2` varchar(10) DEFAULT NULL,
  `alamat3` varchar(255) DEFAULT NULL,
  `kota3` varchar(100) DEFAULT NULL,
  `provinsi3` varchar(100) DEFAULT NULL,
  `kodepos3` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `user_id`, `nama_pelanggan`, `email`, `no_telp`, `alamat1`, `kota1`, `provinsi1`, `kodepos1`, `alamat2`, `kota2`, `provinsi2`, `kodepos2`, `alamat3`, `kota3`, `provinsi3`, `kodepos3`, `foto`, `created_at`, `updated_at`) VALUES
(1, NULL, 'el', 'elrazqa996@gmail.com', '085176802810', 'bojonggede', 'bogor', 'jawa barat', '16920', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-19 20:10:20', '2026-04-19 20:10:20'),
(7, NULL, 'razqaa', 'el0987654321@gmail.com', '0886546781', 'Cibinong', 'Bogor', 'Jawa Barat', '169922', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:41:47', '2026-04-21 08:41:47'),
(10, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:42:41', '2026-04-21 08:42:41'),
(11, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:44:44', '2026-04-21 08:44:44'),
(12, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:48:56', '2026-04-21 08:48:56'),
(13, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:51:23', '2026-04-21 08:51:23'),
(14, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:55:05', '2026-04-21 08:55:05'),
(15, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:55:06', '2026-04-21 08:55:06'),
(16, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:59:14', '2026-04-21 08:59:14'),
(17, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 08:59:34', '2026-04-21 08:59:34'),
(18, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:03:39', '2026-04-21 09:03:39'),
(19, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:04:46', '2026-04-21 09:04:46'),
(20, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:05:17', '2026-04-21 09:05:17'),
(21, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:06:02', '2026-04-21 09:06:02'),
(22, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:06:03', '2026-04-21 09:06:03'),
(23, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:08:49', '2026-04-21 09:08:49'),
(24, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:08:50', '2026-04-21 09:08:50'),
(25, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:09:08', '2026-04-21 09:09:08'),
(26, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:11:26', '2026-04-21 09:11:26'),
(27, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:12:37', '2026-04-21 09:12:37'),
(28, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:13:35', '2026-04-21 09:13:35'),
(30, NULL, 'el razqa', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:13:49', '2026-04-21 09:13:49'),
(31, 9, 'el razqa', NULL, '085176802810', 'Jl.Curug Mas 1 Gg. Mangga No.36 RT 01/12', 'Bogor', 'Jawa Barat', '16920', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 09:20:08', '2026-04-27 00:43:23'),
(32, 12, 'Rehan', 'rehanc@gmail.com', '08726728118', 'BDB 2 Jl. Flamboyan No 3 RT 09/11', 'Bogor', 'Jawa Barat', '16922', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-30 04:34:26', '2026-04-30 04:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kredit` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal_bayar` double NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `denda` double NOT NULL DEFAULT '0',
  `status_bayar` enum('Belum Bayar','Lunas','Terlambat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kredit` bigint UNSIGNED NOT NULL,
  `angsuran_ke` int NOT NULL,
  `jatuh_tempo` datetime NOT NULL,
  `nominal_bayar` double NOT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `denda` double NOT NULL DEFAULT '0',
  `status_bayar` enum('Belum Bayar','Lunas','Terlambat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_kredit`
--

CREATE TABLE `pengajuan_kredit` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pelanggan` bigint UNSIGNED DEFAULT NULL,
  `id_motor` bigint UNSIGNED DEFAULT NULL,
  `id_jenis_cicilan` int DEFAULT NULL,
  `id_asuransi` bigint UNSIGNED DEFAULT NULL,
  `id_metode_bayar` bigint UNSIGNED DEFAULT NULL,
  `uang_muka` double DEFAULT NULL,
  `status_dp` enum('Belum Bayar','Menunggu','Lunas','Ditolak') DEFAULT 'Belum Bayar',
  `bukti_dp` varchar(255) DEFAULT NULL,
  `tgl_bayar_dp` datetime DEFAULT NULL,
  `keterangan_dp` text,
  `status_pengajuan` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_pengajuan_kredit` date DEFAULT NULL,
  `harga_cash` int DEFAULT NULL,
  `dp` int DEFAULT NULL,
  `harga_kredit` double DEFAULT NULL,
  `biaya_asuransi_perbulan` double DEFAULT NULL,
  `cicilan_perbulan` double DEFAULT NULL,
  `tenor` int NOT NULL DEFAULT '0',
  `url_kk` varchar(255) DEFAULT NULL,
  `url_ktp` varchar(255) DEFAULT NULL,
  `url_npwp` varchar(255) DEFAULT NULL,
  `url_slip_gaji` varchar(255) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `keterangan_status_pengajuan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengajuan_kredit`
--

INSERT INTO `pengajuan_kredit` (`id`, `id_pelanggan`, `id_motor`, `id_jenis_cicilan`, `id_asuransi`, `id_metode_bayar`, `uang_muka`, `status_dp`, `bukti_dp`, `tgl_bayar_dp`, `keterangan_dp`, `status_pengajuan`, `created_at`, `updated_at`, `tgl_pengajuan_kredit`, `harga_cash`, `dp`, `harga_kredit`, `biaya_asuransi_perbulan`, `cicilan_perbulan`, `tenor`, `url_kk`, `url_ktp`, `url_npwp`, `url_slip_gaji`, `url_foto`, `keterangan_status_pengajuan`) VALUES
(8, 31, 1, 1, 1, 3, 6620000, 'Lunas', 'bukti_dp/1777135717_dp_skedul.png', '2026-04-25 16:48:37', 'ea', 'Disetujui', '2026-04-24 23:06:08', '2026-04-25 10:30:16', '2026-04-25', 33100000, 20, 34155800, 416666.66666667, 2846316.6666667, 12, 'dokumen/kk/EOp3bBaZUHH2NxXEnrkGmgtmZOlrfqnmKyYImFHV.png', 'dokumen/ktp/vjh8Px7lJpg3S9fKyvV68ZWCkGxPKJzkPxLMPahP.png', NULL, 'dokumen/slip_gaji/N7B0045EKLyAizWFkm44ZzlrOpOAZCML9WtQ1KlS.png', 'dokumen/foto/pPDgJOOUkrcxvISDVyGmp8VQnJYaxgGE1Itjwd7V.png', NULL),
(9, 31, 4, 4, 1, 4, 6620000, 'Lunas', 'bukti_dp/1777137748_dp_motor vario 160.jpg', '2026-04-25 17:22:28', 'p p apaah', 'Disetujui', '2026-04-25 10:20:11', '2026-04-25 10:23:12', '2026-04-25', 29000000, 23, 33951200, 138888.88888889, 943088.88888889, 36, 'dokumen/kk/4hzXEZkBAe7N3hZryu92DRIHNfArSreCYPo0obIy.png', 'dokumen/ktp/yIrj655HkQhDjS5NUAYmWCrEcKhRJBek6ZStfr6t.jpg', NULL, 'dokumen/slip_gaji/s9uG6pGwnL5xfxsukOG4QvcOCPKgIi0EXx7eTcK3.png', 'dokumen/foto/1TDOcwzL4kbxOQyzF32qL4V8SyraxM76i8w5216t.png', NULL),
(10, 31, 3, 2, 1, 2, 7600000, 'Lunas', NULL, '2026-04-26 05:49:50', 'Pembayaran sukses via settlement', 'Disetujui', '2026-04-25 20:53:56', '2026-04-25 22:49:50', '2026-04-26', 38000000, 20, 38232000, 416666.66666667, 3186000, 12, 'dokumen/kk/kE9n7RMB0fsMTkHHkW57GteyhWyiKECL0DgzLvkm.jpg', 'dokumen/ktp/oBoQkHBQ4ytqVRTZskmbLGQ8fLhG4n10fJp0wDC9.jpg', NULL, 'dokumen/slip_gaji/Ah9iQFEVYlroo7RRALBRsstg0AEIqITYiROhzttL.png', 'dokumen/foto/Ipa59tacCbfhCPVEdZK3LAKRbmnHKEAUvQuMNXt2.jpg', NULL),
(11, 31, 3, 2, 1, 2, 7600000, 'Lunas', NULL, '2026-04-27 04:25:52', NULL, 'Disetujui', '2026-04-26 21:24:14', '2026-04-26 21:25:52', '2026-04-27', 38000000, 20, 38232000, 416666.66666667, 3186000, 12, 'dokumen/kk/GYRu9ALcRDQ57A8HBgerTM1ZjvvT5XoS6q2I5iFk.png', 'dokumen/ktp/cTlS7m8WfokJx1C1wBgUOByI4luzTmflVHx8b5Nm.jpg', NULL, 'dokumen/slip_gaji/tLq60wLoMnub5Qr7ojk0LBsPJEwFiAkAV8xeK7DJ.png', 'dokumen/foto/fiwrDQybeYaNCQ1DOO3N5qpfSnRwddE1Rk9VYxeM.png', NULL),
(12, 31, 1, 3, 1, 2, 6620000, 'Lunas', NULL, '2026-04-28 07:08:34', NULL, 'Disetujui', '2026-04-28 00:05:58', '2026-04-28 00:08:34', '2026-04-28', 33100000, 20, 36516800, 208333.33333333, 1521533.3333333, 24, 'dokumen/kk/xnzwWAHCcQiDC30WkBfpV81xszaERXMyRcY2fNeD.png', 'dokumen/ktp/Dp9WNSVvyVkZtOspWe5HeTBFk0JvgVGD3SSUvxX2.png', NULL, 'dokumen/slip_gaji/6Ele5JScC4fbaOrr5CD1qLPd99mtSvzuvPLxWgA5.png', 'dokumen/foto/MjA6Nnh82TWD36I8oDIM6YOOlV7GXv5wpWbTUJRP.png', 'p p apah'),
(13, 32, 3, 2, 1, 1, 7600000, 'Lunas', NULL, '2026-04-30 12:18:35', NULL, 'Disetujui', '2026-04-30 04:34:27', '2026-04-30 05:18:35', '2026-04-30', 38000000, 20, 38232000, 416666.66666667, 3186000, 12, 'dokumen/kk/bUOyZFkzw7inAZxpL6JndionhLyXdmzaP54rOdxn.png', 'dokumen/ktp/ecAwDbsOrslMGASs124Mb6Lp3ojKa9nbkDNIXSBf.png', 'dokumen/npwp/eVISumSlKlOThF9q9EucYO2znv6ikQ6ON8G5lHA1.png', 'dokumen/slip_gaji/GhHayhQ7JWTe4y51TllSEqeaVZoaUgu5USB4JdXS.png', 'dokumen/foto/8yaLE9rAfak4hXTZfWUUjFUAtK2OUlDd1QIYom8h.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kredit` bigint UNSIGNED NOT NULL,
  `no_resi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_pengiriman` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pengiriman` date DEFAULT NULL,
  `tgl_estimasi_sampai` date DEFAULT NULL,
  `tgl_sampai` date DEFAULT NULL,
  `status` enum('Diproses','Dikirim','Selesai','Batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id`, `id_kredit`, `no_resi`, `kurir`, `alamat_pengiriman`, `tgl_pengiriman`, `tgl_estimasi_sampai`, `tgl_sampai`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 9, 'KRM-9-20260426', 'JNE', 'Alamat belum diisi', '2026-04-27', NULL, NULL, 'Dikirim', NULL, '2026-04-26 09:41:02', '2026-04-26 23:42:07'),
(2, 10, 'KRM-10-20260426', 'Akan ditentukan', 'Alamat belum diisi', NULL, NULL, NULL, 'Diproses', NULL, '2026-04-26 09:41:02', '2026-04-26 09:41:02'),
(3, 11, 'KRM-11-20260426', 'Akan ditentukan', 'Alamat belum diisi', NULL, NULL, NULL, 'Diproses', NULL, '2026-04-26 09:41:02', '2026-04-26 09:41:02'),
(4, 12, 'KRM-12-20260427-364', 'J&T', 'Bj. Gede Jl. Curug mas', '2026-04-27', '2026-04-30', NULL, 'Dikirim', 'Pengiriman dibuat otomatis setelah DP lunas', '2026-04-26 21:25:52', '2026-04-26 23:41:47'),
(5, 13, 'KRM-13-20260428-104', 'J&T', 'Jl.curug mas', '2026-04-30', '2026-05-01', NULL, 'Dikirim', 'P P APh', '2026-04-28 00:08:34', '2026-04-30 05:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8Pxos8Kg5dpxOU5H2V53aGxOujzOhHdI0xjM0OvV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJmOGFZUlhDdGQ5V1A3aWdaZ0J6blBwU21tQlllWXdRWURMNDV3a01yIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=', 1777552447),
('J8aiLvAfPpEQUeIa8Za78LD02vmkcxt8Ih8KJLL0', NULL, '127.0.0.1', 'Veritrans', 'eyJfdG9rZW4iOiI0S0FvQXJzNklEQklNaGVNR25lYmN2ZTZmTlJpWGlHZU1qMnNRdlZuIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777548425),
('wOXM2yHTd1W7Te9QcxHsfkr2su6up34742bXVd7E', NULL, '127.0.0.1', 'Veritrans', 'eyJfdG9rZW4iOiJMVFF3NVd5bjhSRkhEbnNXWWh4czByczRoeDB6NWVoNXZQbHRmOWpwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777547465);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','marketing','ceo','client') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-04-05 02:24:17', '$2y$12$BI8sRPvBo8hJorQL1Z5pkeuJV3YlvapZFSOsStKisVTQ8trIUWjY6', 'client', 'y9DgFALjzO', '2026-04-05 02:24:17', '2026-04-05 02:24:17'),
(7, 'el', 'admin@gmail.com', NULL, '$2y$12$t027lIjKQIsyiFyIRmy4QOjJFv5hzyoBeuCGU8HXTbJM0wAe8PRuu', 'admin', NULL, '2026-04-10 16:19:59', '2026-04-10 16:19:59'),
(9, 'el razqa', 'el098765@gmail.com', NULL, '$2y$12$QCfKfitKCidzv6DCliTHuuKUmJ94pXF86VveJ8uBH4fCVn47mrw3G', 'client', 'AoNn43LRODb4AKNjvvEbSnFsx4j5zdAeSCb856Jb1jG4XHclB0kg5hZYSNNL', '2026-04-17 05:15:15', '2026-04-17 05:15:15'),
(10, 'marketing', 'marketing@gmail.com', NULL, '$2y$12$pVNmTV3KxVZP9F52Xsqzn.98TQynFWVuStqVZfe1IgZcMnS.68.WK', 'marketing', NULL, '2026-04-27 23:33:19', '2026-04-27 23:33:19'),
(11, 'ceo laguna', 'ceo@gmail.com', NULL, '$2y$12$NE2uS95aBP7s5Arz34n8ueYmRGlg7MiHcq2HGwQi5YuLkU0Yoirc.', 'ceo', NULL, '2026-04-29 18:44:01', '2026-04-29 18:44:01'),
(12, 'Rehan', 'rehanc@gmail.com', NULL, '$2y$12$9yHZyCk4qxVmz825S2vgnOaVRLtX6UgEcDWpQnRZWjDBsjlPvTMFy', 'client', NULL, '2026-04-30 04:34:26', '2026-04-30 04:34:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kredit` (`id_kredit`);

--
-- Indexes for table `asuransi`
--
ALTER TABLE `asuransi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_cicilan`
--
ALTER TABLE `jenis_cicilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_motor`
--
ALTER TABLE `jenis_motor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kredit`
--
ALTER TABLE `kredit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengajuan_kredit` (`id_pengajuan_kredit`),
  ADD KEY `id_metode_bayar` (`id_metode_bayar`);

--
-- Indexes for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motor`
--
ALTER TABLE `motor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_motor_jenis` (`jenis_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggans_user_id_foreign` (`user_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_id_kredit_status_bayar_index` (`id_kredit`,`status_bayar`),
  ADD KEY `pembayaran_id_kredit_angsuran_ke_index` (`id_kredit`,`angsuran_ke`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_id_kredit_foreign` (`id_kredit`);

--
-- Indexes for table `pengajuan_kredit`
--
ALTER TABLE `pengajuan_kredit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_motor` (`id_motor`),
  ADD KEY `id_asuransi` (`id_asuransi`),
  ADD KEY `pengajuan_kredit_ibfk_3` (`id_jenis_cicilan`),
  ADD KEY `pengajuan_kredit_id_metode_bayar_foreign` (`id_metode_bayar`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengiriman_id_kredit_foreign` (`id_kredit`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `asuransi`
--
ALTER TABLE `asuransi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_cicilan`
--
ALTER TABLE `jenis_cicilan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_motor`
--
ALTER TABLE `jenis_motor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kredit`
--
ALTER TABLE `kredit`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `motor`
--
ALTER TABLE `motor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengajuan_kredit`
--
ALTER TABLE `pengajuan_kredit`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD CONSTRAINT `angsuran_ibfk_1` FOREIGN KEY (`id_kredit`) REFERENCES `kredit` (`id`);

--
-- Constraints for table `kredit`
--
ALTER TABLE `kredit`
  ADD CONSTRAINT `kredit_ibfk_1` FOREIGN KEY (`id_pengajuan_kredit`) REFERENCES `pengajuan_kredit` (`id`),
  ADD CONSTRAINT `kredit_ibfk_2` FOREIGN KEY (`id_metode_bayar`) REFERENCES `metode_bayar` (`id`);

--
-- Constraints for table `motor`
--
ALTER TABLE `motor`
  ADD CONSTRAINT `fk_motor_jenis` FOREIGN KEY (`jenis_id`) REFERENCES `jenis_motor` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD CONSTRAINT `pelanggans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_id_kredit_foreign` FOREIGN KEY (`id_kredit`) REFERENCES `kredit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_id_kredit_foreign` FOREIGN KEY (`id_kredit`) REFERENCES `kredit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_kredit`
--
ALTER TABLE `pengajuan_kredit`
  ADD CONSTRAINT `pengajuan_kredit_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggans` (`id`),
  ADD CONSTRAINT `pengajuan_kredit_ibfk_2` FOREIGN KEY (`id_motor`) REFERENCES `motor` (`id`),
  ADD CONSTRAINT `pengajuan_kredit_id_metode_bayar_foreign` FOREIGN KEY (`id_metode_bayar`) REFERENCES `metode_bayar` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_kredit_foreign` FOREIGN KEY (`id_kredit`) REFERENCES `kredit` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
