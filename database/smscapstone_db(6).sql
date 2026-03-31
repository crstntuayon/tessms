-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 31, 2026 at 04:59 PM
-- Server version: 8.0.45
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smscapstone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'students',
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `section_id`, `student_id`, `school_year_id`, `date`, `status`, `teacher_id`, `remarks`, `created_at`, `updated_at`) VALUES
(23, 2, 49, 1, '2026-06-08', 'present', 8, NULL, '2026-03-31 00:25:57', '2026-03-31 00:25:57'),
(24, 2, 50, 1, '2026-06-08', 'present', 8, NULL, '2026-03-31 00:25:57', '2026-03-31 00:25:57'),
(25, 2, 51, 1, '2026-06-08', 'present', 8, NULL, '2026-03-31 00:25:57', '2026-03-31 00:25:57'),
(26, 2, 49, 1, '2026-06-09', 'present', 8, NULL, '2026-03-31 00:26:06', '2026-03-31 00:26:06'),
(27, 2, 50, 1, '2026-06-09', 'present', 8, NULL, '2026-03-31 00:26:06', '2026-03-31 00:26:06'),
(28, 2, 51, 1, '2026-06-09', 'present', 8, NULL, '2026-03-31 00:26:06', '2026-03-31 00:26:06'),
(29, 2, 49, 1, '2026-06-10', 'present', 8, NULL, '2026-03-31 00:26:16', '2026-03-31 00:26:16'),
(30, 2, 50, 1, '2026-06-10', 'present', 8, NULL, '2026-03-31 00:26:16', '2026-03-31 00:26:16'),
(31, 2, 51, 1, '2026-06-10', 'present', 8, NULL, '2026-03-31 00:26:16', '2026-03-31 00:26:16'),
(32, 2, 49, 1, '2026-06-11', 'present', 8, NULL, '2026-03-31 00:26:24', '2026-03-31 00:26:24'),
(33, 2, 50, 1, '2026-06-11', 'present', 8, NULL, '2026-03-31 00:26:24', '2026-03-31 00:26:24'),
(34, 2, 51, 1, '2026-06-11', 'present', 8, NULL, '2026-03-31 00:26:24', '2026-03-31 00:26:24'),
(35, 2, 49, 1, '2026-06-12', 'present', 8, NULL, '2026-03-31 00:26:35', '2026-03-31 00:26:35'),
(36, 2, 50, 1, '2026-06-12', 'present', 8, NULL, '2026-03-31 00:26:35', '2026-03-31 00:26:35'),
(37, 2, 51, 1, '2026-06-12', 'present', 8, NULL, '2026-03-31 00:26:35', '2026-03-31 00:26:35'),
(38, 2, 49, 1, '2026-06-15', 'present', 8, NULL, '2026-03-31 00:48:28', '2026-03-31 00:48:28'),
(39, 2, 50, 1, '2026-06-15', 'absent', 8, NULL, '2026-03-31 00:48:28', '2026-03-31 00:48:28'),
(40, 2, 51, 1, '2026-06-15', 'late', 8, NULL, '2026-03-31 00:48:28', '2026-03-31 00:48:28'),
(41, 2, 49, 1, '2026-06-16', 'late', 8, NULL, '2026-03-31 00:48:48', '2026-03-31 00:48:48'),
(42, 2, 50, 1, '2026-06-16', 'present', 8, NULL, '2026-03-31 00:48:48', '2026-03-31 00:48:48'),
(43, 2, 51, 1, '2026-06-16', 'present', 8, NULL, '2026-03-31 00:48:48', '2026-03-31 00:48:48'),
(44, 2, 49, 1, '2026-06-17', 'present', 8, NULL, '2026-03-31 00:48:55', '2026-03-31 00:48:55'),
(45, 2, 50, 1, '2026-06-17', 'present', 8, NULL, '2026-03-31 00:48:55', '2026-03-31 00:48:55'),
(46, 2, 51, 1, '2026-06-17', 'present', 8, NULL, '2026-03-31 00:48:55', '2026-03-31 00:48:55'),
(47, 2, 49, 1, '2026-06-18', 'present', 8, NULL, '2026-03-31 00:49:03', '2026-03-31 00:49:03'),
(48, 2, 50, 1, '2026-06-18', 'present', 8, NULL, '2026-03-31 00:49:03', '2026-03-31 00:49:03'),
(49, 2, 51, 1, '2026-06-18', 'present', 8, NULL, '2026-03-31 00:49:03', '2026-03-31 00:49:03'),
(50, 2, 49, 1, '2026-06-19', 'absent', 8, NULL, '2026-03-31 00:49:14', '2026-03-31 00:49:14'),
(51, 2, 50, 1, '2026-06-19', 'late', 8, NULL, '2026-03-31 00:49:14', '2026-03-31 00:49:14'),
(52, 2, 51, 1, '2026-06-19', 'present', 8, NULL, '2026-03-31 00:49:14', '2026-03-31 00:49:14'),
(53, 2, 49, 1, '2026-06-22', 'present', 8, NULL, '2026-03-31 00:49:36', '2026-03-31 00:49:36'),
(54, 2, 50, 1, '2026-06-22', 'present', 8, NULL, '2026-03-31 00:49:36', '2026-03-31 00:49:36'),
(55, 2, 51, 1, '2026-06-22', 'present', 8, NULL, '2026-03-31 00:49:36', '2026-03-31 00:49:36'),
(56, 2, 49, 1, '2026-06-23', 'present', 8, NULL, '2026-03-31 00:49:44', '2026-03-31 00:49:44'),
(57, 2, 50, 1, '2026-06-23', 'present', 8, NULL, '2026-03-31 00:49:44', '2026-03-31 00:49:44'),
(58, 2, 51, 1, '2026-06-23', 'present', 8, NULL, '2026-03-31 00:49:44', '2026-03-31 00:49:44'),
(59, 2, 49, 1, '2026-06-24', 'present', 8, NULL, '2026-03-31 00:49:51', '2026-03-31 00:49:51'),
(60, 2, 50, 1, '2026-06-24', 'present', 8, NULL, '2026-03-31 00:49:51', '2026-03-31 00:49:51'),
(61, 2, 51, 1, '2026-06-24', 'present', 8, NULL, '2026-03-31 00:49:51', '2026-03-31 00:49:51'),
(62, 2, 49, 1, '2026-06-25', 'present', 8, NULL, '2026-03-31 00:49:58', '2026-03-31 00:49:58'),
(63, 2, 50, 1, '2026-06-25', 'present', 8, NULL, '2026-03-31 00:49:58', '2026-03-31 00:49:58'),
(64, 2, 51, 1, '2026-06-25', 'present', 8, NULL, '2026-03-31 00:49:58', '2026-03-31 00:49:58'),
(65, 2, 49, 1, '2026-06-26', 'present', 8, NULL, '2026-03-31 00:50:05', '2026-03-31 00:50:05'),
(66, 2, 50, 1, '2026-06-26', 'present', 8, NULL, '2026-03-31 00:50:05', '2026-03-31 00:50:05'),
(67, 2, 51, 1, '2026-06-26', 'present', 8, NULL, '2026-03-31 00:50:05', '2026-03-31 00:50:05'),
(68, 2, 49, 1, '2026-06-29', 'present', 8, NULL, '2026-03-31 00:50:14', '2026-03-31 00:50:14'),
(69, 2, 50, 1, '2026-06-29', 'present', 8, NULL, '2026-03-31 00:50:14', '2026-03-31 00:50:14'),
(70, 2, 51, 1, '2026-06-29', 'absent', 8, NULL, '2026-03-31 00:50:14', '2026-03-31 00:50:14'),
(71, 2, 49, 1, '2026-06-30', 'present', 8, NULL, '2026-03-31 00:50:32', '2026-03-31 00:50:32'),
(72, 2, 50, 1, '2026-06-30', 'present', 8, NULL, '2026-03-31 00:50:32', '2026-03-31 00:50:32'),
(73, 2, 51, 1, '2026-06-30', 'present', 8, NULL, '2026-03-31 00:50:32', '2026-03-31 00:50:32'),
(74, 2, 49, 1, '2026-07-01', 'present', 8, NULL, '2026-03-31 00:50:45', '2026-03-31 00:50:45'),
(75, 2, 50, 1, '2026-07-01', 'present', 8, NULL, '2026-03-31 00:50:45', '2026-03-31 00:50:45'),
(76, 2, 51, 1, '2026-07-01', 'present', 8, NULL, '2026-03-31 00:50:45', '2026-03-31 00:50:45'),
(77, 2, 49, 1, '2026-07-02', 'present', 8, NULL, '2026-03-31 00:50:54', '2026-03-31 00:50:54'),
(78, 2, 50, 1, '2026-07-02', 'present', 8, NULL, '2026-03-31 00:50:54', '2026-03-31 00:50:54'),
(79, 2, 51, 1, '2026-07-02', 'present', 8, NULL, '2026-03-31 00:50:54', '2026-03-31 00:50:54'),
(80, 2, 49, 1, '2026-07-03', 'present', 8, NULL, '2026-03-31 00:51:08', '2026-03-31 00:51:08'),
(81, 2, 50, 1, '2026-07-03', 'present', 8, NULL, '2026-03-31 00:51:08', '2026-03-31 00:51:08'),
(82, 2, 51, 1, '2026-07-03', 'present', 8, NULL, '2026-03-31 00:51:08', '2026-03-31 00:51:08'),
(83, 2, 49, 1, '2026-07-06', 'present', 8, NULL, '2026-03-31 01:34:13', '2026-03-31 01:34:13'),
(84, 2, 50, 1, '2026-07-06', 'present', 8, NULL, '2026-03-31 01:34:13', '2026-03-31 01:34:13'),
(85, 2, 51, 1, '2026-07-06', 'present', 8, NULL, '2026-03-31 01:34:13', '2026-03-31 01:34:13'),
(86, 2, 49, 1, '2026-07-07', 'present', 8, NULL, '2026-03-31 01:37:56', '2026-03-31 01:37:56'),
(87, 2, 50, 1, '2026-07-07', 'present', 8, NULL, '2026-03-31 01:37:56', '2026-03-31 01:37:56'),
(88, 2, 51, 1, '2026-07-07', 'present', 8, NULL, '2026-03-31 01:37:56', '2026-03-31 01:37:56'),
(89, 2, 49, 1, '2026-07-08', 'present', 8, NULL, '2026-03-31 01:38:07', '2026-03-31 01:38:07'),
(90, 2, 50, 1, '2026-07-08', 'late', 8, NULL, '2026-03-31 01:38:07', '2026-03-31 01:38:07'),
(91, 2, 51, 1, '2026-07-08', 'present', 8, NULL, '2026-03-31 01:38:07', '2026-03-31 01:38:07'),
(92, 2, 49, 1, '2026-07-09', 'present', 8, NULL, '2026-03-31 01:38:33', '2026-03-31 01:38:33'),
(93, 2, 50, 1, '2026-07-09', 'present', 8, NULL, '2026-03-31 01:38:34', '2026-03-31 01:38:34'),
(94, 2, 51, 1, '2026-07-09', 'late', 8, NULL, '2026-03-31 01:38:34', '2026-03-31 01:38:34'),
(95, 2, 49, 1, '2026-07-10', 'present', 8, NULL, '2026-03-31 01:38:43', '2026-03-31 01:38:43'),
(96, 2, 50, 1, '2026-07-10', 'present', 8, NULL, '2026-03-31 01:38:43', '2026-03-31 01:38:43'),
(97, 2, 51, 1, '2026-07-10', 'present', 8, NULL, '2026-03-31 01:38:43', '2026-03-31 01:38:43'),
(98, 2, 49, 1, '2026-07-13', 'absent', 8, NULL, '2026-03-31 01:41:32', '2026-03-31 01:41:32'),
(99, 2, 50, 1, '2026-07-13', 'absent', 8, NULL, '2026-03-31 01:41:32', '2026-03-31 01:41:32'),
(100, 2, 51, 1, '2026-07-13', 'absent', 8, NULL, '2026-03-31 01:41:32', '2026-03-31 01:41:32'),
(101, 2, 49, 1, '2026-07-14', 'present', 8, NULL, '2026-03-31 01:41:45', '2026-03-31 01:41:45'),
(102, 2, 50, 1, '2026-07-14', 'present', 8, NULL, '2026-03-31 01:41:45', '2026-03-31 01:41:45'),
(103, 2, 51, 1, '2026-07-14', 'present', 8, NULL, '2026-03-31 01:41:45', '2026-03-31 01:41:45'),
(104, 2, 49, 1, '2026-07-15', 'present', 8, NULL, '2026-03-31 01:42:03', '2026-03-31 01:42:03'),
(105, 2, 50, 1, '2026-07-15', 'present', 8, NULL, '2026-03-31 01:42:03', '2026-03-31 01:42:03'),
(106, 2, 51, 1, '2026-07-15', 'absent', 8, NULL, '2026-03-31 01:42:03', '2026-03-31 01:42:03'),
(107, 2, 49, 1, '2026-07-16', 'present', 8, NULL, '2026-03-31 01:42:16', '2026-03-31 01:42:16'),
(108, 2, 50, 1, '2026-07-16', 'present', 8, NULL, '2026-03-31 01:42:16', '2026-03-31 01:42:16'),
(109, 2, 51, 1, '2026-07-16', 'absent', 8, NULL, '2026-03-31 01:42:16', '2026-03-31 01:42:16'),
(110, 2, 49, 1, '2026-07-17', 'present', 8, NULL, '2026-03-31 01:42:29', '2026-03-31 01:42:29'),
(111, 2, 50, 1, '2026-07-17', 'present', 8, NULL, '2026-03-31 01:42:29', '2026-03-31 01:42:29'),
(112, 2, 51, 1, '2026-07-17', 'absent', 8, NULL, '2026-03-31 01:42:29', '2026-03-31 01:42:29'),
(113, 2, 49, 1, '2026-07-20', 'absent', 8, NULL, '2026-03-31 01:50:49', '2026-03-31 01:50:49'),
(114, 2, 50, 1, '2026-07-20', 'absent', 8, NULL, '2026-03-31 01:50:49', '2026-03-31 01:50:49'),
(115, 2, 51, 1, '2026-07-20', 'present', 8, NULL, '2026-03-31 01:50:49', '2026-03-31 01:50:49'),
(116, 2, 49, 1, '2026-07-21', 'present', 8, NULL, '2026-03-31 01:52:18', '2026-03-31 01:52:18'),
(117, 2, 50, 1, '2026-07-21', 'absent', 8, NULL, '2026-03-31 01:52:18', '2026-03-31 01:52:18'),
(118, 2, 51, 1, '2026-07-21', 'present', 8, NULL, '2026-03-31 01:52:18', '2026-03-31 01:52:18'),
(119, 2, 49, 1, '2026-07-22', 'present', 8, NULL, '2026-03-31 01:53:10', '2026-03-31 01:53:10'),
(120, 2, 50, 1, '2026-07-22', 'absent', 8, NULL, '2026-03-31 01:53:10', '2026-03-31 01:53:10'),
(121, 2, 51, 1, '2026-07-22', 'present', 8, NULL, '2026-03-31 01:53:11', '2026-03-31 01:53:11'),
(122, 2, 49, 1, '2026-07-23', 'present', 8, NULL, '2026-03-31 06:26:02', '2026-03-31 06:26:02'),
(123, 2, 50, 1, '2026-07-23', 'present', 8, NULL, '2026-03-31 06:26:02', '2026-03-31 06:26:02'),
(124, 2, 51, 1, '2026-07-23', 'present', 8, NULL, '2026-03-31 06:26:02', '2026-03-31 06:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_published` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_copies` int NOT NULL DEFAULT '0',
  `available_copies` int NOT NULL DEFAULT '0',
  `type` enum('textbook','workbook','reference','module','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'textbook',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_issuances`
--

CREATE TABLE `book_issuances` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `date_issued` date NOT NULL,
  `condition_issued` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Good',
  `issued_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_returned` date DEFAULT NULL,
  `condition_returned` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returned_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fine_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` enum('issued','returned','lost','damaged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('tugawees-sms-cache-app_settings', 'a:9:{s:11:\"system_name\";s:15:\"Tugawe ES - SMS\";s:11:\"school_name\";s:24:\"Tugawe Elementary School\";s:15:\"deped_school_id\";s:6:\"120231\";s:15:\"school_division\";s:27:\"Division of Negros Oriental\";s:13:\"school_region\";s:26:\"NIR - Negros Island Region\";s:11:\"school_head\";s:25:\"MAE HARRIET M. DELA PEÑA\";s:21:\"active_school_year_id\";i:1;s:13:\"passing_grade\";i:75;s:15:\"school_district\";s:14:\"Dauin District\";}', 1774963481),
('tugawees-sms-cache-reports_month_1', 'a:25:{s:13:\"totalStudents\";i:0;s:13:\"totalTeachers\";i:2;s:13:\"totalSections\";i:3;s:10:\"totalUsers\";i:10;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";d:0;s:25:\"averageStudentsPerSection\";d:0;s:16:\"averageClassSize\";d:0;s:9:\"maleCount\";i:0;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";i:0;s:16:\"femalePercentage\";i:0;s:16:\"activeSchoolYear\";s:9:\"2026-2027\";s:16:\"enrollmentLabels\";a:6:{i:0;s:3:\"Oct\";i:1;s:3:\"Dec\";i:2;s:3:\"Dec\";i:3;s:3:\"Jan\";i:4;s:3:\"Mar\";i:5;s:3:\"Mar\";}s:14:\"enrollmentData\";a:6:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;}s:11:\"gradeLevels\";a:0:{}s:17:\"gradeDistribution\";a:0:{}s:12:\"sectionNames\";a:3:{i:0;s:5:\"SALAS\";i:1;s:4:\"ROSE\";i:2;s:6:\"MENDES\";}s:15:\"sectionAverages\";a:3:{i:0;d:0;i:1;d:0;i:2;d:0;}s:11:\"topSections\";a:3:{i:0;a:4:{s:4:\"name\";s:5:\"SALAS\";s:7:\"teacher\";s:3:\"N/A\";s:8:\"students\";i:0;s:7:\"average\";d:0;}i:1;a:4:{s:4:\"name\";s:4:\"ROSE\";s:7:\"teacher\";s:13:\"Maria  Santos\";s:8:\"students\";i:0;s:7:\"average\";d:0;}i:2;a:4:{s:4:\"name\";s:6:\"MENDES\";s:7:\"teacher\";s:13:\"Shane  Mendes\";s:8:\"students\";i:0;s:7:\"average\";d:0;}}s:16:\"recentActivities\";a:2:{i:0;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Shane  Mendes\";s:4:\"time\";s:10:\"3 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}i:1;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Maria  Santos\";s:4:\"time\";s:10:\"5 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}}s:11:\"passingRate\";i:0;s:14:\"attendanceRate\";i:95;}', 1774920676),
('tugawees-sms-cache-reports_today_1', 'a:25:{s:13:\"totalStudents\";i:2;s:13:\"totalTeachers\";i:2;s:13:\"totalSections\";i:3;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";i:0;s:25:\"averageStudentsPerSection\";d:0.7;s:16:\"averageClassSize\";d:0.7;s:9:\"maleCount\";i:2;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";d:100;s:16:\"femalePercentage\";d:0;s:16:\"activeSchoolYear\";s:9:\"2026-2027\";s:16:\"enrollmentLabels\";a:6:{i:0;s:5:\"00:00\";i:1;s:5:\"04:00\";i:2;s:5:\"08:00\";i:3;s:5:\"12:00\";i:4;s:5:\"16:00\";i:5;s:5:\"20:00\";}s:14:\"enrollmentData\";a:6:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;}s:11:\"gradeLevels\";a:2:{i:0;s:7:\"Grade 1\";i:1;s:7:\"Unknown\";}s:17:\"gradeDistribution\";a:2:{i:0;i:1;i:1;i:1;}s:12:\"sectionNames\";a:3:{i:0;s:5:\"SALAS\";i:1;s:4:\"ROSE\";i:2;s:6:\"MENDES\";}s:15:\"sectionAverages\";a:3:{i:0;d:0;i:1;d:0;i:2;d:60;}s:11:\"topSections\";a:3:{i:0;a:4:{s:4:\"name\";s:6:\"MENDES\";s:7:\"teacher\";s:13:\"Shane  Mendes\";s:8:\"students\";i:0;s:7:\"average\";d:60;}i:1;a:4:{s:4:\"name\";s:5:\"SALAS\";s:7:\"teacher\";s:3:\"N/A\";s:8:\"students\";i:0;s:7:\"average\";d:0;}i:2;a:4:{s:4:\"name\";s:4:\"ROSE\";s:7:\"teacher\";s:13:\"Maria  Santos\";s:8:\"students\";i:1;s:7:\"average\";d:0;}}s:16:\"recentActivities\";a:5:{i:0;a:6:{s:5:\"title\";s:14:\"Grades Updated\";s:11:\"description\";s:27:\"Noime  Baldomar - Makabansa\";s:4:\"time\";s:9:\"1 day ago\";s:4:\"icon\";s:7:\"fa-edit\";s:7:\"icon_bg\";s:14:\"bg-emerald-100\";s:10:\"icon_color\";s:16:\"text-emerald-600\";}i:1;a:6:{s:5:\"title\";s:22:\"New Student Registered\";s:11:\"description\";s:15:\"Noime  Baldomar\";s:4:\"time\";s:10:\"2 days ago\";s:4:\"icon\";s:12:\"fa-user-plus\";s:7:\"icon_bg\";s:11:\"bg-blue-100\";s:10:\"icon_color\";s:13:\"text-blue-600\";}i:2;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Shane  Mendes\";s:4:\"time\";s:10:\"2 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}i:3;a:6:{s:5:\"title\";s:22:\"New Student Registered\";s:11:\"description\";s:16:\"Crestian  Tuayon\";s:4:\"time\";s:10:\"4 days ago\";s:4:\"icon\";s:12:\"fa-user-plus\";s:7:\"icon_bg\";s:11:\"bg-blue-100\";s:10:\"icon_color\";s:13:\"text-blue-600\";}i:4;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Maria  Santos\";s:4:\"time\";s:10:\"4 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}}s:11:\"passingRate\";d:0;s:14:\"attendanceRate\";i:95;}', 1774785653),
('tugawees-sms-cache-reports_today_2', 'a:25:{s:13:\"totalStudents\";i:0;s:13:\"totalTeachers\";i:0;s:13:\"totalSections\";i:0;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";i:0;s:25:\"averageStudentsPerSection\";i:0;s:16:\"averageClassSize\";i:0;s:9:\"maleCount\";i:0;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";i:0;s:16:\"femalePercentage\";i:0;s:16:\"activeSchoolYear\";s:9:\"2027-2028\";s:16:\"enrollmentLabels\";a:6:{i:0;s:5:\"00:00\";i:1;s:5:\"04:00\";i:2;s:5:\"08:00\";i:3;s:5:\"12:00\";i:4;s:5:\"16:00\";i:5;s:5:\"20:00\";}s:14:\"enrollmentData\";a:6:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;}s:11:\"gradeLevels\";a:0:{}s:17:\"gradeDistribution\";a:0:{}s:12:\"sectionNames\";a:0:{}s:15:\"sectionAverages\";a:0:{}s:11:\"topSections\";a:0:{}s:16:\"recentActivities\";a:0:{}s:11:\"passingRate\";i:0;s:14:\"attendanceRate\";i:95;}', 1774785661),
('tugawees-sms-cache-reports_today_3', 'a:25:{s:13:\"totalStudents\";i:0;s:13:\"totalTeachers\";i:0;s:13:\"totalSections\";i:0;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";i:0;s:25:\"averageStudentsPerSection\";i:0;s:16:\"averageClassSize\";i:0;s:9:\"maleCount\";i:0;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";i:0;s:16:\"femalePercentage\";i:0;s:16:\"activeSchoolYear\";s:9:\"2028-2029\";s:16:\"enrollmentLabels\";a:6:{i:0;s:5:\"00:00\";i:1;s:5:\"04:00\";i:2;s:5:\"08:00\";i:3;s:5:\"12:00\";i:4;s:5:\"16:00\";i:5;s:5:\"20:00\";}s:14:\"enrollmentData\";a:6:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;}s:11:\"gradeLevels\";a:0:{}s:17:\"gradeDistribution\";a:0:{}s:12:\"sectionNames\";a:0:{}s:15:\"sectionAverages\";a:0:{}s:11:\"topSections\";a:0:{}s:16:\"recentActivities\";a:0:{}s:11:\"passingRate\";i:0;s:14:\"attendanceRate\";i:95;}', 1774785668),
('tugawees-sms-cache-reports_week_1', 'a:25:{s:13:\"totalStudents\";i:2;s:13:\"totalTeachers\";i:2;s:13:\"totalSections\";i:3;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:100;s:13:\"teacherGrowth\";i:100;s:25:\"averageStudentsPerSection\";d:0.7;s:16:\"averageClassSize\";d:0.7;s:9:\"maleCount\";i:2;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";d:100;s:16:\"femalePercentage\";d:0;s:16:\"activeSchoolYear\";s:9:\"2026-2027\";s:16:\"enrollmentLabels\";a:7:{i:0;s:3:\"Mon\";i:1;s:3:\"Tue\";i:2;s:3:\"Wed\";i:3;s:3:\"Thu\";i:4;s:3:\"Fri\";i:5;s:3:\"Sat\";i:6;s:3:\"Sun\";}s:14:\"enrollmentData\";a:7:{i:0;i:0;i:1;i:0;i:2;i:1;i:3;i:0;i:4;i:1;i:5;i:0;i:6;i:0;}s:11:\"gradeLevels\";a:2:{i:0;s:7:\"Grade 1\";i:1;s:7:\"Unknown\";}s:17:\"gradeDistribution\";a:2:{i:0;i:1;i:1;i:1;}s:12:\"sectionNames\";a:3:{i:0;s:5:\"SALAS\";i:1;s:4:\"ROSE\";i:2;s:6:\"MENDES\";}s:15:\"sectionAverages\";a:3:{i:0;d:0;i:1;d:0;i:2;d:60;}s:11:\"topSections\";a:3:{i:0;a:4:{s:4:\"name\";s:6:\"MENDES\";s:7:\"teacher\";s:13:\"Shane  Mendes\";s:8:\"students\";i:0;s:7:\"average\";d:60;}i:1;a:4:{s:4:\"name\";s:5:\"SALAS\";s:7:\"teacher\";s:3:\"N/A\";s:8:\"students\";i:0;s:7:\"average\";d:0;}i:2;a:4:{s:4:\"name\";s:4:\"ROSE\";s:7:\"teacher\";s:13:\"Maria  Santos\";s:8:\"students\";i:1;s:7:\"average\";d:0;}}s:16:\"recentActivities\";a:5:{i:0;a:6:{s:5:\"title\";s:14:\"Grades Updated\";s:11:\"description\";s:27:\"Noime  Baldomar - Makabansa\";s:4:\"time\";s:9:\"1 day ago\";s:4:\"icon\";s:7:\"fa-edit\";s:7:\"icon_bg\";s:14:\"bg-emerald-100\";s:10:\"icon_color\";s:16:\"text-emerald-600\";}i:1;a:6:{s:5:\"title\";s:22:\"New Student Registered\";s:11:\"description\";s:15:\"Noime  Baldomar\";s:4:\"time\";s:10:\"2 days ago\";s:4:\"icon\";s:12:\"fa-user-plus\";s:7:\"icon_bg\";s:11:\"bg-blue-100\";s:10:\"icon_color\";s:13:\"text-blue-600\";}i:2;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Shane  Mendes\";s:4:\"time\";s:10:\"2 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}i:3;a:6:{s:5:\"title\";s:22:\"New Student Registered\";s:11:\"description\";s:16:\"Crestian  Tuayon\";s:4:\"time\";s:10:\"4 days ago\";s:4:\"icon\";s:12:\"fa-user-plus\";s:7:\"icon_bg\";s:11:\"bg-blue-100\";s:10:\"icon_color\";s:13:\"text-blue-600\";}i:4;a:6:{s:5:\"title\";s:17:\"New Teacher Added\";s:11:\"description\";s:13:\"Maria  Santos\";s:4:\"time\";s:10:\"4 days ago\";s:4:\"icon\";s:21:\"fa-chalkboard-teacher\";s:7:\"icon_bg\";s:13:\"bg-purple-100\";s:10:\"icon_color\";s:15:\"text-purple-600\";}}s:11:\"passingRate\";d:0;s:14:\"attendanceRate\";i:95;}', 1774785676),
('tugawees-sms-cache-reports_week_14', 'a:25:{s:13:\"totalStudents\";i:0;s:13:\"totalTeachers\";i:0;s:13:\"totalSections\";i:0;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";i:0;s:25:\"averageStudentsPerSection\";i:0;s:16:\"averageClassSize\";i:0;s:9:\"maleCount\";i:0;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";i:0;s:16:\"femalePercentage\";i:0;s:16:\"activeSchoolYear\";s:9:\"2039-2040\";s:16:\"enrollmentLabels\";a:7:{i:0;s:3:\"Mon\";i:1;s:3:\"Tue\";i:2;s:3:\"Wed\";i:3;s:3:\"Thu\";i:4;s:3:\"Fri\";i:5;s:3:\"Sat\";i:6;s:3:\"Sun\";}s:14:\"enrollmentData\";a:7:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;}s:11:\"gradeLevels\";a:0:{}s:17:\"gradeDistribution\";a:0:{}s:12:\"sectionNames\";a:0:{}s:15:\"sectionAverages\";a:0:{}s:11:\"topSections\";a:0:{}s:16:\"recentActivities\";a:0:{}s:11:\"passingRate\";i:0;s:14:\"attendanceRate\";i:95;}', 1774786003),
('tugawees-sms-cache-reports_week_2', 'a:25:{s:13:\"totalStudents\";i:0;s:13:\"totalTeachers\";i:0;s:13:\"totalSections\";i:0;s:10:\"totalUsers\";i:13;s:13:\"totalSubjects\";i:40;s:20:\"pendingRegistrations\";i:0;s:13:\"studentGrowth\";i:0;s:13:\"teacherGrowth\";i:0;s:25:\"averageStudentsPerSection\";i:0;s:16:\"averageClassSize\";i:0;s:9:\"maleCount\";i:0;s:11:\"femaleCount\";i:0;s:14:\"malePercentage\";i:0;s:16:\"femalePercentage\";i:0;s:16:\"activeSchoolYear\";s:9:\"2027-2028\";s:16:\"enrollmentLabels\";a:7:{i:0;s:3:\"Mon\";i:1;s:3:\"Tue\";i:2;s:3:\"Wed\";i:3;s:3:\"Thu\";i:4;s:3:\"Fri\";i:5;s:3:\"Sat\";i:6;s:3:\"Sun\";}s:14:\"enrollmentData\";a:7:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;}s:11:\"gradeLevels\";a:0:{}s:17:\"gradeDistribution\";a:0:{}s:12:\"sectionNames\";a:0:{}s:15:\"sectionAverages\";a:0:{}s:11:\"topSections\";a:0:{}s:16:\"recentActivities\";a:0:{}s:11:\"passingRate\";i:0;s:14:\"attendanceRate\";i:95;}', 1774786012);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `core_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statement_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `behavior_statement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `quarter` tinyint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `recorded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `student_id`, `core_value`, `statement_key`, `behavior_statement`, `rating`, `remarks`, `quarter`, `school_year_id`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 50, 'Maka-Diyos', 'statement1', '1.1 Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'AO', 'kepp', 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(2, 50, 'Maka-Diyos', 'statement2', '1.2 Shows adherence to ethical principles by upholding truth', 'SO', 'kepp', 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(3, 50, 'Makatao', 'statement1', '2.1 Is sensitive to individual, social, and cultural differences', 'SO', NULL, 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(4, 50, 'Makatao', 'statement2', '2.2 Demonstrates contributions toward solidarity', 'AO', NULL, 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(5, 50, 'Maka-Kalikasan', 'statement1', '3.1 Cares for the environment and utilizes resources wisely, judiciously, and economically', 'SO', NULL, 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(6, 50, 'Maka-bansa', 'statement1', '4.1 Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'SO', NULL, 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(7, 50, 'Maka-bansa', 'statement2', '4.2 Demonstrates appropriate behavior in carrying out activities in the school, community, and country', 'AO', NULL, 4, 1, 66, '2026-03-31 08:46:03', '2026-03-31 08:46:03'),
(8, 51, 'Maka-Diyos', 'statement1', '1.1 Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(9, 51, 'Maka-Diyos', 'statement2', '1.2 Shows adherence to ethical principles by upholding truth', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(10, 51, 'Makatao', 'statement1', '2.1 Is sensitive to individual, social, and cultural differences', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(11, 51, 'Makatao', 'statement2', '2.2 Demonstrates contributions toward solidarity', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(12, 51, 'Maka-Kalikasan', 'statement1', '3.1 Cares for the environment and utilizes resources wisely, judiciously, and economically', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(13, 51, 'Maka-bansa', 'statement1', '4.1 Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13'),
(14, 51, 'Maka-bansa', 'statement2', '4.2 Demonstrates appropriate behavior in carrying out activities in the school, community, and country', 'SO', NULL, 4, 1, 66, '2026-03-31 08:49:13', '2026-03-31 08:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('new','continuing','transferee') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','enrolled','rejected','unenrolled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `previous_school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_division` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `school_year_id`, `grade_level_id`, `student_id`, `section_id`, `type`, `status`, `previous_school`, `school_name`, `school_id`, `school_district`, `school_division`, `school_region`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(36, 1, 3, 49, 2, 'continuing', 'enrolled', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-03-30', '2026-03-30 15:38:02', '2026-03-30 17:22:17'),
(37, 1, 3, 50, 2, 'transferee', 'enrolled', 'Cantil-e Elementary School', 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-03-30', '2026-03-30 15:41:29', '2026-03-30 17:22:07'),
(38, 1, 3, 51, 2, 'transferee', 'enrolled', 'Dauin Central Elementary School', 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-03-30', '2026-03-30 15:43:42', '2026-03-30 17:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `quarter` int NOT NULL,
  `component_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scores` json DEFAULT NULL,
  `titles` json DEFAULT NULL,
  `total_items` json DEFAULT NULL,
  `total_score` int DEFAULT NULL,
  `percentage_score` decimal(5,2) DEFAULT NULL,
  `ww_weighted` decimal(5,2) DEFAULT NULL,
  `pt_weighted` decimal(5,2) DEFAULT NULL,
  `qe_weighted` decimal(5,2) DEFAULT NULL,
  `initial_grade` decimal(5,2) DEFAULT NULL,
  `final_grade` int DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `section_id`, `student_id`, `school_year_id`, `subject_id`, `quarter`, `component_type`, `scores`, `titles`, `total_items`, `total_score`, `percentage_score`, `ww_weighted`, `pt_weighted`, `qe_weighted`, `initial_grade`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES
(70, 2, 49, 1, 11, 1, 'written_work', '[\"18\", \"30\", \"15\"]', '[\"Unang Pagsusulit\", \"Pangalawang Pagsusulit\", \"Pangatlong Pagsusulit\"]', '[\"20\", \"35\", \"15\"]', 63, 90.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(71, 2, 50, 1, 11, 1, 'written_work', '[\"17\", \"34\", \"12\"]', '[\"Unang Pagsusulit\", \"Pangalawang Pagsusulit\", \"Pangatlong Pagsusulit\"]', '[\"20\", \"35\", \"15\"]', 63, 90.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(72, 2, 51, 1, 11, 1, 'written_work', '[\"19\", \"32\", \"14\"]', '[\"Unang Pagsusulit\", \"Pangalawang Pagsusulit\", \"Pangatlong Pagsusulit\"]', '[\"20\", \"35\", \"15\"]', 65, 92.86, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(73, 2, 49, 1, 11, 1, 'performance_task', '[\"98\", \"45\"]', '[\"Debate\", \"Dula-dulaan\"]', '[\"100\", \"50\"]', 143, 95.33, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(74, 2, 50, 1, 11, 1, 'performance_task', '[\"98\", \"45\"]', '[\"Debate\", \"Dula-dulaan\"]', '[\"100\", \"50\"]', 143, 95.33, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(75, 2, 51, 1, 11, 1, 'performance_task', '[\"97\", \"46\"]', '[\"Debate\", \"Dula-dulaan\"]', '[\"100\", \"50\"]', 143, 95.33, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(76, 2, 49, 1, 11, 1, 'quarterly_exam', NULL, NULL, NULL, 30, 30.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(77, 2, 50, 1, 11, 1, 'quarterly_exam', NULL, NULL, NULL, 28, 28.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(78, 2, 51, 1, 11, 1, 'quarterly_exam', NULL, NULL, NULL, 29, 29.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(79, 2, 49, 1, 11, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 36.00, 38.13, 6.00, 80.13, 87, 'Passed', '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(80, 2, 50, 1, 11, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 36.00, 38.13, 5.60, 79.73, 87, 'Passed', '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(81, 2, 51, 1, 11, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 37.14, 38.13, 5.80, 81.08, 88, 'Passed', '2026-03-30 23:25:34', '2026-03-31 00:21:58'),
(82, 2, 49, 1, 12, 1, 'written_work', '[\"16\"]', '[\"Chapter 1 Quiz\"]', '[\"20\"]', 16, 80.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(83, 2, 50, 1, 12, 1, 'written_work', '[\"20\"]', '[\"Chapter 1 Quiz\"]', '[\"20\"]', 20, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(84, 2, 51, 1, 12, 1, 'written_work', '[\"17\"]', '[\"Chapter 1 Quiz\"]', '[\"20\"]', 17, 85.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(85, 2, 49, 1, 12, 1, 'performance_task', '[\"30\"]', '[\"Reporting Chapter 1\"]', '[\"35\"]', 30, 85.71, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(86, 2, 50, 1, 12, 1, 'performance_task', '[\"32\"]', '[\"Reporting Chapter 1\"]', '[\"35\"]', 32, 91.43, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(87, 2, 51, 1, 12, 1, 'performance_task', '[\"28\"]', '[\"Reporting Chapter 1\"]', '[\"35\"]', 28, 80.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(88, 2, 49, 1, 12, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 32.00, 34.28, 0.00, 66.28, 78, 'Passed', '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(89, 2, 50, 1, 12, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 40.00, 36.57, 0.00, 76.57, 85, 'Passed', '2026-03-31 00:23:26', '2026-03-31 00:23:26'),
(90, 2, 51, 1, 12, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 34.00, 32.00, 0.00, 66.00, 78, 'Passed', '2026-03-31 00:23:26', '2026-03-31 00:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `grade_levels`
--

CREATE TABLE `grade_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_final` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_levels`
--

INSERT INTO `grade_levels` (`id`, `name`, `order`, `is_final`, `created_at`, `updated_at`) VALUES
(1, 'Kindergarten', 0, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(2, 'Grade 1', 1, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(3, 'Grade 2', 2, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(4, 'Grade 3', 3, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(5, 'Grade 4', 4, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(6, 'Grade 5', 5, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29'),
(7, 'Grade 6', 6, 0, '2026-03-22 00:42:29', '2026-03-22 00:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `interventions`
--

CREATE TABLE `interventions` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `recipient_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_27_123811_create_roles_table', 2),
(5, '2026_01_27_123927_add_role_id_to_users_table', 3),
(6, '2026_01_27_125206_create_students_table', 4),
(7, '2026_01_27_131235_create_attendance_records_table', 5),
(8, '2026_01_27_131235_create_attendances_table', 5),
(9, '2026_01_27_132003_create_subjects_table', 6),
(10, '2026_01_27_132004_create_grades_table', 6),
(11, '2026_01_28_012026_add_student_fields_to_users_table', 7),
(12, '2026_01_29_022208_make_user_id_nullable_in_students_table', 8),
(13, '2026_01_29_045644_add_capacity_to_sections_table', 9),
(14, '2026_01_29_052644_make_teacher_id_nullable_in_sections_table', 10),
(15, '2026_01_29_061618_create_year_levels_table', 11),
(16, '2026_03_22_082248_create_sections_table', 12),
(17, '2026_03_22_082453_create_teachers_table', 13),
(18, '2026_03_22_083431_create_school_years_table', 14),
(19, '2026_03_22_083720_add_status_to_teachers_table', 15),
(20, '2026_03_22_083831_create_attendances_table', 16),
(21, '2026_03_22_084113_create_grade_levels_table', 17),
(22, '2026_03_22_084335_add_grade_level_id_to_students_table', 18),
(23, '2026_03_22_084622_create_events_table', 19),
(24, '2026_03_22_090159_add_deleted_at_to_teachers_table', 20),
(25, '2026_03_22_090829_create_teachers_table', 21),
(26, '2026_03_22_091229_create_teacher_sections_table', 22),
(27, '2026_03_22_091444_create_subjects_table', 23),
(28, '2026_03_22_091735_create_students_table', 24),
(29, '2026_03_22_091909_create_sections_table', 25),
(30, '2026_03_22_092922_add_photo_to_users_table', 26),
(31, '2026_03_22_093244_add_is_active_to_users_table', 27),
(32, '2026_03_22_095546_create_school_years_table', 28),
(33, '2026_03_22_100125_create_teacher_sections_table', 29),
(34, '2026_03_22_131029_create_settings_table', 30),
(35, '2026_03_22_133230_create_settings_table', 31),
(36, '2026_03_22_152104_create_notifications_table', 32),
(37, '2026_03_22_152737_create_interventions_table', 33),
(38, '2026_03_23_000232_add_settings_to_users_table', 34),
(39, '2026_03_23_004512_create_enrollments_table', 35),
(40, '2026_03_23_012202_add_quarter_to_grades_table', 36),
(41, '2026_03_23_012441_add_final_grade_to_grades_table', 37),
(42, '2026_03_23_083656_add_is_active_to_sections_table', 38),
(43, '2026_03_23_101314_create_enrollments_table', 39),
(44, '2026_03_23_102648_add_order_and_is_final_to_grade_levels_table', 40),
(45, '2026_03_23_104611_add_school_year_id_to_enrollments_table', 41),
(46, '2026_03_23_104754_add_status_to_enrollments_table', 42),
(47, '2026_03_23_112520_add_grade_level_id_to_enrollments_table', 43),
(48, '2026_03_23_112703_make_section_id_nullable_in_enrollments_table', 44),
(49, '2026_03_23_112851_make_school_year_id_nullable_in_enrollments_table', 45),
(50, '2026_03_23_130926_create_announcements_table', 46),
(51, '2026_03_25_133643_add_status_to_users_table', 47),
(52, '2026_03_25_144324_create_attendances_table', 48),
(53, '2026_03_25_145116_add_section_id_to_grades_table', 49),
(54, '2026_03_26_071057_create_assignments_table', 50),
(55, '2026_03_26_071231_create_submissions_table', 51),
(56, '2026_03_26_071336_create_schedules_table', 52),
(57, '2026_03_26_071500_create_messages_table', 53),
(58, '2026_03_26_071708_add_grade_level_to_announcements_table', 54),
(59, '2026_03_26_071923_add_grade_level_id_to_announcements_table', 55),
(60, '2026_03_26_072145_create_activities_table', 56),
(61, '2026_03_26_072359_create_section_subject_table', 57),
(62, '2026_03_26_072500_create_achievements_table', 58),
(63, '2026_03_26_075823_add_status_to_assignments_table', 59),
(64, '2026_03_26_075940_add_is_read_to_messages_table', 60),
(65, '2026_03_26_080111_add_target_and_is_read_to_announcements_table', 61),
(66, '2026_03_26_120432_add_remarks_to_attendances_table', 62),
(67, '2026_03_26_131646_add_grade_level_id_to_subjects_table', 63),
(68, '2026_03_27_101054_add_component_type_to_grades_table', 64),
(69, '2026_03_27_101933_add_scores_to_grades_table', 65),
(70, '2026_03_27_102151_create_grades_table', 66),
(71, '2026_03_27_143342_add_school_year_id_to_events_table', 67),
(72, '2026_03_28_001923_recreate_settings_table', 68),
(73, '2026_03_28_014639_add_mother_tongue_and_ethnicity_to_students_table', 69),
(74, '2026_03_28_022845_add_remarks_to_students_table', 70),
(75, '2026_03_28_092543_add_school_year_id_to_grades_table', 71),
(76, '2026_03_28_092842_add_school_year_id_to_attendances_table', 72),
(77, '2026_03_28_101329_add_school_info_to_enrollments_table', 73),
(78, '2026_03_28_131208_create_books_table', 74),
(79, '2026_03_29_120432_create_school_year_qr_codes_table', 75),
(80, '2026_03_31_014936_add_titles_to_grades_table', 76),
(81, '2026_03_31_021001_add_total_items_to_grades_table', 77),
(82, '2026_03_31_080328_add_teacher_id_to_attendances_table', 78),
(83, '2026_03_31_122932_create_school_core_value_ratings_table', 79),
(84, '2026_03_31_132410_create_core_values_table', 80),
(85, '2026_03_31_133829_create_core_values_table', 81),
(86, '2026_03_31_163036_add_statement_key_to_core_values_table', 82),
(87, '2026_03_31_164346_create_core_values_table', 83);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(2, 'Teacher', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(3, 'Registrar', '2026-01-27 04:41:10', '2026-01-27 04:41:10'),
(4, 'Student', '2026-01-27 04:41:10', '2026-01-27 04:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `name`, `start_date`, `end_date`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
(1, '2026-2027', '2026-06-01', NULL, 1, 'School year 2026-2027 (current)', '2026-03-22 01:56:23', '2026-03-29 06:16:14'),
(2, '2027-2028', '2027-06-01', NULL, 0, 'School year 2027-2028', '2026-03-22 01:56:23', '2026-03-29 06:16:14'),
(3, '2028-2029', '2028-06-01', NULL, 0, 'School year 2028-2029', '2026-03-22 01:56:23', '2026-03-29 05:31:10'),
(4, '2029-2030', '2029-06-01', NULL, 0, 'School year 2029-2030', '2026-03-22 01:56:23', '2026-03-29 05:39:53'),
(5, '2030-2031', '2030-06-01', '2031-03-31', 0, 'School year 2030-2031', '2026-03-22 01:56:23', '2026-03-29 05:39:43'),
(6, '2031-2032', '2031-06-01', '2032-03-31', 0, 'School year 2031-2032', '2026-03-22 01:56:23', '2026-03-29 05:36:58'),
(7, '2032-2033', '2032-06-01', '2033-03-31', 0, 'School year 2032-2033', '2026-03-22 01:56:23', '2026-03-29 05:36:51'),
(8, '2033-2034', '2033-06-01', '2034-03-31', 0, 'School year 2033-2034', '2026-03-22 01:56:23', '2026-03-29 05:36:44'),
(9, '2034-2035', '2034-06-01', '2035-03-31', 0, 'School year 2034-2035', '2026-03-22 01:56:23', '2026-03-29 05:36:37'),
(10, '2035-2036', '2035-06-01', '2036-03-31', 0, 'School year 2035-2036', '2026-03-22 01:56:23', '2026-03-29 05:36:29'),
(11, '2036-2037', '2036-06-01', '2037-03-31', 0, 'School year 2036-2037', '2026-03-22 01:56:23', '2026-03-29 05:36:23'),
(12, '2037-2038', '2037-06-01', '2038-03-31', 0, 'School year 2037-2038', '2026-03-22 01:56:23', '2026-03-29 05:36:01'),
(13, '2038-2039', '2038-06-01', '2039-03-31', 0, 'School year 2038-2039', '2026-03-22 01:56:23', '2026-03-29 05:36:07'),
(14, '2039-2040', '2039-06-01', '2040-03-31', 0, 'School year 2039-2040', '2026-03-22 01:56:23', '2026-03-29 05:40:01'),
(15, '2040-2041', '2040-06-01', '2041-03-31', 0, NULL, '2026-03-29 06:22:51', '2026-03-29 06:22:51'),
(16, '2041-2042', '2041-06-01', '2042-03-31', 0, 'School Year 2041-2042', '2026-03-29 06:25:27', '2026-03-29 06:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `school_year_qr_codes`
--

CREATE TABLE `school_year_qr_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `qr_code_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_year_qr_codes`
--

INSERT INTO `school_year_qr_codes` (`id`, `school_year_id`, `qr_code_token`, `qr_code_image_path`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(22, 4, 'Xe0iTamWc1gNVjIn8yDza2DzCDlzNKNO', 'qr-codes/school-year-4-Xe0iTamWc1gNVjIn8yDza2DzCDlzNKNO.png', 1, '2027-03-29 13:39:44', '2026-03-29 05:39:44', '2026-03-29 05:39:44'),
(23, 14, 'E1sRrJHavkR9SUlLtZ0sHTn75yFvnmqe', 'qr-codes/school-year-14-E1sRrJHavkR9SUlLtZ0sHTn75yFvnmqe.png', 1, '2037-12-31 23:59:59', '2026-03-29 05:39:53', '2026-03-29 05:39:53'),
(24, 1, '2qwMAzhckzlPSFRuBcPjzyhqcDG2HnIr', 'qr-codes/school-year-1-2qwMAzhckzlPSFRuBcPjzyhqcDG2HnIr.png', 0, '2027-03-29 13:40:01', '2026-03-29 05:40:01', '2026-03-30 05:12:49'),
(25, 2, 'Qwt2TlIYUxbM4fpa4f1pOvy84K805YXG', 'qr-codes/school-year-2-Qwt2TlIYUxbM4fpa4f1pOvy84K805YXG.png', 1, '2027-03-29 14:15:58', '2026-03-29 06:15:58', '2026-03-29 06:15:58'),
(26, 1, 'XGnQOVvpX2absJCSu7ygw1oYe2TpY8u5', 'qr-codes/school-year-1-XGnQOVvpX2absJCSu7ygw1oYe2TpY8u5.png', 0, '2027-03-29 14:16:14', '2026-03-29 06:16:14', '2026-03-30 05:12:49'),
(27, 1, '8q3YZalduggjJ6OBKUTprXbLcHkAA5Ks', 'qr-codes/school-year-1-8q3YZalduggjJ6OBKUTprXbLcHkAA5Ks.png', 0, '2027-03-30 12:27:01', '2026-03-30 04:27:01', '2026-03-30 05:12:49'),
(28, 1, 'jlOeTGUAtvhTdjlzWZ4ksm8ds71dnn2o', 'qr-codes/school-year-1-jlOeTGUAtvhTdjlzWZ4ksm8ds71dnn2o.png', 1, '2027-03-30 13:12:49', '2026-03-30 05:12:49', '2026-03-30 05:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `room_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `grade_level_id`, `school_year_id`, `room_number`, `teacher_id`, `capacity`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'SALAS', 2, 1, 'ROOM101', NULL, 40, '2026-03-22 02:05:23', '2026-03-22 02:05:23', 1),
(2, 'ROSE', 4, 1, 'ROOM102', 8, 40, '2026-03-22 23:10:06', '2026-03-30 15:44:57', 1),
(3, 'MENDES', 3, 1, 'ROOM103', 9, 40, '2026-03-27 03:14:07', '2026-03-27 03:14:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `section_subject`
--

CREATE TABLE `section_subject` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MS9vjGAh0omQWjhR9fAhs6xI0hHWu8APySHi90Ob', 66, '192.168.0.198', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFVhYURwVFFja1dPQkV3MDhZeTZMNmRSZTZXa1JJWGxuOXBkdVVNdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xOTIuMTY4LjAuMTk4OjgwMDAvdGVhY2hlci9zZWN0aW9ucy8yL2NvcmUtdmFsdWVzIjtzOjU6InJvdXRlIjtzOjM0OiJ0ZWFjaGVyLnNlY3Rpb25zLmNvcmUtdmFsdWVzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjY7fQ==', 1774976339);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_editable` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `is_public`, `is_editable`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'system_name', 'Tugawe ES - SMS', 'string', 'general', 'System name', 0, 1, 0, NULL, NULL),
(2, 'school_name', 'Tugawe Elementary School', 'string', 'school', 'Official school name', 0, 1, 0, NULL, NULL),
(3, 'deped_school_id', '120231', 'string', 'school', 'DepEd school ID', 0, 1, 0, NULL, NULL),
(4, 'school_division', 'Division of Negros Oriental', 'string', 'school', 'Division', 0, 1, 0, NULL, NULL),
(5, 'school_region', 'NIR - Negros Island Region', 'string', 'school', 'Region', 0, 1, 0, NULL, NULL),
(6, 'school_head', 'MAE HARRIET M. DELA PEÑA', 'string', 'school', 'Principal', 0, 1, 0, NULL, NULL),
(7, 'active_school_year_id', '1', 'integer', 'academic', 'Active school year ID', 0, 1, 0, NULL, NULL),
(8, 'passing_grade', '75', 'integer', 'academic', 'Passing grade', 0, 1, 0, NULL, NULL),
(9, 'school_district', 'Dauin District', 'string', 'school', 'School District', 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `lrn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birth_place` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_tongue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ethnicity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_relationship` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_contact` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','enrolled','rejected','unenrolled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `lrn`, `birthdate`, `birth_place`, `gender`, `mother_tongue`, `ethnicity`, `nationality`, `religion`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `guardian_name`, `guardian_relationship`, `guardian_contact`, `street_address`, `barangay`, `city`, `province`, `zip_code`, `status`, `grade_level_id`, `section_id`, `photo`, `created_at`, `updated_at`, `school_year_id`, `remarks`) VALUES
(49, 78, '120231260000', '2004-01-07', 'Dauin', 'Male', 'Bisaya', 'Negrense', 'Filipino', 'Roman Catholic', 'Nelson A. Tuayon', 'Farmer', 'Agripina B. Tuayon', 'Farmer', 'Nelson A. Tuayon', 'Parent', '09368726547', 'Purok 5', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 'enrolled', 3, 2, NULL, '2026-03-30 15:38:02', '2026-03-30 17:22:17', NULL, NULL),
(50, 79, '120231260001', '2003-11-06', 'Bayawan City', 'Female', 'Bisaya', 'Negrense', 'Filipino', 'Roman Catholic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purok Twin Hearts', 'Cantil-e', 'Dumaguete City', 'Negros Oriental', '6200', 'enrolled', 3, 2, NULL, '2026-03-30 15:41:29', '2026-03-30 17:22:07', NULL, NULL),
(51, 80, '120231260002', '2003-10-31', 'Dauin', 'Female', 'Bisaya', 'Negrense', 'Filipino', 'Christianity', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LUCA', 'LIPAYO', 'Dauin', 'Negros Oriental', '6217', 'enrolled', 3, 2, NULL, '2026-03-30 15:43:42', '2026-03-30 17:21:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `grade_level_id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mathematics', 'MATH1', 'Grade 1 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(2, 2, 'Good Manners and Right Conduct', 'GMRC1', 'Grade 1 subject: Good Manners and Right Conduct', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(3, 2, 'Language', 'LANG1', 'Grade 1 subject: Language', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(4, 2, 'Reading and Literacy', 'READ1', 'Grade 1 subject: Reading and Literacy', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(5, 2, 'Makabansa', 'MAKA1', 'Grade 1 subject: Makabansa', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(6, 3, 'Filipino', 'FIL2', 'Grade 2 subject: Filipino', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(7, 3, 'English', 'ENG2', 'Grade 2 subject: English', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(8, 3, 'Mathematics', 'MATH2', 'Grade 2 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(9, 3, 'Makabansa', 'MAKA2', 'Grade 2 subject: Makabansa', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(10, 3, 'Good Manners and Right Conduct', 'GMRC2', 'Grade 2 subject: Good Manners and Right Conduct', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(11, 4, 'Filipino', 'FIL3', 'Grade 3 subject: Filipino', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(12, 4, 'English', 'ENG3', 'Grade 3 subject: English', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(13, 4, 'Mathematics', 'MATH3', 'Grade 3 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(14, 4, 'Science', 'SCI3', 'Grade 3 subject: Science', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(15, 4, 'Makabansa', 'MAKA3', 'Grade 3 subject: Makabansa', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(16, 4, 'Good Manners and Right Conduct', 'GMRC3', 'Grade 3 subject: Good Manners and Right Conduct', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(17, 5, 'Filipino', 'FIL4', 'Grade 4 subject: Filipino', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(18, 5, 'English', 'ENG4', 'Grade 4 subject: English', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(19, 5, 'Mathematics', 'MATH4', 'Grade 4 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(20, 5, 'Science', 'SCI4', 'Grade 4 subject: Science', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(21, 5, 'Araling Panlipunan', 'AP4', 'Grade 4 subject: Araling Panlipunan', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(22, 5, 'Music, Arts, Physical Education, Health', 'MAPEH4', 'Grade 4 subject: Music, Arts, Physical Education, Health', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(23, 5, 'Edukasyong Pantahanan at Pangkabuhayan', 'EPP4', 'Grade 4 subject: Edukasyong Pantahanan at Pangkabuhayan', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(24, 5, 'Good Manners and Right Conduct', 'GMRC4', 'Grade 4 subject: Good Manners and Right Conduct', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(25, 6, 'Filipino', 'FIL5', 'Grade 5 subject: Filipino', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(26, 6, 'English', 'ENG5', 'Grade 5 subject: English', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(27, 6, 'Mathematics', 'MATH5', 'Grade 5 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(28, 6, 'Science', 'SCI5', 'Grade 5 subject: Science', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(29, 6, 'Araling Panlipunan', 'AP5', 'Grade 5 subject: Araling Panlipunan', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(30, 6, 'Music, Arts, Physical Education, Health', 'MAPEH5', 'Grade 5 subject: Music, Arts, Physical Education, Health', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(31, 6, 'Edukasyong Pantahanan at Pangkabuhayan', 'EPP5', 'Grade 5 subject: Edukasyong Pantahanan at Pangkabuhayan', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(32, 6, 'Good Manners and Right Conduct', 'GMRC5', 'Grade 5 subject: Good Manners and Right Conduct', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(33, 7, 'Filipino', 'FIL6', 'Grade 6 subject: Filipino', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(34, 7, 'English', 'ENG6', 'Grade 6 subject: English', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(35, 7, 'Mathematics', 'MATH6', 'Grade 6 subject: Mathematics', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(36, 7, 'Science', 'SCI6', 'Grade 6 subject: Science', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(37, 7, 'Araling Panlipunan', 'AP6', 'Grade 6 subject: Araling Panlipunan', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(38, 7, 'Music, Arts, Physical Education, Health', 'MAPEH6', 'Grade 6 subject: Music, Arts, Physical Education, Health', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(39, 7, 'Technology and Livelihood Education', 'TLE6', 'Grade 6 subject: Technology and Livelihood Education', '2026-03-26 05:02:34', '2026-03-26 05:02:34'),
(40, 7, 'Edukasyon sa Pagpapakatao', 'ESP6', 'Grade 6 subject: Edukasyon sa Pagpapakatao', '2026-03-26 05:02:34', '2026-03-26 05:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `assignment_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deped_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_municipality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_relationship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_address` text COLLATE utf8mb4_unicode_ci,
  `employment_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `date_regularized` date DEFAULT NULL,
  `current_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teaching_level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_class_adviser` tinyint(1) NOT NULL DEFAULT '0',
  `advisory_class` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_graduated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_graduated` int DEFAULT NULL,
  `honors_received` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prc_license_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prc_license_validity` date DEFAULT NULL,
  `let_passer` tinyint(1) NOT NULL DEFAULT '0',
  `board_rating` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tesda_nc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tesda_sector` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_of_experience` int DEFAULT NULL,
  `previous_school` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_position` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gsis_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagibig_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `philhealth_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sss_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagibig_rtn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_grade` int DEFAULT NULL,
  `step_increment` int DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `bank_account_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_contact` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_children` int DEFAULT NULL,
  `father_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_conditions` text COLLATE utf8mb4_unicode_ci,
  `medications` text COLLATE utf8mb4_unicode_ci,
  `covid_vaccinated` tinyint(1) NOT NULL DEFAULT '0',
  `covid_vaccine_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `covid_vaccine_date` date DEFAULT NULL,
  `photo_path` text COLLATE utf8mb4_unicode_ci,
  `resume_path` text COLLATE utf8mb4_unicode_ci,
  `prc_id_path` text COLLATE utf8mb4_unicode_ci,
  `transcript_path` text COLLATE utf8mb4_unicode_ci,
  `clearance_path` text COLLATE utf8mb4_unicode_ci,
  `medical_cert_path` text COLLATE utf8mb4_unicode_ci,
  `nbi_clearance_path` text COLLATE utf8mb4_unicode_ci,
  `service_record_path` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','on_leave','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_id`, `deped_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `date_of_birth`, `place_of_birth`, `gender`, `civil_status`, `nationality`, `religion`, `blood_type`, `email`, `mobile_number`, `telephone_number`, `street_address`, `barangay`, `city_municipality`, `province`, `zip_code`, `region`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_number`, `emergency_contact_address`, `employment_status`, `date_hired`, `date_regularized`, `current_status`, `teaching_level`, `position`, `designation`, `is_class_adviser`, `advisory_class`, `department`, `highest_education`, `degree_program`, `major`, `minor`, `school_graduated`, `year_graduated`, `honors_received`, `prc_license_number`, `prc_license_validity`, `let_passer`, `board_rating`, `tesda_nc`, `tesda_sector`, `years_of_experience`, `previous_school`, `previous_position`, `gsis_id`, `pagibig_id`, `philhealth_id`, `sss_id`, `tin_id`, `pagibig_rtn`, `salary_grade`, `step_increment`, `basic_salary`, `bank_account_number`, `bank_name`, `spouse_name`, `spouse_occupation`, `spouse_contact`, `number_of_children`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `medical_conditions`, `medications`, `covid_vaccinated`, `covid_vaccine_type`, `covid_vaccine_date`, `photo_path`, `resume_path`, `prc_id_path`, `transcript_path`, `clearance_path`, `medical_cert_path`, `nbi_clearance_path`, `service_record_path`, `user_id`, `last_login_at`, `ip_address`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`, `school_year_id`) VALUES
(8, NULL, NULL, 'Maria', 'Carreon', 'Santos', NULL, '1998-10-10', 'Dauin', 'female', 'single', 'Filipino', 'Roman Catholic', 'AB-', 'mariasan@gmail.com', '0936 872 6547', NULL, 'Elithon', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 'NIR', NULL, NULL, NULL, NULL, 'substitute', NULL, NULL, 'Active', 'I', 'Teacher 1', NULL, 0, NULL, NULL, 'bachelor', 'BEED', NULL, NULL, 'NORSU', 2016, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 66, NULL, NULL, NULL, 'active', NULL, '2026-03-25 02:22:47', '2026-03-27 03:13:25', 1),
(9, NULL, NULL, 'Shane', NULL, 'Mendes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'msmendes@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 70, NULL, NULL, NULL, 'active', NULL, '2026-03-27 03:13:09', '2026-03-27 03:13:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_sections`
--

CREATE TABLE `teacher_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subject`
--

CREATE TABLE `teacher_subject` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `school_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `room` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` json DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lrn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `status`, `email`, `email_verified_at`, `password`, `photo`, `is_active`, `remember_token`, `settings`, `two_factor_enabled`, `two_factor_secret`, `two_factor_recovery_codes`, `created_at`, `updated_at`, `lrn`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `username`) VALUES
(1, 1, 'active', 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', NULL, 1, 'BU6pTeBlJvlsPdL0WP0Iz1j9tqUcyIkTYchsl26a1abQw5moL83M1X5Sl61C', NULL, 0, NULL, NULL, '2026-01-27 05:37:20', '2026-03-25 06:21:45', NULL, 'TES', NULL, 'ADMIN', NULL, NULL, 'sysadmin'),
(2, 3, 'active', 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', NULL, 1, 'YrC7y5PHO5Xp4frRjM1cutO36L5FcQK10AAjebcQz46PDBmtxNVsVS9CcL9G', NULL, 0, NULL, NULL, '2026-01-27 05:37:21', '2026-01-27 05:37:21', NULL, '', NULL, '', NULL, NULL, ''),
(4, 4, 'active', 'student@tugaweES.edu.ph', NULL, '$2y$12$WIxeJEYWoAGnKxkiWIWT7uT1s6Owua0cZUsWGVVO1Zs/dImzr.8ee', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-01-27 05:37:22', '2026-01-27 05:37:22', NULL, '', NULL, '', NULL, NULL, ''),
(13, 2, 'active', 'teacher@tugaweES.edu.ph', NULL, '$2y$12$I703bY65xDMTGUJ/NA1hYuoccRQRYjy7INoW2feSbrdmlKoqmEbTO', NULL, 1, NULL, '{\"theme\": \"dark\", \"language\": \"ceb\", \"date_format\": \"MM/DD/YYYY\", \"time_format\": \"12h\", \"system_updates\": \"1\", \"grade_reminders\": \"1\", \"profile_visible\": \"1\", \"show_last_active\": \"1\", \"attendance_alerts\": \"1\", \"sms_notifications\": \"0\", \"email_notifications\": \"1\", \"email_visible_to_students\": \"0\", \"new_student_notifications\": \"0\"}', 0, NULL, NULL, '2026-01-28 21:57:58', '2026-03-22 16:33:32', NULL, 'Teacher', NULL, 'User', NULL, NULL, 'teacheruser1'),
(66, 2, 'active', 'mariasan@gmail.com', NULL, '$2y$12$3kEcB2mHyjA0b0SFLTlhfeVAFFhMXgKZSzPPX0zvJ7QQStLjJVvbS', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 02:22:47', '2026-03-25 02:22:47', NULL, 'Maria', NULL, 'Santos', NULL, NULL, 'msmaria'),
(68, 1, 'active', 'admin123@gmail.com', NULL, '$2y$12$TUqAbwYAVzJkHjkxiwa3peAV2mq7ctJhndKfwpBWb7lZBlocE5TPa', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 05:21:01', '2026-03-27 21:57:33', NULL, 'System', NULL, 'Admin', NULL, NULL, 'mysysad12'),
(70, 2, 'active', 'msmendes@gmail.com', NULL, '$2y$12$ws3zhjWNpiifRIzw9fbZgeVbItUrVD3anY5QCm1anpXuOT7q5xNZm', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-27 03:13:09', '2026-03-27 03:13:09', NULL, 'Shane', NULL, 'Mendes', NULL, NULL, 'msmendes'),
(78, 4, 'active', 'cresttuayon@gmail.com', NULL, '$2y$12$4TU7dGYm8r8WWS64tbTL4utkyo5.hUwvtkyPiOWaqXw6IX/FiJrhu', NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-03-30 15:38:02', '2026-03-30 15:38:02', NULL, 'Crestian', 'Bajado', 'Tuayon', NULL, NULL, 'crstn'),
(79, 4, 'active', 'baldomarnoime@gmail.com', '2026-03-30 15:41:29', '$2y$12$yH8PSsDHiEMvH6FTvoXTVufh8XOVM9TErEkZyQpr/Zu5mxaDMfpE.', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-30 15:41:29', '2026-03-30 15:41:29', NULL, 'Noime', 'Talorete', 'Baldomar', NULL, NULL, 'evarocksredhell'),
(80, 4, 'active', 'ejiemaestradio@gmail.com', '2026-03-30 15:43:42', '$2y$12$pueqWoPzq.26UBAaqKMDOe8pfU0xKnUpcI6E8ZjwFVuMnXGv2futS', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-30 15:43:42', '2026-03-30 15:43:42', NULL, 'Ejie Mae', 'Santos', 'Tradio', NULL, NULL, 'ezimei');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievements_student_id_foreign` (`student_id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_student_id_foreign` (`student_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_grade_level_id_foreign` (`grade_level_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignments_section_id_foreign` (`section_id`),
  ADD KEY `assignments_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_section_id_foreign` (`section_id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_school_year_id_foreign` (`school_year_id`),
  ADD KEY `attendances_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_issuances`
--
ALTER TABLE `book_issuances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_active_issuance` (`student_id`,`book_id`,`school_year_id`),
  ADD KEY `book_issuances_book_id_foreign` (`book_id`),
  ADD KEY `book_issuances_school_year_id_foreign` (`school_year_id`),
  ADD KEY `book_issuances_section_id_foreign` (`section_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `core_values_unique_full` (`student_id`,`core_value`,`statement_key`,`quarter`,`school_year_id`),
  ADD KEY `core_values_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_student_id_foreign` (`student_id`),
  ADD KEY `enrollments_section_id_foreign` (`section_id`),
  ADD KEY `enrollments_school_year_id_foreign` (`school_year_id`),
  ADD KEY `enrollments_grade_level_id_foreign` (`grade_level_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_grade_record` (`section_id`,`student_id`,`subject_id`,`quarter`,`component_type`),
  ADD KEY `grades_student_id_foreign` (`student_id`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`),
  ADD KEY `grades_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `grade_levels`
--
ALTER TABLE `grade_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interventions`
--
ALTER TABLE `interventions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interventions_teacher_id_foreign` (`teacher_id`),
  ADD KEY `interventions_student_id_foreign` (`student_id`),
  ADD KEY `interventions_subject_id_foreign` (`subject_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_recipient_id_foreign` (`recipient_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_section_id_foreign` (`section_id`),
  ADD KEY `schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `schedules_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_year_qr_codes`
--
ALTER TABLE `school_year_qr_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_year_qr_codes_qr_code_token_unique` (`qr_code_token`),
  ADD KEY `school_year_qr_codes_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `sections_school_year_id_foreign` (`school_year_id`),
  ADD KEY `sections_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `section_subject`
--
ALTER TABLE `section_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_subject_section_id_foreign` (`section_id`),
  ADD KEY `section_subject_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_lrn_unique` (`lrn`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `students_section_id_foreign` (`section_id`),
  ADD KEY `students_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`),
  ADD KEY `subjects_grade_level_id_foreign` (`grade_level_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submissions_assignment_id_foreign` (`assignment_id`),
  ADD KEY `submissions_student_id_foreign` (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`),
  ADD KEY `teachers_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `teacher_sections`
--
ALTER TABLE `teacher_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_sections_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_sections_section_id_foreign` (`section_id`);

--
-- Indexes for table `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_subject_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_lrn_unique` (`lrn`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_issuances`
--
ALTER TABLE `book_issuances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `grade_levels`
--
ALTER TABLE `grade_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `interventions`
--
ALTER TABLE `interventions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `school_year_qr_codes`
--
ALTER TABLE `school_year_qr_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `section_subject`
--
ALTER TABLE `section_subject`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teacher_sections`
--
ALTER TABLE `teacher_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_subject`
--
ALTER TABLE `teacher_subject`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `book_issuances`
--
ALTER TABLE `book_issuances`
  ADD CONSTRAINT `book_issuances_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issuances_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issuances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `book_issuances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `core_values`
--
ALTER TABLE `core_values`
  ADD CONSTRAINT `core_values_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `core_values_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enrollments_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grades_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interventions`
--
ALTER TABLE `interventions`
  ADD CONSTRAINT `interventions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_year_qr_codes`
--
ALTER TABLE `school_year_qr_codes`
  ADD CONSTRAINT `school_year_qr_codes_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `section_subject`
--
ALTER TABLE `section_subject`
  ADD CONSTRAINT `section_subject_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_sections`
--
ALTER TABLE `teacher_sections`
  ADD CONSTRAINT `teacher_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD CONSTRAINT `teacher_subject_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
