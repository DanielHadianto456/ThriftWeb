-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 04:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekawanthrift3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('3XG4dJDYgNTmQoqD', 's:7:\"forever\";', 2045007122),
('80titCeTpPFDt2g5', 's:7:\"forever\";', 2045008864),
('AgOl3I7ubrmdPrq5', 's:7:\"forever\";', 2045008296),
('J11GEhfooNM3yEM7', 's:7:\"forever\";', 2044920214),
('KaAf2Ai1uavdFzjE', 's:7:\"forever\";', 2044849387),
('lfzFARikmuI7RPd4', 's:7:\"forever\";', 2045008857),
('pKafiymqQeZ6wPlM', 's:7:\"forever\";', 2045008451),
('TkpbWaldRNXCcalB', 's:7:\"forever\";', 2044850079),
('UgJCXjfix7oeHXmq', 's:7:\"forever\";', 2045007092),
('x1N2IRV6U1PyGJll', 's:7:\"forever\";', 2045008877);

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
-- Table structure for table `kategori_pakaian`
--

CREATE TABLE `kategori_pakaian` (
  `kategori_pakaian_id` int(11) NOT NULL,
  `kategori_pakaian_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pakaian`
--

INSERT INTO `kategori_pakaian` (`kategori_pakaian_id`, `kategori_pakaian_nama`) VALUES
(2, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `metode_pembayaran_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `metode_pembayaran_jenis` enum('OVO','DANA','BCA','COD') NOT NULL,
  `metode_pembayaran_nomor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`metode_pembayaran_id`, `user_id`, `metode_pembayaran_jenis`, `metode_pembayaran_nomor`) VALUES
(4, 9, 'OVO', '1234-5678-9012-3456'),
(6, 9, 'OVO', '1234-5678-9012-3456'),
(7, 9, 'OVO', '1234-5678-9012-3456'),
(8, 9, 'OVO', '1234-5678-9012-3456'),
(12, 9, 'OVO', '1234-5678-9012-3456'),
(13, 9, 'OVO', '1234-5678-9012-3456'),
(14, 9, 'OVO', '1234-5678-9012-3456'),
(15, 9, 'OVO', '1234-5678-9012-3456'),
(16, 9, 'OVO', '1234-5678-9012-3456'),
(17, 9, 'OVO', '1234-5678-9012-3456'),
(22, 9, 'OVO', '1234-5678-9012-3456'),
(23, 9, 'OVO', '1234-5678-9012-3456'),
(25, 9, 'OVO', '1234-5678-9012-3456'),
(26, 9, 'OVO', '1234-5678-9012-3456'),
(27, 9, 'OVO', '1234-5678-9012-3456'),
(28, 9, 'OVO', '1234-5678-9012-3456'),
(29, 9, 'OVO', '1234-5678-9012-3456'),
(30, 9, 'OVO', '1234-5678-9012-3456'),
(31, 9, 'OVO', '1234-5678-9012-3456'),
(32, 9, 'OVO', '1234-5678-9012-3456'),
(33, 9, 'OVO', '1234-5678-9012-3456'),
(34, 9, 'OVO', '1234-5678-9012-3456'),
(35, 9, 'OVO', '1234-5678-9012-3456'),
(36, 9, 'OVO', '1234-5678-9012-3456'),
(37, 9, 'OVO', '1234-5678-9012-3456');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_21_041910_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pakaian`
--

CREATE TABLE `pakaian` (
  `pakaian_id` int(11) NOT NULL,
  `kategori_pakaian_id` int(11) NOT NULL,
  `pakaian_nama` varchar(50) NOT NULL,
  `pakaian_harga` varchar(50) NOT NULL,
  `pakaian_stok` varchar(100) NOT NULL,
  `pakaian_gambar_url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pakaian`
--

INSERT INTO `pakaian` (`pakaian_id`, `kategori_pakaian_id`, `pakaian_nama`, `pakaian_harga`, `pakaian_stok`, `pakaian_gambar_url`) VALUES
(1, 2, 'Yipeee', '3500000', '9858', 'boxer.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelian_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `metode_pembayaran_id` int(11) NOT NULL,
  `pembelian_tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pembelian_total_harga` int(11) NOT NULL,
  `status` enum('LUNAS','BELUM_LUNAS') NOT NULL DEFAULT 'BELUM_LUNAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`pembelian_id`, `user_id`, `metode_pembayaran_id`, `pembelian_tanggal`, `pembelian_total_harga`, `status`) VALUES
(1, 9, 26, '2024-10-23 01:07:37', 0, 'LUNAS'),
(2, 9, 26, '2024-10-23 01:07:37', 14000000, 'LUNAS'),
(3, 9, 27, '2024-10-23 01:07:37', 0, 'LUNAS'),
(4, 9, 27, '2024-10-23 01:07:37', 14000000, 'LUNAS'),
(6, 9, 29, '2024-10-23 01:07:37', 14000000, 'LUNAS'),
(7, 9, 30, '2024-10-23 01:08:19', 14000000, 'LUNAS'),
(8, 9, 31, '2024-10-23 01:08:19', 14000000, 'LUNAS'),
(13, 9, 36, '2024-10-23 01:14:43', 14000000, 'LUNAS'),
(14, 9, 37, '2024-10-23 02:00:25', 42000000, 'BELUM_LUNAS');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `pembelian_detail_id` int(11) NOT NULL,
  `pembelian_id` int(11) NOT NULL,
  `pakaian_id` int(11) NOT NULL,
  `pembelian_detail_jumlah` int(11) NOT NULL,
  `pembelian_detail_total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`pembelian_detail_id`, `pembelian_id`, `pakaian_id`, `pembelian_detail_jumlah`, `pembelian_detail_total_harga`) VALUES
(1, 2, 1, 4, 14000000),
(2, 4, 1, 4, 14000000),
(7, 6, 1, 4, 14000000),
(8, 7, 1, 4, 14000000),
(9, 8, 1, 4, 14000000),
(14, 13, 1, 4, 14000000),
(15, 14, 1, 4, 14000000),
(16, 14, 1, 2, 7000000),
(17, 14, 1, 2, 7000000),
(18, 14, 1, 2, 7000000),
(19, 14, 1, 2, 7000000);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_nohp` char(13) NOT NULL,
  `user_alamat` varchar(200) NOT NULL,
  `user_profil_url` varchar(255) NOT NULL DEFAULT 'url_placeholder_profil',
  `user_level` enum('ADMIN','PENGGUNA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_fullname`, `user_email`, `user_nohp`, `user_alamat`, `user_profil_url`, `user_level`) VALUES
(7, 'demouser2', '$2y$12$GzoSNbeyBKSR9NhlImAwiedGK32fkpGq3.Z8VVH97sAMbOVXTOxR6', 'demouser2', 'demouser2@gmail.com', '22222222', 'demouser2', 'demouser2.jpg', 'PENGGUNA'),
(8, 'demoadmin1', '$2y$12$F4cyuFc8CgDI6jsAjs4z5OgQaQ2DI7FouNoDEgBta35UGpx567jxe', 'demoadmin1', 'demoadmin1@gmail.com', '333333333', 'demoadmin1', 'demoadmin1.jpg', 'ADMIN'),
(9, 'demouser1', '$2y$12$9MD5uHpcFetE92Ycnr/0cONbiCUruQSszYP7FrdiqUj3/wu5NX4zW', 'demouser1', 'demouser1@gmail.com', '999999999', 'demouser1', 'demouser1.jpg', 'PENGGUNA'),
(10, 'demouser3', '$2y$12$IzqymljKxIDPaHxxdgQOnOm1Ao5co1Hb3j4gbaaYbbPNCjeWb4k6y', 'demouser3', 'demouser3@gmail.com', '999999999', 'demouser3', 'demouser3.jpg', 'PENGGUNA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `kategori_pakaian`
--
ALTER TABLE `kategori_pakaian`
  ADD PRIMARY KEY (`kategori_pakaian_id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`metode_pembayaran_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD PRIMARY KEY (`pakaian_id`),
  ADD KEY `kategori_pakaian_id` (`kategori_pakaian_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelian_id`),
  ADD KEY `user_id` (`user_id`,`metode_pembayaran_id`),
  ADD KEY `metode_pembayaran_id` (`metode_pembayaran_id`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`pembelian_detail_id`),
  ADD KEY `pembelian_id` (`pembelian_id`,`pakaian_id`),
  ADD KEY `pakaian_id` (`pakaian_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

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
-- AUTO_INCREMENT for table `kategori_pakaian`
--
ALTER TABLE `kategori_pakaian`
  MODIFY `kategori_pakaian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `metode_pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pakaian`
--
ALTER TABLE `pakaian`
  MODIFY `pakaian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pembelian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `pembelian_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD CONSTRAINT `metode_pembayaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD CONSTRAINT `pakaian_ibfk_1` FOREIGN KEY (`kategori_pakaian_id`) REFERENCES `kategori_pakaian` (`kategori_pakaian_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`metode_pembayaran_id`) REFERENCES `metode_pembayaran` (`metode_pembayaran_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD CONSTRAINT `pembelian_detail_ibfk_1` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`pembelian_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_detail_ibfk_2` FOREIGN KEY (`pakaian_id`) REFERENCES `pakaian` (`pakaian_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
