-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2026 at 09:46 AM
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
-- Database: `app_presensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id_bidang` bigint(20) UNSIGNED NOT NULL,
  `kode_bidang` varchar(20) NOT NULL,
  `id_skpd` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_bidang` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id_bidang`, `kode_bidang`, `id_skpd`, `nama_bidang`, `created_at`, `updated_at`, `created_id`, `updated_id`, `deleted_id`, `deleted_at`) VALUES
(1, 'admin1123', 1, 'Admin', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, 5, NULL, NULL),
(2, '1', 1, 'Sekretariat', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(3, 'ITIK', 1, 'Infrastruktur Teknologi Informasi dan Komunikasi', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(4, 'EGOV', 1, 'Layanan E-Government', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(5, 'PIKB', 1, 'Pengelolaan Informasi dan Komunikasi Publik', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(6, 'PIKP', 1, 'Persandian Informasi dan Komunikasi Publik', '2026-01-27 02:50:30', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(7, '6', 1, 'Statistik Sektoral', '2026-01-27 02:50:38', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(8, 'TTL', 2, 'Tata Lingkungan', '2026-01-27 03:34:27', '2026-01-27 03:34:27', 9, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_01_04_071833_create_bidang_table', 1),
(4, '2026_01_04_072343_create_users_table', 1),
(5, '2026_01_04_073509_qr_table', 1),
(6, '2026_01_05_072036_create_presensi_table', 1),
(7, '2026_01_06_023900_create_personal_access_tokens_table', 1),
(8, '2026_01_15_101827_tambah_soft_deletes', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 6, 'auth_token', '647ea60ffb64d4874a3d1175f02a76f20e8468dd6cb928f1d22e71106efeddfb', '[\"*\"]', NULL, NULL, '2026-01-11 13:51:17', '2026-01-11 13:51:17'),
(2, 'App\\Models\\User', 6, 'auth_token', '163e78f1d20672a9eeef4e933a9522e36e94be53b1fe6de130dde205a253dd8c', '[\"*\"]', NULL, NULL, '2026-01-11 13:51:26', '2026-01-11 13:51:26'),
(3, 'App\\Models\\User', 6, 'auth_token', '80f466aa8c1dc7544b4479cdeedf63e4f47b494bc8ad9ee2860a2ea8e8d46c3f', '[\"*\"]', NULL, NULL, '2026-01-11 13:51:58', '2026-01-11 13:51:58'),
(4, 'App\\Models\\User', 6, 'auth_token', 'd005c8ccf14dabbe4da021b06964791b179e4be9372ac952421bbdaf44feb9c4', '[\"*\"]', NULL, NULL, '2026-01-11 13:52:14', '2026-01-11 13:52:14'),
(5, 'App\\Models\\User', 6, 'auth_token', '4b301d837248061505debe73e0eeea12e816903dac351ba6b9a3650fcb22842a', '[\"*\"]', NULL, NULL, '2026-01-11 13:52:23', '2026-01-11 13:52:23'),
(6, 'App\\Models\\User', 5, 'auth_token', '18dae769fd3a87af286429f3df148fd28a78f0d5b12c22fe7e27ebd63f5ffdf0', '[\"*\"]', NULL, NULL, '2026-01-11 13:52:51', '2026-01-11 13:52:51'),
(7, 'App\\Models\\User', 6, 'auth_token', '14a884ceda6177eb1eaaca235266cfd09c97d5dccb42c8952b74e08f10860b14', '[\"*\"]', NULL, NULL, '2026-01-11 13:53:08', '2026-01-11 13:53:08'),
(8, 'App\\Models\\User', 6, 'auth_token', '252a8837efe5089ca8acb08f46a6d11473f212c475ec62a11f5dd09118ce47b4', '[\"*\"]', NULL, NULL, '2026-01-11 13:53:42', '2026-01-11 13:53:42'),
(9, 'App\\Models\\User', 6, 'auth_token', '05c4a9d709eb115491b72b79d24d3a9421c70e15a87370289e5bf003ea1c6fce', '[\"*\"]', NULL, NULL, '2026-01-11 13:53:49', '2026-01-11 13:53:49'),
(10, 'App\\Models\\User', 6, 'auth_token', '3ec00e119f1390e0de8ea325db480f4f9e122f283c90ff9fd48419756cdfe072', '[\"*\"]', NULL, NULL, '2026-01-11 13:54:27', '2026-01-11 13:54:27'),
(11, 'App\\Models\\User', 7, 'auth_token', '989095a59d7f5ab86e848b10c890d2b54045c3e807a9a1dfa210bdabb44b4230', '[\"*\"]', NULL, NULL, '2026-01-11 13:58:01', '2026-01-11 13:58:01'),
(12, 'App\\Models\\User', 6, 'auth_token', '9cc5f9f252124525e9dfacee3274929f1edb0a8f15ba16eb8d5c26fc49f01383', '[\"*\"]', NULL, NULL, '2026-01-13 07:08:45', '2026-01-13 07:08:45'),
(13, 'App\\Models\\User', 9, 'auth_token', 'a031cf0f1372a6d9470af46e3d56c6db0d363484576bbb17a689576fd3973430', '[\"*\"]', '2026-01-19 02:35:21', NULL, '2026-01-15 03:27:10', '2026-01-19 02:35:21'),
(14, 'App\\Models\\User', 6, 'auth_token', 'b56d32a9e237bb0383501d07885471253fca26d7b7c843f75a0d513adccdcf63', '[\"*\"]', NULL, NULL, '2026-01-15 03:47:48', '2026-01-15 03:47:48'),
(15, 'App\\Models\\User', 9, 'auth_token', 'a4f665e62ca5571799d3c67c85948cb62b5d5d0f73562843c0e2ef8b77d51104', '[\"*\"]', '2026-01-22 06:28:00', NULL, '2026-01-19 03:00:15', '2026-01-22 06:28:00'),
(16, 'App\\Models\\User', 9, 'auth_token', '662bae7d712f7ee8fe79d0693f94079c35a446f1583197270649808e83859d57', '[\"*\"]', '2026-01-22 06:29:12', NULL, '2026-01-22 06:29:09', '2026-01-22 06:29:12'),
(17, 'App\\Models\\User', 9, 'auth_token', 'bc360f8e7ed5245355a4fb4fa5668f1d10366124888cf1b6fe671c89bb05a3f3', '[\"*\"]', '2026-01-23 03:47:01', NULL, '2026-01-22 06:38:38', '2026-01-23 03:47:01'),
(18, 'App\\Models\\User', 12, 'auth_token', 'd63e3886bb5c026b13be0923abb433aaebf91413a797cff111ec50e9cdf34edc', '[\"*\"]', '2026-01-27 08:13:37', NULL, '2026-01-27 08:09:53', '2026-01-27 08:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_QR` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status` enum('Hadir','Izin','Tidak Hadir') NOT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `Latitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `Id_QR`, `user_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `status`, `Longitude`, `Latitude`, `created_at`, `updated_at`, `created_id`, `updated_id`, `deleted_id`, `deleted_at`) VALUES
(28, 7, 9, '2026-01-15', '14:24:34', NULL, 'Hadir', 108.53916260, -6.72619480, '2026-01-19 07:53:38', '2026-01-19 07:53:38', 9, 5, 5, '2026-01-19 07:53:38'),
(31, 9, 6, '2026-01-20', '07:25:00', NULL, 'Hadir', NULL, NULL, '2026-01-20 02:59:27', '2026-01-20 04:08:11', 5, 5, NULL, NULL),
(35, 11, 9, '2026-01-22', '13:40:12', NULL, 'Hadir', 108.53906320, -6.72614180, '2026-01-22 06:40:12', '2026-01-22 06:40:12', 9, NULL, NULL, NULL),
(36, 11, 9, '2026-01-22', '13:40:23', NULL, 'Hadir', 108.53906360, -6.72614020, '2026-01-22 06:40:23', '2026-01-22 06:40:23', 9, NULL, NULL, NULL),
(37, 12, 9, '2026-01-23', '10:42:22', NULL, 'Hadir', 108.53913150, -6.72631800, '2026-01-23 03:42:22', '2026-01-23 03:42:22', 9, NULL, NULL, NULL),
(38, 12, 9, '2026-01-23', '10:46:24', NULL, 'Izin', NULL, NULL, '2026-01-23 03:46:24', '2026-01-26 02:56:26', 9, 5, NULL, NULL),
(39, 14, 12, '2026-01-27', '15:13:35', NULL, 'Izin', 108.53914980, -6.72623190, '2026-01-27 08:13:35', '2026-01-27 08:13:35', 12, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qr`
--

CREATE TABLE `qr` (
  `Id_QR` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `Tanggal` date NOT NULL,
  `Created_at` timestamp NULL DEFAULT NULL,
  `Expired_at` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr`
--

INSERT INTO `qr` (`Id_QR`, `token`, `Tanggal`, `Created_at`, `Expired_at`, `created_id`, `updated_id`, `deleted_id`, `deleted_at`) VALUES
(7, 'ShJ0rVW57qU8z9tVJOltywrRPl4tISkZ', '2026-01-15', '2026-01-15 07:14:11', '2026-01-15 19:14:11', 5, NULL, NULL, NULL),
(8, 'gE1BJYGp0XAFyTWiwoObv2qsrNtp9qON', '2026-01-19', '2026-01-19 02:22:51', '2026-01-19 14:22:51', 5, NULL, NULL, NULL),
(9, 'MSlPjUqyeN1c8rwqzupMT4iWWDvagKYq', '2026-01-20', '2026-01-20 02:18:34', '2026-01-20 14:18:34', 5, NULL, NULL, NULL),
(10, 'ZOyrwacV7qsDhNEXjkYXzbXPH227IH3Q', '2026-01-21', '2026-01-21 07:58:22', '2026-01-21 19:58:22', 5, NULL, NULL, NULL),
(11, 'gkfrl1dYebnIf35RDfijEtJF0JJZQDpS', '2026-01-22', '2026-01-22 02:02:01', '2026-01-22 14:02:01', 5, NULL, NULL, NULL),
(12, '3ons5vvDE5xEVkt2WZvd8SkeCVhcxj2Z', '2026-01-23', '2026-01-23 03:40:08', '2026-01-23 15:40:08', 5, NULL, NULL, NULL),
(13, '5ohfBfdGbGGUO7UPH1YIkyxQBgCdGJxw', '2026-01-26', '2026-01-26 02:39:49', '2026-01-26 14:39:49', 5, NULL, NULL, NULL),
(14, 'CbTe3mEcxSsdMciasLhNflcxPCLI8n6m', '2026-01-27', '2026-01-27 07:01:15', '2026-01-27 19:01:15', 12, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skpd`
--

CREATE TABLE `skpd` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(60) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skpd`
--

INSERT INTO `skpd` (`id`, `nama`, `kode`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`) VALUES
(1, 'Dinas Komunikasi, Informatika, dan Statistik', 'DKIS', '2026-01-27 10:32:26', NULL, NULL, 9, NULL, NULL),
(2, 'Dinas Lingkungan Hidup', 'DLH', '2026-01-27 04:30:15', NULL, NULL, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `Nama_Pengguna` varchar(100) NOT NULL,
  `NIP` varchar(100) NOT NULL,
  `id_bidang` bigint(20) UNSIGNED NOT NULL,
  `Jabatan` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `Nama_Pengguna`, `NIP`, `id_bidang`, `Jabatan`, `created_at`, `updated_at`, `created_id`, `updated_id`, `deleted_id`, `deleted_at`) VALUES
(5, 'admin@gmail.com', '$2y$12$x3WKJwz7OiIiD/6ITYT2dO/zFRqjR/PJib5a1xmMIYRdrZdzt4tTS', 'Admin', '123', 1, 'admin', '2026-01-09 08:06:09', '2026-01-09 08:06:09', NULL, NULL, NULL, NULL),
(6, 'tes@gmail.com', '$2y$12$9cr7bPIYz6IaO/V/pJL8pOYfiYFaX3H2m.wwpl0gG34.ZT5qfMmaO', 'tes', '324234', 3, 'user', '2026-01-10 14:25:54', '2026-01-10 14:28:52', NULL, NULL, NULL, NULL),
(7, 'basuki@gmail.com', '$2y$12$/FPgAQA7CqUG1WntRzzKL.qxRdZKg8KdiR6.Yq9pcoxCqFOb6IpxC', 'Basuki Susanto', '123123123213', 7, 'user', '2026-01-11 13:56:35', '2026-01-15 04:06:03', NULL, NULL, NULL, '2026-01-15 04:06:03'),
(8, 'bambang@gmail.com', '$2y$12$huYyqXwElycDbwWWdUDYY.QOC0FcDQWvlZ7lPcDlPCLD2E58w.y8e', 'Bambang Susanto', '345345654', 7, 'user', '2026-01-11 14:03:39', '2026-01-15 04:10:45', NULL, 5, 5, '2026-01-15 04:10:45'),
(9, 'cuba@gmail.com', '$2y$12$elujhgcub5S75EaZ4Pc4k.JCt6KDREv4K75hSF9LRxT2fyU26sqMi', 'Cuba CUba', '123903213', 4, 'user', '2026-01-15 03:22:32', '2026-01-15 03:22:32', 5, NULL, NULL, NULL),
(10, 'bang@gmail.com', '$2a$12$UwN8ejU9Z7VFPYa9Ke2OkuKqk6i6U/uwiSJqM8KPZn8AdWiO.elPe', 'bangbang', '123983218', 8, 'Admin', '2026-01-27 03:36:13', NULL, 9, NULL, NULL, NULL),
(12, 'gembong@gmail.com', '$2y$12$zT7/ikskOMY8nuWAua8XTeLYml67HYqyS4MqIQawHVtYTHmef6eBS', 'gembong', '1223000000999', 8, 'admin', '2026-01-27 06:56:32', '2026-01-27 06:56:32', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id_bidang`),
  ADD UNIQUE KEY `bidang_kode_bidang_unique` (`kode_bidang`),
  ADD KEY `id_skpd` (`id_skpd`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presensi_id_qr_foreign` (`Id_QR`),
  ADD KEY `presensi_user_id_foreign` (`user_id`);

--
-- Indexes for table `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`Id_QR`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `skpd`
--
ALTER TABLE `skpd`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_bidang_foreign` (`id_bidang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id_bidang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `qr`
--
ALTER TABLE `qr`
  MODIFY `Id_QR` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `skpd`
--
ALTER TABLE `skpd`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidang`
--
ALTER TABLE `bidang`
  ADD CONSTRAINT `fk_bidang_skpd_v2` FOREIGN KEY (`id_skpd`) REFERENCES `skpd` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_id_qr_foreign` FOREIGN KEY (`Id_QR`) REFERENCES `qr` (`Id_QR`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
