-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 24, 2025 at 08:20 PM
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
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:12:\"display_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:26:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"add_products\";s:1:\"c\";s:12:\"Add Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"edit_products\";s:1:\"c\";s:13:\"Edit Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"delete_products\";s:1:\"c\";s:15:\"Delete Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"show_users\";s:1:\"c\";s:10:\"Show Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"edit_users\";s:1:\"c\";s:10:\"Edit Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:5;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"delete_users\";s:1:\"c\";s:12:\"Delete Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:6;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"admin_users\";s:1:\"c\";s:11:\"Admin Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"view_products\";s:1:\"c\";s:13:\"View Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:8;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"purchase_products\";s:1:\"c\";s:17:\"Purchase Products\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"manage_inventory\";s:1:\"c\";s:16:\"Manage Inventory\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:10;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"manage_promotions\";s:1:\"c\";s:17:\"Manage Promotions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:11;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:10:\"view_sales\";s:1:\"c\";s:10:\"View Sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:12;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:22:\"manage_customer_credit\";s:1:\"c\";s:22:\"Manage Customer Credit\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:13;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"view_customers\";s:1:\"c\";s:14:\"View Customers\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:14;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"manage_refunds\";s:1:\"c\";s:14:\"Manage Refunds\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:15;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:7:\"AddRole\";s:1:\"c\";s:7:\"AddRole\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:7:\"add_fav\";s:1:\"c\";s:7:\"add_fav\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:17;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:22:\"view_financial_reports\";s:1:\"c\";s:22:\"View Financial Reports\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:18;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:15:\"manage_expenses\";s:1:\"c\";s:15:\"Manage Expenses\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:19;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"view_expenses\";s:1:\"c\";s:13:\"View Expenses\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:20;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"manage_sales\";s:1:\"c\";s:12:\"Manage Sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:21;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:13:\"manage_profit\";s:1:\"c\";s:13:\"Manage Profit\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:22;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:11:\"view_profit\";s:1:\"c\";s:11:\"View Profit\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:23;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:29:\"manage_financial_transactions\";s:1:\"c\";s:29:\"Manage Financial Transactions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:27:\"view_financial_transactions\";s:1:\"c\";s:27:\"View Financial Transactions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:25;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"request_refund\";s:1:\"c\";s:14:\"Request Refund\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"Supplier\";s:1:\"d\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"Employee\";s:1:\"d\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Manager\";s:1:\"d\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"Customer\";s:1:\"d\";s:3:\"web\";}}}', 1748194218);

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
-- Stand-in structure for view `daily_financial_summary`
-- (See below for the actual view)
--
CREATE TABLE `daily_financial_summary` (
`date` date
,`total_sales` decimal(10,2)
,`total_expenses` decimal(10,2)
,`net_profit` decimal(10,2)
,`number_of_sales` bigint(21)
,`number_of_expenses` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `date`, `category`, `description`, `amount`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-05-21', 'Salary', 'Paid the salary for Seif', 2500.00, 'Cash', 'paid', '2025-05-23 22:40:13', '2025-05-23 22:40:13');

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
-- Table structure for table `financial_transactions`
--

CREATE TABLE `financial_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2025_03_10_185119_create_permission_tables', 2),
(5, '2025_05_21_201154_create_oauth_auth_codes_table', 3),
(6, '2025_05_21_201155_create_oauth_access_tokens_table', 3),
(7, '2025_05_21_201156_create_oauth_refresh_tokens_table', 3),
(8, '2025_05_21_201157_create_oauth_clients_table', 3),
(9, '2025_05_21_201158_create_oauth_personal_access_clients_table', 3);

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
(5, 'App\\Models\\User', 25),
(7, 'App\\Models\\User', 25),
(8, 'App\\Models\\User', 25),
(9, 'App\\Models\\User', 16),
(9, 'App\\Models\\User', 25),
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
(3, 'App\\Models\\User', 30),
(4, 'App\\Models\\User', 27),
(4, 'App\\Models\\User', 29),
(5, 'App\\Models\\User', 26),
(5, 'App\\Models\\User', 28);

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthly_financial_summary`
-- (See below for the actual view)
--
CREATE TABLE `monthly_financial_summary` (
`month` varchar(7)
,`total_sales` decimal(32,2)
,`total_expenses` decimal(32,2)
,`net_profit` decimal(32,2)
,`number_of_sales` bigint(21)
,`number_of_expenses` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('9efd877a-b836-4227-98e8-ce714970c8c5', NULL, 'Laravel', '$2y$12$AktMNc7hwTR04YmxUyzI2.RsP/NRAjbTumRRuF4xhVgQBNVdPxUbO', 'users', '', 1, 0, 0, '2025-05-24 17:09:29', '2025-05-24 17:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `client_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(32) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 'ORD-68312EF62BB0E', 9000.00, 'completed', '2025-05-23 23:29:10', '2025-05-23 23:29:10'),
(2, 23, 'ORD-68313052A4AB1', 17000.00, 'completed', '2025-05-23 23:34:58', '2025-05-23 23:34:58'),
(3, 23, 'ORD-683130B9479DD', 40000.00, 'completed', '2025-05-23 23:36:41', '2025-05-23 23:36:41'),
(4, 23, 'ORD-6831318E44C7E', 1000.00, 'refunded', '2025-05-23 23:40:14', '2025-05-23 23:45:17'),
(5, 23, 'ORD-68313194BFDB3', 8000.00, 'refunded', '2025-05-23 23:40:20', '2025-05-23 23:44:32'),
(6, 23, 'ORD-683133896F3A6', 8000.00, 'refunded', '2025-05-23 23:48:41', '2025-05-23 23:49:18'),
(7, 23, 'ORD-68313413E5674', 8000.00, 'refunded', '2025-05-23 23:50:59', '2025-05-23 23:52:25'),
(8, 23, 'ORD-68313630BBFFA', 1000.00, 'completed', '2025-05-24 00:00:00', '2025-05-24 00:00:00'),
(9, 23, 'ORD-6831381C8ABF4', 1000.00, 'refunded', '2025-05-24 00:08:12', '2025-05-24 00:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 23, 1, 1000.00, 1000.00, '2025-05-23 23:29:10', '2025-05-23 23:29:10'),
(2, 1, 24, 1, 8000.00, 8000.00, '2025-05-23 23:29:10', '2025-05-23 23:29:10'),
(3, 2, 23, 1, 1000.00, 1000.00, '2025-05-23 23:34:58', '2025-05-23 23:34:58'),
(4, 2, 24, 2, 8000.00, 16000.00, '2025-05-23 23:34:58', '2025-05-23 23:34:58'),
(5, 3, 24, 5, 8000.00, 40000.00, '2025-05-23 23:36:41', '2025-05-23 23:36:41'),
(6, 4, 23, 1, 1000.00, 1000.00, '2025-05-23 23:40:14', '2025-05-23 23:40:14'),
(7, 5, 24, 1, 8000.00, 8000.00, '2025-05-23 23:40:20', '2025-05-23 23:40:20'),
(8, 6, 24, 1, 8000.00, 8000.00, '2025-05-23 23:48:41', '2025-05-23 23:48:41'),
(9, 7, 24, 1, 8000.00, 8000.00, '2025-05-23 23:50:59', '2025-05-23 23:50:59'),
(10, 8, 23, 1, 1000.00, 1000.00, '2025-05-24 00:00:00', '2025-05-24 00:00:00'),
(11, 9, 23, 1, 1000.00, 1000.00, '2025-05-24 00:08:12', '2025-05-24 00:08:12');

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
(16, 'manage_refunds', 'Manage Refunds', 'web', NULL, NULL),
(21, 'AddRole', 'AddRole', 'web', NULL, NULL),
(22, 'add_fav', 'add_fav', 'web', NULL, NULL),
(32, 'view_financial_reports', 'View Financial Reports', 'web', NULL, NULL),
(33, 'manage_expenses', 'Manage Expenses', 'web', NULL, NULL),
(34, 'view_expenses', 'View Expenses', 'web', NULL, NULL),
(35, 'manage_sales', 'Manage Sales', 'web', NULL, NULL),
(36, 'manage_profit', 'Manage Profit', 'web', NULL, NULL),
(37, 'view_profit', 'View Profit', 'web', NULL, NULL),
(38, 'manage_financial_transactions', 'Manage Financial Transactions', 'web', NULL, NULL),
(39, 'view_financial_transactions', 'View Financial Transactions', 'web', NULL, NULL),
(40, 'request_refund', 'Request Refund', 'web', '2025-05-24 02:57:55', '2025-05-24 02:57:55');

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
(23, '002', 'mohamed', 1000.00, 96, '20001', 'hh', '2 (1).jpeg', '2025-05-11 16:26:21', '2025-05-23 22:22:35', NULL, 1, 0),
(24, 'jpg-258', 'Jean Paul Gaultier de Bleu', 8000.00, 91, 'Jean Paul Gaultier', 'The original men\'s fragrance by Gaultier. In a secret Garden of Eden, Gaultier opens the gates and Le Beau makes a striking appearance. The tone is set by his sculptural body, adorned only with a golden vine leaf. Beneath this couture detail, we discover a natural man who loves seduction and freedom in the simplest form. How can we not be captivated? His hypnotic personality, his exotically sensual Eau de Toilette. Nothing is more fresh and powerful than Le Beau.', 'JpgDeBlu.jpg', '2025-05-18 16:58:44', '2025-05-23 22:22:28', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `total_sales` decimal(10,2) NOT NULL,
  `total_expenses` decimal(10,2) NOT NULL,
  `net_profit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profit`
--

INSERT INTO `profit` (`id`, `date`, `total_sales`, `total_expenses`, `net_profit`, `created_at`, `updated_at`) VALUES
(1, '2025-05-24', 67000.00, 0.00, 67000.00, '2025-05-24 01:21:20', '2025-05-24 00:08:52'),
(4, '2025-05-21', 0.00, 2500.00, -2500.00, '2025-05-23 22:43:43', '2025-05-23 23:17:01');

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
(8, 25, 23, 1, 1000.00, '2025-05-20 11:06:53', '2025-05-20 11:06:53', NULL),
(9, 23, 23, 1, 1000.00, '2025-05-23 22:21:20', '2025-05-23 22:21:20', NULL),
(10, 23, 24, 2, 16000.00, '2025-05-23 22:21:20', '2025-05-23 22:21:20', NULL),
(11, 23, 24, 1, 8000.00, '2025-05-23 22:23:45', '2025-05-23 22:23:45', NULL),
(12, 23, 23, 1, 1000.00, '2025-05-23 23:10:38', '2025-05-23 23:10:38', NULL);

--
-- Triggers `purchases`
--
DELIMITER $$
CREATE TRIGGER `after_sale_insert` AFTER INSERT ON `purchases` FOR EACH ROW BEGIN
    -- Update sales table
    INSERT INTO sales (date, total_amount, total_products, payment_method, created_at, updated_at)
    VALUES (CURDATE(), NEW.total_price, NEW.quantity, 'credit', NOW(), NOW())
    ON DUPLICATE KEY UPDATE 
        total_amount = total_amount + NEW.total_price,
        total_products = total_products + NEW.quantity,
        updated_at = NOW();
    
    -- Update profit table
    INSERT INTO profit (date, total_sales, total_expenses, net_profit, created_at, updated_at)
    SELECT 
        CURDATE(),
        COALESCE(SUM(total_amount), 0),
        COALESCE((SELECT SUM(amount) FROM expenses WHERE date = CURDATE()), 0),
        COALESCE(SUM(total_amount), 0) - COALESCE((SELECT SUM(amount) FROM expenses WHERE date = CURDATE()), 0),
        NOW(),
        NOW()
    FROM sales
    WHERE date = CURDATE()
    ON DUPLICATE KEY UPDATE 
        total_sales = VALUES(total_sales),
        total_expenses = VALUES(total_expenses),
        net_profit = VALUES(net_profit),
        updated_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refund_requests`
--

INSERT INTO `refund_requests` (`id`, `order_id`, `user_id`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 23, 'I no longer need this product', 'pending', '2025-05-24 00:04:59', '2025-05-24 00:04:59'),
(2, 9, 23, 'hate it', 'completed', '2025-05-24 00:08:27', '2025-05-24 00:08:52');

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
(1, 5),
(2, 1),
(2, 5),
(3, 1),
(3, 5),
(4, 1),
(4, 2),
(4, 4),
(5, 1),
(5, 2),
(5, 4),
(7, 1),
(7, 2),
(7, 4),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(10, 1),
(10, 3),
(11, 1),
(11, 5),
(12, 1),
(12, 4),
(13, 1),
(13, 4),
(14, 1),
(14, 2),
(14, 4),
(15, 1),
(15, 2),
(15, 4),
(16, 1),
(16, 2),
(16, 4),
(21, 1),
(22, 3),
(32, 1),
(32, 4),
(33, 1),
(33, 4),
(34, 1),
(34, 4),
(35, 1),
(35, 4),
(36, 1),
(36, 4),
(37, 1),
(37, 4),
(38, 1),
(39, 1),
(39, 4),
(40, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_products` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `order_id`, `date`, `total_amount`, `total_products`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(5, NULL, '2025-05-24', 66000.00, 10, 'credit', 'completed', '2025-05-23 23:34:58', '2025-05-23 23:36:41'),
(6, 4, '2025-05-24', 1000.00, 1, 'credit', 'refunded', '2025-05-23 23:40:14', '2025-05-23 23:45:17'),
(7, 5, '2025-05-24', 8000.00, 1, 'credit', 'refunded', '2025-05-23 23:40:20', '2025-05-23 23:44:32'),
(8, 6, '2025-05-24', 8000.00, 1, 'credit', 'refunded', '2025-05-23 23:48:41', '2025-05-23 23:49:18'),
(9, 7, '2025-05-24', 8000.00, 1, 'credit', 'refunded', '2025-05-23 23:50:59', '2025-05-23 23:52:25'),
(10, 8, '2025-05-24', 1000.00, 1, 'credit', 'completed', '2025-05-24 00:00:00', '2025-05-24 00:00:00'),
(11, 9, '2025-05-24', 1000.00, 1, 'credit', 'refunded', '2025-05-24 00:08:12', '2025-05-24 00:08:52');

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
('2IqjGzpCNDmTehURVJ4Y3FzNbw8aAqKAZlVf5wLb', 23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVRGZ0JaeWxaY2M3RzcxaFdjRnZtbk1tQmlxM3NHRmZXTkRGM3YyQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8va2VybmVscGFuaWMubG9jYWxob3N0LmNvbSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIzO30=', 1748117110),
('IJL7qZrlF7DALyYCvJqAuWBqCTlefg1CPRUHY1YV', 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVldRcUF4ODhvVFFaWHlFSUlBWlVGNjByWWc3RVJQYVJVU1dzV25QdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8va2VybmVscGFuaWMubG9jYWxob3N0LmNvbSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMwO30=', 1748106467),
('RvmCqBFZw8sXksMBttr3CjPddSsvCEJKuPKslMV0', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTF4aGlQTzQxZEtUNGhYMXFzdVp6aUtEVEo1NDcyNDZ0OXkzSWZiYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8va2VybmVscGFuaWMubG9jYWxob3N0LmNvbS9kYXNoYm9hcmQvZGF0YSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI1O30=', 1748106182),
('SaTBBoH57wSH5eUNQTRocDbqGzGRgppUwy9uGwST', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibVVSakU2MTIzdWhLdTg1cTBmU3FIRklYbDBDQTdoemw4T2NTZDF0WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8va2VybmVscGFuaWMubG9jYWxob3N0LmNvbS9sb2dpbiI7fXM6NToic3RhdGUiO3M6NDA6IkdHRmtSWmpTWTN5RVVuRFJ3SEN0N295bHB6YVRFeUI2SVVERzdtVGgiO30=', 1748107198);

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
  `data_sharing` tinyint(1) NOT NULL DEFAULT 0,
  `google_id` text DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `google_refresh_token` text DEFAULT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `github_token` text DEFAULT NULL,
  `github_refresh_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `credit`, `created_at`, `updated_at`, `deleted_at`, `email_offers`, `order_updates`, `currency`, `language`, `theme`, `data_sharing`, `google_id`, `google_token`, `google_refresh_token`, `github_id`, `github_token`, `github_refresh_token`) VALUES
(16, 'Ahmed Ali Said', 'malisobh2010@gmail.com', '2025-05-11 16:09:04', '$2y$12$M/Yzb7zC7rYhZ9tkKBGL1.NZ8PnR./kPtAwLlh.aflbSUwziZxtHS', NULL, 111111.00, '2025-03-11 05:32:37', '2025-03-18 01:54:30', NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'mohamed askar', 'huss44@gmail.com', '2025-05-11 16:09:04', '$2y$12$M/Yzb7zC7rYhZ9tkKBGL1.NZ8PnR./kPtAwLlh.aflbSUwziZxtHS', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'yassin', 'yassin.shaher2005@gmail.com', '2025-05-18 16:24:50', '$2y$12$ChO03f.WxQk1OhH9hLrENOGgPOGSyWlIbJOm1HGQysx9Mr6IZuq7O', NULL, 100000.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'yassin2', 'yassinchinco@gmail.com', '2025-05-18 16:52:12', '$2y$12$1ILE8oUIkgU02aPZEmcR8eAs8NBKPS7Ub/h/JEhEzdy9YiFQkirfO', NULL, 959000.00, NULL, NULL, NULL, 0, 1, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Seif Waheed', 'seifwaheed559@gmail.com', '2025-05-24 14:41:14', '$2y$12$QNR0Isi7cPetqIDqE0mU8e5JCWmLemdOlEyPKN1h8XAIf0Ben/A2O', NULL, 975000.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, '104232143773565460081', 'ya29.a0AW4XtxgCeUBMEg_7YqtG3nORF5aom7p1blbvvGA6C2rAVbHF0kBBVP05IkfwjJNeApCXWvPLzWGpdosLdICmGV8RvqT7BgS2FQAWF9uwXA_Ah6NvLmJjC9MOFdmG-XZzNVojz5Lx9VUQZo0w_TtEh0sW50vEWBL0DsF9K2P4aCgYKAXoSARcSFQHGX2MiD9yTU_0EiGkFk12eUYn9Ag0175', NULL, '135646856', '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', NULL),
(26, 'ahmed essam', 'essam@gmail.com', NULL, '$2y$12$zUKKA3x1hAWYC6q8TSQSKeFZRj3vQdWf1EubQ4j9BCetrIVX8NxpK', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '3assm', 'essm@gmail.com', NULL, '$2y$12$ZKxMawoG6/h5ArYVEJF9BOrMmhUXyL8hN1CB.nb0AoN4sbdTRhF9a', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'mohamed askar', 'f@gmail.com', '2025-05-23 19:50:58', '$2y$12$s..5dcKvc3ymb30.k19gpuZWiCQ7MHWpw2Xl1NkV9cMfPcIxs6KVe', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'manager', 'manager@gmail.com', '2025-05-22 21:00:00', '$2y$12$vKe5zQq52COQAkmvLF1vY.3PI9kd/lquM0inLjrNLwuOZsDwTBQI2', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Zayd Waheed', 'zaydwaheed123123@gmail.com', NULL, '$2y$12$/jVuZzBnasm0d5sgZ.tFUewp9JLg/TpmWerGCPykjLSa.w/48qluO', NULL, 0.00, NULL, NULL, NULL, 0, 0, 'USD', 'en', 'dark', 0, '105431708031989360413', 'ya29.a0AW4XtxheuLXK6nngT_fUjn3wRhf0V9FWzFt4ZZ6jlW3TfK6An51PXMozBpcSYz4ep4tpEdkd0bnzgZj9elS0XjB5V6rFSw9jRybWE2OmcpYNO8Ut5ykUpJgYD0uzWSwQPLwllCAT9x_jMtZtRmAIQ_y9eWZfvnDe1niGqUQaaCgYKAVcSARQSFQHGX2Mi-gcVGcDwFdolMQYYlC1Egg0175', NULL, NULL, NULL, NULL);

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
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_date_index` (`date`),
  ADD KEY `expenses_category_index` (`category`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_transactions_date_index` (`date`),
  ADD KEY `financial_transactions_type_index` (`type`),
  ADD KEY `financial_transactions_reference_index` (`reference_id`,`reference_type`);

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
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profit_date_unique` (`date`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_date_index` (`date`),
  ADD KEY `sales_order_id_foreign` (`order_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_transactions`
--
ALTER TABLE `financial_transactions`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `profit`
--
ALTER TABLE `profit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

-- --------------------------------------------------------

--
-- Structure for view `daily_financial_summary`
--
DROP TABLE IF EXISTS `daily_financial_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daily_financial_summary`  AS SELECT `p`.`date` AS `date`, `p`.`total_sales` AS `total_sales`, `p`.`total_expenses` AS `total_expenses`, `p`.`net_profit` AS `net_profit`, count(distinct `s`.`id`) AS `number_of_sales`, count(distinct `e`.`id`) AS `number_of_expenses` FROM ((`profit` `p` left join `sales` `s` on(`s`.`date` = `p`.`date`)) left join `expenses` `e` on(`e`.`date` = `p`.`date`)) GROUP BY `p`.`date` ;

-- --------------------------------------------------------

--
-- Structure for view `monthly_financial_summary`
--
DROP TABLE IF EXISTS `monthly_financial_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `monthly_financial_summary`  AS SELECT date_format(`p`.`date`,'%Y-%m') AS `month`, sum(`p`.`total_sales`) AS `total_sales`, sum(`p`.`total_expenses`) AS `total_expenses`, sum(`p`.`net_profit`) AS `net_profit`, count(distinct `s`.`id`) AS `number_of_sales`, count(distinct `e`.`id`) AS `number_of_expenses` FROM ((`profit` `p` left join `sales` `s` on(`s`.`date` = `p`.`date`)) left join `expenses` `e` on(`e`.`date` = `p`.`date`)) GROUP BY date_format(`p`.`date`,'%Y-%m') ;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD CONSTRAINT `refund_requests_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refund_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
