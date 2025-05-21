-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 03:06 PM
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
-- Database: `perfumestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `product_id`, `product_name`, `quantity`, `created_at`, `updated_at`) VALUES
(15, 25, 24, 'Jean Paul Gaultier de Bleu', 2, '2025-05-20 11:24:19', '2025-05-20 11:24:19');

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
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:12:\"display_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:15:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"add_products\";s:1:\"c\";s:12:\"Add Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"edit_products\";s:1:\"c\";s:13:\"Edit Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"delete_products\";s:1:\"c\";s:15:\"Delete Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"show_users\";s:1:\"c\";s:10:\"Show Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"edit_users\";s:1:\"c\";s:10:\"Edit Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:5;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"delete_users\";s:1:\"c\";s:12:\"Delete Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:6;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"admin_users\";s:1:\"c\";s:11:\"Admin Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:7;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"view_products\";s:1:\"c\";s:13:\"View Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:8;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"purchase_products\";s:1:\"c\";s:17:\"Purchase Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:9;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"manage_inventory\";s:1:\"c\";s:16:\"Manage Inventory\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:10;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"manage_promotions\";s:1:\"c\";s:17:\"Manage Promotions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:10:\"view_sales\";s:1:\"c\";s:10:\"View Sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:22:\"manage_customer_credit\";s:1:\"c\";s:22:\"Manage Customer Credit\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"view_customers\";s:1:\"c\";s:14:\"View Customers\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"manage_refunds\";s:1:\"c\";s:14:\"Manage Refunds\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"Employee\";s:1:\"d\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Manager\";s:1:\"d\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"Customer\";s:1:\"d\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"Supplier\";s:1:\"d\";s:3:\"web\";}}}', 1747837370);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_10_185119_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 16),
(1, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 25),
(5, 'App\\Models\\User', 23),
(5, 'App\\Models\\User', 25),
(7, 'App\\Models\\User', 25),
(8, 'App\\Models\\User', 25),
(9, 'App\\Models\\User', 16),
(9, 'App\\Models\\User', 23),
(9, 'App\\Models\\User', 25),
(10, 'App\\Models\\User', 23),
(10, 'App\\Models\\User', 25),
(11, 'App\\Models\\User', 25),
(11, 'App\\Models\\User', 26),
(12, 'App\\Models\\User', 25),
(13, 'App\\Models\\User', 25),
(14, 'App\\Models\\User', 25),
(15, 'App\\Models\\User', 16),
(15, 'App\\Models\\User', 25);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 20),
(1, 'App\\Models\\User', 21),
(1, 'App\\Models\\User', 24),
(1, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 27),
(5, 'App\\Models\\User', 26);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(128) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'add_products', 'Add Products', 'web', NULL, NULL),
(2, 'edit_products', 'Edit Products', 'web', NULL, NULL),
(3, 'delete_products', 'Delete Products', 'web', NULL, NULL),
(4, 'show_users', 'Show Users', 'web', NULL, NULL),
(5, 'edit_users', 'Edit Users', 'web', NULL, NULL),
(7, 'delete_users', 'Delete Users', 'web', NULL, NULL),
(8, 'admin_users', 'Admin Users', 'web', NULL, NULL),
(9, 'view_products', 'View Products', 'web', NULL, NULL),
(10, 'purchase_products', 'Purchase Products', 'web', NULL, NULL),
(11, 'manage_inventory', 'Manage Inventory', 'web', NULL, NULL),
(12, 'manage_promotions', 'Manage Promotions', 'web', NULL, NULL),
(13, 'view_sales', 'View Sales', 'web', NULL, NULL),
(14, 'manage_customer_credit', 'Manage Customer Credit', 'web', NULL, NULL),
(15, 'view_customers', 'View Customers', 'web', NULL, NULL),
(16, 'manage_refunds', 'Manage Refunds', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `name` varchar(256) NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `model` varchar(128) NOT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `favourite` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `price`, `stock`, `model`, `description`, `photo`, `created_at`, `updated_at`, `deleted_at`, `featured`, `favourite`) VALUES
(23, '002', 'mohamed', 1000.00, 1, '20001', 'hh', '2 (1).jpeg', '2025-05-11 16:26:21', '2025-05-19 14:50:56', NULL, 1, 0),
(24, 'jpg-258', 'Jean Paul Gaultier de Bleu', 8000.00, 2, 'Jean Paul Gaultier', 'The original men\'s fragrance by Gaultier. In a secret Garden of Eden, Gaultier opens the gates and Le Beau makes a striking appearance. The tone is set by his sculptural body, adorned only with a golden vine leaf. Beneath this couture detail, we discover a natural man who loves seduction and freedom in the simplest form. How can we not be captivated? His hypnotic personality, his exotically sensual Eau de Toilette. Nothing is more fresh and powerful than Le Beau.', 'JpgDeBlu.jpg', '2025-05-18 16:58:44', '2025-05-20 11:25:20', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 23, 23, 3, 3000.00, '2025-05-19 16:51:37', '2025-05-19 16:51:37', NULL),
(2, 23, 24, 2, 16000.00, '2025-05-19 16:51:37', '2025-05-19 16:51:37', NULL),
(3, 23, 23, 1, 1000.00, '2025-05-19 16:51:54', '2025-05-19 16:51:54', NULL),
(4, 23, 24, 1, 8000.00, '2025-05-19 16:51:54', '2025-05-19 16:51:54', NULL),
(5, 23, 23, 1, 1000.00, '2025-05-19 16:52:09', '2025-05-19 16:52:09', NULL),
(6, 23, 24, 1, 8000.00, '2025-05-19 16:52:09', '2025-05-19 16:52:09', NULL),
(7, 25, 24, 1, 8000.00, '2025-05-20 10:20:52', '2025-05-20 10:20:52', NULL),
(8, 25, 23, 1, 1000.00, '2025-05-20 11:06:53', '2025-05-20 11:06:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', NULL, NULL),
(2, 'Employee', 'web', NULL, NULL),
(3, 'Customer', 'web', NULL, NULL),
(4, 'Manager', 'web', NULL, NULL),
(5, 'Supplier', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(4, 1),
(4, 2),
(4, 4),
(5, 1),
(5, 4),
(7, 1),
(7, 4),
(8, 1),
(8, 4),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(10, 1),
(10, 3),
(10, 4),
(11, 1),
(11, 5),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 2),
(16, 1),
(16, 4);

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
('DdXEZdfuFuFBSA7Sx5wvr8ilTHQsOutBjGJVHglM', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiN3RvZjZFVGFpS3Z0RXJ5bzlpaEJ0RVVxZDVwTDFMbHpweEdkYjl6RCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToic3RhdGUiO3M6NDA6Im5KaENxM0hGQmZqNzdiRnI1bHl6RnVIT29yZmRUaGlEWlZBMjRRU0UiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI1O30=', 1747750323),
('HnE6rnt6MVXzPWo20ndmP7xpWYY0vJmmFlJHZ0RG', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXFoNEhlaHdiQkMyT2Ftc3ZYaDNFQUFBTEt6bFh4YkI1VzZ2WWtSTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2Vycy9jcmVhdGUiO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyNTt9', 1747753398);

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
  `credit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email_offers` tinyint(1) NOT NULL DEFAULT 0,
  `order_updates` tinyint(1) NOT NULL DEFAULT 0,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `theme` varchar(10) NOT NULL DEFAULT 'dark',
  `data_sharing` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `credit`, `created_at`, `updated_at`, `deleted_at`, `email_offers`, `order_updates`, `currency`, `language`, `theme`, `data_sharing`) VALUES
(16, 'Ahmed Ali Said', 'malisobh2010@gmail.com', '2025-05-11 16:09:04', '$2y$12$M/Yzb7zC7rYhZ9tkKBGL1.NZ8PnR./kPtAwLlh.aflbSUwziZxtHS', NULL, 111111.00, '2025-03-11 05:32:37', '2025-03-18 01:54:30', NULL, 0, 0, 'USD', 'en', 'dark', 0),
(20, 'mohamed askar', 'huss44@gmail.com', '2025-05-11 16:09:04', '$2y$12$M/Yzb7zC7rYhZ9tkKBGL1.NZ8PnR./kPtAwLlh.aflbSUwziZxtHS', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0),
(21, 'yassin', 'yassin.shaher2005@gmail.com', '2025-05-18 16:24:50', '$2y$12$ChO03f.WxQk1OhH9hLrENOGgPOGSyWlIbJOm1HGQysx9Mr6IZuq7O', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0),
(23, 'yassin2', 'yassinchinco@gmail.com', '2025-05-18 16:52:12', '$2y$12$1ILE8oUIkgU02aPZEmcR8eAs8NBKPS7Ub/h/JEhEzdy9YiFQkirfO', NULL, 52999.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0),
(25, 'Seif Waheed', 'seifwaheed559@gmail.com', '2025-05-19 13:26:33', '$2y$12$QNR0Isi7cPetqIDqE0mU8e5JCWmLemdOlEyPKN1h8XAIf0Ben/A2O', NULL, 975000.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0),
(26, 'ahmed essam', 'essam@gmail.com', NULL, '$2y$12$zUKKA3x1hAWYC6q8TSQSKeFZRj3vQdWf1EubQ4j9BCetrIVX8NxpK', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0),
(27, '3assm', 'essm@gmail.com', NULL, '$2y$12$ZKxMawoG6/h5ArYVEJF9BOrMmhUXyL8hN1CB.nb0AoN4sbdTRhF9a', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basket_user_id_foreign` (`user_id`),
  ADD KEY `basket_product_id_foreign` (`product_id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `basket_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
