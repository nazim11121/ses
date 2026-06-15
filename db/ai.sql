-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 15, 2026 at 06:35 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Silk', 'silk', 'Rich silk sarees for weddings and celebrations.', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(2, 'Georgette', 'georgette', 'Lightweight georgette sarees with elegant designs.', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(3, 'Chiffon', 'chiffon', 'Soft chiffon sarees that drape gracefully.', '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nusrat Jahan', 'nusrat@example.com', 'Saree material inquiry', 'Hi, can you tell me if the Banarasi silk saree is pure silk and if there is a matching blouse available?', 'New', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(2, 'Imran Hossain', 'imran@example.com', 'Shipping to Dhaka', 'I need this saree delivered to Gulshan by tomorrow. Do you offer same-day or next-day delivery?', 'Read', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(3, 'Rumana Sultana', 'rumana@example.com', 'Order cancellation', 'Please cancel my recent order if it has not been shipped yet, and refund the amount to my bKash account.', 'New', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(4, 'Arman Khan', 'arman@example.com', 'Gift wrapping', 'Can I request gift wrapping for the Kanjivaram saree if I place the order today?', 'New', '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `designation`, `message`, `image`, `active`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Ayesha Karim', 'Fashion Blogger', 'The saree quality exceeded my expectations and the delivery was prompt. I loved the rich texture and color.', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80', 1, 1, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(2, 'Sadia Islam', 'Wedding Guest', 'Beautiful saree and great customer service. The piece arrived in perfect condition and looked stunning.', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80', 1, 2, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(3, 'Farzana Akter', 'Boutique Shopper', 'I keep coming back for the latest saree designs. The fabric and prints are excellent for special occasions.', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80', 1, 3, '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(38, '2014_10_12_000000_create_users_table', 1),
(39, '2014_10_12_100000_create_password_resets_table', 1),
(40, '2019_08_19_000000_create_failed_jobs_table', 1),
(41, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(42, '2026_06_15_000001_create_sliders_table', 1),
(43, '2026_06_15_151328_create_products_table', 1),
(44, '2026_06_15_155359_create_categories_table', 1),
(45, '2026_06_15_155558_create_orders_table', 1),
(46, '2026_06_15_155718_create_order_items_table', 1),
(47, '2026_06_15_155722_create_contact_messages_table', 1),
(48, '2026_06_16_000001_add_section_to_products_table', 1),
(49, '2026_06_16_000002_create_pages_table', 1),
(50, '2026_06_16_000003_create_feedback_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `payment_method`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mina Rahman', 'mina.rahman@example.com', '+8801712345678', 'House 23, Road 12, Dhanmondi, Dhaka 1209', 'Cash on Delivery', 9597.00, 'Delivered', '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(2, 'Arif Hossain', 'arif.hossain@example.com', '+8801812345678', 'Flat 5B, House 14, Banani, Dhaka 1213', 'bKash', 11198.00, 'Pending', '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_product_id_index` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 4399.00, 4399.00, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(2, 1, 2, 2, 2599.00, 5198.00, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(3, 2, 3, 1, 7899.00, 7899.00, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(4, 2, 4, 1, 3299.00, 3299.00, '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar_text` text COLLATE utf8mb4_unicode_ci,
  `feature_one_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_one_text` text COLLATE utf8mb4_unicode_ci,
  `feature_two_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_two_text` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `sidebar_title`, `sidebar_text`, `feature_one_title`, `feature_one_text`, `feature_two_title`, `feature_two_text`, `created_at`, `updated_at`) VALUES
(1, 'about', 'About Our Saree Boutique', 'We are a Bangladesh-based saree boutique dedicated to handpicked fabrics, timeless designs, and customer-first service. Our collection blends traditional craftsmanship with modern styling so every celebration feels special.', 'Why Choose Us', 'Shop with confidence from a curated range of silk, georgette and chiffon sarees backed by fast delivery and secure payment.', 'Authentic Craftsmanship', 'Each saree is selected for its quality, details, and beautiful finish, perfect for weddings, festivals, and everyday elegance.', 'Trusted Local Support', 'Our customer care team is ready to help with styling, sizing and delivery updates across Bangladesh.', '2026-06-15 12:23:17', '2026-06-15 12:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_index` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `image`, `stock`, `active`, `section`, `created_at`, `updated_at`) VALUES
(1, 1, 'Banarasi Silk Saree', 'banarasi-silk-saree', 'A luxurious Banarasi saree with rich zari work and an elegant border for weddings and festivals.', 4399.00, 'https://cdn.kaykraft.com/wp-content/uploads/2025/05/SARI-HSL-JW-802-A-600x900.jpg?auto=format&fit=crop&w=800&q=80', 24, 1, 'top_rated', '2026-06-15 12:23:17', '2026-06-15 12:27:09'),
(2, 2, 'Georgette Party Wear Saree', 'georgette-party-wear-saree', 'A lightweight georgette saree with sequins and a modern blouse design for evening parties.', 2599.00, 'https://cdn.kaykraft.com/wp-content/uploads/2026/02/SARI-HSL-MT-823-600x900.jpg?auto=format&fit=crop&w=800&q=80', 18, 1, 'new_arrival', '2026-06-15 12:23:17', '2026-06-15 12:26:00'),
(3, 1, 'Kanjivaram Silk Saree', 'kanjivaram-silk-saree', 'Traditional Kanjivaram saree with contrasting border and classic temple motifs for elegant celebrations.', 7899.00, 'https://cdn.kaykraft.com/wp-content/uploads/2026/01/SARI-HSL-MT-843-600x900.jpg?auto=format&fit=crop&w=800&q=80', 12, 1, 'new_arrival', '2026-06-15 12:23:17', '2026-06-15 12:25:25'),
(4, 3, 'Chiffon Designer Saree', 'chiffon-designer-saree', 'A flowing chiffon saree with intricate embroidery and pastel shades for a graceful look.', 3299.00, 'https://cdn.kaykraft.com/wp-content/uploads/2026/02/SARI-HSL-NK-842-600x900.jpg?auto=format&fit=crop&w=800&q=80', 30, 1, 'featured', '2026-06-15 12:23:17', '2026-06-15 12:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `button_text`, `button_link`, `image`, `position`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Elegant Bangladeshi Sarees', 'Discover premium handwoven designs for every celebration.', 'Shop Now', 'http://127.0.0.1:8000/shop', 'https://tskbd.com/wp-content/uploads/2018/10/slide1.jpg?auto=format&fit=crop&w=1300&q=80', 1, 1, '2026-06-15 12:23:17', '2026-06-15 12:34:27'),
(2, 'Luxury Silk Collection', 'Rich textures and vibrant colors, curated just for you.', 'Browse Collection', '/shop', 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1300&q=80', 2, 1, '2026-06-15 12:23:17', '2026-06-15 12:23:17'),
(3, 'Modern Designer Sarees', 'Style your wardrobe with comfortable, statement-making drapes.', 'View More', 'http://127.0.0.1:8000/shop', 'https://cdn.kaykraft.com/wp-content/uploads/2026/02/DSC_8074.jpg?auto=format&fit=crop&w=1300&q=80', 3, 1, '2026-06-15 12:23:17', '2026-06-15 12:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$10$gi8pAXaMcxyIt3EFUL48W.Cq7bILsI6RyzFqCYECr6H9znamLbT6a', NULL, '2026-06-15 12:23:17', '2026-06-15 12:23:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
