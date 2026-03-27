-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 26, 2026 at 07:09 AM
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
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
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
('tugawees-sms-cache-app_settings', 'a:31:{s:11:\"system_name\";s:24:\"Tugawe Elementary School\";s:8:\"timezone\";s:11:\"Asia/Manila\";s:11:\"date_format\";s:6:\"F d, Y\";s:16:\"default_language\";s:2:\"en\";s:16:\"maintenance_mode\";b:0;s:17:\"user_registration\";b:1;s:18:\"email_verification\";b:1;s:11:\"school_name\";s:24:\"Tugawe Elementary School\";s:11:\"school_code\";s:8:\"TES-2024\";s:15:\"deped_school_id\";s:0:\"\";s:14:\"school_address\";s:0:\"\";s:12:\"school_email\";s:0:\"\";s:12:\"school_phone\";s:0:\"\";s:19:\"current_school_year\";s:9:\"2024-2025\";s:14:\"grading_system\";s:9:\"quarterly\";s:13:\"passing_grade\";i:75;s:18:\"notify_new_student\";b:1;s:17:\"notify_attendance\";b:1;s:13:\"notify_grades\";b:1;s:11:\"sms_enabled\";b:0;s:19:\"min_password_length\";i:8;s:15:\"password_expiry\";i:90;s:16:\"strong_passwords\";b:1;s:15:\"session_timeout\";i:30;s:18:\"max_login_attempts\";i:5;s:13:\"primary_color\";s:7:\"#6366f1\";s:15:\"secondary_color\";s:7:\"#10b981\";s:9:\"dark_mode\";b:0;s:10:\"animations\";b:1;s:11:\"auto_backup\";b:0;s:11:\"last_backup\";s:5:\"Never\";}', 1774509645);

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
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('new','continuing','transferee') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','enrolled','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `previous_school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `school_year_id`, `grade_level_id`, `student_id`, `section_id`, `type`, `status`, `previous_school`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(27, 1, 2, 40, 2, 'continuing', 'enrolled', NULL, '2026-03-25', '2026-03-25 02:45:58', '2026-03-25 06:26:39');

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
  `updated_at` timestamp NULL DEFAULT NULL
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
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `quarter` tinyint NOT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `score` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(53, '2026_03_25_145116_add_section_id_to_grades_table', 49);

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
(1, '2026-2027', '2026-06-01', '2027-03-31', 1, 'School year 2026-2027 (current)', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(2, '2027-2028', '2027-06-01', '2028-03-31', 0, 'School year 2027-2028', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(3, '2028-2029', '2028-06-01', '2029-03-31', 0, 'School year 2028-2029', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(4, '2029-2030', '2029-06-01', '2030-03-31', 0, 'School year 2029-2030', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(5, '2030-2031', '2030-06-01', '2031-03-31', 0, 'School year 2030-2031', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(6, '2031-2032', '2031-06-01', '2032-03-31', 0, 'School year 2031-2032', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(7, '2032-2033', '2032-06-01', '2033-03-31', 0, 'School year 2032-2033', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(8, '2033-2034', '2033-06-01', '2034-03-31', 0, 'School year 2033-2034', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(9, '2034-2035', '2034-06-01', '2035-03-31', 0, 'School year 2034-2035', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(10, '2035-2036', '2035-06-01', '2036-03-31', 0, 'School year 2035-2036', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(11, '2036-2037', '2036-06-01', '2037-03-31', 0, 'School year 2036-2037', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(12, '2037-2038', '2037-06-01', '2038-03-31', 0, 'School year 2037-2038', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(13, '2038-2039', '2038-06-01', '2039-03-31', 0, 'School year 2038-2039', '2026-03-22 01:56:23', '2026-03-24 20:14:21'),
(14, '2039-2040', '2039-06-01', '2040-03-31', 0, 'School year 2039-2040', '2026-03-22 01:56:23', '2026-03-24 20:14:21');

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
(2, 'ROSE', 1, 1, 'ROOM102', 8, 40, '2026-03-22 23:10:06', '2026-03-25 02:23:13', 1);

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
('Ml3AK2KYksSMkYwNRU9EwqRLrYOf9gPIDj0o1ASR', 67, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjF2bmhZNXFCWkpNYWN3cFFQeUpycW1DTWZTa25leDJFWTdvTzFmdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoic3R1ZGVudC5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2Nzt9', 1774508912);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
(1, 'system_name', 'Tugawe Elementary School', 'string', 'general', 'The name of the system displayed throughout the application', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(2, 'timezone', 'Asia/Manila', 'string', 'general', 'Default timezone for the application', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(3, 'date_format', 'F d, Y', 'string', 'general', 'Format for displaying dates', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(4, 'default_language', 'en', 'string', 'general', 'Default language for the application', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(5, 'maintenance_mode', '0', 'boolean', 'general', 'Enable maintenance mode', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(6, 'user_registration', '1', 'boolean', 'general', 'Allow new user registration', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(7, 'email_verification', '1', 'boolean', 'general', 'Require email verification for new accounts', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(8, 'school_name', 'Tugawe Elementary School', 'string', 'school', 'Official name of the school', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(9, 'school_code', 'TES-2024', 'string', 'school', 'School code identifier', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(10, 'deped_school_id', '', 'string', 'school', 'DepEd assigned school ID', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(11, 'school_address', '', 'string', 'school', 'Complete school address', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(12, 'school_email', '', 'string', 'school', 'School contact email', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(13, 'school_phone', '', 'string', 'school', 'School contact phone number', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(14, 'current_school_year', '2024-2025', 'string', 'academic', 'Current active school year', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(15, 'grading_system', 'quarterly', 'string', 'academic', 'Grading period system', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(16, 'passing_grade', '75', 'integer', 'academic', 'Minimum passing grade percentage', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(17, 'notify_new_student', '1', 'boolean', 'notifications', 'Send email on new student enrollment', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(18, 'notify_attendance', '1', 'boolean', 'notifications', 'Notify parents of student absences', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(19, 'notify_grades', '1', 'boolean', 'notifications', 'Send notification when grades are published', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(20, 'sms_enabled', '0', 'boolean', 'notifications', 'Enable SMS notifications', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(21, 'min_password_length', '8', 'integer', 'security', 'Minimum required password length', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(22, 'password_expiry', '90', 'integer', 'security', 'Days until password expires (0 = never)', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(23, 'strong_passwords', '1', 'boolean', 'security', 'Require complex passwords', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(24, 'session_timeout', '30', 'integer', 'security', 'Session timeout in minutes', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(25, 'max_login_attempts', '5', 'integer', 'security', 'Maximum failed login attempts', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(26, 'primary_color', '#6366f1', 'string', 'appearance', 'Primary brand color', '2026-03-22 05:47:49', '2026-03-22 05:47:49'),
(27, 'secondary_color', '#10b981', 'string', 'appearance', 'Secondary accent color', '2026-03-22 05:47:50', '2026-03-22 05:47:50'),
(28, 'dark_mode', '0', 'boolean', 'appearance', 'Enable dark theme', '2026-03-22 05:47:50', '2026-03-22 05:47:50'),
(29, 'animations', '1', 'boolean', 'appearance', 'Enable UI animations', '2026-03-22 05:47:50', '2026-03-22 05:47:50'),
(30, 'auto_backup', '0', 'boolean', 'backup', 'Enable automatic daily backups', '2026-03-22 05:47:50', '2026-03-22 05:47:50'),
(31, 'last_backup', 'Never', 'string', 'backup', 'Last backup timestamp', '2026-03-22 05:47:50', '2026-03-22 05:47:50');

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
  `status` enum('pending','approved','enrolled','rejected','dropped','transferred') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `lrn`, `birthdate`, `birth_place`, `gender`, `nationality`, `religion`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `guardian_name`, `guardian_relationship`, `guardian_contact`, `street_address`, `barangay`, `city`, `province`, `zip_code`, `status`, `grade_level_id`, `section_id`, `photo`, `created_at`, `updated_at`) VALUES
(40, 67, '120231260000', '2004-01-07', 'Dauin', 'Male', 'Filipino', 'Christianity', 'Nelson A. Tuayon', 'Farmer', 'Agripina B. Tuayon', 'Farmer', 'Nelson A. Tuayon', 'Parent', '09368726547', 'Purok 5', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 'enrolled', 2, 2, NULL, '2026-03-25 02:45:58', '2026-03-25 06:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_id`, `deped_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `date_of_birth`, `place_of_birth`, `gender`, `civil_status`, `nationality`, `religion`, `blood_type`, `email`, `mobile_number`, `telephone_number`, `street_address`, `barangay`, `city_municipality`, `province`, `zip_code`, `region`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_number`, `emergency_contact_address`, `employment_status`, `date_hired`, `date_regularized`, `current_status`, `teaching_level`, `position`, `designation`, `is_class_adviser`, `advisory_class`, `department`, `highest_education`, `degree_program`, `major`, `minor`, `school_graduated`, `year_graduated`, `honors_received`, `prc_license_number`, `prc_license_validity`, `let_passer`, `board_rating`, `tesda_nc`, `tesda_sector`, `years_of_experience`, `previous_school`, `previous_position`, `gsis_id`, `pagibig_id`, `philhealth_id`, `sss_id`, `tin_id`, `pagibig_rtn`, `salary_grade`, `step_increment`, `basic_salary`, `bank_account_number`, `bank_name`, `spouse_name`, `spouse_occupation`, `spouse_contact`, `number_of_children`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `medical_conditions`, `medications`, `covid_vaccinated`, `covid_vaccine_type`, `covid_vaccine_date`, `photo_path`, `resume_path`, `prc_id_path`, `transcript_path`, `clearance_path`, `medical_cert_path`, `nbi_clearance_path`, `service_record_path`, `user_id`, `last_login_at`, `ip_address`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(8, NULL, NULL, 'Maria', 'Carreon', 'Santos', NULL, '1998-10-10', 'Dauin', 'female', 'single', 'Filipino', 'Roman Catholic', 'AB-', 'mariasan@gmail.com', '0936 872 6547', NULL, 'Elithon', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 'NIR', NULL, NULL, NULL, NULL, 'substitute', NULL, NULL, 'On Leave', 'I', 'Teacher 1', NULL, 0, NULL, NULL, 'bachelor', 'BEED', NULL, NULL, 'NORSU', 2016, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 66, NULL, NULL, NULL, 'on_leave', NULL, '2026-03-25 02:22:47', '2026-03-25 05:23:09');

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
(1, 1, 'active', 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', NULL, 1, '8wwpU6S10qMwDgIwJppG3ntCWcD4zur8nxxnzqJbzWCblMVtiy3dIIQ1AxaU', NULL, 0, NULL, NULL, '2026-01-27 05:37:20', '2026-03-25 06:21:45', NULL, 'TES', NULL, 'ADMIN', NULL, NULL, 'sysadmin'),
(2, 3, 'active', 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', NULL, 1, 'YrC7y5PHO5Xp4frRjM1cutO36L5FcQK10AAjebcQz46PDBmtxNVsVS9CcL9G', NULL, 0, NULL, NULL, '2026-01-27 05:37:21', '2026-01-27 05:37:21', NULL, '', NULL, '', NULL, NULL, ''),
(4, 4, 'active', 'student@tugaweES.edu.ph', NULL, '$2y$12$WIxeJEYWoAGnKxkiWIWT7uT1s6Owua0cZUsWGVVO1Zs/dImzr.8ee', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-01-27 05:37:22', '2026-01-27 05:37:22', NULL, '', NULL, '', NULL, NULL, ''),
(13, 2, 'active', 'teacher@tugaweES.edu.ph', NULL, '$2y$12$I703bY65xDMTGUJ/NA1hYuoccRQRYjy7INoW2feSbrdmlKoqmEbTO', NULL, 1, NULL, '{\"theme\": \"dark\", \"language\": \"ceb\", \"date_format\": \"MM/DD/YYYY\", \"time_format\": \"12h\", \"system_updates\": \"1\", \"grade_reminders\": \"1\", \"profile_visible\": \"1\", \"show_last_active\": \"1\", \"attendance_alerts\": \"1\", \"sms_notifications\": \"0\", \"email_notifications\": \"1\", \"email_visible_to_students\": \"0\", \"new_student_notifications\": \"0\"}', 0, NULL, NULL, '2026-01-28 21:57:58', '2026-03-22 16:33:32', NULL, 'Teacher', NULL, 'User', NULL, NULL, 'teacheruser1'),
(66, 2, 'active', 'mariasan@gmail.com', NULL, '$2y$12$3kEcB2mHyjA0b0SFLTlhfeVAFFhMXgKZSzPPX0zvJ7QQStLjJVvbS', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 02:22:47', '2026-03-25 02:22:47', NULL, 'Maria', NULL, 'Santos', NULL, NULL, 'msmaria'),
(67, 4, 'active', 'cresttuayon@gmail.com', '2026-03-25 02:45:58', '$2y$12$VIiA.G96y61jAirqtmXL8OTS6tULU0VkBplwlEN5o12PD3yu0Gb2q', 'photos/GF6X0a0u5OpF25VAiYrrc6RnbZ6mma5ylb2KVp0S.jpg', 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 02:45:58', '2026-03-25 02:45:58', NULL, 'Crestian', NULL, 'Tuayon', NULL, NULL, 'crstn'),
(68, 1, 'inactive', 'admin123@gmail.com', NULL, '$2y$12$TUqAbwYAVzJkHjkxiwa3peAV2mq7ctJhndKfwpBWb7lZBlocE5TPa', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 05:21:01', '2026-03-25 05:55:43', NULL, 'System', NULL, 'Admin', NULL, NULL, 'mysysad12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_section_id_foreign` (`section_id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `grades_student_id_foreign` (`student_id`),
  ADD KEY `grades_section_id_foreign` (`section_id`);

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
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `sections_school_year_id_foreign` (`school_year_id`),
  ADD KEY `sections_teacher_id_foreign` (`teacher_id`);

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
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD KEY `settings_group_index` (`group`),
  ADD KEY `settings_key_index` (`key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_lrn_unique` (`lrn`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `students_section_id_foreign` (`section_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enrollments_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interventions`
--
ALTER TABLE `interventions`
  ADD CONSTRAINT `interventions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
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
