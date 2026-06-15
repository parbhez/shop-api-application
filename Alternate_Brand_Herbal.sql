-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2026 at 11:40 AM
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
-- Table structure for table `Alternate_Brand_Herbal`
--

CREATE TABLE `Alternate_Brand_Herbal` (
  `id` bigint(200) NOT NULL,
  `herbal_id` bigint(200) NOT NULL,
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
-- Dumping data for table `Alternate_Brand_Herbal`
--

INSERT INTO `Alternate_Brand_Herbal` (`id`, `herbal_id`, `tablet_name`, `generic_name`, `strength`, `manufacturer_company`, `unit_price`, `strip_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1070, 2, 'A-cerumen', 'Hygiene & Healthcare', 'N/A', 'Purnava Limited\n(Mfg. by: Laboratoires Gilbert)', '৳ 60.00', NULL, '2026-06-01 07:12:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1071, 2, 'Diabetasol', 'Hygiene & Healthcare', 'N/A', 'Purnava Limited\n(Mfg. by: KALBE Nutritionals)', '৳ 450.00', NULL, '2026-06-01 07:12:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Alternate_Brand_Herbal`
--
ALTER TABLE `Alternate_Brand_Herbal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alternate_herbal` (`herbal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Alternate_Brand_Herbal`
--
ALTER TABLE `Alternate_Brand_Herbal`
  MODIFY `id` bigint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Alternate_Brand_Herbal`
--
ALTER TABLE `Alternate_Brand_Herbal`
  ADD CONSTRAINT `fk_alternate_herbal` FOREIGN KEY (`herbal_id`) REFERENCES `Herbal_Brand` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
