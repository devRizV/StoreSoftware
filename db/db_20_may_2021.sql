-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2021 at 12:11 PM
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
(1, 5, 'N/A', 2, 135, 'kg', 270, 270, NULL, '2021-05-10', NULL, NULL, NULL, '2021-05-10 03:10:36', NULL),
(2, 4, 'N/A', 20, 100, 'kg', 2000, 2000, NULL, '2021-05-10', NULL, NULL, NULL, '2021-05-15 03:11:04', NULL);

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
DELIMITER $$
CREATE TRIGGER `after_product_delete` AFTER DELETE ON `prd_master` FOR EACH ROW BEGIN
    
    DELETE FROM prd_stock
    WHERE (prd_stock.prd_id = old.prd_id); 
    
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
(1, 'Apple', 'apple', 'kg', NULL, '2021-05-10 03:09:18', NULL),
(2, 'Mango', 'mango', 'kg', NULL, '2021-05-10 03:09:27', NULL),
(3, 'Grape', 'grape', 'kg', NULL, '2021-05-10 03:09:39', NULL),
(4, 'Orange', 'orange', 'kg', NULL, '2021-05-10 03:09:52', NULL),
(5, 'Malta', 'malta', 'kg', NULL, '2021-05-10 03:09:58', NULL);

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
(1, 5, 2, '2021-05-10 03:10:36', NULL, NULL, NULL, 0),
(2, 4, 20, '2021-05-10 03:11:04', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prd_usage`
--

CREATE TABLE `prd_usage` (
  `pk_no` int(11) NOT NULL,
  `prd_name_id` int(11) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `taken_by` varchar(255) DEFAULT NULL,
  `taken_date` timestamp NULL DEFAULT NULL,
  `prd_qty` int(11) DEFAULT NULL,
  `prd_unit` varchar(50) DEFAULT NULL,
  `prd_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Rony', 'ronymia111333@gmail.com', NULL, '$2y$10$q27QzC6kgZXjIpW284ir..t75nI99fsSfgmqzbDx1jp21cuZ5/JiS', 0, NULL, '2021-03-04 03:12:53', '2021-03-04 03:12:53'),
(2, 'Rony', 'kamrul@gmail.com', NULL, '$2y$10$Uq9wXKArTwii1fATMQxgKOhk1KbpG6NdA8ZqVlPSTVk8usEeEFV8q', 0, NULL, NULL, NULL),
(3, 'joy', 'joy@gmail.com', NULL, '$2y$10$MEYAQ6wkzyOWtfP/nW6hSOgnCWawaj.7BXa2sb2iLxUOzM6wSsp3u', 1, NULL, NULL, NULL);

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
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prd_name`
--
ALTER TABLE `prd_name`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prd_stock`
--
ALTER TABLE `prd_stock`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prd_usage`
--
ALTER TABLE `prd_usage`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
