-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2026 at 11:39 AM
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
-- Database: `MedEx_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Herbal_Brand`
--

CREATE TABLE `Herbal_Brand` (
  `id` bigint(200) NOT NULL,
  `tablet_name` longtext NOT NULL,
  `generic_name` longtext NOT NULL,
  `strength` longtext NOT NULL,
  `manufacturer_company` longtext NOT NULL,
  `unit_price` text DEFAULT NULL,
  `strip_price` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Herbal_Brand`
--

INSERT INTO `Herbal_Brand` (`id`, `tablet_name`, `generic_name`, `strength`, `manufacturer_company`, `unit_price`, `strip_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5HTP', '5-Hydroxytryptophan + Valerian extract', '100 mg+100 mg', 'Purnava Limited', '৳ 15.00', '৳ 90.00', '2026-06-01 07:12:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'A-cerumen', 'Hygiene & Healthcare', '', 'Purnava Limited', '৳ 60.00', NULL, '2026-06-01 07:12:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Abolib', 'Ginkgo Biloba', '60 mg', 'Veritas Pharmaceuticals Ltd.', '৳ 10.00', NULL, '2026-06-01 07:13:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Herbal_Brand`
--
ALTER TABLE `Herbal_Brand`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Herbal_Brand`
--
ALTER TABLE `Herbal_Brand`
  MODIFY `id` bigint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=888;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
