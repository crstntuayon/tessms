-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2026 at 11:06 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `description`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"system_name\", \"timezone\", \"date_format\", \"default_language\", \"maintenance_mode\", \"user_registration\", \"email_verification\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 21:45:33'),
(2, 1, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"school_name\", \"school_code\", \"deped_school_id\", \"school_address\", \"school_email\", \"school_phone\", \"school_division\", \"school_region\", \"school_district\", \"school_head\", \"school_logo\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 21:48:47'),
(3, 1, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"school_name\", \"school_code\", \"deped_school_id\", \"school_address\", \"school_email\", \"school_phone\", \"school_division\", \"school_region\", \"school_district\", \"school_head\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-23 21:50:20'),
(4, 1, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 22:36:44'),
(5, 1, 'enabled', 'Setting', NULL, 'Enrollment submissions enabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 22:37:03'),
(6, 1, 'approved', 'EnrollmentApplication', 1, 'Enrollment approved: ENR-2026-0001 assigned to Sampaguita', '{\"status\": \"pending\", \"section_id\": null}', '{\"status\": \"approved\", \"section_name\": \"Sampaguita\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 22:57:42'),
(7, 1, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-23 23:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED DEFAULT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'students',
  `scope` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'school',
  `target_id` bigint UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `author_id`, `grade_level_id`, `title`, `message`, `priority`, `pinned`, `expires_at`, `school_year_id`, `created_at`, `updated_at`, `target`, `scope`, `target_id`, `is_read`) VALUES
(1, 7, NULL, 'I2uwgei', 'Nshsisj', 'normal', 0, NULL, 2, '2026-04-23 21:29:01', '2026-04-23 21:29:01', 'students', 'school', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_attachments`
--

CREATE TABLE `announcement_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `announcement_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_reads`
--

CREATE TABLE `announcement_reads` (
  `id` bigint UNSIGNED NOT NULL,
  `announcement_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `read_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcement_reads`
--

INSERT INTO `announcement_reads` (`id`, `announcement_id`, `user_id`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2026-04-23 21:35:00', '2026-04-23 21:35:00', '2026-04-23 21:35:00'),
(2, 1, 10, '2026-04-23 21:35:40', '2026-04-23 21:35:40', '2026-04-23 21:35:40');

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
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `accuracy` decimal(8,2) DEFAULT NULL COMMENT 'Accuracy in meters',
  `location_verified` tinyint(1) NOT NULL DEFAULT '0',
  `distance_from_school` decimal(8,2) DEFAULT NULL COMMENT 'Distance in meters',
  `location_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'within_range, out_of_range, no_signal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_school_days`
--

CREATE TABLE `attendance_school_days` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `month` tinyint UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `total_school_days` int NOT NULL DEFAULT '0',
  `school_dates` json DEFAULT NULL,
  `non_school_days` json DEFAULT NULL,
  `teacher_notes` text COLLATE utf8mb4_unicode_ci,
  `configured_by` bigint UNSIGNED DEFAULT NULL,
  `configured_at` timestamp NULL DEFAULT NULL,
  `is_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biometric_credentials`
--

CREATE TABLE `biometric_credentials` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `credential_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `raw_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public-key',
  `public_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Title of the textbook or learning material',
  `subject_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Subject area (e.g., Math, Science, English)',
  `book_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Internal book tracking code',
  `reference_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ISBN or official reference number',
  `date_issued` date DEFAULT NULL COMMENT 'Date when book was issued to student',
  `date_returned` date DEFAULT NULL COMMENT 'Date when book was returned',
  `status` enum('issued','returned','lost') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issued' COMMENT 'Current status of the book',
  `condition` enum('new','good','used','damaged') COLLATE utf8mb4_unicode_ci NOT NULL,
  `damage_details` text COLLATE utf8mb4_unicode_ci COMMENT 'Description of damage if applicable',
  `loss_code` enum('FM','TDO','NEG') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'FM=Force Majeure, TDO=Transferred/Dropout, NEG=Negligence',
  `action_taken` enum('LLTR','TLTR','PTL') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LLTR=Letter from Learner, TLTR=Teacher Letter, PTL=Paid',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT 'Additional notes or comments',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `book_inventory_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_inventories`
--

CREATE TABLE `book_inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `total_copies` int NOT NULL DEFAULT '0',
  `available_copies` int NOT NULL DEFAULT '0',
  `issued_copies` int NOT NULL DEFAULT '0',
  `damaged_copies` int NOT NULL DEFAULT '0',
  `lost_copies` int NOT NULL DEFAULT '0',
  `replacement_cost` decimal(10,2) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `grade_level_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('tugawees-sms-cache-44d90515b43b53cf8b3476ced414e8b4', 'i:1;', 1777008175),
('tugawees-sms-cache-44d90515b43b53cf8b3476ced414e8b4:timer', 'i:1777008175;', 1777008175),
('tugawees-sms-cache-94d92f976fd06fd3e8cf53ec4e03d646', 'i:1;', 1776989046),
('tugawees-sms-cache-94d92f976fd06fd3e8cf53ec4e03d646:timer', 'i:1776989046;', 1776989046),
('tugawees-sms-cache-9e4e43b53a58dc5633d86d5bb2ef8bd1', 'i:1;', 1777014206),
('tugawees-sms-cache-9e4e43b53a58dc5633d86d5bb2ef8bd1:timer', 'i:1777014206;', 1777014206),
('tugawees-sms-cache-a82a373e75eed4ee457d262029c27cf8', 'i:1;', 1777015392),
('tugawees-sms-cache-a82a373e75eed4ee457d262029c27cf8:timer', 'i:1777015392;', 1777015392),
('tugawees-sms-cache-app_settings', 'a:59:{s:11:\"system_name\";s:24:\"Tugawe Elementary School\";s:8:\"timezone\";s:11:\"Asia/Manila\";s:11:\"date_format\";s:6:\"F d, Y\";s:16:\"default_language\";s:3:\"ceb\";s:16:\"maintenance_mode\";b:0;s:17:\"user_registration\";b:1;s:18:\"email_verification\";b:1;s:11:\"school_name\";s:24:\"Tugawe Elementary School\";s:11:\"school_code\";s:8:\"TES-2024\";s:15:\"deped_school_id\";s:6:\"120231\";s:14:\"school_address\";s:48:\"Tugawe, Dauin, Negros Oriental, Philippines 6217\";s:12:\"school_email\";s:20:\"tessupport@gmail.com\";s:12:\"school_phone\";s:0:\"\";s:11:\"school_logo\";s:53:\"settings/HT7exZn7TiiJt9yr1JxrsxKrLJIXu9yp3vkaMFOA.png\";s:15:\"school_division\";s:27:\"Division of Negros Oriental\";s:13:\"school_region\";s:26:\"Negros Island Region (NIR)\";s:11:\"school_head\";s:25:\"MAE HARRIET M. DELA PEÑA\";s:21:\"active_school_year_id\";s:0:\"\";s:15:\"school_district\";s:14:\"Dauin District\";s:19:\"current_school_year\";s:9:\"2024-2025\";s:17:\"school_year_start\";s:0:\"\";s:15:\"school_year_end\";s:0:\"\";s:14:\"grading_system\";s:9:\"quarterly\";s:13:\"passing_grade\";i:75;s:21:\"enrollment_start_date\";s:0:\"\";s:19:\"enrollment_end_date\";s:0:\"\";s:21:\"allow_late_enrollment\";b:0;s:18:\"enrollment_enabled\";b:0;s:18:\"notify_new_student\";b:1;s:17:\"notify_attendance\";b:1;s:13:\"notify_grades\";b:1;s:20:\"notify_announcements\";b:1;s:11:\"sms_enabled\";b:0;s:12:\"sms_provider\";s:0:\"\";s:11:\"mail_driver\";s:4:\"smtp\";s:9:\"mail_host\";s:0:\"\";s:9:\"mail_port\";i:587;s:13:\"mail_username\";s:0:\"\";s:13:\"mail_password\";s:0:\"\";s:15:\"mail_encryption\";s:3:\"tls\";s:17:\"mail_from_address\";s:0:\"\";s:14:\"mail_from_name\";s:24:\"Tugawe Elementary School\";s:19:\"min_password_length\";i:8;s:15:\"password_expiry\";i:90;s:16:\"strong_passwords\";b:1;s:11:\"require_2fa\";b:0;s:15:\"session_timeout\";i:30;s:18:\"max_login_attempts\";i:5;s:19:\"login_notifications\";b:1;s:13:\"primary_color\";s:7:\"#6366f1\";s:15:\"secondary_color\";s:7:\"#10b981\";s:12:\"accent_color\";s:7:\"#f59e0b\";s:12:\"compact_mode\";b:0;s:9:\"dark_mode\";b:0;s:10:\"animations\";b:1;s:11:\"auto_backup\";b:0;s:11:\"last_backup\";s:5:\"Never\";s:11:\"api_enabled\";b:0;s:7:\"api_key\";s:0:\"\";}', 1777032194),
('tugawees-sms-cache-fb1e497d4f66233c3683d43c13c58a4f', 'i:1;', 1777028775),
('tugawees-sms-cache-fb1e497d4f66233c3683d43c13c58a4f:timer', 'i:1777028775;', 1777028775),
('tugawees-sms-cache-user-online-6', 'b:1;', 1776988573);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `status` enum('pending','approved','enrolled','completed','dropped','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `previous_school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_division` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `school_year_id`, `grade_level_id`, `student_id`, `section_id`, `type`, `status`, `previous_school`, `school_name`, `school_id`, `school_district`, `school_division`, `school_region`, `enrollment_date`, `created_at`, `updated_at`, `remarks`) VALUES
(1, 1, 2, 2, 1, 'continuing', 'completed', NULL, 'Tugawe Elementary School', '', '', '', '', '2026-04-23', '2026-04-23 13:33:27', '2026-04-23 13:44:13', NULL),
(2, 2, 3, 2, 2, 'continuing', 'enrolled', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-23', '2026-04-23 14:57:42', '2026-04-23 14:57:42', NULL),
(3, 2, 1, 3, NULL, 'new', 'pending', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'Negros Island Region (NIR)', '2026-04-24', '2026-04-23 17:54:46', '2026-04-23 17:54:46', NULL),
(4, 2, 2, 4, 1, 'continuing', 'enrolled', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-24', '2026-04-23 20:33:05', '2026-04-23 20:33:05', NULL),
(5, 2, 3, 5, 2, 'transferee', 'enrolled', 'San Jose Elementary School', NULL, NULL, NULL, NULL, NULL, '2026-04-24', '2026-04-23 20:40:03', '2026-04-23 20:40:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_applications`
--

CREATE TABLE `enrollment_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `status` enum('draft','pending','under_review','approved','rejected','waitlisted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `application_type` enum('new_student','transfer','returning','continuing') COLLATE utf8mb4_unicode_ci DEFAULT 'new_student',
  `application_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `grade_level_id` bigint UNSIGNED NOT NULL,
  `student_first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_birthdate` date NOT NULL,
  `student_gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_birth_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Filipino',
  `student_mother_tongue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_ethnicity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Negros Oriental',
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_school_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_school_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_grade_completed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_average` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_address` text COLLATE utf8mb4_unicode_ci,
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_special_needs` tinyint(1) NOT NULL DEFAULT '0',
  `special_needs_details` text COLLATE utf8mb4_unicode_ci,
  `medical_conditions` text COLLATE utf8mb4_unicode_ci,
  `allergies` text COLLATE utf8mb4_unicode_ci,
  `parent_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `student_lrn` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_created` tinyint(1) NOT NULL DEFAULT '0',
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollment_applications`
--

INSERT INTO `enrollment_applications` (`id`, `status`, `application_type`, `application_number`, `school_year_id`, `grade_level_id`, `student_first_name`, `student_middle_name`, `student_last_name`, `student_suffix`, `student_birthdate`, `student_gender`, `student_birth_place`, `student_religion`, `student_nationality`, `student_mother_tongue`, `student_ethnicity`, `address`, `barangay`, `city`, `province`, `zip_code`, `previous_school`, `previous_school_id`, `previous_school_address`, `last_grade_completed`, `general_average`, `father_name`, `father_occupation`, `father_contact`, `father_email`, `mother_name`, `mother_occupation`, `mother_contact`, `mother_email`, `guardian_name`, `guardian_relationship`, `guardian_contact`, `guardian_email`, `guardian_address`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_number`, `has_special_needs`, `special_needs_details`, `medical_conditions`, `allergies`, `parent_email`, `parent_password`, `student_id`, `student_lrn`, `account_created`, `reviewed_by`, `reviewed_at`, `admin_notes`, `rejection_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'approved', 'continuing', 'ENR-2026-0001', 2, 3, 'Juan', 'Dela Cruz', 'Santos', NULL, '2017-10-10', 'male', NULL, NULL, 'Filipino', NULL, NULL, 'Purok 4', 'MAG-ASO', 'DAUIN', 'NEGROS ORIENTAL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lorna Del Valle', 'Grandparent', '09759952680', NULL, NULL, 'Lorna Del Valle', 'Grandparent', '09759952680', 0, NULL, NULL, NULL, 'juandesantos@gmail.com', '$2y$12$5oWCzf.YszU4w.eL4FBPh.WMP7vO5NFAx61aJdxZDs7q5rffbFnnG', 2, '120221260000', 1, 1, '2026-04-23 14:57:42', NULL, NULL, '2026-04-23 14:38:00', '2026-04-23 14:57:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_documents`
--

CREATE TABLE `enrollment_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `enrollment_application_id` bigint UNSIGNED NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `verified_by` bigint UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `created_at`, `updated_at`, `school_year_id`, `created_by`) VALUES
(1, 'Graduation', 'Hdheusjdnhsjsjskjsnd jsnjdjsijsjsjsn', '2026-06-06', '2026-04-23 19:45:40', '2026-04-23 19:45:40', 1, 1),
(2, 'Graduation', 'Hdheusjdnhsjsjskjsnd jsnjdjsijsjsjsn', '2026-06-06', '2026-04-23 19:45:42', '2026-04-23 19:45:42', 1, 1),
(3, 'Graduation', 'Hdheusjdnhsjsjskjsnd jsnjdjsijsjsjsn', '2026-06-06', '2026-04-23 19:45:45', '2026-04-23 19:45:45', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 'Kindergarten', 0, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(2, 'Grade 1', 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(3, 'Grade 2', 2, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(4, 'Grade 3', 3, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(5, 'Grade 4', 4, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(6, 'Grade 5', 5, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(7, 'Grade 6', 6, 1, '2026-04-22 17:04:36', '2026-04-22 17:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `grade_weights`
--

CREATE TABLE `grade_weights` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `quarter` int NOT NULL,
  `ww_weight` decimal(5,2) NOT NULL DEFAULT '40.00',
  `pt_weight` decimal(5,2) NOT NULL DEFAULT '40.00',
  `qe_weight` decimal(5,2) NOT NULL DEFAULT '20.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"4a1476b2-0542-4db3-9883-4d218c6bf297\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007801,\"delay\":null}', 0, NULL, 1777007801, 1777007801),
(2, 'default', '{\"uuid\":\"b0bd22a7-a945-4172-b0e2-b6c38e1f6204\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007802,\"delay\":null}', 0, NULL, 1777007802, 1777007802),
(3, 'default', '{\"uuid\":\"f2c45a38-c448-4af1-8f48-016db73743f8\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007874,\"delay\":null}', 0, NULL, 1777007874, 1777007874),
(4, 'default', '{\"uuid\":\"e8a53b45-aa78-4777-9a0d-662bc64574d5\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007884,\"delay\":null}', 0, NULL, 1777007884, 1777007884),
(5, 'default', '{\"uuid\":\"56eb42f7-d80f-48f9-a5e0-4162c21abe9f\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007884,\"delay\":null}', 0, NULL, 1777007884, 1777007884),
(6, 'default', '{\"uuid\":\"c4b280b5-6292-46fb-86fa-6b8943134810\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007884,\"delay\":null}', 0, NULL, 1777007884, 1777007884),
(7, 'default', '{\"uuid\":\"11e7cd09-883a-43ac-a2fe-20df009dc351\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007885,\"delay\":null}', 0, NULL, 1777007885, 1777007885),
(8, 'default', '{\"uuid\":\"86167055-e6cc-4c9e-8096-fb76a78d798a\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:5;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007957,\"delay\":null}', 0, NULL, 1777007957, 1777007957),
(9, 'default', '{\"uuid\":\"1b98c89d-208b-4e6b-882b-f7ffe993a587\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:5;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007958,\"delay\":null}', 0, NULL, 1777007958, 1777007958),
(10, 'default', '{\"uuid\":\"1c6e2dc5-8b17-4022-b211-554dee536db1\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:5;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007961,\"delay\":null}', 0, NULL, 1777007961, 1777007961),
(11, 'default', '{\"uuid\":\"3f8e6294-b9f5-427b-b7fb-1573c4ea643a\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:5;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777007963,\"delay\":null}', 0, NULL, 1777007963, 1777007963),
(12, 'default', '{\"uuid\":\"92ea4ae7-cef2-4f3e-ac3f-8c15768f9e61\",\"displayName\":\"App\\\\Events\\\\AnnouncementPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\AnnouncementPosted\\\":1:{s:12:\\\"announcement\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Announcement\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:2:{i:0;s:6:\\\"author\\\";i:1;s:11:\\\"attachments\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008542,\"delay\":null}', 0, NULL, 1777008542, 1777008542),
(13, 'default', '{\"uuid\":\"3d901c33-5771-4a96-8c0c-78662e9be5cd\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008730,\"delay\":null}', 0, NULL, 1777008730, 1777008730),
(14, 'default', '{\"uuid\":\"7a586649-031a-4ec2-8056-268b49751ed4\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008731,\"delay\":null}', 0, NULL, 1777008731, 1777008731),
(15, 'default', '{\"uuid\":\"38716cd6-c4cc-414a-861f-8c6637314bc4\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008731,\"delay\":null}', 0, NULL, 1777008731, 1777008731),
(16, 'default', '{\"uuid\":\"5124ecfc-6ebf-4ccb-8a10-036c83c9071e\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008732,\"delay\":null}', 0, NULL, 1777008732, 1777008732),
(17, 'default', '{\"uuid\":\"0ba4eee6-2ec0-4974-9450-14a263dd5ddd\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008733,\"delay\":null}', 0, NULL, 1777008733, 1777008733),
(18, 'default', '{\"uuid\":\"15e91eef-f8b5-4aef-8e35-c494c45cd743\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008734,\"delay\":null}', 0, NULL, 1777008734, 1777008734),
(19, 'default', '{\"uuid\":\"dace5f64-33f7-4387-8f19-6e16f18f98a7\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008780,\"delay\":null}', 0, NULL, 1777008780, 1777008780),
(20, 'default', '{\"uuid\":\"8e84fee4-de6c-4991-bdb5-1c58d071a9e5\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008781,\"delay\":null}', 0, NULL, 1777008781, 1777008781),
(21, 'default', '{\"uuid\":\"6b524fe1-e159-457d-9b56-ce5e0349e530\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008801,\"delay\":null}', 0, NULL, 1777008801, 1777008801),
(22, 'default', '{\"uuid\":\"3c8824c6-4b4e-4c74-baf5-9e2fdaaaee64\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008802,\"delay\":null}', 0, NULL, 1777008802, 1777008802),
(23, 'default', '{\"uuid\":\"fc01b0d0-e5d9-4241-ba34-4dc1b61726a3\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008802,\"delay\":null}', 0, NULL, 1777008802, 1777008802),
(24, 'default', '{\"uuid\":\"bed3ec1c-f778-4f38-9bac-f3e3bb61d5fe\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:7;s:11:\\\"recipientId\\\";s:2:\\\"10\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008803,\"delay\":null}', 0, NULL, 1777008803, 1777008803),
(25, 'default', '{\"uuid\":\"80077a27-b26b-427d-84af-85aaa5257f89\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008810,\"delay\":null}', 0, NULL, 1777008810, 1777008810),
(26, 'default', '{\"uuid\":\"4c158f2e-9633-4006-8197-f179090fd870\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008863,\"delay\":null}', 0, NULL, 1777008863, 1777008863),
(27, 'default', '{\"uuid\":\"3d44497c-817d-4608-bcf3-4519cb8b8614\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:10;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008864,\"delay\":null}', 0, NULL, 1777008864, 1777008864),
(28, 'default', '{\"uuid\":\"8932b30a-bd08-44d4-80ef-ad2fe829bb2f\",\"displayName\":\"App\\\\Events\\\\UserTyping\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:21:\\\"App\\\\Events\\\\UserTyping\\\":2:{s:8:\\\"senderId\\\";i:5;s:11:\\\"recipientId\\\";s:1:\\\"7\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1777008920,\"delay\":null}', 0, NULL, 1777008920, 1777008920);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kindergarten_domains`
--

CREATE TABLE `kindergarten_domains` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `quarter` tinyint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `recorded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_edited` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `is_bulk` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `recipient_id`, `subject`, `body`, `read`, `created_at`, `updated_at`, `is_read`, `is_edited`, `read_at`, `is_bulk`, `parent_id`, `section_id`, `deleted_at`) VALUES
(1, 7, 5, 'Message from Jennie  Sikad', 'Hey', 0, '2026-04-23 20:42:28', '2026-04-23 20:43:09', 1, 0, '2026-04-23 20:43:09', 0, NULL, NULL, NULL),
(2, 7, 10, 'Message from Jennie  Sikad', 'Hey', 0, '2026-04-23 20:42:40', '2026-04-23 20:43:38', 1, 0, '2026-04-23 20:43:38', 0, NULL, NULL, NULL),
(3, 5, 7, 'Message from Juan Dela Cruz Santos', 'Yowwww', 0, '2026-04-23 20:43:13', '2026-04-23 20:43:32', 1, 0, '2026-04-23 20:43:32', 0, 1, NULL, '2026-04-23 20:43:32'),
(4, 10, 7, 'Message from Ruffa Mae  Sapan', 'Buang ka', 0, '2026-04-23 20:44:27', '2026-04-23 20:44:40', 1, 0, '2026-04-23 20:44:40', 0, 2, NULL, NULL),
(5, 7, 10, 'Message from Jennie  Sikad', 'Yoww', 0, '2026-04-23 21:17:54', '2026-04-23 21:18:16', 1, 0, '2026-04-23 21:18:16', 0, 2, NULL, NULL),
(6, 10, 7, 'Message from Ruffa Mae  Sapan', 'Hey siri', 0, '2026-04-23 21:18:06', '2026-04-23 21:18:25', 1, 0, '2026-04-23 21:18:25', 0, 2, NULL, NULL),
(7, 5, 7, 'Message from Juan Dela Cruz Santos', 'Ma\'am absent ko unya', 0, '2026-04-23 21:19:23', '2026-04-23 21:22:34', 1, 0, '2026-04-23 21:22:34', 0, 1, NULL, NULL),
(8, 7, 10, 'Message from Jennie  Sikad', 'Chatgpt', 0, '2026-04-23 21:32:15', '2026-04-23 21:32:50', 1, 0, '2026-04-23 21:32:50', 0, 2, NULL, NULL),
(9, 10, 7, 'Message from Ruffa Mae  Sapan', 'Hello', 0, '2026-04-23 21:33:02', '2026-04-23 21:33:44', 1, 0, '2026-04-23 21:33:44', 0, 2, NULL, NULL),
(10, 7, 10, 'Message from Jennie  Sikad', 'Chateyy', 0, '2026-04-23 21:33:24', '2026-04-23 21:34:06', 1, 0, '2026-04-23 21:34:06', 0, 2, NULL, NULL),
(11, 10, 7, 'Message from Ruffa Mae  Sapan', 'Hi', 0, '2026-04-23 21:33:31', '2026-04-23 21:33:44', 1, 0, '2026-04-23 21:33:44', 0, 2, NULL, NULL),
(12, 10, 7, 'Message from Ruffa Mae  Sapan', 'Huhey', 0, '2026-04-23 21:34:25', '2026-04-23 23:03:50', 1, 0, '2026-04-23 23:03:50', 0, 2, NULL, NULL),
(13, 5, 7, 'Message from Juan Dela Cruz Santos', 'Jxjdjsijdjdjwjdndjwjhdjf', 0, '2026-04-23 21:35:21', '2026-04-23 21:35:28', 1, 0, '2026-04-23 21:35:28', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `message_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_04_20_103354_create_sessions_table', 1),
(2, '2026_04_23_003700_create_achievements_table', 1),
(3, '2026_04_23_003700_create_activities_table', 1),
(4, '2026_04_23_003700_create_activity_logs_table', 1),
(5, '2026_04_23_003700_create_announcement_attachments_table', 1),
(6, '2026_04_23_003700_create_announcement_reads_table', 1),
(7, '2026_04_23_003700_create_announcements_table', 1),
(8, '2026_04_23_003700_create_assignments_table', 1),
(9, '2026_04_23_003700_create_attendance_school_days_table', 1),
(10, '2026_04_23_003700_create_attendances_table', 1),
(11, '2026_04_23_003700_create_biometric_credentials_table', 1),
(12, '2026_04_23_003700_create_book_inventories_table', 1),
(13, '2026_04_23_003700_create_books_table', 1),
(14, '2026_04_23_003700_create_cache_locks_table', 1),
(15, '2026_04_23_003700_create_cache_table', 1),
(16, '2026_04_23_003700_create_core_values_table', 1),
(17, '2026_04_23_003700_create_enrollment_applications_table', 1),
(18, '2026_04_23_003700_create_enrollment_documents_table', 1),
(19, '2026_04_23_003700_create_enrollments_table', 1),
(20, '2026_04_23_003700_create_events_table', 1),
(21, '2026_04_23_003700_create_failed_jobs_table', 1),
(22, '2026_04_23_003700_create_grade_levels_table', 1),
(23, '2026_04_23_003700_create_grade_weights_table', 1),
(24, '2026_04_23_003700_create_grades_table', 1),
(25, '2026_04_23_003700_create_interventions_table', 1),
(26, '2026_04_23_003700_create_job_batches_table', 1),
(27, '2026_04_23_003700_create_jobs_table', 1),
(28, '2026_04_23_003700_create_kindergarten_domains_table', 1),
(29, '2026_04_23_003700_create_message_attachments_table', 1),
(30, '2026_04_23_003700_create_messages_table', 1),
(31, '2026_04_23_003700_create_notifications_table', 1),
(32, '2026_04_23_003700_create_password_reset_tokens_table', 1),
(33, '2026_04_23_003700_create_promotion_histories_table', 1),
(34, '2026_04_23_003700_create_push_subscriptions_table', 1),
(35, '2026_04_23_003700_create_report_schedules_table', 1),
(36, '2026_04_23_003700_create_report_templates_table', 1),
(37, '2026_04_23_003700_create_roles_table', 1),
(38, '2026_04_23_003700_create_saved_reports_table', 1),
(39, '2026_04_23_003700_create_schedules_table', 1),
(40, '2026_04_23_003700_create_school_locations_table', 1),
(41, '2026_04_23_003700_create_school_year_closures_table', 1),
(42, '2026_04_23_003700_create_school_year_qr_codes_table', 1),
(43, '2026_04_23_003700_create_school_years_table', 1),
(44, '2026_04_23_003700_create_section_finalizations_table', 1),
(45, '2026_04_23_003700_create_section_subject_table', 1),
(46, '2026_04_23_003700_create_sections_table', 1),
(47, '2026_04_23_003700_create_settings_table', 1),
(48, '2026_04_23_003700_create_student_health_records_table', 1),
(49, '2026_04_23_003700_create_students_table', 1),
(50, '2026_04_23_003700_create_subjects_table', 1),
(51, '2026_04_23_003700_create_submissions_table', 1),
(52, '2026_04_23_003700_create_teacher_sections_table', 1),
(53, '2026_04_23_003700_create_teacher_subject_table', 1),
(54, '2026_04_23_003700_create_teachers_table', 1),
(55, '2026_04_23_003700_create_teaching_programs_table', 1),
(56, '2026_04_23_003700_create_user_notification_settings_table', 1),
(57, '2026_04_23_003700_create_users_table', 1),
(58, '2026_04_23_003703_add_foreign_keys_to_achievements_table', 1),
(59, '2026_04_23_003703_add_foreign_keys_to_activities_table', 1),
(60, '2026_04_23_003703_add_foreign_keys_to_activity_logs_table', 1),
(61, '2026_04_23_003703_add_foreign_keys_to_announcement_attachments_table', 1),
(62, '2026_04_23_003703_add_foreign_keys_to_announcement_reads_table', 1),
(63, '2026_04_23_003703_add_foreign_keys_to_announcements_table', 1),
(64, '2026_04_23_003703_add_foreign_keys_to_assignments_table', 1),
(65, '2026_04_23_003703_add_foreign_keys_to_attendance_school_days_table', 1),
(66, '2026_04_23_003703_add_foreign_keys_to_attendances_table', 1),
(67, '2026_04_23_003703_add_foreign_keys_to_biometric_credentials_table', 1),
(68, '2026_04_23_003703_add_foreign_keys_to_book_inventories_table', 1),
(69, '2026_04_23_003703_add_foreign_keys_to_books_table', 1),
(70, '2026_04_23_003703_add_foreign_keys_to_core_values_table', 1),
(71, '2026_04_23_003703_add_foreign_keys_to_enrollment_applications_table', 1),
(72, '2026_04_23_003703_add_foreign_keys_to_enrollment_documents_table', 1),
(73, '2026_04_23_003703_add_foreign_keys_to_enrollments_table', 1),
(74, '2026_04_23_003703_add_foreign_keys_to_events_table', 1),
(75, '2026_04_23_003703_add_foreign_keys_to_grade_weights_table', 1),
(76, '2026_04_23_003703_add_foreign_keys_to_grades_table', 1),
(77, '2026_04_23_003703_add_foreign_keys_to_interventions_table', 1),
(78, '2026_04_23_003703_add_foreign_keys_to_kindergarten_domains_table', 1),
(79, '2026_04_23_003703_add_foreign_keys_to_message_attachments_table', 1),
(80, '2026_04_23_003703_add_foreign_keys_to_messages_table', 1),
(81, '2026_04_23_003703_add_foreign_keys_to_notifications_table', 1),
(82, '2026_04_23_003703_add_foreign_keys_to_promotion_histories_table', 1),
(83, '2026_04_23_003703_add_foreign_keys_to_report_schedules_table', 1),
(84, '2026_04_23_003703_add_foreign_keys_to_report_templates_table', 1),
(85, '2026_04_23_003703_add_foreign_keys_to_saved_reports_table', 1),
(86, '2026_04_23_003703_add_foreign_keys_to_schedules_table', 1),
(87, '2026_04_23_003703_add_foreign_keys_to_school_year_closures_table', 1),
(88, '2026_04_23_003703_add_foreign_keys_to_school_year_qr_codes_table', 1),
(89, '2026_04_23_003703_add_foreign_keys_to_section_finalizations_table', 1),
(90, '2026_04_23_003703_add_foreign_keys_to_section_subject_table', 1),
(91, '2026_04_23_003703_add_foreign_keys_to_sections_table', 1),
(92, '2026_04_23_003703_add_foreign_keys_to_student_health_records_table', 1),
(93, '2026_04_23_003703_add_foreign_keys_to_students_table', 1),
(94, '2026_04_23_003703_add_foreign_keys_to_subjects_table', 1),
(95, '2026_04_23_003703_add_foreign_keys_to_submissions_table', 1),
(96, '2026_04_23_003703_add_foreign_keys_to_teacher_sections_table', 1),
(97, '2026_04_23_003703_add_foreign_keys_to_teacher_subject_table', 1),
(98, '2026_04_23_003703_add_foreign_keys_to_teachers_table', 1),
(99, '2026_04_23_003703_add_foreign_keys_to_teaching_programs_table', 1),
(100, '2026_04_23_003703_add_foreign_keys_to_user_notification_settings_table', 1),
(101, '2026_04_23_003703_add_foreign_keys_to_users_table', 1);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_via_email_at` timestamp NULL DEFAULT NULL,
  `sent_via_sms_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_histories`
--

CREATE TABLE `promotion_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `from_school_year_id` bigint UNSIGNED NOT NULL,
  `to_school_year_id` bigint UNSIGNED NOT NULL,
  `from_grade_level_id` bigint UNSIGNED NOT NULL,
  `to_grade_level_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `subscribable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribable_id` bigint UNSIGNED NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_encoding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_schedules`
--

CREATE TABLE `report_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `saved_report_id` bigint UNSIGNED NOT NULL,
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_config` json NOT NULL,
  `recipients` json NOT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf',
  `delivery_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'email',
  `last_sent_at` timestamp NULL DEFAULT NULL,
  `next_send_at` timestamp NULL DEFAULT NULL,
  `send_count` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_templates`
--

CREATE TABLE `report_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `columns` json NOT NULL,
  `filters` json NOT NULL,
  `chart_config` json DEFAULT NULL,
  `default_params` json DEFAULT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_templates`
--

INSERT INTO `report_templates` (`id`, `name`, `slug`, `description`, `category`, `type`, `columns`, `filters`, `chart_config`, `default_params`, `icon`, `color`, `is_system`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Student Masterlist', 'student-masterlist', 'Complete roster of all students with filtering options by grade level, section, and status.', 'academic', 'table', '[{\"key\": \"lrn\", \"type\": \"text\", \"label\": \"LRN\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"gender\", \"type\": \"text\", \"label\": \"Gender\"}, {\"key\": \"birthdate\", \"type\": \"date\", \"label\": \"Birthdate\"}, {\"key\": \"age\", \"type\": \"number\", \"label\": \"Age\"}, {\"key\": \"contact\", \"type\": \"text\", \"label\": \"Contact\"}, {\"key\": \"status\", \"type\": \"badge\", \"label\": \"Status\"}]', '[\"school_year_id\", \"grade_level_id\", \"section_id\", \"gender\", \"status\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01\"/>', 'blue', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(2, 'Grade Summary Report', 'grade-summary', 'Comprehensive grade report showing quarterly grades and final averages by student and subject.', 'academic', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"subject\", \"type\": \"text\", \"label\": \"Subject\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"q1\", \"type\": \"number\", \"label\": \"Q1\"}, {\"key\": \"q2\", \"type\": \"number\", \"label\": \"Q2\"}, {\"key\": \"q3\", \"type\": \"number\", \"label\": \"Q3\"}, {\"key\": \"q4\", \"type\": \"number\", \"label\": \"Q4\"}, {\"key\": \"final\", \"type\": \"number\", \"label\": \"Final\"}, {\"key\": \"remarks\", \"type\": \"badge\", \"label\": \"Remarks\"}]', '[\"school_year_id\", \"section_id\", \"subject_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'green', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(3, 'Honor Roll', 'honor-roll', 'List of students who achieved honors based on general average.', 'academic', 'table', '[{\"key\": \"rank\", \"type\": \"number\", \"label\": \"Rank\"}, {\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"general_average\", \"type\": \"number\", \"label\": \"General Average\"}, {\"key\": \"honor\", \"type\": \"badge\", \"label\": \"Honor\"}]', '[\"school_year_id\", \"grade_level_id\", \"min_average\"]', NULL, '{\"min_average\": 90}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z\"/>', 'purple', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(4, 'Class Performance Report', 'class-performance', 'Performance metrics for each section including average grades and passing rates.', 'academic', 'combined', '[{\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"adviser\", \"type\": \"text\", \"label\": \"Adviser\"}, {\"key\": \"total_students\", \"type\": \"number\", \"label\": \"Students\"}, {\"key\": \"average_grade\", \"type\": \"number\", \"label\": \"Avg Grade\"}, {\"key\": \"passing_rate\", \"type\": \"percentage\", \"label\": \"Passing Rate\"}]', '[\"school_year_id\", \"section_id\", \"grade_level_id\"]', '{\"type\": \"bar\", \"x_axis\": \"section\", \"y_axis\": \"average_grade\"}', NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'indigo', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(5, 'Attendance Summary', 'attendance-summary', 'Daily attendance records with present, absent, and late counts by student.', 'attendance', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"present\", \"type\": \"number\", \"label\": \"Present\"}, {\"key\": \"absent\", \"type\": \"number\", \"label\": \"Absent\"}, {\"key\": \"late\", \"type\": \"number\", \"label\": \"Late\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"attendance_rate\", \"type\": \"percentage\", \"label\": \"Rate\"}]', '[\"section_id\", \"start_date\", \"end_date\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4\"/>', 'amber', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(6, 'Attendance Trend', 'attendance-trend', 'Visual trend of attendance rates over a specified time period.', 'attendance', 'chart', '[{\"key\": \"date\", \"type\": \"date\", \"label\": \"Date\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"present\", \"type\": \"number\", \"label\": \"Present\"}, {\"key\": \"rate\", \"type\": \"percentage\", \"label\": \"Rate\"}]', '[\"section_id\", \"days\"]', '{\"type\": \"line\", \"x_axis\": \"date\", \"y_axis\": \"rate\"}', '{\"days\": 30}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z\"/>', 'cyan', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(7, 'Enrollment Statistics', 'enrollment-statistics', 'Enrollment numbers broken down by grade level and section.', 'enrollment', 'combined', '[{\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"male\", \"type\": \"number\", \"label\": \"Male\"}, {\"key\": \"female\", \"type\": \"number\", \"label\": \"Female\"}]', '[\"school_year_id\", \"grade_level_id\"]', '{\"type\": \"bar\", \"x_axis\": \"grade_level\", \"y_axis\": \"total\"}', NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"/>', 'teal', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(8, 'At-Risk Students Report', 'dropout-risk', 'Identify students at risk of dropping out based on attendance and grade patterns.', 'analytics', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"attendance_rate\", \"type\": \"percentage\", \"label\": \"Attendance\"}, {\"key\": \"average_grade\", \"type\": \"number\", \"label\": \"Avg Grade\"}, {\"key\": \"risk_factors\", \"type\": \"text\", \"label\": \"Risk Factors\"}, {\"key\": \"risk_level\", \"type\": \"badge\", \"label\": \"Risk Level\"}]', '[\"school_year_id\", \"attendance_threshold\", \"grade_threshold\"]', NULL, '{\"grade_threshold\": 75, \"attendance_threshold\": 75}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"/>', 'red', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(9, 'Teacher Workload Report', 'teacher-workload', 'Overview of teaching assignments and student load per teacher.', 'analytics', 'table', '[{\"key\": \"teacher_name\", \"type\": \"text\", \"label\": \"Teacher Name\"}, {\"key\": \"specialization\", \"type\": \"text\", \"label\": \"Specialization\"}, {\"key\": \"sections_handled\", \"type\": \"number\", \"label\": \"Sections\"}, {\"key\": \"subjects\", \"type\": \"text\", \"label\": \"Subjects\"}, {\"key\": \"total_students\", \"type\": \"number\", \"label\": \"Total Students\"}]', '[]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z\"/>', 'orange', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(10, 'SF1 - School Register', 'sf1-school-register', 'DepEd School Register form with complete student information.', 'compliance', 'table', '[{\"key\": \"no\", \"type\": \"number\", \"label\": \"No.\"}, {\"key\": \"lrn\", \"type\": \"text\", \"label\": \"LRN\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Learner Name\"}, {\"key\": \"gender\", \"type\": \"text\", \"label\": \"Sex\"}, {\"key\": \"birthdate\", \"type\": \"date\", \"label\": \"Birth Date\"}, {\"key\": \"age\", \"type\": \"number\", \"label\": \"Age\"}, {\"key\": \"mother_tongue\", \"type\": \"text\", \"label\": \"Mother Tongue\"}, {\"key\": \"religion\", \"type\": \"text\", \"label\": \"Religion\"}, {\"key\": \"address\", \"type\": \"text\", \"label\": \"Address\"}, {\"key\": \"father_name\", \"type\": \"text\", \"label\": \"Father\'s Name\"}, {\"key\": \"mother_name\", \"type\": \"text\", \"label\": \"Mother\'s Name\"}, {\"key\": \"guardian_name\", \"type\": \"text\", \"label\": \"Guardian\'s Name\"}, {\"key\": \"guardian_contact\", \"type\": \"text\", \"label\": \"Contact\"}]', '[\"school_year_id\", \"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(11, 'SF2 - Daily Attendance', 'sf2-daily-attendance', 'DepEd Daily Attendance Report of Learners.', 'compliance', 'table', '[{\"key\": \"no\", \"type\": \"number\", \"label\": \"No.\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Name\"}, {\"key\": \"days_present\", \"type\": \"number\", \"label\": \"Days Present\"}, {\"key\": \"days_absent\", \"type\": \"number\", \"label\": \"Days Absent\"}, {\"key\": \"days_late\", \"type\": \"number\", \"label\": \"Days Late\"}, {\"key\": \"total_days\", \"type\": \"number\", \"label\": \"Total Days\"}]', '[\"section_id\", \"month\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(12, 'SF3 - Books Issued and Returned', 'sf3-books', 'DepEd record of books issued and returned by students.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(13, 'SF4 - Monthly Learner Movement and Attendance', 'sf4-monthly-movement', 'DepEd monthly movement and attendance summary.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(14, 'SF5 - Report on Promotion and Level of Proficiency', 'sf5-promotion', 'DepEd report on promotion and proficiency levels by grade.', 'compliance', 'table', '[]', '[\"grade_level_id\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(15, 'SF6 - Summary Report on Promotion', 'sf6-summary-promotion', 'DepEd summary report on promotion and retention.', 'compliance', 'table', '[]', '[\"grade_level_id\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(16, 'SF7 - School Personnel Assignment List', 'sf7-personnel', 'DepEd list of teaching and non-teaching personnel assignments.', 'compliance', 'table', '[]', '[\"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(17, 'SF8 - Learner Health and Nutrition', 'sf8-health-nutrition', 'DepEd report on learner health and nutrition profile.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(18, 'SF9 - Report Card', 'sf9-report-card', 'DepEd Learner Progress Report Card.', 'compliance', 'table', '[]', '[\"section_id\", \"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(19, 'SF10 - Learner Permanent Record', 'sf10-permanent-record', 'DepEd Learner Permanent Academic Record.', 'compliance', 'table', '[]', '[\"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10'),
(20, 'Kindergarten Assessment', 'kindergarten-assessment', 'DepEd Kindergarten Developmental Domains Assessment.', 'compliance', 'table', '[]', '[\"section_id\", \"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"/>', 'gray', 1, 1, NULL, '2026-04-23 16:42:10', '2026-04-23 16:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(2, 'Teacher', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(3, 'Registrar', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(4, 'Student', '2026-04-22 17:04:36', '2026-04-22 17:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `saved_reports`
--

CREATE TABLE `saved_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `parameters` json NOT NULL,
  `column_visibility` json DEFAULT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'html',
  `schedule_frequency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_config` json DEFAULT NULL,
  `last_run_at` timestamp NULL DEFAULT NULL,
  `next_run_at` timestamp NULL DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT '0',
  `is_scheduled` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `school_locations`
--

CREATE TABLE `school_locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main_campus' COMMENT 'main_campus, annex, etc.',
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius_meters` int NOT NULL DEFAULT '100' COMMENT 'Allowed radius for attendance',
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `require_location` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Require location verification for attendance',
  `allowed_schedules` text COLLATE utf8mb4_unicode_ci COMMENT 'JSON array of allowed time slots',
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
(1, '2026-2027', '2026-06-01', '2027-03-31', 0, 'School year 2026-2027 (current)', '2026-04-22 17:04:36', '2026-04-23 17:01:55'),
(2, '2027-2028', '2027-06-01', '2028-03-31', 1, 'School year 2027-2028', '2026-04-22 17:04:36', '2026-04-23 17:01:55'),
(3, '2028-2029', '2028-06-01', '2029-03-31', 0, 'School year 2028-2029', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(4, '2029-2030', '2029-06-01', '2030-03-31', 0, 'School year 2029-2030', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(5, '2030-2031', '2030-06-01', '2031-03-31', 0, 'School year 2030-2031', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(6, '2031-2032', '2031-06-01', '2032-03-31', 0, 'School year 2031-2032', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(7, '2032-2033', '2032-06-01', '2033-03-31', 0, 'School year 2032-2033', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(8, '2033-2034', '2033-06-01', '2034-03-31', 0, 'School year 2033-2034', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(9, '2034-2035', '2034-06-01', '2035-03-31', 0, 'School year 2034-2035', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(10, '2035-2036', '2035-06-01', '2036-03-31', 0, 'School year 2035-2036', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(11, '2036-2037', '2036-06-01', '2037-03-31', 0, 'School year 2036-2037', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(12, '2037-2038', '2037-06-01', '2038-03-31', 0, 'School year 2037-2038', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(13, '2038-2039', '2038-06-01', '2039-03-31', 0, 'School year 2038-2039', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(14, '2039-2040', '2039-06-01', '2040-03-31', 0, 'School year 2039-2040', '2026-04-22 17:04:36', '2026-04-22 17:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `school_year_closures`
--

CREATE TABLE `school_year_closures` (
  `id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','ready_to_close','closing','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_sections` int NOT NULL DEFAULT '0',
  `finalized_sections` int NOT NULL DEFAULT '0',
  `all_sections_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `closure_started_at` timestamp NULL DEFAULT NULL,
  `closure_completed_at` timestamp NULL DEFAULT NULL,
  `closed_by` bigint UNSIGNED DEFAULT NULL,
  `finalization_deadline` timestamp NULL DEFAULT NULL,
  `auto_close_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `auto_close_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `closure_summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_year_closures`
--

INSERT INTO `school_year_closures` (`id`, `school_year_id`, `status`, `total_sections`, `finalized_sections`, `all_sections_finalized`, `closure_started_at`, `closure_completed_at`, `closed_by`, `finalization_deadline`, `auto_close_enabled`, `auto_close_at`, `admin_notes`, `closure_summary`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 0, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-04-22 22:35:55', '2026-04-22 22:35:55'),
(2, 2, 'pending', 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-04-23 17:10:14', '2026-04-23 17:10:14');

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
(1, 2, 'WuQG1M5ebCGJeWawVwyQYoaxlQggN3ux', 'qr-codes/school-year-2-WuQG1M5ebCGJeWawVwyQYoaxlQggN3ux.png', 0, '2028-03-31 00:00:00', '2026-04-23 17:17:52', '2026-04-23 23:02:52'),
(2, 2, 'w6PIZ2RCxLHV4GySFLTuULdhoyB75M4h', 'qr-codes/school-year-2-w6PIZ2RCxLHV4GySFLTuULdhoyB75M4h.png', 0, '2028-03-31 00:00:00', '2026-04-23 17:20:00', '2026-04-23 23:02:52'),
(3, 2, 'DxdrUM8qL9MmgOAs08C6VCBaOdAl3sV5', 'qr-codes/school-year-2-DxdrUM8qL9MmgOAs08C6VCBaOdAl3sV5.png', 0, '2028-03-31 00:00:00', '2026-04-23 18:38:07', '2026-04-23 23:02:52'),
(4, 2, 'Tr5aHnDYdoe8q7gfZ3OW3IhUUF5mf4j7', 'qr-codes/school-year-2-Tr5aHnDYdoe8q7gfZ3OW3IhUUF5mf4j7.png', 0, '2028-03-31 00:00:00', '2026-04-23 19:35:17', '2026-04-23 23:02:52'),
(5, 2, 'anRYyOHQfQIZwZ5droO8TJLaDyXrrMeF', 'qr-codes/school-year-2-anRYyOHQfQIZwZ5droO8TJLaDyXrrMeF.png', 0, '2028-03-31 00:00:00', '2026-04-23 19:48:27', '2026-04-23 23:02:52'),
(6, 2, 'WQwpfOj20Bx5jAqYFXHGnbmeNN9CCE71', 'qr-codes/school-year-2-WQwpfOj20Bx5jAqYFXHGnbmeNN9CCE71.png', 0, '2028-03-31 00:00:00', '2026-04-23 19:48:33', '2026-04-23 23:02:52'),
(7, 2, 'rfawG3qzcEzlhjjRBzmxNVaA7HpEUtkm', 'qr-codes/school-year-2-rfawG3qzcEzlhjjRBzmxNVaA7HpEUtkm.png', 0, '2028-03-31 00:00:00', '2026-04-23 21:12:54', '2026-04-23 23:02:52'),
(8, 2, 'W0OOjzflC4lfuvze8OjYFC17qkoXMoKU', 'qr-codes/school-year-2-W0OOjzflC4lfuvze8OjYFC17qkoXMoKU.png', 1, '2028-03-31 00:00:00', '2026-04-23 23:02:52', '2026-04-23 23:02:52');

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
(1, 'Orchid', 2, 2, 'Room100', 1, 40, '2026-04-23 13:37:47', '2026-04-23 15:52:40', 1),
(2, 'Sampaguita', 3, 2, 'Room101', 2, 40, '2026-04-23 14:49:07', '2026-04-23 15:58:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `section_finalizations`
--

CREATE TABLE `section_finalizations` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `grades_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `grades_finalized_at` timestamp NULL DEFAULT NULL,
  `attendance_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `attendance_finalized_at` timestamp NULL DEFAULT NULL,
  `core_values_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `core_values_finalized_at` timestamp NULL DEFAULT NULL,
  `is_fully_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `finalized_at` timestamp NULL DEFAULT NULL,
  `finalized_by` bigint UNSIGNED DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `locked_at` timestamp NULL DEFAULT NULL,
  `unlocked_at` timestamp NULL DEFAULT NULL,
  `unlocked_by` bigint UNSIGNED DEFAULT NULL,
  `grades_unlocked_at` timestamp NULL DEFAULT NULL,
  `unlock_reason` text COLLATE utf8mb4_unicode_ci,
  `deadline_at` timestamp NULL DEFAULT NULL,
  `auto_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `grades_unlocked_by` bigint UNSIGNED DEFAULT NULL,
  `grades_unlock_reason` text COLLATE utf8mb4_unicode_ci,
  `attendance_unlocked_at` timestamp NULL DEFAULT NULL,
  `attendance_unlocked_by` bigint UNSIGNED DEFAULT NULL,
  `attendance_unlock_reason` text COLLATE utf8mb4_unicode_ci,
  `core_values_unlocked_at` timestamp NULL DEFAULT NULL,
  `core_values_unlocked_by` bigint UNSIGNED DEFAULT NULL,
  `core_values_unlock_reason` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_finalizations`
--

INSERT INTO `section_finalizations` (`id`, `section_id`, `school_year_id`, `teacher_id`, `grades_finalized`, `grades_finalized_at`, `attendance_finalized`, `attendance_finalized_at`, `core_values_finalized`, `core_values_finalized_at`, `is_fully_finalized`, `finalized_at`, `finalized_by`, `is_locked`, `locked_at`, `unlocked_at`, `unlocked_by`, `grades_unlocked_at`, `unlock_reason`, `deadline_at`, `auto_finalized`, `created_at`, `updated_at`, `grades_unlocked_by`, `grades_unlock_reason`, `attendance_unlocked_at`, `attendance_unlocked_by`, `attendance_unlock_reason`, `core_values_unlocked_at`, `core_values_unlocked_by`, `core_values_unlock_reason`) VALUES
(1, 1, 2, 1, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-04-23 15:29:39', '2026-04-23 15:29:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 2, 2, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-04-23 20:48:33', '2026-04-23 20:48:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8trxs1YdET0SmPwP69eXPgAglPjHdUmoGGOKEhq2', 1, '192.168.0.199', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2gycFk1ekpDa0U3b3UyU1E5TGRXMHlHcjY4S1RmT0xJRjRMN2E1WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xOTIuMTY4LjAuMTk5OjgwMDAvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO3M6NToicm91dGUiO3M6MjY6Im5vdGlmaWNhdGlvbnMudW5yZWFkLWNvdW50Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1777028774),
('ikUwFltkE3OHbceJCr20SVmbqHoJzUmzRzmG548g', 10, '192.168.0.197', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.4 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUkRmM3M2SHpZWDd3Y1lxM1cxcmNMclZkcEQyZGFoOU9ETjluWHZDMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xOTIuMTY4LjAuMTk5OjgwMDAvc3R1ZGVudC9hdHRlbmRhbmNlIjtzOjU6InJvdXRlIjtzOjE4OiJzdHVkZW50LmF0dGVuZGFuY2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDt9', 1777028743);

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
(1, 'system_name', 'Tugawe Elementary School', 'string', 'general', 'The name of the system displayed throughout the application', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(2, 'timezone', 'Asia/Manila', 'string', 'general', 'Default timezone for the application', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(3, 'date_format', 'F d, Y', 'string', 'general', 'Format for displaying dates', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(4, 'default_language', 'ceb', 'string', 'general', 'Default language for the application', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:45:33'),
(5, 'maintenance_mode', '0', 'boolean', 'general', 'Enable maintenance mode', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(6, 'user_registration', '1', 'boolean', 'general', 'Allow new user registration', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(7, 'email_verification', '1', 'boolean', 'general', 'Require email verification for new accounts', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(8, 'school_name', 'Tugawe Elementary School', 'string', 'school', 'Official name of the school', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(9, 'school_code', 'TES-2024', 'string', 'school', 'School code identifier', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(10, 'deped_school_id', '120231', 'string', 'school', 'DepEd assigned school ID', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(11, 'school_address', 'Tugawe, Dauin, Negros Oriental, Philippines 6217', 'string', 'school', 'Complete school address', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(12, 'school_email', 'tessupport@gmail.com', 'string', 'school', 'School contact email', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(13, 'school_phone', '', 'string', 'school', 'School contact phone number', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(14, 'school_logo', 'settings/HT7exZn7TiiJt9yr1JxrsxKrLJIXu9yp3vkaMFOA.png', 'string', 'school', 'Path to school logo image', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(15, 'school_division', 'Division of Negros Oriental', 'string', 'school', 'School division', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(16, 'school_region', 'Negros Island Region (NIR)', 'string', 'school', 'School region', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(17, 'school_head', 'MAE HARRIET M. DELA PEÑA', 'string', 'school', 'School head/principal', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:50:20'),
(18, 'active_school_year_id', '', 'string', 'school', 'Active school year ID', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(19, 'school_district', 'Dauin District', 'string', 'school', 'School district', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 13:48:47'),
(20, 'current_school_year', '2024-2025', 'string', 'academic', 'Current active school year', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(21, 'school_year_start', '', 'string', 'academic', 'Start date of the current school year', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(22, 'school_year_end', '', 'string', 'academic', 'End date of the current school year', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(23, 'grading_system', 'quarterly', 'string', 'academic', 'Grading period system', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(24, 'passing_grade', '75', 'integer', 'academic', 'Minimum passing grade percentage', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(25, 'enrollment_start_date', '', 'string', 'academic', 'Enrollment period start date', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(26, 'enrollment_end_date', '', 'string', 'academic', 'Enrollment period end date', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(27, 'allow_late_enrollment', '0', 'boolean', 'academic', 'Allow enrollment after the deadline', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(28, 'enrollment_enabled', '0', 'boolean', 'enrollment', 'Allow students to submit enrollment requests', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-23 15:14:52'),
(29, 'notify_new_student', '1', 'boolean', 'notifications', 'Send email on new student enrollment', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(30, 'notify_attendance', '1', 'boolean', 'notifications', 'Notify parents of student absences', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(31, 'notify_grades', '1', 'boolean', 'notifications', 'Send notification when grades are published', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(32, 'notify_announcements', '1', 'boolean', 'notifications', 'Send notification for new announcements', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(33, 'sms_enabled', '0', 'boolean', 'notifications', 'Enable SMS notifications', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(34, 'sms_provider', '', 'string', 'notifications', 'SMS gateway provider', 0, 1, 0, '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(35, 'mail_driver', 'smtp', 'string', 'email', 'Mail driver', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(36, 'mail_host', '', 'string', 'email', 'SMTP host', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(37, 'mail_port', '587', 'integer', 'email', 'SMTP port', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(38, 'mail_username', '', 'string', 'email', 'SMTP username', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(39, 'mail_password', '', 'string', 'email', 'SMTP password', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(40, 'mail_encryption', 'tls', 'string', 'email', 'SMTP encryption', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(41, 'mail_from_address', '', 'string', 'email', 'From email address', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(42, 'mail_from_name', 'Tugawe Elementary School', 'string', 'email', 'From name', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(43, 'min_password_length', '8', 'integer', 'security', 'Minimum required password length', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(44, 'password_expiry', '90', 'integer', 'security', 'Days until password expires (0 = never)', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(45, 'strong_passwords', '1', 'boolean', 'security', 'Require complex passwords', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(46, 'require_2fa', '0', 'boolean', 'security', 'Require two-factor authentication', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(47, 'session_timeout', '30', 'integer', 'security', 'Session timeout in minutes', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(48, 'max_login_attempts', '5', 'integer', 'security', 'Maximum failed login attempts per minute', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(49, 'login_notifications', '1', 'boolean', 'security', 'Send email on new login', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(50, 'primary_color', '#6366f1', 'string', 'appearance', 'Primary brand color', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(51, 'secondary_color', '#10b981', 'string', 'appearance', 'Secondary accent color', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(52, 'accent_color', '#f59e0b', 'string', 'appearance', 'Accent color', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(53, 'compact_mode', '0', 'boolean', 'appearance', 'Use compact spacing', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(54, 'dark_mode', '0', 'boolean', 'appearance', 'Enable dark theme', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(55, 'animations', '1', 'boolean', 'appearance', 'Enable UI animations', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(56, 'auto_backup', '0', 'boolean', 'backup', 'Enable automatic daily backups', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(57, 'last_backup', 'Never', 'string', 'backup', 'Last backup timestamp', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(58, 'api_enabled', '0', 'boolean', 'advanced', 'Enable API access', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37'),
(59, 'api_key', '', 'string', 'advanced', 'API authentication key', 0, 1, 0, '2026-04-22 17:04:37', '2026-04-22 17:04:37');

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
  `status` enum('active','inactive','graduated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `birth_certificate_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_card_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `good_moral_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_credential_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_status` enum('pending','complete','incomplete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `documents_verified_at` timestamp NULL DEFAULT NULL,
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
  `grade_level_id` bigint UNSIGNED DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `remarks` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents_verified_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `lrn`, `birthdate`, `birth_place`, `gender`, `status`, `birth_certificate_path`, `report_card_path`, `good_moral_path`, `transfer_credential_path`, `registration_status`, `documents_verified_at`, `mother_tongue`, `ethnicity`, `nationality`, `religion`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `guardian_name`, `guardian_relationship`, `guardian_contact`, `street_address`, `barangay`, `city`, `province`, `zip_code`, `grade_level_id`, `section_id`, `photo`, `created_at`, `updated_at`, `school_year_id`, `remarks`, `documents_verified_by`) VALUES
(2, 5, '120221260000', '2017-10-10', 'Dauin', 'Male', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Christianity', 'Jose Santos', 'Businessman', 'Macy Santos', 'Housewife', 'Lorna Del Valle', 'Grandparent', '09759952680', 'Purok 4', 'MAG-ASO', 'DAUIN', 'NEGROS ORIENTAL', '6217', 3, 2, NULL, '2026-04-23 13:33:27', '2026-04-23 14:57:42', 2, NULL, NULL),
(3, 8, '120231000001', '2003-10-31', 'Dauin', 'Female', 'inactive', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Roman Catholi', 'Juan Tradio', 'Engineer', 'Maria Tradio', 'Businesswoman', 'Maria Tradio', 'Parent', '09952669654', 'Luca', 'Lipayo', 'Dauin', 'Negros Oriental', '6217', 1, NULL, NULL, '2026-04-23 17:54:46', '2026-04-23 17:54:46', NULL, NULL, NULL),
(4, 9, NULL, '2003-11-06', 'Bayawan City', 'Female', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Christianity', 'Jose Baldomar', 'Businessman', 'Macy Baldomar', 'Housewife', 'Nancy Talorete', 'Grandparent', '09759952680', 'Purok Twin Hearts', 'Cantil-e', 'Dumaguete City', 'NEGROS ORIENTAL', '6200', 2, 1, NULL, '2026-04-23 20:33:05', '2026-04-23 20:33:05', NULL, NULL, NULL),
(5, 10, NULL, '2004-01-30', 'Antique', 'Female', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Christianity', 'Jose Sapan', 'Farmer', 'Macy Sapan', 'Businesswoman', 'Macy Sapan', 'Mother', '09759952680', 'Purok 4', 'Cancawas', 'San Jose', 'NEGROS ORIENTAL', '6222', 3, 2, NULL, '2026-04-23 20:40:03', '2026-04-23 20:40:03', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_health_records`
--

CREATE TABLE `student_health_records` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `period` enum('bosy','eosy') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Beginning/End of School Year',
  `weight` decimal(5,2) DEFAULT NULL COMMENT 'in kg',
  `height` decimal(4,2) DEFAULT NULL COMMENT 'in meters',
  `bmi` decimal(5,2) DEFAULT NULL COMMENT 'kg/m²',
  `nutritional_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Severely Wasted, Wasted, Normal, Overweight, Obese',
  `height_for_age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Severely Stunted, Stunted, Normal, Tall',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `date_of_assessment` date DEFAULT NULL,
  `assessed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 'Mathematics', 'MATH1', 'Grade 1 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(2, 1, 'Good Manners and Right Conduct', 'GMRC1', 'Grade 1 subject: Good Manners and Right Conduct', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(3, 1, 'Language', 'LANG1', 'Grade 1 subject: Language', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(4, 1, 'Reading and Literacy', 'READ1', 'Grade 1 subject: Reading and Literacy', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(5, 1, 'Makabansa', 'MAKA1', 'Grade 1 subject: Makabansa', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(6, 2, 'Filipino', 'FIL2', 'Grade 2 subject: Filipino', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(7, 2, 'English', 'ENG2', 'Grade 2 subject: English', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(8, 2, 'Mathematics', 'MATH2', 'Grade 2 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(9, 2, 'Makabansa', 'MAKA2', 'Grade 2 subject: Makabansa', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(10, 2, 'Good Manners and Right Conduct', 'GMRC2', 'Grade 2 subject: Good Manners and Right Conduct', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(11, 3, 'Filipino', 'FIL3', 'Grade 3 subject: Filipino', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(12, 3, 'English', 'ENG3', 'Grade 3 subject: English', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(13, 3, 'Mathematics', 'MATH3', 'Grade 3 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(14, 3, 'Science', 'SCI3', 'Grade 3 subject: Science', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(15, 3, 'Makabansa', 'MAKA3', 'Grade 3 subject: Makabansa', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(16, 3, 'Good Manners and Right Conduct', 'GMRC3', 'Grade 3 subject: Good Manners and Right Conduct', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(17, 4, 'Filipino', 'FIL4', 'Grade 4 subject: Filipino', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(18, 4, 'English', 'ENG4', 'Grade 4 subject: English', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(19, 4, 'Mathematics', 'MATH4', 'Grade 4 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(20, 4, 'Science', 'SCI4', 'Grade 4 subject: Science', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(21, 4, 'Araling Panlipunan', 'AP4', 'Grade 4 subject: Araling Panlipunan', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(22, 4, 'Music, Arts, Physical Education, Health', 'MAPEH4', 'Grade 4 subject: Music, Arts, Physical Education, Health', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(23, 4, 'Edukasyong Pantahanan at Pangkabuhayan', 'EPP4', 'Grade 4 subject: Edukasyong Pantahanan at Pangkabuhayan', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(24, 4, 'Good Manners and Right Conduct', 'GMRC4', 'Grade 4 subject: Good Manners and Right Conduct', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(25, 5, 'Filipino', 'FIL5', 'Grade 5 subject: Filipino', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(26, 5, 'English', 'ENG5', 'Grade 5 subject: English', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(27, 5, 'Mathematics', 'MATH5', 'Grade 5 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(28, 5, 'Science', 'SCI5', 'Grade 5 subject: Science', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(29, 5, 'Araling Panlipunan', 'AP5', 'Grade 5 subject: Araling Panlipunan', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(30, 5, 'Music, Arts, Physical Education, Health', 'MAPEH5', 'Grade 5 subject: Music, Arts, Physical Education, Health', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(31, 5, 'Edukasyong Pantahanan at Pangkabuhayan', 'EPP5', 'Grade 5 subject: Edukasyong Pantahanan at Pangkabuhayan', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(32, 5, 'Good Manners and Right Conduct', 'GMRC5', 'Grade 5 subject: Good Manners and Right Conduct', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(33, 6, 'Filipino', 'FIL6', 'Grade 6 subject: Filipino', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(34, 6, 'English', 'ENG6', 'Grade 6 subject: English', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(35, 6, 'Mathematics', 'MATH6', 'Grade 6 subject: Mathematics', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(36, 6, 'Science', 'SCI6', 'Grade 6 subject: Science', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(37, 6, 'Araling Panlipunan', 'AP6', 'Grade 6 subject: Araling Panlipunan', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(38, 6, 'Music, Arts, Physical Education, Health', 'MAPEH6', 'Grade 6 subject: Music, Arts, Physical Education, Health', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(39, 6, 'Technology and Livelihood Education', 'TLE6', 'Grade 6 subject: Technology and Livelihood Education', '2026-04-22 17:04:36', '2026-04-22 17:04:36'),
(40, 6, 'Edukasyon sa Pagpapakatao', 'ESP6', 'Grade 6 subject: Edukasyon sa Pagpapakatao', '2026-04-22 17:04:36', '2026-04-22 17:04:36');

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
(1, NULL, NULL, 'Maria', NULL, 'Delrosario', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'msdelrosario@mgmail.com', '0996 266 7323', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, 'active', NULL, '2026-04-23 13:39:51', '2026-04-23 13:39:51', NULL),
(2, NULL, NULL, 'Jennie', NULL, 'Sikad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'msjensikd@gmail.com', '0996 266 7323', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, 'active', NULL, '2026-04-23 14:48:03', '2026-04-24 02:35:46', NULL);

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
-- Table structure for table `teaching_programs`
--

CREATE TABLE `teaching_programs` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `school_year_id` bigint UNSIGNED NOT NULL,
  `day` enum('M','T','W','TH','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci,
  `minutes` int NOT NULL DEFAULT '0',
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` json DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lrn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `status`, `email`, `email_verified_at`, `password`, `password_updated_at`, `photo`, `is_active`, `remember_token`, `settings`, `two_factor_enabled`, `two_factor_secret`, `two_factor_recovery_codes`, `created_at`, `updated_at`, `lrn`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `username`) VALUES
(1, 1, 'active', 'admin@tugaweES.edu.ph', NULL, '$2y$12$GfLRuQ7Y.o2.JJwIvUOIlOd7cQNvv5.JbBEtkf64baEOBBW1C1AUm', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-22 17:04:37', '2026-04-22 17:04:37', NULL, 'System', NULL, 'Admin', NULL, NULL, 'admin'),
(2, 3, 'active', 'registrar@tugaweES.edu.ph', NULL, '$2y$12$Eyi.Gob1qM.YxZC3kw2q/OFVZOfPb4G0PK8kBiINARlza7lfMKGTu', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-22 17:04:37', '2026-04-22 17:04:37', NULL, 'Registrar', NULL, 'User', NULL, NULL, 'registrar'),
(5, 4, 'active', 'juandesantos@gmail.com', NULL, '$2y$12$PpflWxww1wUm2Wuc0OGCX.LVCLQU0VLRs7FbG6/ZXWKzTtwAq9B0G', NULL, 'profile-photos/ZvhSj2K1jzAPYRGpvystr6d2MlMTxJXOgi577UjX.jpg', 1, NULL, NULL, 0, NULL, NULL, '2026-04-23 13:33:27', '2026-04-23 20:46:14', NULL, 'Juan', 'Dela Cruz', 'Santos', NULL, NULL, 'juansantos11'),
(6, 2, 'active', 'msdelrosario@mgmail.com', NULL, '$2y$12$eFdPqP3e76mtm62GxEA9vu7Q2gGR6o85tMSpQ2bfopBekCIZ1TXoi', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-23 13:39:51', '2026-04-23 13:39:51', NULL, 'Maria', NULL, 'Delrosario', NULL, NULL, 'msdelrosario09'),
(7, 2, 'active', 'msjensikd@gmail.com', NULL, '$2y$12$PF9hR3wAJ1Oxdex7o5iGbeVjo04VzoG0vlbKeRyIkaDPme5hbZUkq', NULL, 'profile-photos/o5HkR7r7NgbFP5uMm6DIfOMVgkzMbnoCUzRcK7Nf.jpg', 1, NULL, '{\"theme\": \"light\", \"language\": \"en\", \"date_format\": \"MM/DD/YYYY\", \"time_format\": \"12h\", \"system_updates\": \"1\", \"grade_reminders\": \"1\", \"profile_visible\": \"1\", \"show_last_active\": \"1\", \"attendance_alerts\": \"1\", \"sms_notifications\": \"0\", \"email_notifications\": \"1\", \"email_visible_to_students\": \"0\", \"new_student_notifications\": \"0\"}', 0, NULL, NULL, '2026-04-23 14:48:03', '2026-04-24 02:37:10', NULL, 'Jennie', NULL, 'Sikad', NULL, NULL, 'mssikad11'),
(8, 4, 'active', 'ezimeitradio@gmail.com', NULL, '$2y$12$pLC4vbxlxwWRIUEoFGuif.kP7YOVxsdd1aRL7HOGpYxZLMRlDFzwq', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-04-23 17:54:46', '2026-04-23 17:54:46', NULL, 'Ejie Mae', 'Santos', 'Tradio', NULL, NULL, 'ezimei31'),
(9, 4, 'active', 'evarocksredhell@gmail.com', NULL, '$2y$12$lfSHCWTWMTPwgIGHyhHQoOCf9RMoEvCRGRWOS/xYEInrVQQgHGTtO', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-23 20:33:05', '2026-04-23 20:33:05', NULL, 'Noime', 'Talorete', 'Baldomar', NULL, NULL, 'evarocksredhell'),
(10, 4, 'active', 'ruffamae@gmail.com', NULL, '$2y$12$4qbQkqCBVYlFdeZDDNcoXO//pwlRQ.74x2UrTiJMtTT/qXPl3b02S', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-23 20:40:03', '2026-04-23 20:40:03', NULL, 'Ruffa Mae', NULL, 'Sapan', NULL, NULL, 'ruffamaego');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_settings`
--

CREATE TABLE `user_notification_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `email_new_message` tinyint(1) NOT NULL DEFAULT '1',
  `email_announcement` tinyint(1) NOT NULL DEFAULT '1',
  `email_grade_posted` tinyint(1) NOT NULL DEFAULT '1',
  `email_attendance_alert` tinyint(1) NOT NULL DEFAULT '1',
  `email_assignment_due` tinyint(1) NOT NULL DEFAULT '1',
  `sms_new_message` tinyint(1) NOT NULL DEFAULT '0',
  `sms_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `sms_grade_posted` tinyint(1) NOT NULL DEFAULT '0',
  `sms_attendance_alert` tinyint(1) NOT NULL DEFAULT '1',
  `sms_assignment_due` tinyint(1) NOT NULL DEFAULT '0',
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notification_settings`
--

INSERT INTO `user_notification_settings` (`id`, `user_id`, `email_new_message`, `email_announcement`, `email_grade_posted`, `email_attendance_alert`, `email_assignment_due`, `sms_new_message`, `sms_announcement`, `sms_grade_posted`, `sms_attendance_alert`, `sms_assignment_due`, `phone_number`, `phone_verified`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-23 14:00:03', '2026-04-23 14:00:03'),
(3, 6, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-23 15:22:06', '2026-04-23 15:22:06'),
(4, 7, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-23 15:22:50', '2026-04-23 15:22:50'),
(5, 8, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-23 19:45:40', '2026-04-23 19:45:40'),
(6, 10, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-23 20:42:32', '2026-04-23 20:42:32');

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
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_entity_type_entity_id_index` (`entity_type`,`entity_id`),
  ADD KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `activity_logs_action_index` (`action`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_author_id_foreign` (`author_id`),
  ADD KEY `announcements_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `announcements_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `announcement_attachments`
--
ALTER TABLE `announcement_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_attachments_announcement_id_foreign` (`announcement_id`);

--
-- Indexes for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcement_reads_announcement_id_user_id_unique` (`announcement_id`,`user_id`),
  ADD KEY `announcement_reads_user_id_foreign` (`user_id`);

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
-- Indexes for table `attendance_school_days`
--
ALTER TABLE `attendance_school_days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section_month_year` (`section_id`,`school_year_id`,`month`,`year`),
  ADD KEY `attendance_school_days_school_year_id_month_year_index` (`school_year_id`,`month`,`year`),
  ADD KEY `attendance_school_days_section_id_is_finalized_index` (`section_id`,`is_finalized`),
  ADD KEY `attendance_school_days_configured_by_foreign` (`configured_by`);

--
-- Indexes for table `biometric_credentials`
--
ALTER TABLE `biometric_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `biometric_credentials_credential_id_unique` (`credential_id`),
  ADD KEY `biometric_credentials_user_id_index` (`user_id`),
  ADD KEY `biometric_credentials_credential_id_index` (`credential_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_student_id_status_index` (`student_id`,`status`),
  ADD KEY `books_student_id_index` (`student_id`),
  ADD KEY `books_subject_area_index` (`subject_area`),
  ADD KEY `books_status_index` (`status`),
  ADD KEY `books_school_year_id_foreign` (`school_year_id`),
  ADD KEY `books_book_inventory_id_foreign` (`book_inventory_id`);

--
-- Indexes for table `book_inventories`
--
ALTER TABLE `book_inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_inventories_book_code_unique` (`book_code`),
  ADD KEY `book_inventories_grade_level_id_foreign` (`grade_level_id`);

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
  ADD UNIQUE KEY `unique_student_year` (`student_id`,`school_year_id`),
  ADD KEY `fk_enrollment_school_year` (`school_year_id`),
  ADD KEY `enrollments_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `enrollments_section_id_foreign` (`section_id`);

--
-- Indexes for table `enrollment_applications`
--
ALTER TABLE `enrollment_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_applications_status_created_at_index` (`status`,`created_at`),
  ADD KEY `enrollment_applications_application_number_index` (`application_number`),
  ADD KEY `enrollment_applications_school_year_id_foreign` (`school_year_id`),
  ADD KEY `enrollment_applications_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `enrollment_applications_student_id_foreign` (`student_id`),
  ADD KEY `enrollment_applications_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `enrollment_documents`
--
ALTER TABLE `enrollment_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_documents_enrollment_application_id_foreign` (`enrollment_application_id`),
  ADD KEY `enrollment_documents_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_school_year_id_foreign` (`school_year_id`),
  ADD KEY `events_created_by_foreign` (`created_by`);

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
  ADD KEY `grades_school_year_id_foreign` (`school_year_id`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `grade_levels`
--
ALTER TABLE `grade_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_weights`
--
ALTER TABLE `grade_weights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_grade_weights` (`section_id`,`subject_id`,`school_year_id`,`quarter`),
  ADD KEY `grade_weights_subject_id_foreign` (`subject_id`),
  ADD KEY `grade_weights_school_year_id_foreign` (`school_year_id`);

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
-- Indexes for table `kindergarten_domains`
--
ALTER TABLE `kindergarten_domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kindergarten_domains_unique` (`student_id`,`domain`,`indicator_key`,`quarter`,`school_year_id`),
  ADD KEY `kindergarten_domains_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_recipient_id_foreign` (`recipient_id`),
  ADD KEY `messages_parent_id_foreign` (`parent_id`),
  ADD KEY `messages_section_id_foreign` (`section_id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_message_id_foreign` (`message_id`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifications_type_created_at_index` (`type`,`created_at`),
  ADD KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `promotion_histories`
--
ALTER TABLE `promotion_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotion_unique_per_year` (`student_id`,`from_school_year_id`,`to_school_year_id`),
  ADD KEY `promotion_histories_from_school_year_id_foreign` (`from_school_year_id`),
  ADD KEY `promotion_histories_to_school_year_id_foreign` (`to_school_year_id`),
  ADD KEY `promotion_histories_from_grade_level_id_foreign` (`from_grade_level_id`),
  ADD KEY `promotion_histories_to_grade_level_id_foreign` (`to_grade_level_id`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_subscribable_morph_idx` (`subscribable_type`,`subscribable_id`);

--
-- Indexes for table `report_schedules`
--
ALTER TABLE `report_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_schedules_frequency_is_active_index` (`frequency`,`is_active`),
  ADD KEY `report_schedules_saved_report_id_foreign` (`saved_report_id`),
  ADD KEY `report_schedules_next_send_at_index` (`next_send_at`);

--
-- Indexes for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_templates_slug_unique` (`slug`),
  ADD KEY `report_templates_category_is_active_index` (`category`,`is_active`),
  ADD KEY `report_templates_slug_index` (`slug`),
  ADD KEY `report_templates_created_by_foreign` (`created_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `saved_reports`
--
ALTER TABLE `saved_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_reports_template_id_user_id_index` (`template_id`,`user_id`),
  ADD KEY `saved_reports_user_id_is_favorite_index` (`user_id`,`is_favorite`),
  ADD KEY `saved_reports_is_scheduled_index` (`is_scheduled`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_section_id_foreign` (`section_id`),
  ADD KEY `schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `schedules_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `school_locations`
--
ALTER TABLE `school_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_locations_latitude_longitude_index` (`latitude`,`longitude`),
  ADD KEY `school_locations_is_active_index` (`is_active`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_year_closures`
--
ALTER TABLE `school_year_closures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_school_year_closure` (`school_year_id`),
  ADD KEY `school_year_closures_closed_by_foreign` (`closed_by`);

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
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `sections_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `section_finalizations`
--
ALTER TABLE `section_finalizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section_school_year` (`section_id`,`school_year_id`),
  ADD KEY `section_finalizations_school_year_id_is_fully_finalized_index` (`school_year_id`,`is_fully_finalized`),
  ADD KEY `section_finalizations_teacher_id_is_fully_finalized_index` (`teacher_id`,`is_fully_finalized`),
  ADD KEY `section_finalizations_finalized_by_foreign` (`finalized_by`),
  ADD KEY `section_finalizations_unlocked_by_foreign` (`unlocked_by`),
  ADD KEY `section_finalizations_grades_unlocked_by_foreign` (`grades_unlocked_by`),
  ADD KEY `section_finalizations_attendance_unlocked_by_foreign` (`attendance_unlocked_by`),
  ADD KEY `section_finalizations_core_values_unlocked_by_foreign` (`core_values_unlocked_by`);

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
  ADD KEY `students_school_year_id_foreign` (`school_year_id`),
  ADD KEY `students_documents_verified_by_foreign` (`documents_verified_by`);

--
-- Indexes for table `student_health_records`
--
ALTER TABLE `student_health_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_health_records_student_id_foreign` (`student_id`),
  ADD KEY `student_health_records_section_id_foreign` (`section_id`),
  ADD KEY `student_health_records_school_year_id_foreign` (`school_year_id`),
  ADD KEY `student_health_records_assessed_by_foreign` (`assessed_by`);

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
-- Indexes for table `teaching_programs`
--
ALTER TABLE `teaching_programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tp_unique_schedule` (`teacher_id`,`section_id`,`school_year_id`,`day`,`time_from`),
  ADD KEY `teaching_programs_section_id_foreign` (`section_id`),
  ADD KEY `teaching_programs_school_year_id_foreign` (`school_year_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_lrn_unique` (`lrn`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_notification_settings_user_id_unique` (`user_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement_attachments`
--
ALTER TABLE `announcement_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_school_days`
--
ALTER TABLE `attendance_school_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biometric_credentials`
--
ALTER TABLE `biometric_credentials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_inventories`
--
ALTER TABLE `book_inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollment_applications`
--
ALTER TABLE `enrollment_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollment_documents`
--
ALTER TABLE `enrollment_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `grade_weights`
--
ALTER TABLE `grade_weights`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interventions`
--
ALTER TABLE `interventions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kindergarten_domains`
--
ALTER TABLE `kindergarten_domains`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `promotion_histories`
--
ALTER TABLE `promotion_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_schedules`
--
ALTER TABLE `report_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_templates`
--
ALTER TABLE `report_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saved_reports`
--
ALTER TABLE `saved_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_locations`
--
ALTER TABLE `school_locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `school_year_closures`
--
ALTER TABLE `school_year_closures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_year_qr_codes`
--
ALTER TABLE `school_year_qr_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section_finalizations`
--
ALTER TABLE `section_finalizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section_subject`
--
ALTER TABLE `section_subject`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_health_records`
--
ALTER TABLE `student_health_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `teaching_programs`
--
ALTER TABLE `teaching_programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `announcements_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `announcements_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcement_attachments`
--
ALTER TABLE `announcement_attachments`
  ADD CONSTRAINT `announcement_attachments_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  ADD CONSTRAINT `announcement_reads_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcement_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `attendance_school_days`
--
ALTER TABLE `attendance_school_days`
  ADD CONSTRAINT `attendance_school_days_configured_by_foreign` FOREIGN KEY (`configured_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendance_school_days_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_school_days_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biometric_credentials`
--
ALTER TABLE `biometric_credentials`
  ADD CONSTRAINT `biometric_credentials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_book_inventory_id_foreign` FOREIGN KEY (`book_inventory_id`) REFERENCES `book_inventories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `books_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`);

--
-- Constraints for table `book_inventories`
--
ALTER TABLE `book_inventories`
  ADD CONSTRAINT `book_inventories_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_school_year` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollment_applications`
--
ALTER TABLE `enrollment_applications`
  ADD CONSTRAINT `enrollment_applications_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollment_applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enrollment_applications_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollment_applications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollment_documents`
--
ALTER TABLE `enrollment_documents`
  ADD CONSTRAINT `enrollment_documents_enrollment_application_id_foreign` FOREIGN KEY (`enrollment_application_id`) REFERENCES `enrollment_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollment_documents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `grade_weights`
--
ALTER TABLE `grade_weights`
  ADD CONSTRAINT `grade_weights_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_weights_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_weights_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interventions`
--
ALTER TABLE `interventions`
  ADD CONSTRAINT `interventions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kindergarten_domains`
--
ALTER TABLE `kindergarten_domains`
  ADD CONSTRAINT `kindergarten_domains_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kindergarten_domains_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_histories`
--
ALTER TABLE `promotion_histories`
  ADD CONSTRAINT `promotion_histories_from_grade_level_id_foreign` FOREIGN KEY (`from_grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_from_school_year_id_foreign` FOREIGN KEY (`from_school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_to_grade_level_id_foreign` FOREIGN KEY (`to_grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_to_school_year_id_foreign` FOREIGN KEY (`to_school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_schedules`
--
ALTER TABLE `report_schedules`
  ADD CONSTRAINT `report_schedules_saved_report_id_foreign` FOREIGN KEY (`saved_report_id`) REFERENCES `saved_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD CONSTRAINT `report_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `saved_reports`
--
ALTER TABLE `saved_reports`
  ADD CONSTRAINT `saved_reports_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `report_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_year_closures`
--
ALTER TABLE `school_year_closures`
  ADD CONSTRAINT `school_year_closures_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `school_year_closures_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `section_finalizations`
--
ALTER TABLE `section_finalizations`
  ADD CONSTRAINT `section_finalizations_attendance_unlocked_by_foreign` FOREIGN KEY (`attendance_unlocked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `section_finalizations_core_values_unlocked_by_foreign` FOREIGN KEY (`core_values_unlocked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `section_finalizations_finalized_by_foreign` FOREIGN KEY (`finalized_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `section_finalizations_grades_unlocked_by_foreign` FOREIGN KEY (`grades_unlocked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `section_finalizations_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_finalizations_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_finalizations_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section_finalizations_unlocked_by_foreign` FOREIGN KEY (`unlocked_by`) REFERENCES `users` (`id`);

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
  ADD CONSTRAINT `students_documents_verified_by_foreign` FOREIGN KEY (`documents_verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_health_records`
--
ALTER TABLE `student_health_records`
  ADD CONSTRAINT `student_health_records_assessed_by_foreign` FOREIGN KEY (`assessed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_health_records_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_health_records_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_health_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `teaching_programs`
--
ALTER TABLE `teaching_programs`
  ADD CONSTRAINT `teaching_programs_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_programs_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_programs_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  ADD CONSTRAINT `user_notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
