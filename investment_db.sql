-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26 يوليو 2025 الساعة 05:13
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investment_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '123456'),
(2, 'admin', '123456'),
(3, 'admin', '123456');

-- --------------------------------------------------------

--
-- بنية الجدول `opportunities`
--

CREATE TABLE `opportunities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `lastDate` date DEFAULT NULL,
  `map` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `opportunities`
--

INSERT INTO `opportunities` (`id`, `name`, `location`, `area`, `type`, `status`, `duration`, `lastDate`, `map`, `link`) VALUES
(2, 'حي الجامعين', 'الهفوف', '1795 م2', 'خدمي', 'منتهية', '33', '2025-11-17', 'https://www.google.com/maps/place/25%C2%B017\'44.3%22N+49%C2%B032\'26.4%22E/@25.2956389,49.5406667,385m/data=!3m2!1e3!4b1!4m4!3m3!8m2!3d25.2956389!4d49.5406667?coh=245187&entry=tts&g_ep=EgoyMDI1MDUyMS4wIPu8ASoJLDEwMjExNDUzSAFQAw%3D%3D&skid=a0a5cfbc-e64b-414b-a122-dc9fc6823a24', 'https://furas.momah.gov.sa/ar/opportunity/01-25-017001-25001?type=Investment'),
(3, 'حي منسوبي التعليم', 'الهفوف', '22 سنوات', 'تجاري', 'متاحة', '33', '2025-07-18', 'https://www.google.com/maps/@25.9945064,49.5430164,361m/data=!3m1!1e3?entry=ttu&g_ep=EgoyMDI1MDcyMi4wIKXMDSoASAFQAw%3D%3D', 'https://furas.momah.gov.sa/ar/opportunities-listing/Investment'),
(6, 'مينينني تيتتي تيتتيت', 'الهفوف', '122222', 'تجاري', 'متاحة', '5 سنوات', '2025-07-30', 'https://windows.php.net/download', 'https://windows.php.net/download'),
(7, 'مينينني تيتتي تيتتيت', 'الهفوف', '122222', 'تجاري', 'متاحة', '5 سنوات', '2025-07-30', 'https://windows.php.net/download', 'https://windows.php.net/download'),
(8, 'شجون', 'الهفوف', '122222', 'ترفيهي', 'متاحة', '5 سنوات', '2025-07-30', 'https://windows.php.net/download', 'https://windows.php.net/download');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opportunities`
--
ALTER TABLE `opportunities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `opportunities`
--
ALTER TABLE `opportunities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
