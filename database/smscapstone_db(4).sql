-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2026 at 11:13 PM
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
(1, NULL, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-11 10:25:59'),
(2, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"dark_mode\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-14 23:59:40'),
(3, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"dark_mode\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:02:39'),
(4, NULL, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:04:28'),
(5, NULL, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:04:35'),
(6, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"school_name\", \"school_code\", \"deped_school_id\", \"school_address\", \"school_email\", \"school_phone\", \"school_division\", \"school_region\", \"school_district\", \"school_head\", \"school_logo\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:41:12'),
(7, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"school_name\", \"school_code\", \"deped_school_id\", \"school_address\", \"school_email\", \"school_phone\", \"school_division\", \"school_region\", \"school_district\", \"school_head\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:48:59'),
(8, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"dark_mode\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:52:39'),
(9, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"dark_mode\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:52:51'),
(10, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"dark_mode\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:53:45'),
(11, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"school_name\", \"school_code\", \"deped_school_id\", \"school_address\", \"school_email\", \"school_phone\", \"school_division\", \"school_region\", \"school_district\", \"school_head\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:02:30'),
(12, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"compact_mode\", \"dark_mode\", \"animations\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:02:40'),
(13, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"compact_mode\", \"dark_mode\", \"animations\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:03:26'),
(14, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"compact_mode\", \"dark_mode\", \"animations\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:07:33'),
(15, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"compact_mode\", \"dark_mode\", \"animations\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:08:21'),
(16, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"primary_color\", \"secondary_color\", \"accent_color\", \"compact_mode\", \"dark_mode\", \"animations\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 01:08:36'),
(17, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 18:05:02'),
(18, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 18:06:14'),
(19, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 18:08:39'),
(20, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 18:22:33'),
(21, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 18:46:03'),
(22, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-18 19:04:09'),
(23, NULL, 'updated', 'Setting', NULL, 'Settings updated by admin', NULL, '{\"changed_keys\": [\"active_school_year_id\", \"current_school_year\", \"school_year_start\", \"school_year_end\", \"grading_system\", \"passing_grade\", \"enrollment_start_date\", \"enrollment_end_date\", \"allow_late_enrollment\", \"enrollment_enabled\"]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-19 05:02:11'),
(24, 119, 'cleared', 'ActivityLog', NULL, 'Cleared 0 activity logs older than 30 days', NULL, '{\"days\": \"30\", \"deleted_count\": 0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:44:25'),
(25, 119, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:44:35'),
(26, 119, 'enabled', 'Setting', NULL, 'Enrollment submissions enabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:44:42'),
(27, 119, 'cleared', 'ActivityLog', NULL, 'Cleared 0 activity logs older than 30 days', NULL, '{\"days\": \"30\", \"deleted_count\": 0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 13:29:50'),
(28, 119, 'cleared', 'ActivityLog', NULL, 'Cleared 0 activity logs older than 10 days', NULL, '{\"days\": \"10\", \"deleted_count\": 0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 13:30:14'),
(29, 119, 'cleared', 'ActivityLog', NULL, 'Cleared 0 activity logs older than 30 days', NULL, '{\"days\": \"30\", \"deleted_count\": 0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 13:33:55'),
(30, 119, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 13:34:15'),
(31, 119, 'enabled', 'Setting', NULL, 'Enrollment submissions enabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 13:34:21'),
(32, 119, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 21:47:11'),
(33, 119, 'enabled', 'Setting', NULL, 'Enrollment submissions enabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 21:47:14'),
(34, 119, 'disabled', 'Setting', NULL, 'Enrollment submissions disabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-21 12:27:31'),
(35, 119, 'enabled', 'Setting', NULL, 'Enrollment submissions enabled', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-21 12:27:33');

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

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `section_id`, `student_id`, `school_year_id`, `date`, `status`, `teacher_id`, `remarks`, `latitude`, `longitude`, `accuracy`, `location_verified`, `distance_from_school`, `location_status`, `created_at`, `updated_at`) VALUES
(144, 1, 74, 1, '2025-06-02', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 04:56:09', '2026-04-20 04:56:09'),
(145, 1, 75, 1, '2025-06-02', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 04:56:09', '2026-04-20 04:56:09'),
(146, 1, 76, 1, '2025-06-02', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 04:56:09', '2026-04-20 04:56:09'),
(147, 1, 74, 1, '2026-03-05', 'absent', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 22:06:51', '2026-04-20 22:06:51'),
(148, 1, 75, 1, '2026-03-05', 'absent', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 22:06:51', '2026-04-20 22:06:51'),
(149, 1, 76, 1, '2026-03-05', 'absent', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 22:06:51', '2026-04-20 22:06:51'),
(150, 1, 74, 1, '2026-03-06', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:35:46', '2026-04-21 04:35:46'),
(151, 1, 75, 1, '2026-03-06', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:35:46', '2026-04-21 04:35:46'),
(152, 1, 76, 1, '2026-03-06', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:35:46', '2026-04-21 04:35:46'),
(153, 1, 74, 1, '2025-06-18', 'late', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:23', '2026-04-21 04:42:23'),
(154, 1, 75, 1, '2025-06-18', 'absent', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:23', '2026-04-21 04:42:23'),
(155, 1, 76, 1, '2025-06-18', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:23', '2026-04-21 04:42:23'),
(156, 1, 74, 1, '2025-06-19', 'late', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:41', '2026-04-21 04:42:41'),
(157, 1, 75, 1, '2025-06-19', 'present', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:41', '2026-04-21 04:42:41'),
(158, 1, 76, 1, '2025-06-19', 'absent', 11, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-21 04:42:41', '2026-04-21 04:42:41');

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
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Title of the textbook or learning material',
  `subject_area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Subject area (e.g., Math, Science, English)',
  `book_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Internal book tracking code',
  `reference_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ISBN or official reference number',
  `date_issued` date DEFAULT NULL COMMENT 'Date when book was issued to student',
  `date_returned` date DEFAULT NULL COMMENT 'Date when book was returned',
  `status` enum('issued','returned','lost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issued' COMMENT 'Current status of the book',
  `condition` enum('new','good','used','damaged') COLLATE utf8mb4_unicode_ci NOT NULL,
  `damage_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Description of damage if applicable',
  `loss_code` enum('FM','TDO','NEG') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'FM=Force Majeure, TDO=Transferred/Dropout, NEG=Negligence',
  `action_taken` enum('LLTR','TLTR','PTL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LLTR=Letter from Learner, TLTR=Teacher Letter, PTL=Paid',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Additional notes or comments',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_year_id` bigint UNSIGNED DEFAULT NULL,
  `book_inventory_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `student_id`, `title`, `subject_area`, `book_code`, `reference_code`, `date_issued`, `date_returned`, `status`, `condition`, `damage_details`, `loss_code`, `action_taken`, `remarks`, `created_at`, `updated_at`, `school_year_id`, `book_inventory_id`) VALUES
(3, 65, 'English', 'English', 'ENG-100', '787-1-00-123456-0', '2026-04-04', NULL, 'issued', 'new', NULL, NULL, NULL, NULL, '2026-04-04 04:24:09', '2026-04-04 04:24:09', 2, 1),
(4, 68, 'English', 'English', 'ENG-100', '787-1-00-123456-0', '2026-04-04', '2026-04-04', 'returned', 'used', NULL, NULL, NULL, NULL, '2026-04-04 04:30:38', '2026-04-04 13:59:10', 2, 1);

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

--
-- Dumping data for table `book_inventories`
--

INSERT INTO `book_inventories` (`id`, `title`, `subject_area`, `grade_level`, `book_code`, `isbn`, `publisher`, `publication_year`, `total_copies`, `available_copies`, `issued_copies`, `damaged_copies`, `lost_copies`, `replacement_cost`, `remarks`, `created_at`, `updated_at`, `grade_level_id`) VALUES
(1, 'English', 'English', 'Grade 3', 'ENG-100', '787-1-00-123456-0', NULL, NULL, 50, 49, 3, 0, 0, NULL, NULL, '2026-04-04 03:58:05', '2026-04-04 13:59:10', NULL);

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
('tugawees-sms-cache-94d92f976fd06fd3e8cf53ec4e03d646', 'i:1;', 1776866760),
('tugawees-sms-cache-94d92f976fd06fd3e8cf53ec4e03d646:timer', 'i:1776866760;', 1776866760),
('tugawees-sms-cache-app_settings', 'a:59:{s:11:\"system_name\";s:24:\"Tugawe Elementary School\";s:11:\"school_name\";s:24:\"Tugawe Elementary School\";s:15:\"deped_school_id\";s:6:\"120231\";s:15:\"school_division\";s:27:\"Division of Negros Oriental\";s:13:\"school_region\";s:26:\"Negros Island Region (NIR)\";s:11:\"school_head\";s:26:\"MAE HARRIET M. DELA  PEÑA\";s:21:\"active_school_year_id\";s:1:\"1\";s:13:\"passing_grade\";i:75;s:15:\"school_district\";s:14:\"Dauin District\";s:18:\"enrollment_enabled\";b:1;s:8:\"timezone\";s:11:\"Asia/Manila\";s:11:\"date_format\";s:6:\"F d, Y\";s:16:\"default_language\";s:2:\"en\";s:16:\"maintenance_mode\";b:0;s:17:\"user_registration\";b:1;s:18:\"email_verification\";b:1;s:11:\"school_code\";s:8:\"TES-2026\";s:14:\"school_address\";s:48:\"Tugawe, Dauin, Negros Oriental, Philippines 6217\";s:12:\"school_email\";s:19:\"teswecare@gmail.com\";s:12:\"school_phone\";s:11:\"09934469637\";s:11:\"school_logo\";s:53:\"settings/xuZVe6b9Z2NmzqycdwcjoNnOv8dbLX9JXdgKUpWS.png\";s:19:\"current_school_year\";s:9:\"2025-2026\";s:17:\"school_year_start\";s:10:\"2025-06-01\";s:15:\"school_year_end\";s:10:\"2026-03-31\";s:14:\"grading_system\";s:9:\"quarterly\";s:21:\"enrollment_start_date\";s:0:\"\";s:19:\"enrollment_end_date\";s:0:\"\";s:21:\"allow_late_enrollment\";b:1;s:18:\"notify_new_student\";b:1;s:17:\"notify_attendance\";b:1;s:13:\"notify_grades\";b:1;s:20:\"notify_announcements\";b:1;s:11:\"sms_enabled\";b:0;s:12:\"sms_provider\";s:0:\"\";s:11:\"mail_driver\";s:4:\"smtp\";s:9:\"mail_host\";s:0:\"\";s:9:\"mail_port\";i:587;s:13:\"mail_username\";s:0:\"\";s:13:\"mail_password\";s:0:\"\";s:15:\"mail_encryption\";s:3:\"tls\";s:17:\"mail_from_address\";s:0:\"\";s:14:\"mail_from_name\";s:24:\"Tugawe Elementary School\";s:19:\"min_password_length\";i:8;s:15:\"password_expiry\";i:90;s:16:\"strong_passwords\";b:1;s:11:\"require_2fa\";b:0;s:15:\"session_timeout\";i:480;s:18:\"max_login_attempts\";i:5;s:19:\"login_notifications\";b:1;s:13:\"primary_color\";s:7:\"#6366f1\";s:15:\"secondary_color\";s:7:\"#10b981\";s:12:\"accent_color\";s:7:\"#f59e0b\";s:12:\"compact_mode\";b:1;s:9:\"dark_mode\";b:0;s:10:\"animations\";b:1;s:11:\"auto_backup\";b:0;s:11:\"last_backup\";s:5:\"Never\";s:11:\"api_enabled\";b:0;s:7:\"api_key\";s:0:\"\";}', 1776900670),
('tugawees-sms-cache-user-online-103', 'b:1;', 1776691553);

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
(64, 1, 2, 74, 1, 'continuing', 'enrolled', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'Negros Island Region (NIR)', '2026-04-18', '2026-04-18 05:40:02', '2026-04-18 07:53:13', NULL),
(65, 1, 2, 75, 1, 'continuing', 'enrolled', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'Negros Island Region (NIR)', '2026-04-18', '2026-04-18 07:00:07', '2026-04-18 07:53:00', NULL),
(66, 1, 2, 76, 1, 'transferee', 'enrolled', 'Cantil-e Elementary School', 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'Negros Island Region (NIR)', '2026-04-18', '2026-04-18 07:51:14', '2026-04-18 07:52:10', 'TI'),
(67, 1, 3, 77, NULL, 'transferee', 'rejected', 'Mag-aso Elementary School', 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'Negros Island Region (NIR)', '2026-04-22', '2026-04-22 06:04:43', '2026-04-22 06:06:07', NULL);

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
(10, 'foundation day', NULL, '2026-07-07', '2026-04-16 07:45:54', '2026-04-16 07:45:54', 2, NULL);

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

--
-- Dumping data for table `grade_weights`
--

INSERT INTO `grade_weights` (`id`, `section_id`, `subject_id`, `school_year_id`, `quarter`, `ww_weight`, `pt_weight`, `qe_weight`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 10.00, 60.00, 30.00, '2026-04-11 21:35:32', '2026-04-11 21:43:58'),
(2, 1, 1, 1, 2, 10.00, 60.00, 30.00, '2026-04-11 21:42:34', '2026-04-11 21:42:34'),
(3, 1, 1, 1, 3, 10.00, 60.00, 30.00, '2026-04-11 21:55:43', '2026-04-11 21:55:43'),
(4, 1, 1, 1, 4, 10.00, 60.00, 30.00, '2026-04-11 21:57:39', '2026-04-11 21:57:39'),
(5, 1, 2, 1, 1, 10.00, 60.00, 30.00, '2026-04-11 22:08:58', '2026-04-11 22:08:58'),
(6, 1, 2, 1, 2, 10.00, 60.00, 30.00, '2026-04-11 22:10:15', '2026-04-11 22:10:15'),
(7, 1, 2, 1, 3, 10.00, 60.00, 30.00, '2026-04-11 22:11:42', '2026-04-11 22:11:42'),
(8, 1, 2, 1, 4, 10.00, 60.00, 30.00, '2026-04-11 22:13:59', '2026-04-11 22:13:59'),
(9, 1, 3, 1, 1, 40.00, 40.00, 20.00, '2026-04-11 22:17:28', '2026-04-11 22:17:28'),
(10, 1, 3, 1, 2, 40.00, 40.00, 20.00, '2026-04-11 22:18:46', '2026-04-11 22:18:46'),
(11, 1, 3, 1, 3, 40.00, 40.00, 20.00, '2026-04-11 22:21:52', '2026-04-11 22:21:52'),
(12, 1, 3, 1, 4, 40.00, 40.00, 20.00, '2026-04-11 22:23:18', '2026-04-11 22:23:18'),
(13, 1, 4, 1, 4, 40.00, 40.00, 20.00, '2026-04-11 22:24:18', '2026-04-11 22:24:18'),
(14, 1, 4, 1, 1, 40.00, 40.00, 20.00, '2026-04-11 22:26:41', '2026-04-11 22:26:41'),
(15, 1, 4, 1, 2, 40.00, 40.00, 20.00, '2026-04-11 22:27:28', '2026-04-11 22:27:28'),
(16, 1, 4, 1, 3, 40.00, 40.00, 20.00, '2026-04-11 22:29:10', '2026-04-11 22:29:10'),
(17, 1, 5, 1, 1, 40.00, 40.00, 20.00, '2026-04-11 22:30:43', '2026-04-11 22:30:43'),
(18, 1, 5, 1, 2, 40.00, 40.00, 20.00, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(19, 1, 5, 1, 3, 40.00, 40.00, 20.00, '2026-04-11 22:32:38', '2026-04-11 22:32:38'),
(20, 1, 5, 1, 4, 40.00, 40.00, 20.00, '2026-04-11 22:34:14', '2026-04-11 22:34:14');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"5baac91a-8ddf-4b18-83ee-57f7f8bd12ed\",\"displayName\":\"App\\\\Events\\\\AnnouncementPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\AnnouncementPosted\\\":1:{s:12:\\\"announcement\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Announcement\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:2:{i:0;s:6:\\\"author\\\";i:1;s:11:\\\"attachments\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1775752052,\"delay\":null}', 0, NULL, 1775752052, 1775752052),
(2, 'default', '{\"uuid\":\"ea0238b7-0220-4efa-95ab-b53383349e77\",\"displayName\":\"App\\\\Events\\\\AnnouncementPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\AnnouncementPosted\\\":1:{s:12:\\\"announcement\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Announcement\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:2:{i:0;s:6:\\\"author\\\";i:1;s:11:\\\"attachments\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1775754434,\"delay\":null}', 0, NULL, 1775754434, 1775754434),
(3, 'default', '{\"uuid\":\"3f9ed4d5-9eb6-4bc3-86e0-83cf6f5f1f76\",\"displayName\":\"App\\\\Events\\\\AnnouncementPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:29:\\\"App\\\\Events\\\\AnnouncementPosted\\\":1:{s:12:\\\"announcement\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Announcement\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:2:{i:0;s:6:\\\"author\\\";i:1;s:11:\\\"attachments\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1775755377,\"delay\":null}', 0, NULL, 1775755377, 1775755377);

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
(28, 116, 103, 'Message from Crestian Bajado Tuayon', 'good evening ma\'am', 0, '2026-04-18 08:24:23', '2026-04-18 09:44:27', 1, 0, '2026-04-18 09:44:27', 0, NULL, NULL, NULL),
(29, 103, 116, 'Message from Samantha  Kim', 'hello good day ging', 0, '2026-04-18 09:44:43', '2026-04-18 09:45:15', 1, 0, '2026-04-18 09:45:15', 0, 28, NULL, NULL),
(30, 116, 103, 'Message from Crestian Bajado Tuayon', '', 0, '2026-04-18 09:45:33', '2026-04-18 09:46:04', 1, 0, '2026-04-18 09:46:04', 0, 29, NULL, NULL),
(31, 103, 116, 'Message from Samantha  Kim', '', 0, '2026-04-18 09:46:24', '2026-04-20 04:01:06', 1, 0, '2026-04-20 04:01:06', 0, 28, NULL, NULL);

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

--
-- Dumping data for table `message_attachments`
--

INSERT INTO `message_attachments` (`id`, `message_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`) VALUES
(10, 30, '6ccd9e90b2d51356b19451f03a2698d1.jpg', 'message-attachments/30/ADJ33Ao5xXrpokWB3PaMgVgKLKPFGk489zcQ6My8.jpg', 'image/jpeg', 36658, '2026-04-18 09:45:33', '2026-04-18 09:45:33'),
(11, 31, 'logo.png', 'message-attachments/31/xAeuNgOXvnakEiAfzzXPbTW4iTGdByvpqQsE95Z6.png', 'image/png', 342804, '2026-04-18 09:46:24', '2026-04-18 09:46:24');

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
(87, '2026_03_31_164346_create_core_values_table', 83),
(88, '2026_04_02_230352_create_promotion_histories_table', 84),
(89, '2026_04_03_021607_create_book_issuances_table', 85),
(90, '2026_04_03_100324_create_sf3_records_table', 86),
(91, '2026_04_03_102314_create_book_inventories_table', 87),
(92, '2026_04_03_102436_create_books_table', 88),
(93, '2026_04_03_233121_add_school_year_id_to_books_table', 89),
(94, '2026_04_04_114613_add_grade_level_id_to_book_inventories', 90),
(95, '2026_04_04_115951_add_book_inventory_id_to_books', 91),
(96, '2026_04_04_120522_modify_condition_in_books', 92),
(97, '2026_04_05_034817_create_teaching_programs_table', 93),
(98, '2026_04_05_084434_create_message_attachments_table', 94),
(99, '2026_04_05_084444_add_threading_to_messages_table', 95),
(100, '2026_04_05_121649_create_user_notification_settings_table', 96),
(101, '2026_04_05_123925_fix_notifications_table_add_user_id', 97),
(102, '2026_04_05_141718_add_registration_documents_to_students_table', 98),
(103, '2026_04_05_152917_add_student_lrn_to_enrollment_applications_table', 99),
(104, '2026_04_05_153137_update_application_type_enum', 100),
(105, '2026_04_09_000000_add_is_edited_to_messages_table', 101),
(106, '2026_04_09_160753_add_announcement_metadata_to_announcements_table', 102),
(107, '2026_04_09_160756_create_announcement_reads_table', 103),
(108, '2026_04_09_160757_create_announcement_attachments_table', 104),
(109, '2026_04_10_000001_create_section_finalizations_table', 105),
(110, '2026_04_10_000002_create_school_year_closures_table', 106),
(111, '2026_04_10_000003_create_attendance_school_days_table', 107),
(112, '2025_04_11_000000_create_push_subscriptions_table', 108),
(113, '2025_04_11_000001_create_biometric_credentials_table', 109),
(114, '2026_04_11_113353_create_school_locations_table', 110),
(115, '2026_04_11_113353_add_location_to_attendance_table', 111),
(116, '2026_04_11_132425_create_report_templates_table', 112),
(117, '2026_04_11_132425_create_saved_reports_table', 113),
(118, '2026_04_11_132427_create_report_schedules_table', 114),
(119, '2026_04_12_052304_create_grade_weights_table', 115),
(120, '2026_04_12_071705_add_component_unlock_tracking_to_section_finalizations', 116),
(121, '2026_04_12_000001_create_kindergarten_domains_table', 117),
(122, '2026_04_14_234731_add_password_updated_at_to_users_table', 118),
(123, '2026_04_16_150000_add_created_by_to_events_table', 119),
(124, '2026_04_20_103354_create_sessions_table', 120);

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
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 'Student Masterlist', 'student-masterlist', 'Complete roster of all students with filtering options by grade level, section, and status.', 'academic', 'table', '[{\"key\": \"lrn\", \"type\": \"text\", \"label\": \"LRN\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"gender\", \"type\": \"text\", \"label\": \"Gender\"}, {\"key\": \"birthdate\", \"type\": \"date\", \"label\": \"Birthdate\"}, {\"key\": \"age\", \"type\": \"number\", \"label\": \"Age\"}, {\"key\": \"contact\", \"type\": \"text\", \"label\": \"Contact\"}, {\"key\": \"status\", \"type\": \"badge\", \"label\": \"Status\"}]', '[\"school_year_id\", \"grade_level_id\", \"section_id\", \"gender\", \"status\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01\"/>', 'blue', 1, 1, NULL, '2026-04-11 06:01:25', '2026-04-11 06:01:25'),
(2, 'Grade Summary Report', 'grade-summary', 'Comprehensive grade report showing quarterly grades and final averages by student and subject.', 'academic', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"subject\", \"type\": \"text\", \"label\": \"Subject\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"q1\", \"type\": \"number\", \"label\": \"Q1\"}, {\"key\": \"q2\", \"type\": \"number\", \"label\": \"Q2\"}, {\"key\": \"q3\", \"type\": \"number\", \"label\": \"Q3\"}, {\"key\": \"q4\", \"type\": \"number\", \"label\": \"Q4\"}, {\"key\": \"final\", \"type\": \"number\", \"label\": \"Final\"}, {\"key\": \"remarks\", \"type\": \"badge\", \"label\": \"Remarks\"}]', '[\"school_year_id\", \"section_id\", \"subject_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'green', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(3, 'Honor Roll', 'honor-roll', 'List of students who achieved honors based on general average.', 'academic', 'table', '[{\"key\": \"rank\", \"type\": \"number\", \"label\": \"Rank\"}, {\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"general_average\", \"type\": \"number\", \"label\": \"General Average\"}, {\"key\": \"honor\", \"type\": \"badge\", \"label\": \"Honor\"}]', '[\"school_year_id\", \"grade_level_id\", \"min_average\"]', NULL, '{\"min_average\": 90}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z\"/>', 'purple', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(4, 'Class Performance Report', 'class-performance', 'Performance metrics for each section including average grades and passing rates.', 'academic', 'combined', '[{\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"adviser\", \"type\": \"text\", \"label\": \"Adviser\"}, {\"key\": \"total_students\", \"type\": \"number\", \"label\": \"Students\"}, {\"key\": \"average_grade\", \"type\": \"number\", \"label\": \"Avg Grade\"}, {\"key\": \"passing_rate\", \"type\": \"percentage\", \"label\": \"Passing Rate\"}]', '[\"school_year_id\", \"section_id\", \"grade_level_id\"]', '{\"type\": \"bar\", \"x_axis\": \"section\", \"y_axis\": \"average_grade\"}', NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'indigo', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(5, 'Attendance Summary', 'attendance-summary', 'Daily attendance records with present, absent, and late counts by student.', 'attendance', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"present\", \"type\": \"number\", \"label\": \"Present\"}, {\"key\": \"absent\", \"type\": \"number\", \"label\": \"Absent\"}, {\"key\": \"late\", \"type\": \"number\", \"label\": \"Late\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"attendance_rate\", \"type\": \"percentage\", \"label\": \"Rate\"}]', '[\"section_id\", \"start_date\", \"end_date\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4\"/>', 'amber', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(6, 'Attendance Trend', 'attendance-trend', 'Visual trend of attendance rates over a specified time period.', 'attendance', 'chart', '[{\"key\": \"date\", \"type\": \"date\", \"label\": \"Date\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"present\", \"type\": \"number\", \"label\": \"Present\"}, {\"key\": \"rate\", \"type\": \"percentage\", \"label\": \"Rate\"}]', '[\"section_id\", \"days\"]', '{\"type\": \"line\", \"x_axis\": \"date\", \"y_axis\": \"rate\"}', '{\"days\": 30}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z\"/>', 'cyan', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(7, 'Enrollment Statistics', 'enrollment-statistics', 'Enrollment numbers broken down by grade level and section.', 'enrollment', 'combined', '[{\"key\": \"grade_level\", \"type\": \"text\", \"label\": \"Grade Level\"}, {\"key\": \"total\", \"type\": \"number\", \"label\": \"Total\"}, {\"key\": \"male\", \"type\": \"number\", \"label\": \"Male\"}, {\"key\": \"female\", \"type\": \"number\", \"label\": \"Female\"}]', '[\"school_year_id\", \"grade_level_id\"]', '{\"type\": \"bar\", \"x_axis\": \"grade_level\", \"y_axis\": \"total\"}', NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"/>', 'teal', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(8, 'At-Risk Students Report', 'dropout-risk', 'Identify students at risk of dropping out based on attendance and grade patterns.', 'analytics', 'table', '[{\"key\": \"student_name\", \"type\": \"text\", \"label\": \"Student Name\"}, {\"key\": \"section\", \"type\": \"text\", \"label\": \"Section\"}, {\"key\": \"attendance_rate\", \"type\": \"percentage\", \"label\": \"Attendance\"}, {\"key\": \"average_grade\", \"type\": \"number\", \"label\": \"Avg Grade\"}, {\"key\": \"risk_factors\", \"type\": \"text\", \"label\": \"Risk Factors\"}, {\"key\": \"risk_level\", \"type\": \"badge\", \"label\": \"Risk Level\"}]', '[\"school_year_id\", \"attendance_threshold\", \"grade_threshold\"]', NULL, '{\"grade_threshold\": 75, \"attendance_threshold\": 75}', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"/>', 'red', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(9, 'Teacher Workload Report', 'teacher-workload', 'Overview of teaching assignments and student load per teacher.', 'analytics', 'table', '[{\"key\": \"teacher_name\", \"type\": \"text\", \"label\": \"Teacher Name\"}, {\"key\": \"specialization\", \"type\": \"text\", \"label\": \"Specialization\"}, {\"key\": \"sections_handled\", \"type\": \"number\", \"label\": \"Sections\"}, {\"key\": \"subjects\", \"type\": \"text\", \"label\": \"Subjects\"}, {\"key\": \"total_students\", \"type\": \"number\", \"label\": \"Total Students\"}]', '[]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z\"/>', 'orange', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(10, 'SF1 - School Register', 'sf1-school-register', 'DepEd School Register form with complete student information.', 'compliance', 'table', '[{\"key\": \"no\", \"type\": \"number\", \"label\": \"No.\"}, {\"key\": \"lrn\", \"type\": \"text\", \"label\": \"LRN\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Learner Name\"}, {\"key\": \"gender\", \"type\": \"text\", \"label\": \"Sex\"}, {\"key\": \"birthdate\", \"type\": \"date\", \"label\": \"Birth Date\"}, {\"key\": \"age\", \"type\": \"number\", \"label\": \"Age\"}, {\"key\": \"mother_tongue\", \"type\": \"text\", \"label\": \"Mother Tongue\"}, {\"key\": \"religion\", \"type\": \"text\", \"label\": \"Religion\"}, {\"key\": \"address\", \"type\": \"text\", \"label\": \"Address\"}, {\"key\": \"father_name\", \"type\": \"text\", \"label\": \"Father\'s Name\"}, {\"key\": \"mother_name\", \"type\": \"text\", \"label\": \"Mother\'s Name\"}, {\"key\": \"guardian_name\", \"type\": \"text\", \"label\": \"Guardian\'s Name\"}, {\"key\": \"guardian_contact\", \"type\": \"text\", \"label\": \"Contact\"}]', '[\"school_year_id\", \"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(11, 'SF2 - Daily Attendance', 'sf2-daily-attendance', 'DepEd Daily Attendance Report of Learners.', 'compliance', 'table', '[{\"key\": \"no\", \"type\": \"number\", \"label\": \"No.\"}, {\"key\": \"name\", \"type\": \"text\", \"label\": \"Name\"}, {\"key\": \"days_present\", \"type\": \"number\", \"label\": \"Days Present\"}, {\"key\": \"days_absent\", \"type\": \"number\", \"label\": \"Days Absent\"}, {\"key\": \"days_late\", \"type\": \"number\", \"label\": \"Days Late\"}, {\"key\": \"total_days\", \"type\": \"number\", \"label\": \"Total Days\"}]', '[\"section_id\", \"month\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"/>', 'gray', 1, 1, NULL, '2026-04-11 06:02:51', '2026-04-11 06:02:51'),
(12, 'SF3 - Books Issued and Returned', 'sf3-books', 'DepEd record of books issued and returned by students.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(13, 'SF4 - Monthly Learner Movement and Attendance', 'sf4-monthly-movement', 'DepEd monthly movement and attendance summary.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(14, 'SF5 - Report on Promotion and Level of Proficiency', 'sf5-promotion', 'DepEd report on promotion and proficiency levels by grade.', 'compliance', 'table', '[]', '[\"grade_level_id\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(15, 'SF6 - Summary Report on Promotion', 'sf6-summary-promotion', 'DepEd summary report on promotion and retention.', 'compliance', 'table', '[]', '[\"grade_level_id\", \"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(16, 'SF7 - School Personnel Assignment List', 'sf7-personnel', 'DepEd list of teaching and non-teaching personnel assignments.', 'compliance', 'table', '[]', '[\"school_year_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(17, 'SF8 - Learner Health and Nutrition', 'sf8-health-nutrition', 'DepEd report on learner health and nutrition profile.', 'compliance', 'table', '[]', '[\"section_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(18, 'SF9 - Report Card', 'sf9-report-card', 'DepEd Learner Progress Report Card.', 'compliance', 'table', '[]', '[\"section_id\", \"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(19, 'SF10 - Learner Permanent Record', 'sf10-permanent-record', 'DepEd Learner Permanent Academic Record.', 'compliance', 'table', '[]', '[\"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08'),
(20, 'Kindergarten Assessment', 'kindergarten-assessment', 'DepEd Kindergarten Developmental Domains Assessment.', 'compliance', 'table', '[]', '[\"section_id\", \"student_id\"]', NULL, NULL, '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"/>', 'gray', 1, 1, NULL, '2026-04-13 15:15:08', '2026-04-13 15:15:08');

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

--
-- Dumping data for table `school_locations`
--

INSERT INTO `school_locations` (`id`, `name`, `type`, `latitude`, `longitude`, `radius_meters`, `address`, `is_active`, `require_location`, `allowed_schedules`, `created_at`, `updated_at`) VALUES
(1, 'Tugawe Elementary School - Main Campus', 'main_campus', 9.18330000, 123.26670000, 150, 'Tugawe, Dauin, Negros Oriental, Philippines', 1, 1, NULL, '2026-04-11 03:47:25', '2026-04-11 03:47:25');

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
(1, '2025-2026', '2025-06-13', '2026-04-05', 1, 'School year 2026-2027 (current)', '2026-03-22 01:56:23', '2026-04-21 04:34:46'),
(2, '2026-2027', '2026-06-01', '2027-03-31', 0, 'School year 2027-2028', '2026-03-22 01:56:23', '2026-04-20 22:09:20'),
(3, '2027-2028', '2027-06-01', '2028-03-31', 0, 'School year 2028-2029', '2026-03-22 01:56:23', '2026-04-18 21:02:11'),
(4, '2028-2029', '2028-06-01', '2029-03-31', 0, 'School year 2029-2030', '2026-03-22 01:56:23', '2026-04-18 21:02:11'),
(5, '2039-2030', '2029-06-01', '2030-03-31', 0, 'School year 2030-2031', '2026-03-22 01:56:23', '2026-04-18 21:02:11');

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
(1, 2, 'pending', 7, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-04-10 14:48:35', '2026-04-10 14:48:35'),
(2, 1, 'pending', 7, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-04-10 14:54:28', '2026-04-20 04:53:07');

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
(24, 1, '2qwMAzhckzlPSFRuBcPjzyhqcDG2HnIr', 'qr-codes/school-year-1-2qwMAzhckzlPSFRuBcPjzyhqcDG2HnIr.png', 0, '2027-03-29 13:40:01', '2026-03-29 05:40:01', '2026-04-01 19:28:31'),
(25, 2, 'Qwt2TlIYUxbM4fpa4f1pOvy84K805YXG', 'qr-codes/school-year-2-Qwt2TlIYUxbM4fpa4f1pOvy84K805YXG.png', 0, '2027-03-29 14:15:58', '2026-03-29 06:15:58', '2026-04-02 14:34:13'),
(26, 1, 'XGnQOVvpX2absJCSu7ygw1oYe2TpY8u5', 'qr-codes/school-year-1-XGnQOVvpX2absJCSu7ygw1oYe2TpY8u5.png', 0, '2027-03-29 14:16:14', '2026-03-29 06:16:14', '2026-04-01 19:28:31'),
(27, 1, '8q3YZalduggjJ6OBKUTprXbLcHkAA5Ks', 'qr-codes/school-year-1-8q3YZalduggjJ6OBKUTprXbLcHkAA5Ks.png', 0, '2027-03-30 12:27:01', '2026-03-30 04:27:01', '2026-04-01 19:28:31'),
(28, 1, 'jlOeTGUAtvhTdjlzWZ4ksm8ds71dnn2o', 'qr-codes/school-year-1-jlOeTGUAtvhTdjlzWZ4ksm8ds71dnn2o.png', 0, '2027-03-30 13:12:49', '2026-03-30 05:12:49', '2026-04-01 19:28:31'),
(29, 2, 'JvAQb6RYmihrxuMc9I2iyCr30H11f8xV', 'qr-codes/school-year-2-JvAQb6RYmihrxuMc9I2iyCr30H11f8xV.png', 0, '2027-04-02 06:21:03', '2026-04-01 22:21:03', '2026-04-02 14:34:13');

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
(1, 'SALAS', 2, 1, 'ROOM101', 11, 40, '2026-03-22 02:05:23', '2026-04-18 09:08:06', 1),
(2, 'ROSE', 4, 1, 'ROOM102', 8, 40, '2026-03-22 23:10:06', '2026-04-20 13:58:23', 1),
(3, 'MENDES', 3, 1, 'ROOM103', 9, 40, '2026-03-27 03:14:07', '2026-04-20 13:58:07', 1),
(4, 'ALAMA', 7, 1, 'ROOM103', 13, 40, '2026-04-02 16:05:18', '2026-04-20 13:59:42', 1),
(5, 'JUPITER', 6, 1, 'ROOM105', 12, 40, '2026-04-02 16:06:35', '2026-04-20 13:59:08', 1),
(6, 'SATURN', 5, 1, 'ROOM104', 17, 40, '2026-04-02 16:34:28', '2026-04-20 13:58:49', 1),
(7, 'MACIAS', 1, 1, 'ROOM100', 15, 40, '2026-04-02 16:35:30', '2026-04-18 09:17:38', 1);

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
(1, 2, 2, 8, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-04-10 04:10:40', '2026-04-10 04:10:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 1, 8, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-04-10 14:57:19', '2026-04-10 14:57:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 1, 11, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 103, 0, '2026-04-12 01:53:56', '2026-04-20 04:53:01', 119, '2026-04-20 04:53:01', 'needs to be edited', NULL, 0, '2026-04-11 20:51:02', '2026-04-20 04:53:01', 119, 'needs to be edited', '2026-04-20 04:53:01', 119, 'needs to be edited', '2026-04-20 04:53:01', 119, 'needs to be edited'),
(4, 7, 1, 15, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, '2026-04-20 04:53:20', 119, '2026-04-20 04:53:20', 'needs to be edited', NULL, 0, '2026-04-12 06:24:55', '2026-04-20 04:53:20', 119, 'needs to be edited', '2026-04-20 04:53:20', 119, 'needs to be edited', '2026-04-20 04:53:20', 119, 'needs to be edited');

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
('6AWkPrKbPt5faKe0iMvruhCV2xD2EQbndzxsGKoh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3V6M3RXUXhzMzM3WVphSm5jdXNRTldIOUZIam1PNlhzazZlZjFaMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776899356);

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
(1, 'system_name', 'Tugawe Elementary School', 'string', 'general', 'The name of the system displayed throughout the application', 0, 1, 0, NULL, '2026-04-14 15:51:42'),
(2, 'school_name', 'Tugawe Elementary School', 'string', 'school', 'Official name of the school', 0, 1, 0, NULL, '2026-04-14 15:51:42'),
(3, 'deped_school_id', '120231', 'string', 'school', 'DepEd assigned school ID', 0, 1, 0, NULL, '2026-04-14 16:41:12'),
(4, 'school_division', 'Division of Negros Oriental', 'string', 'school', 'School division', 0, 1, 0, NULL, '2026-04-14 16:48:59'),
(5, 'school_region', 'Negros Island Region (NIR)', 'string', 'school', 'School region', 0, 1, 0, NULL, '2026-04-14 16:48:59'),
(6, 'school_head', 'MAE HARRIET M. DELA  PEÑA', 'string', 'school', 'School head/principal', 0, 1, 0, NULL, '2026-04-14 16:48:59'),
(7, 'active_school_year_id', '1', 'string', 'school', 'Active school year ID', 0, 1, 0, NULL, '2026-04-18 10:05:02'),
(8, 'passing_grade', '75', 'integer', 'academic', 'Minimum passing grade percentage', 0, 1, 0, NULL, '2026-04-14 15:51:42'),
(9, 'school_district', 'Dauin District', 'string', 'school', 'School district', 0, 1, 0, NULL, '2026-04-14 16:48:59'),
(10, 'enrollment_enabled', '1', 'boolean', 'enrollment', 'Allow students to submit enrollment requests', 0, 1, 0, '2026-04-06 03:26:35', '2026-04-21 04:27:33'),
(11, 'timezone', 'Asia/Manila', 'string', 'general', 'Default timezone for the application', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(12, 'date_format', 'F d, Y', 'string', 'general', 'Format for displaying dates', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(13, 'default_language', 'en', 'string', 'general', 'Default language for the application', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(14, 'maintenance_mode', '0', 'boolean', 'general', 'Enable maintenance mode', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(15, 'user_registration', '1', 'boolean', 'general', 'Allow new user registration', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(16, 'email_verification', '1', 'boolean', 'general', 'Require email verification for new accounts', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(17, 'school_code', 'TES-2026', 'string', 'school', 'School code identifier', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 16:41:12'),
(18, 'school_address', 'Tugawe, Dauin, Negros Oriental, Philippines 6217', 'string', 'school', 'Complete school address', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 16:41:12'),
(19, 'school_email', 'teswecare@gmail.com', 'string', 'school', 'School contact email', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 16:48:59'),
(20, 'school_phone', '09934469637', 'string', 'school', 'School contact phone number', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 16:48:59'),
(21, 'school_logo', 'settings/xuZVe6b9Z2NmzqycdwcjoNnOv8dbLX9JXdgKUpWS.png', 'string', 'school', 'Path to school logo image', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 16:41:12'),
(22, 'current_school_year', '2025-2026', 'string', 'academic', 'Current active school year', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-18 10:05:02'),
(23, 'school_year_start', '2025-06-01', 'string', 'academic', 'Start date of the current school year', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-18 10:05:02'),
(24, 'school_year_end', '2026-03-31', 'string', 'academic', 'End date of the current school year', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-18 10:05:02'),
(25, 'grading_system', 'quarterly', 'string', 'academic', 'Grading period system', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(26, 'enrollment_start_date', '', 'string', 'academic', 'Enrollment period start date', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(27, 'enrollment_end_date', '', 'string', 'academic', 'Enrollment period end date', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(28, 'allow_late_enrollment', '1', 'boolean', 'academic', 'Allow enrollment after the deadline', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-18 10:06:14'),
(29, 'notify_new_student', '1', 'boolean', 'notifications', 'Send email on new student enrollment', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(30, 'notify_attendance', '1', 'boolean', 'notifications', 'Notify parents of student absences', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(31, 'notify_grades', '1', 'boolean', 'notifications', 'Send notification when grades are published', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(32, 'notify_announcements', '1', 'boolean', 'notifications', 'Send notification for new announcements', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(33, 'sms_enabled', '0', 'boolean', 'notifications', 'Enable SMS notifications', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(34, 'sms_provider', '', 'string', 'notifications', 'SMS gateway provider', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(35, 'mail_driver', 'smtp', 'string', 'email', 'Mail driver', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(36, 'mail_host', '', 'string', 'email', 'SMTP host', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(37, 'mail_port', '587', 'integer', 'email', 'SMTP port', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(38, 'mail_username', '', 'string', 'email', 'SMTP username', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(39, 'mail_password', '', 'string', 'email', 'SMTP password', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(40, 'mail_encryption', 'tls', 'string', 'email', 'SMTP encryption', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(41, 'mail_from_address', '', 'string', 'email', 'From email address', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(42, 'mail_from_name', 'Tugawe Elementary School', 'string', 'email', 'From name', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(43, 'min_password_length', '8', 'integer', 'security', 'Minimum required password length', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(44, 'password_expiry', '90', 'integer', 'security', 'Days until password expires (0 = never)', 0, 1, 0, '2026-04-14 15:51:42', '2026-04-14 15:51:42'),
(45, 'strong_passwords', '1', 'boolean', 'security', 'Require complex passwords', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(46, 'require_2fa', '0', 'boolean', 'security', 'Require two-factor authentication', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(47, 'session_timeout', '480', 'integer', 'security', 'Session timeout in minutes', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-20 04:22:39'),
(48, 'max_login_attempts', '5', 'integer', 'security', 'Maximum failed login attempts per minute', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(49, 'login_notifications', '1', 'boolean', 'security', 'Send email on new login', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(50, 'primary_color', '#6366f1', 'string', 'appearance', 'Primary brand color', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(51, 'secondary_color', '#10b981', 'string', 'appearance', 'Secondary accent color', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(52, 'accent_color', '#f59e0b', 'string', 'appearance', 'Accent color', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(53, 'compact_mode', '1', 'boolean', 'appearance', 'Use compact spacing', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 17:08:21'),
(54, 'dark_mode', '0', 'boolean', 'appearance', 'Enable dark theme', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 17:08:21'),
(55, 'animations', '1', 'boolean', 'appearance', 'Enable UI animations', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(56, 'auto_backup', '0', 'boolean', 'backup', 'Enable automatic daily backups', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(57, 'last_backup', 'Never', 'string', 'backup', 'Last backup timestamp', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(58, 'api_enabled', '0', 'boolean', 'advanced', 'Enable API access', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43'),
(59, 'api_key', '', 'string', 'advanced', 'API authentication key', 0, 1, 0, '2026-04-14 15:51:43', '2026-04-14 15:51:43');

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
(74, 116, '120231260000', '2004-01-07', 'Dauin', 'Male', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Roman Catholic', 'Nelson A. Tuayon', 'Farmer', 'Agripina B. Tuyaon', 'Farmer', 'Lourdes T. Alcoriza', 'Grandparent', '09368726547', 'PUROK 5', 'TUGAWE', 'DAUIN', 'NEGROS ORIENTAL', '6217', 2, 1, NULL, '2026-04-18 05:40:02', '2026-04-18 07:53:13', NULL, NULL, NULL),
(75, 117, '120231260001', '2003-10-31', 'Dauin', 'Female', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Catholic', 'Mario Tradio', 'Engineer', 'Maria Tradio', 'Business Owner', 'Maria Tradio', 'Parent', '09934638844', 'LUCA', 'LIPAYO', 'DAUIN', 'NEGROS ORIENTAL', '6217', 2, 1, NULL, '2026-04-18 07:00:07', '2026-04-18 07:53:00', NULL, NULL, NULL),
(76, 118, '120231260002', '2003-11-06', 'Bayawan City', 'Female', 'active', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Christianity', 'Mario Baldomar', 'Farmer', 'Maria Baldomar', 'Farmer', 'Maria Baldomar', 'Parent', '09934638844', 'PUROK TWIN HEARTS', 'CANTIL-E', 'DUMAGUETE CITY', 'NEGROS ORIENTAL', '6200', 2, 1, NULL, '2026-04-18 07:51:14', '2026-04-18 07:52:10', NULL, 'TI', NULL),
(77, NULL, '120221260000', '2010-10-10', 'Dauin', 'Male', 'inactive', NULL, NULL, NULL, NULL, 'pending', NULL, 'Bisaya', 'NegOrense', 'Filipino', 'Christianity', 'Jose Santos', 'Businessman', 'Macy Santos', 'Housewife', 'Lorna Del Valle', 'Grandparent', '0975995268', 'Purok 4', 'MAG-ASO', 'DAUIN', 'NEGROS ORIENTAL', '6217', 3, NULL, NULL, '2026-04-22 06:04:43', '2026-04-22 06:04:43', NULL, NULL, NULL);

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
(8, NULL, NULL, 'Maria', NULL, 'Santos', NULL, NULL, 'Dauin', 'female', 'single', 'Filipino', 'Roman Catholic', 'AB-', 'mariasan@gmail.com', '0936 872 6547', NULL, 'Elithon', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 'NIR', NULL, NULL, NULL, NULL, 'substitute', NULL, NULL, NULL, 'I', 'Teacher 1', NULL, 0, NULL, NULL, 'bachelor', 'BEED', NULL, NULL, 'NORSU', 2016, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 66, NULL, NULL, NULL, 'active', NULL, '2026-03-25 02:22:47', '2026-04-09 15:19:35', 1),
(9, NULL, NULL, 'Shane', NULL, 'Mendes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'msmendes@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 70, NULL, NULL, NULL, 'active', NULL, '2026-03-27 03:13:09', '2026-03-27 03:13:09', 1),
(11, NULL, NULL, 'Samantha', NULL, 'Kim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kimisamanttha@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 103, NULL, NULL, NULL, 'active', NULL, '2026-04-10 15:35:18', '2026-04-11 05:31:34', NULL),
(12, NULL, NULL, 'Monique', NULL, 'Filipinas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'msfilipinas@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 104, NULL, NULL, NULL, 'active', NULL, '2026-04-10 15:37:46', '2026-04-10 15:37:46', NULL),
(13, NULL, NULL, 'Anthony', NULL, 'Rapsing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mranthon@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 105, NULL, NULL, NULL, 'active', NULL, '2026-04-10 15:38:45', '2026-04-10 15:38:45', NULL),
(15, NULL, NULL, 'Nancy', NULL, 'Lewis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mslewis@gmail.com', '0936 872 6547', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 107, NULL, NULL, NULL, 'active', NULL, '2026-04-10 15:41:08', '2026-04-10 15:41:08', NULL),
(17, NULL, NULL, 'Melvin', NULL, 'Benitez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'benitezmelv@gmail.com', '0996 266 7110', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 113, NULL, NULL, NULL, 'active', NULL, '2026-04-14 05:55:20', '2026-04-14 05:55:20', NULL);

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

--
-- Dumping data for table `teaching_programs`
--

INSERT INTO `teaching_programs` (`id`, `teacher_id`, `section_id`, `school_year_id`, `day`, `time_from`, `time_to`, `subject`, `activity`, `minutes`, `created_at`, `updated_at`) VALUES
(3, 8, 2, 2, 'M', '08:00:00', '09:00:00', 'English', NULL, 60, '2026-04-04 20:07:30', '2026-04-04 20:07:30');

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
  `password_updated_at` timestamp NULL DEFAULT NULL,
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

INSERT INTO `users` (`id`, `role_id`, `status`, `email`, `email_verified_at`, `password`, `password_updated_at`, `photo`, `is_active`, `remember_token`, `settings`, `two_factor_enabled`, `two_factor_secret`, `two_factor_recovery_codes`, `created_at`, `updated_at`, `lrn`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `username`) VALUES
(66, 2, 'active', 'mariasan@gmail.com', NULL, '$2y$12$3kEcB2mHyjA0b0SFLTlhfeVAFFhMXgKZSzPPX0zvJ7QQStLjJVvbS', NULL, 'profile-photos/LT2JUidn7dXUeJu7o6VDcoC1chsvGhUe9g7AJZoT.jpg', 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 02:22:47', '2026-04-09 15:19:35', NULL, 'Maria', NULL, 'Santos', NULL, NULL, 'msmaria'),
(70, 2, 'active', 'msmendes@gmail.com', NULL, '$2y$12$ws3zhjWNpiifRIzw9fbZgeVbItUrVD3anY5QCm1anpXuOT7q5xNZm', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-27 03:13:09', '2026-03-27 03:13:09', NULL, 'Shane', NULL, 'Mendes', NULL, NULL, 'msmendes'),
(103, 2, 'active', 'kimisamanttha@gmail.com', NULL, '$2y$12$T//na0UVyeybUqMdSJmqguEmgucAfOT8UA6KqHMdIuCNNQs7s.U3O', NULL, 'profile-photos/vNw2o6ShhM78RIaIkIwKwNg2WrnjIwsrEDy6wj4k.jpg', 1, NULL, '{\"theme\": \"dark\", \"language\": \"en\", \"date_format\": \"MM/DD/YYYY\", \"time_format\": \"12h\", \"system_updates\": \"1\", \"grade_reminders\": \"1\", \"profile_visible\": \"1\", \"show_last_active\": \"1\", \"attendance_alerts\": \"1\", \"sms_notifications\": \"0\", \"email_notifications\": \"1\", \"email_visible_to_students\": \"0\", \"new_student_notifications\": \"0\"}', 0, NULL, NULL, '2026-04-10 15:35:18', '2026-04-18 03:30:32', NULL, 'Samantha', NULL, 'Kim', NULL, NULL, 'mssamantha12'),
(104, 2, 'active', 'msfilipinas@gmail.com', NULL, '$2y$12$3jAMKTeIflGKoVfyG/ZXTu1wTxn1N7fDdYiBS9NNiLcp3CEuLDsRO', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-10 15:37:46', '2026-04-10 15:37:46', NULL, 'Monique', NULL, 'Filipinas', NULL, NULL, 'msmonique11'),
(105, 2, 'active', 'mranthon@gmail.com', NULL, '$2y$12$7Bpbm9PGKrr6jK0mRYDHp.XAv8gEt0FCBxB3ACcyo3yRld7FlhlxC', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-10 15:38:45', '2026-04-10 15:38:45', NULL, 'Anthony', NULL, 'Rapsing', NULL, NULL, 'mranthon113'),
(107, 2, 'active', 'mslewis@gmail.com', NULL, '$2y$12$NNZ.iJZJ48H5pdUlBF4ugea2Hv3ZXqMHBSymBE9q44NFeVBKUyBHi', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-10 15:41:08', '2026-04-10 15:41:08', NULL, 'Nancy', NULL, 'Lewis', NULL, NULL, 'mslewis90'),
(113, 2, 'active', 'benitezmelv@gmail.com', NULL, '$2y$12$pFHUea8onil6UTfsSwPL6ehL81Q29bcji6NqJjXACflgq19AWOTRi', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-14 05:55:20', '2026-04-14 05:55:20', NULL, 'Melvin', NULL, 'Benitez', NULL, NULL, 'mrmelv88'),
(116, 4, 'active', 'cresttuayon@gmail.com', NULL, '$2y$12$htT9Y.Lz5AZwHushLo0U2eZXaIlCXpSL9ebcpPgdwffFwJHF8mmAa', NULL, 'photos/ckCX8x2qyrp69Ufg0rrEepLcr4PF8B7Bv8pmQtTS.jpg', 0, NULL, NULL, 0, NULL, NULL, '2026-04-18 05:40:02', '2026-04-18 05:40:02', NULL, 'Crestian', 'Bajado', 'Tuayon', NULL, NULL, 'crstn'),
(117, 4, 'active', 'ezimeitradio@gmail.com', NULL, '$2y$12$svB0JrxUphHTfSbHU52j0.g/HHydaL22zNwJrUiPS4PHkt3FCTW8.', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-04-18 07:00:07', '2026-04-18 07:00:07', NULL, 'Ejie Mae', 'Santos', 'Tradio', NULL, NULL, 'ezimei31'),
(118, 4, 'active', 'evarocksredhell@gmail.com', NULL, '$2y$12$hIca/TKKecuCJGauMeYM0OBTIDBGGDre3hOMONq4grgzOp/EhLuOu', NULL, 'photos/44QrBVn5UY0hizHXp6Dc1AlTO1hB7QZJ3oZhIcGn.jpg', 0, NULL, NULL, 0, NULL, NULL, '2026-04-18 07:51:14', '2026-04-18 07:51:14', NULL, 'Noime', 'Talorete', 'Baldomar', NULL, NULL, 'evarocksredhell'),
(119, 1, 'active', 'tesadmin@gmail.com', NULL, '$2y$12$6YbvfsF2YO5sTUBQe6ei/O812RITol7jcODvmyw4Qmim0kxXoA74S', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-18 08:14:13', '2026-04-18 08:14:13', NULL, 'TugaweES', NULL, 'Administrator', NULL, NULL, 'tesadmin');

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
(2, 66, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-08 19:38:36', '2026-04-08 19:38:36'),
(4, 107, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, '2026-04-13 19:30:01', '2026-04-13 20:33:18'),
(6, 70, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-16 07:16:03', '2026-04-16 07:16:03'),
(7, 103, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-16 07:16:03', '2026-04-16 07:16:03'),
(8, 104, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-16 07:16:03', '2026-04-16 07:16:03'),
(9, 105, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-16 07:16:03', '2026-04-16 07:16:03'),
(10, 113, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-16 07:16:03', '2026-04-16 07:16:03'),
(14, 116, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, NULL, 0, '2026-04-18 08:24:04', '2026-04-18 08:24:04');

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
  ADD KEY `announcements_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `announcements_author_id_foreign` (`author_id`),
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
  ADD KEY `attendance_school_days_configured_by_foreign` (`configured_by`),
  ADD KEY `attendance_school_days_school_year_id_month_year_index` (`school_year_id`,`month`,`year`),
  ADD KEY `attendance_school_days_section_id_is_finalized_index` (`section_id`,`is_finalized`);

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
  ADD KEY `books_student_id_index` (`student_id`),
  ADD KEY `books_status_index` (`status`),
  ADD KEY `books_subject_area_index` (`subject_area`),
  ADD KEY `books_student_id_status_index` (`student_id`,`status`),
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
  ADD KEY `enrollments_section_id_foreign` (`section_id`),
  ADD KEY `enrollments_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `fk_enrollment_school_year` (`school_year_id`);

--
-- Indexes for table `enrollment_applications`
--
ALTER TABLE `enrollment_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_applications_school_year_id_foreign` (`school_year_id`),
  ADD KEY `enrollment_applications_grade_level_id_foreign` (`grade_level_id`),
  ADD KEY `enrollment_applications_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `enrollment_applications_status_created_at_index` (`status`,`created_at`),
  ADD KEY `enrollment_applications_application_number_index` (`application_number`),
  ADD KEY `enrollment_applications_student_id_foreign` (`student_id`);

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
  ADD KEY `grades_subject_id_foreign` (`subject_id`),
  ADD KEY `grades_school_year_id_foreign` (`school_year_id`);

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
  ADD KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`),
  ADD KEY `notifications_type_created_at_index` (`type`,`created_at`);

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
  ADD KEY `report_schedules_saved_report_id_foreign` (`saved_report_id`),
  ADD KEY `report_schedules_frequency_is_active_index` (`frequency`,`is_active`),
  ADD KEY `report_schedules_next_send_at_index` (`next_send_at`);

--
-- Indexes for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_templates_slug_unique` (`slug`),
  ADD KEY `report_templates_created_by_foreign` (`created_by`),
  ADD KEY `report_templates_category_is_active_index` (`category`,`is_active`),
  ADD KEY `report_templates_slug_index` (`slug`);

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
  ADD KEY `saved_reports_user_id_is_favorite_index` (`user_id`,`is_favorite`),
  ADD KEY `saved_reports_template_id_user_id_index` (`template_id`,`user_id`),
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
  ADD KEY `sections_teacher_id_foreign` (`teacher_id`),
  ADD KEY `school_year_id` (`school_year_id`);

--
-- Indexes for table `section_finalizations`
--
ALTER TABLE `section_finalizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section_school_year` (`section_id`,`school_year_id`),
  ADD KEY `section_finalizations_finalized_by_foreign` (`finalized_by`),
  ADD KEY `section_finalizations_unlocked_by_foreign` (`unlocked_by`),
  ADD KEY `section_finalizations_school_year_id_is_fully_finalized_index` (`school_year_id`,`is_fully_finalized`),
  ADD KEY `section_finalizations_teacher_id_is_fully_finalized_index` (`teacher_id`,`is_fully_finalized`),
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `announcement_attachments`
--
ALTER TABLE `announcement_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_inventories`
--
ALTER TABLE `book_inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `enrollment_applications`
--
ALTER TABLE `enrollment_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollment_documents`
--
ALTER TABLE `enrollment_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `grade_levels`
--
ALTER TABLE `grade_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade_weights`
--
ALTER TABLE `grade_weights`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `interventions`
--
ALTER TABLE `interventions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kindergarten_domains`
--
ALTER TABLE `kindergarten_domains`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `school_year_closures`
--
ALTER TABLE `school_year_closures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_year_qr_codes`
--
ALTER TABLE `school_year_qr_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `section_finalizations`
--
ALTER TABLE `section_finalizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `student_health_records`
--
ALTER TABLE `student_health_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
