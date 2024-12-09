-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2021 at 12:45 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storesoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `pk_no` int(11) NOT NULL,
  `dep_name` varchar(255) DEFAULT NULL,
  `dep_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`pk_no`, `dep_name`, `dep_remarks`, `created_at`, `updated_at`) VALUES
(6, 'Rony', 'afd', '2021-04-01 02:53:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prd_master`
--

CREATE TABLE `prd_master` (
  `pk_no` int(11) NOT NULL,
  `prd_id` int(11) DEFAULT NULL,
  `prd_brand` varchar(255) DEFAULT NULL,
  `prd_qty` int(11) DEFAULT NULL,
  `prd_qty_price` int(11) DEFAULT NULL,
  `prd_unit` varchar(255) DEFAULT NULL,
  `prd_price` float DEFAULT NULL,
  `prd_grand_price` float DEFAULT NULL,
  `prd_purchase_from` varchar(255) DEFAULT NULL,
  `prd_purchase_date` date DEFAULT NULL,
  `prd_req_dep` varchar(255) DEFAULT NULL,
  `prd_for_dep` varchar(255) DEFAULT NULL,
  `prd_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_master`
--

INSERT INTO `prd_master` (`pk_no`, `prd_id`, `prd_brand`, `prd_qty`, `prd_qty_price`, `prd_unit`, `prd_price`, `prd_grand_price`, `prd_purchase_from`, `prd_purchase_date`, `prd_req_dep`, `prd_for_dep`, `prd_details`, `created_at`, `updated_at`) VALUES
(1, 3, 'N/A', 10, 34, 'kg', 340, 175, 'Shopno', '2021-04-03', 'Kitchen', 'Kitchen', 'n/a', '2021-04-03 03:07:09', '2021-04-05 04:08:38');

--
-- Triggers `prd_master`
--
DELIMITER $$
CREATE TRIGGER `after_prd_insert` AFTER INSERT ON `prd_master` FOR EACH ROW BEGIN
IF NEW.prd_id not in (
            select A.prd_id
            From prd_stock A  
            where (NEW.prd_id = A.prd_id)
        ) THEN
        
         INSERT INTO prd_stock(prd_id, prd_qty,created_at,updated_at)
        VALUES(new.prd_id, new.prd_qty,new.created_at,new.updated_at);
        
       
ELSE
  UPDATE prd_stock SET prd_qty = new.prd_qty+prd_qty WHERE prd_id = new.prd_id;     


END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `prd_name`
--

CREATE TABLE `prd_name` (
  `pk_no` int(11) NOT NULL,
  `prd_name` varchar(255) DEFAULT NULL,
  `prd_slug` varchar(200) DEFAULT NULL,
  `prd_unit` varchar(200) DEFAULT NULL,
  `prd_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_name`
--

INSERT INTO `prd_name` (`pk_no`, `prd_name`, `prd_slug`, `prd_unit`, `prd_remarks`, `created_at`, `updated_at`) VALUES
(1, 'Onion', 'onion', 'kg', NULL, '2021-04-03 02:45:47', NULL),
(2, 'Potato', 'potato', 'kg', NULL, '2021-04-03 02:45:58', NULL),
(3, 'Normal Rice', 'normal-rice', 'kg', NULL, '2021-04-03 02:46:11', NULL),
(4, 'Oil', 'oil', 'Litre', NULL, '2021-04-03 02:50:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prd_stock`
--

CREATE TABLE `prd_stock` (
  `pk_no` int(11) NOT NULL,
  `prd_id` int(11) NOT NULL,
  `prd_qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_stock`
--

INSERT INTO `prd_stock` (`pk_no`, `prd_id`, `prd_qty`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 3, 3, '2021-04-03 03:07:09', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prd_usage`
--

CREATE TABLE `prd_usage` (
  `pk_no` int(11) NOT NULL,
  `prd_name_id` int(11) DEFAULT NULL,
  `prd_brand` varchar(255) DEFAULT NULL,
  `taken_by` varchar(255) DEFAULT NULL,
  `taken_date` timestamp NULL DEFAULT NULL,
  `prd_qty` int(11) DEFAULT NULL,
  `prd_unit` varchar(50) DEFAULT NULL,
  `prd_qty_price` int(11) DEFAULT NULL,
  `prd_price` float DEFAULT NULL,
  `prd_grand_price` float DEFAULT NULL,
  `prd_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_usage`
--

INSERT INTO `prd_usage` (`pk_no`, `prd_name_id`, `prd_brand`, `taken_by`, `taken_date`, `prd_qty`, `prd_unit`, `prd_qty_price`, `prd_price`, `prd_grand_price`, `prd_remarks`, `created_at`, `updated_at`) VALUES
(2, 3, 'N/A', 'Kamrul', '2021-04-09 18:00:00', 5, 'kg', 52, 260, 260, NULL, '2021-04-10 03:14:45', NULL),
(3, 3, 'N/A', 'Kamrul', '2021-04-09 18:00:00', 2, 'kg', 85, 170, 170, NULL, '2021-04-10 03:15:50', NULL);

--
-- Triggers `prd_usage`
--
DELIMITER $$
CREATE TRIGGER `after_product_insert` AFTER INSERT ON `prd_usage` FOR EACH ROW BEGIN
      
UPDATE prd_stock SET prd_qty = prd_qty-new.prd_qty WHERE prd_id = new.prd_name_id;     

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=admin,1=store,2=block',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@store.app', NULL, '$2y$10$q27QzC6kgZXjIpW284ir..t75nI99fsSfgmqzbDx1jp21cuZ5/JiS', 0, NULL, '2021-03-04 03:12:53', '2021-03-04 03:12:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`pk_no`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `prd_master`
--
ALTER TABLE `prd_master`
  ADD PRIMARY KEY (`pk_no`);

--
-- Indexes for table `prd_name`
--
ALTER TABLE `prd_name`
  ADD PRIMARY KEY (`pk_no`);

--
-- Indexes for table `prd_stock`
--
ALTER TABLE `prd_stock`
  ADD PRIMARY KEY (`pk_no`);

--
-- Indexes for table `prd_usage`
--
ALTER TABLE `prd_usage`
  ADD PRIMARY KEY (`pk_no`);

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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prd_master`
--
ALTER TABLE `prd_master`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prd_name`
--
ALTER TABLE `prd_name`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prd_stock`
--
ALTER TABLE `prd_stock`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prd_usage`
--
ALTER TABLE `prd_usage`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
