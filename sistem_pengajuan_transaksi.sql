-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 02:48 PM
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
-- Database: `sistem_pengajuan_transaksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Approved','Rejected') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id`, `submission_id`, `user_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'Rejected', NULL, '2026-07-10 11:25:00', '2026-07-10 11:25:00'),
(2, 3, 3, 'Rejected', '[Sistem Otomatis] Di-reject karena sisa budget kategori tidak mencukupi.', '2026-07-11 00:02:41', '2026-07-11 00:02:41'),
(3, 1, 5, 'Approved', 'ok acc', '2026-07-11 00:13:34', '2026-07-11 00:13:34'),
(4, 12, 3, 'Approved', 'okayy acc', '2026-07-11 06:34:21', '2026-07-11 06:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fiscal_year` varchar(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `category_id`, `amount`, `fiscal_year`, `created_at`, `updated_at`) VALUES
(2, 1, 20000000.00, '2026', '2026-07-11 04:55:02', '2026-07-11 04:55:02'),
(3, 2, 25000000.00, '2026', '2026-07-11 04:55:25', '2026-07-11 04:55:25'),
(4, 3, 30000000.00, '2026', '2026-07-11 04:57:24', '2026-07-11 04:57:24');

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
('laravel-cache-ruli@test|127.0.0.1', 'i:2;', 1783772955),
('laravel-cache-ruli@test|127.0.0.1:timer', 'i:1783772955;', 1783772955);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PO Produk', '2026-07-09 21:33:13', '2026-07-09 21:33:13'),
(2, 'Operasional', '2026-07-09 21:33:13', '2026-07-09 21:33:13'),
(3, 'ATK', '2026-07-09 21:33:13', '2026-07-09 21:33:13'),
(4, 'Lain-lain', '2026-07-09 21:33:13', '2026-07-09 21:33:13');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_08_033348_create_categories_table', 1),
(5, '2026_07_08_033349_create_submissions_table', 1);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `submission_id`, `user_id`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2026-07-11', '2026-07-11 01:03:26', '2026-07-11 01:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(2, 'staff', '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(3, 'spv', '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(4, 'manager', '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(5, 'direktur', '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(6, 'finance', '2026-07-09 21:33:11', '2026-07-09 21:33:11');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BdHfJv159Q0vLYj4pplEdVXb1HJi6NUNw4ZHMSD1', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicjJEWWJ4SWV0QmVraWlWd2E0ZmlOcmdMZGdMNnVTSHJ5clVUN1JOZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGFmZi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6InN0YWZmLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783786539),
('hJLMpl08rNVVQoFn1H0SpoG9ohDO2bkH6OEBGEpm', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmhBQzNkak9nMjVKd0lSNEQzUTBaeWtCYnpqTEJ5ODRmZVBUYUI2bSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcHYvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjEzOiJzcHYuZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1783786541);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_number` varchar(50) NOT NULL,
  `submission_date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Submitted','Waiting SPV Approval','Waiting Manager Approval','Waiting Director Approval','Waiting Finance','Paid','Rejected') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `submission_number`, `submission_date`, `user_id`, `category_id`, `amount`, `description`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'REQ-20260710-0001', '2026-07-10', 2, 1, 12000000.00, 'travel', 'attachments/8D4ZjZ9uLpdi5djNLcgTIwPj9qMPQ821W9i6vEWF.pdf', 'Paid', '2026-07-10 10:30:54', '2026-07-11 01:03:26'),
(2, 'REQ-20260710-0002', '2026-07-10', 2, 2, 11000000.00, 'travel', 'attachments/HOkRpSdpWWujjgpBg28rcicsuUAKbOZehJwYS0pM.png', 'Rejected', '2026-07-10 11:24:40', '2026-07-10 11:25:00'),
(3, 'REQ-20260710-0003', '2026-07-10', 2, 3, 15000000.00, 'pengeluaran dana', 'attachments/q2wTWbDM4QZR3J2VurCKPDVU3OAAjlvoR6SdhnhZ.jpg', 'Rejected', '2026-07-10 11:26:19', '2026-07-11 00:02:41'),
(4, 'REQ-20260710-0004', '2026-07-10', 2, 1, 75000000.00, '75000000', 'attachments/TizOevaF0PmT2D3acg0g1huCtCtjDVtdRtXWBImI.pdf', 'Waiting Director Approval', '2026-07-10 11:27:13', '2026-07-10 11:27:13'),
(5, 'REQ-20260710-0005', '2026-07-10', 2, 4, 75000000.00, '75000000', 'attachments/9M42eHtYV8lpRCAoC4w4RuCZUVpSSMY7QbwrzUm5.pdf', 'Waiting SPV Approval', '2026-07-10 11:27:34', '2026-07-10 11:27:34'),
(6, 'REQ-20260710-0006', '2026-07-10', 2, 2, 75000000.00, '75000000', 'attachments/RB6xW2Y69xwdFoVDbyYLLY7iNyS1iM3yyLYAuKXZ.pdf', 'Waiting SPV Approval', '2026-07-10 11:27:56', '2026-07-10 11:27:56'),
(7, 'REQ-20260710-0007', '2026-07-10', 2, 2, 75000000.00, '75000000', 'attachments/ID3HsJF6PWhCefj4LQblaV2C5bMEaggjEjZAVEHp.png', 'Waiting SPV Approval', '2026-07-10 11:28:23', '2026-07-10 11:28:23'),
(8, 'REQ-20260710-0008', '2026-07-10', 2, 3, 75000000.00, 'operasional', 'attachments/W85bcwSd2DUJ4e0Nx4SnbMPijA760xLWvt6osLSt.pdf', 'Waiting SPV Approval', '2026-07-10 11:28:47', '2026-07-10 11:28:47'),
(9, 'REQ-20260710-0009', '2026-07-10', 2, 1, 75000000.00, 'Bahan travel', 'attachments/u6qD4RdO0uFa2lsnI6M08c3JHiOB94fkZzi89TSd.pdf', 'Waiting Director Approval', '2026-07-10 11:29:17', '2026-07-10 11:29:17'),
(10, 'REQ-20260710-0010', '2026-07-10', 2, 4, 75000000.00, 'Kebutuan supir', 'attachments/pkgEVtLYvIxwZwXppvavkveMSZ6e3UWhUefjmpk0.pdf', 'Waiting SPV Approval', '2026-07-10 11:29:44', '2026-07-10 11:29:44'),
(11, 'REQ-20260711-0001', '2026-07-11', 2, 1, 7000000.00, 'Sajadah', 'attachments/MkKMXOhvqtSKZEfHMytIwDpkxHGB2pNLSSz6WcY6.pdf', 'Waiting Director Approval', '2026-07-11 06:30:06', '2026-07-11 06:30:06'),
(12, 'REQ-20260711-0002', '2026-07-11', 2, 2, 6500000.00, 'operasional travel', 'attachments/SjIwy5sScx0m77mqiUTgm5Ik6DhhwwTAZTDnHpuy.pdf', 'Waiting Manager Approval', '2026-07-11 06:33:56', '2026-07-11 06:34:21'),
(13, 'REQ-20260711-0003', '2026-07-11', 2, 3, 4500000.00, 'Travel', 'attachments/fvgr8VmGtTizLY252rirBb4UjR4fvNU83NSiUZUQ.pdf', 'Submitted', '2026-07-11 08:34:47', '2026-07-11 08:34:47'),
(14, 'REQ-20260711-0004', '2026-07-11', 2, 3, 5500000.00, 'Travel', 'attachments/fbOPYGtVwGkJMSVi73G3F7VcB6BXUFAZGILBnC0w.pdf', 'Waiting SPV Approval', '2026-07-11 08:35:41', '2026-07-11 08:35:41');

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
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Utama', 'admin@test.com', NULL, '$2y$12$3Pifotf.A01fWba2i9V3M.P9Qq3e/5pYJRrTo5iMTEYkAZwP2/Lly', 1, NULL, '2026-07-09 21:33:11', '2026-07-09 21:33:11'),
(2, 'Akun Staff', 'staff@test.com', NULL, '$2y$12$ert0zazjSWPugjJ5eFKa6OowdDD1yZQ9OqzPh1G9EahirFQ3JuRQ6', 2, NULL, '2026-07-09 21:33:12', '2026-07-09 21:33:12'),
(3, 'Akun SPV', 'spv@test.com', NULL, '$2y$12$tjq2oRfEpQkWcfZfRkll/elfCtVbpSSsrhJ05p9wMJcgoV8ZX4Tse', 3, NULL, '2026-07-09 21:33:12', '2026-07-09 21:33:12'),
(4, 'Akun Manager', 'manager@test.com', NULL, '$2y$12$YwdloTkMOzPTsh3Yhml2N.bInkSiWVALv4dkKooHFDVwIEZt6Ciii', 4, NULL, '2026-07-09 21:33:12', '2026-07-09 21:33:12'),
(5, 'Akun Direktur', 'direktur@test.com', NULL, '$2y$12$lJxDlyM1qXLxYXYAZsn5neDqbHrsro7MF1d2c9xOSNi1hIgVDt0gS', 5, NULL, '2026-07-09 21:33:13', '2026-07-09 21:33:13'),
(6, 'Akun Finance', 'finance@test.com', NULL, '$2y$12$XvVEiUNeKEgntxpju7KuG.G3QbbtZc1BF2i7P2yvuHMjKthEEi.3.', 6, NULL, '2026-07-09 21:33:13', '2026-07-09 21:33:13'),
(7, 'Ruli M Kustiana', 'ruli@test.com', NULL, '$2y$12$k/eqE39ObWm.vgyJVx2iAOBJaX7OjL13Oj7F0ud1qXp.zQWzYXW5K', 4, NULL, '2026-07-10 10:10:42', '2026-07-10 10:10:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approvals_submission_id_foreign` (`submission_id`),
  ADD KEY `approvals_user_id_foreign` (`user_id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_category_id_foreign` (`category_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_submission_id_foreign` (`submission_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `submissions_submission_number_unique` (`submission_number`),
  ADD KEY `submissions_user_id_foreign` (`user_id`),
  ADD KEY `submissions_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
