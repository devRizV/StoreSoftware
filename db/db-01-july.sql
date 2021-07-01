-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2021 at 02:50 PM
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
(2, 'Xyz', NULL, '2021-06-21 00:55:08', NULL),
(3, 'abc', 'hello', '2021-06-21 00:55:18', NULL),
(4, 'Rony', 'sdf', '2021-06-21 00:56:54', NULL);

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
  `prd_name` varchar(255) DEFAULT NULL,
  `prd_brand` varchar(255) DEFAULT NULL,
  `prd_qty` float(10,2) DEFAULT NULL,
  `prd_qty_price` int(11) DEFAULT NULL,
  `prd_unit` varchar(255) DEFAULT NULL,
  `prd_price` float DEFAULT NULL,
  `prd_grand_price` float DEFAULT NULL,
  `prd_purchase_from` varchar(255) DEFAULT NULL,
  `prd_purchase_date` timestamp NULL DEFAULT NULL,
  `prd_req_dep` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `prd_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_master`
--

INSERT INTO `prd_master` (`pk_no`, `prd_id`, `prd_name`, `prd_brand`, `prd_qty`, `prd_qty_price`, `prd_unit`, `prd_price`, `prd_grand_price`, `prd_purchase_from`, `prd_purchase_date`, `prd_req_dep`, `supplier`, `prd_details`, `created_at`, `updated_at`) VALUES
(1, 70, 'Store requsitien book', NULL, 10.00, 20, 'pc', 200, 20, NULL, '2021-05-09 18:00:00', 'kitchen', NULL, NULL, '2021-06-05 02:36:32', NULL),
(2, 67, 'Daimond wraping paper', NULL, 30.00, 60, 'pc', 1800, 1800, NULL, '2021-05-19 18:00:00', 'Xyz', 'Rony', NULL, '2021-06-05 02:37:00', '2021-06-28 03:58:35'),
(4, 1, NULL, NULL, 10.00, 20, 'pc', 200, 20, NULL, '2021-05-09 18:00:00', 'kitchen', NULL, NULL, '2021-06-05 02:36:32', NULL),
(5, 71, NULL, NULL, 10.00, 20, 'pc', 200, 200, 'kitchen', '2021-06-09 18:00:00', 'kitchen', NULL, NULL, '2021-06-10 03:20:21', NULL),
(7, 71, NULL, NULL, 50.00, 50, 'pc', 2500, 2500, 'kitchen', '2021-06-11 18:00:00', 'kitchen', NULL, NULL, '2021-06-12 03:59:45', NULL),
(8, 70, NULL, NULL, 10.00, 5, 'pc', 50, 50, NULL, '2021-06-13 18:00:00', 'kitchen', 'kitchen', NULL, '2021-06-14 00:44:38', NULL),
(9, 71, NULL, NULL, 3.00, 50, 'pc', 150, 150, NULL, '2021-06-13 18:00:00', 'kitchen', NULL, NULL, '2021-06-14 00:44:52', NULL),
(10, 71, 'Convence', NULL, 10.00, 10, 'pc', 100, 100, NULL, '2021-06-14 18:00:00', 'abc', 'Rony', NULL, '2021-06-21 02:40:12', '2021-06-21 02:46:04'),
(12, 70, 'Green mazoni', NULL, 10.00, 50, 'pc', 500, 500, NULL, '2021-06-27 18:00:00', 'Xyz', 'Rony', NULL, '2021-06-28 03:28:54', NULL),
(13, 54, 'Cotton buds  pkt', NULL, 30.00, 20, 'pc', 600, 1000, NULL, '2021-06-29 18:00:00', 'abc', 'Rony', NULL, '2021-06-30 00:27:12', '2021-06-30 00:29:16');

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
DELIMITER $$
CREATE TRIGGER `before_prd_insert` BEFORE INSERT ON `prd_master` FOR EACH ROW BEGIN
SELECT `prd_name` into @prduct_name from `prd_name` WHERE pk_no = new.prd_id;
set new.prd_name = @prduct_name;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_prd_update` BEFORE UPDATE ON `prd_master` FOR EACH ROW BEGIN
SELECT `prd_name` into @prduct_name from `prd_name` WHERE pk_no = new.prd_id;
set new.prd_name = @prduct_name;


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
(1, 'Store requsitien book', 'store-requsitien-book', 'pc', NULL, '2021-05-31 11:53:00', NULL),
(2, 'Money receipt book', 'money-receipt-book', 'pc', NULL, '2021-05-31 11:56:25', NULL),
(3, 'Transport bill book', 'transport-bill-book', 'pc', NULL, '2021-05-31 11:57:40', NULL),
(4, 'payment voucher for guest', 'payment-voucher-for-guest', 'pc', NULL, '2021-05-31 12:00:03', NULL),
(5, 'M- bar  book', 'm--bar-book', 'pc', NULL, '2021-05-31 12:01:28', NULL),
(6, 'parchase requsition book', 'parchase-requsition-book', 'pc', NULL, '2021-05-31 12:02:45', NULL),
(7, 'Debit vouchar', 'debit-vouchar', 'pc', NULL, '2021-05-31 12:04:24', NULL),
(8, 'Credit vouchar', 'credit-vouchar', 'pc', NULL, '2021-05-31 12:05:42', NULL),
(9, 'Leave form', 'leave-form', 'pc', NULL, '2021-05-31 12:06:17', NULL),
(10, 'Convence', 'convence', 'pc', NULL, '2021-05-31 12:06:56', NULL),
(11, 'Rent  a  car  bill', 'rent-a-car-bill', 'pc', NULL, '2021-05-31 12:08:21', NULL),
(12, 'Master bill', 'master-bill', 'pc', NULL, '2021-05-31 12:08:58', NULL),
(13, 'F/o cash summery', 'f/o-cash-summery', 'pc', NULL, '2021-05-31 12:10:17', NULL),
(14, 'Guest room cleaning', 'guest-room-cleaning', 'pc', NULL, '2021-05-31 12:11:12', NULL),
(15, 'Q t  book', 'q-t-book', 'pc', NULL, '2021-05-31 12:12:49', NULL),
(16, 'Laundry book', 'laundry-book', 'pc', NULL, '2021-05-31 12:14:11', NULL),
(17, 'Hotel pad', 'hotel-pad', 'pc', NULL, '2021-05-31 12:15:12', NULL),
(18, 'Guest folio', 'guest-folio', 'pc', NULL, '2021-05-31 12:16:18', NULL),
(19, 'Plastic file', 'plastic-file', 'pc', NULL, '2021-05-31 12:18:02', NULL),
(20, 'Register book (16 no)', 'register-book-(16-no)', 'pc', NULL, '2021-05-31 12:19:21', NULL),
(21, 'Later file', 'later-file', 'pc', NULL, '2021-05-31 12:19:56', NULL),
(22, 'A 4  paper (1 rim)', 'a-4-paper-(1-rim)', 'pc', NULL, '2021-05-31 12:21:19', NULL),
(23, 'A 4  invelop', 'a-4-invelop', 'pc', NULL, '2021-05-31 12:22:08', NULL),
(24, 'Caut file', 'caut-file', 'pc', NULL, '2021-05-31 12:23:36', NULL),
(25, 'Binder clips  2\"', 'binder-clips-2\"', 'pc', NULL, '2021-05-31 12:26:21', NULL),
(26, 'Binder clips  1\"', 'binder-clips-1\"', 'pc', NULL, '2021-05-31 12:28:42', NULL),
(27, 'Binder clips  1/2\"', 'binder-clips-1/2\"', 'pc', NULL, '2021-05-31 12:30:48', NULL),
(28, 'Glue stick', 'glue-stick', 'pc', NULL, '2021-05-31 12:31:25', NULL),
(29, 'Sunlite buttery  aaa', 'sunlite-buttery-aaa', 'pc', NULL, '2021-05-31 12:32:23', NULL),
(30, 'Sunlite buttery  aa', 'sunlite-buttery-aa', 'pc', NULL, '2021-05-31 12:32:42', NULL),
(31, 'Stapler pin', 'stapler-pin', 'pc', NULL, '2021-05-31 12:33:37', NULL),
(32, 'Stapler pin  small', 'stapler-pin-small', 'pc', NULL, '2021-05-31 12:36:08', NULL),
(33, 'Sapner', 'sapner', 'pc', NULL, '2021-05-31 12:36:50', NULL),
(34, 'Thumb tacks', 'thumb-tacks', 'pc', NULL, '2021-05-31 12:37:28', NULL),
(35, 'white board marker', 'white-board-marker', 'pc', NULL, '2021-06-01 06:19:33', NULL),
(36, 'permanent marker', 'permanent-marker', 'pc', NULL, '2021-06-01 06:21:15', NULL),
(37, 'correction pen', 'correction-pen', 'pc', NULL, '2021-06-01 06:22:11', NULL),
(38, 'High lighter pen', 'high-lighter-pen', 'pc', NULL, '2021-06-01 06:22:56', NULL),
(39, 'Triangle clips', 'triangle-clips', 'pc', NULL, '2021-06-01 06:23:54', NULL),
(40, 'Eraser', 'eraser', 'pc', NULL, '2021-06-01 06:24:55', NULL),
(41, 'Scos tap  small', 'scos-tap-small', 'pc', NULL, '2021-06-01 06:27:33', NULL),
(42, 'Scos tap  big', 'scos-tap-big', 'pc', NULL, '2021-06-01 06:28:05', NULL),
(43, 'Money robar', 'money-robar', 'kg', NULL, '2021-06-01 06:29:47', NULL),
(44, 'Disposable head cap', 'disposable-head-cap', 'pc', NULL, '2021-06-02 05:26:23', NULL),
(45, 'Spry gun', 'spry-gun', 'pc', NULL, '2021-06-02 05:28:02', NULL),
(46, 'Hotel logo tissue box', 'hotel-logo-tissue-box', 'pc', NULL, '2021-06-02 05:29:30', NULL),
(47, 'Tissue box normal', 'tissue-box-normal', 'pc', NULL, '2021-06-02 05:48:14', NULL),
(48, 'Paper napkin', 'paper-napkin', 'pc', NULL, '2021-06-02 05:49:45', NULL),
(49, 'Toilet roll ( 12pc x 1pkt )', 'toilet-roll-(-12pc-x-1pkt-)', 'pc', NULL, '2021-06-02 05:51:58', NULL),
(50, 'Kitchen tawal ( 2pc x 1pkt )', 'kitchen-tawal-(-2pc-x-1pkt-)', 'pc', NULL, '2021-06-02 05:54:20', NULL),
(51, 'Gel pen ( rad )', 'gel-pen-(-rad-)', 'pc', NULL, '2021-06-02 05:55:26', NULL),
(52, 'Pen black ( staff )', 'pen-black-(-staff-)', 'pc', NULL, '2021-06-02 05:59:36', NULL),
(53, 'Pen rad( staff )', 'pen-rad(-staff-)', 'pc', NULL, '2021-06-02 06:00:38', NULL),
(54, 'Cotton buds  pkt', 'cotton-buds-pkt', 'pc', NULL, '2021-06-02 06:01:39', NULL),
(55, 'Odonil  ( 4pc x 1pkt )', 'odonil-(-4pc-x-1pkt-)', 'pc', NULL, '2021-06-02 06:03:47', NULL),
(56, 'Candle ( 6pc x 1pkt )', 'candle-(-6pc-x-1pkt-)', 'pc', NULL, '2021-06-02 06:05:05', NULL),
(57, 'Good knight oil', 'good-knight-oil', 'pc', NULL, '2021-06-02 06:17:23', NULL),
(58, 'Raping  paper', 'raping-paper', 'pc', NULL, '2021-06-02 06:18:27', NULL),
(59, 'Shoping bag ( kitchen )', 'shoping-bag-(-kitchen-)', 'pc', NULL, '2021-06-02 06:23:11', NULL),
(60, 'Strowe ( 100ps x1pkt )', 'strowe-(-100ps-x1pkt-)', 'pc', NULL, '2021-06-03 06:50:41', NULL),
(61, 'Baskete paper (100ps x1ps )', 'baskete-paper-(100ps-x1ps-)', 'pc', NULL, '2021-06-03 06:54:03', NULL),
(62, 'Poly  ( 12\"x 16\" )', 'poly-(-12\"x-16\"-)', 'kg', NULL, '2021-06-03 06:55:54', NULL),
(63, 'Poly  ( 16\" x 20\" )', 'poly-(-16\"-x-20\"-)', 'kg', NULL, '2021-06-03 06:58:44', NULL),
(64, 'Poly  ( 7\" x 8 \")', 'poly-(-7\"-x-8-\")', 'kg', NULL, '2021-06-03 07:00:03', NULL),
(65, 'Poly  black ( 30\"x 40\")', 'poly-black-(-30\"x-40\")', 'kg', NULL, '2021-06-03 07:05:36', NULL),
(66, 'Daimond foil paper', 'daimond-foil-paper', 'pc', NULL, '2021-06-03 07:08:29', NULL),
(67, 'Daimond wraping paper', 'daimond-wraping-paper', 'pc', NULL, '2021-06-03 07:09:16', NULL),
(68, 'Ribon fita', 'ribon-fita', 'pc', NULL, '2021-06-03 07:09:53', NULL),
(69, 'Still mazoni', 'still-mazoni', 'pc', NULL, '2021-06-03 07:11:08', NULL),
(70, 'Green mazoni', 'green-mazoni', 'pc', NULL, '2021-06-03 07:11:34', NULL),
(71, 'Fire box  (12ps x 1 )', 'fire-box-(12ps-x-1-)', 'pc', NULL, '2021-06-03 07:13:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prd_stock`
--

CREATE TABLE `prd_stock` (
  `pk_no` int(11) NOT NULL,
  `prd_id` int(11) NOT NULL,
  `prd_qty` float(10,2) NOT NULL,
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
(2, 67, 30.00, '2021-06-05 02:37:00', NULL, NULL, NULL, 0),
(3, 1, 10.00, '2021-06-05 02:36:32', NULL, NULL, NULL, 0),
(4, 71, 53.00, '2021-06-10 03:20:21', NULL, NULL, NULL, 0),
(5, 69, 200.00, '2021-06-12 03:47:24', NULL, NULL, NULL, 0),
(7, 54, 0.00, '2021-06-30 00:27:12', NULL, NULL, NULL, 0);

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
  `prd_qty` float(10,2) DEFAULT NULL,
  `prd_qty_price` int(11) DEFAULT NULL,
  `prd_grand_price` float DEFAULT NULL,
  `prd_price` float DEFAULT NULL,
  `prd_unit` varchar(50) DEFAULT NULL,
  `prd_brand` varchar(100) DEFAULT NULL,
  `prd_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prd_usage`
--

INSERT INTO `prd_usage` (`pk_no`, `prd_name_id`, `dept`, `taken_by`, `taken_date`, `prd_qty`, `prd_qty_price`, `prd_grand_price`, `prd_price`, `prd_unit`, `prd_brand`, `prd_remarks`, `created_at`, `updated_at`) VALUES
(1, 71, NULL, 'Kamrul', '2021-06-27 18:00:00', 10.00, 50, 500, 500, 'pc', NULL, NULL, '2021-06-28 02:33:13', NULL),
(2, 54, NULL, 'Kamrul', '2021-06-22 18:00:00', 30.00, 20, 600, 600, 'pc', NULL, NULL, '2021-06-30 00:39:35', NULL);

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
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `pk_no` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`pk_no`, `supplier_name`, `supplier_remarks`, `created_at`, `updated_at`) VALUES
(3, 'Rony', NULL, '2021-06-21 02:24:53', NULL);

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
(1, 'Rony', 'store@app.com', NULL, '$2y$10$q27QzC6kgZXjIpW284ir..t75nI99fsSfgmqzbDx1jp21cuZ5/JiS', 0, NULL, '2021-03-04 03:12:53', '2021-03-04 03:12:53'),
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
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `prd_name`
--
ALTER TABLE `prd_name`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `prd_stock`
--
ALTER TABLE `prd_stock`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `prd_usage`
--
ALTER TABLE `prd_usage`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `pk_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
