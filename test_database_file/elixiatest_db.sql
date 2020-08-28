-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 28, 2020 at 01:30 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.2.27-6+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elixiatest_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_dispatchDetails` (IN `lowerLimit` INT(10))  NO SQL
BEGIN

select d.*,sm.sourceName,dm.destName,tm.transName from dispatches as d join source_masters as sm on d.source_code=sm.id join destination_masters as dm on d.dest_code=dm.id join transporter_masters as tm on d.trans_code=tm.id WHERE d.isDeleted=0 ORDER BY d.id DESC 
limit lowerLimit,10;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_dispatchDetails` (IN `shipment_no` INT(11), IN `delivery_no` INT(11), IN `source_code` INT(11), IN `dest_code` INT(11), IN `vehicle_no` VARCHAR(100), IN `trans_code` INT(11), IN `start_date` DATE, IN `end_date` DATE, IN `driver_name` VARCHAR(100), IN `driver_phone` BIGINT(20), IN `created_by` INT(11), IN `updated_by` INT(11))  NO SQL
BEGIN

INSERT INTO dispatches (shipment_no, delivery_no, source_code, dest_code, vehicle_no, trans_code, start_date, end_date, driver_name, driver_phone, created_by, updated_by) 
                
VALUES (shipment_no, delivery_no, source_code, dest_code, vehicle_no, trans_code, start_date, end_date, driver_name, driver_phone, created_by, updated_by);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `destination_masters`
--

CREATE TABLE `destination_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destination_masters`
--

INSERT INTO `destination_masters` (`id`, `destName`, `created_at`, `updated_at`) VALUES
(1, 'Patna', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(2, 'Mumbai', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(3, 'Ahmedabad', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(4, 'Ghaziabad', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(5, 'Aurangabad', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(6, 'Navi Mumbai', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(7, 'Coimbatore', '2020-08-28 07:28:14', '2020-08-28 07:28:14'),
(8, 'Vijayawada', '2020-08-28 07:28:14', '2020-08-28 07:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `dispatches`
--

CREATE TABLE `dispatches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_no` int(11) DEFAULT NULL,
  `delivery_no` int(11) DEFAULT NULL,
  `source_code` int(11) NOT NULL,
  `dest_code` int(11) NOT NULL,
  `vehicle_no` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_code` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `driver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_phone` bigint(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `isDeleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dispatches`
--

INSERT INTO `dispatches` (`id`, `shipment_no`, `delivery_no`, `source_code`, `dest_code`, `vehicle_no`, `trans_code`, `start_date`, `end_date`, `driver_name`, `driver_phone`, `created_by`, `created_at`, `updated_at`, `updated_by`, `isDeleted`) VALUES
(1, 1, 1, 1, 1, 'MH09CC0987', 1, '2020-08-28', '2020-08-30', 'Ashok', 9876543210, 1, '2020-08-28 07:31:38', '2020-08-28 07:33:24', 1, 0),
(2, 2, 2, 2, 2, 'MH10CC0987', 2, '2020-08-27', '2020-08-29', 'Shaam', 9876543210, 1, '2020-08-28 07:33:05', '2020-08-28 07:33:05', 1, 0);

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_08_26_090737_create_source_masters_table', 2),
(5, '2020_08_26_090751_create_destination_masters_table', 2),
(6, '2020_08_26_090954_create_transporter_masters_table', 2),
(7, '2020_08_26_091050_create_token_details_table', 2),
(8, '2020_08_26_091113_create_dispatches_table', 2);

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
-- Table structure for table `source_masters`
--

CREATE TABLE `source_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sourceName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `source_masters`
--

INSERT INTO `source_masters` (`id`, `sourceName`, `created_at`, `updated_at`) VALUES
(1, 'Mumbai', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(2, 'Delhi', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(3, 'Bangalore', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(4, 'Hyderabad', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(5, 'Surat', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(6, 'Pune', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(7, 'Lucknow', '2020-08-28 07:26:00', '2020-08-28 07:26:00'),
(8, 'Visakhapatnam', '2020-08-28 07:26:00', '2020-08-28 07:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `token_details`
--

CREATE TABLE `token_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transporter_masters`
--

CREATE TABLE `transporter_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transporter_masters`
--

INSERT INTO `transporter_masters` (`id`, `transName`, `created_at`, `updated_at`) VALUES
(1, 'Trans100', '2020-08-26 09:23:53', '2020-08-28 07:29:59'),
(2, 'Trans101', '2020-08-26 09:24:11', '2020-08-28 07:30:06'),
(3, 'Trans103', '2020-08-26 09:23:53', '2020-08-28 07:29:59'),
(4, 'Trans104', '2020-08-26 09:24:11', '2020-08-28 07:30:06'),
(5, 'Trans105', '2020-08-26 09:23:53', '2020-08-28 07:29:59'),
(6, 'Trans106', '2020-08-26 09:24:11', '2020-08-28 07:30:06'),
(7, 'Trans107', '2020-08-26 09:23:53', '2020-08-28 07:29:59'),
(8, 'Trans108', '2020-08-26 09:24:11', '2020-08-28 07:30:06');

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
  `access_token` longtext COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `access_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@gmail.com', NULL, '$2y$10$nPAxCfNWsiCSKEaAzdcjIuv.Hk5DCOTmIkIYAWym4oY1rfmL8NUtC', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2VsaXhpYXRlc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE1OTg2MDA4NjgsImV4cCI6MTU5ODYwMjY2OCwibmJmIjoxNTk4NjAwODY4LCJqdGkiOiJsWjBPaUZ4SlJOWlRCTUt4Iiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.sICSLYDzGS3kXNM7coqC4nb4V__vKEME11pK8gvZx_w', NULL, '2020-08-25 23:32:18', '2020-08-25 23:32:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destination_masters`
--
ALTER TABLE `destination_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatches`
--
ALTER TABLE `dispatches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `source_masters`
--
ALTER TABLE `source_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_details`
--
ALTER TABLE `token_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transporter_masters`
--
ALTER TABLE `transporter_masters`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `destination_masters`
--
ALTER TABLE `destination_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `dispatches`
--
ALTER TABLE `dispatches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `source_masters`
--
ALTER TABLE `source_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `token_details`
--
ALTER TABLE `token_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transporter_masters`
--
ALTER TABLE `transporter_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
