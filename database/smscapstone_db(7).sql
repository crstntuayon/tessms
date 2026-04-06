-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2026 at 12:35 PM
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
(125, 2, 64, 1, '2026-04-02', 'present', 8, NULL, '2026-04-01 19:14:12', '2026-04-01 19:14:12'),
(126, 2, 65, 2, '2026-06-01', 'present', 8, NULL, '2026-04-02 03:29:53', '2026-04-02 03:29:53'),
(127, 2, 68, 2, '2026-04-04', 'present', 8, NULL, '2026-04-04 03:25:55', '2026-04-04 03:25:55'),
(128, 2, 65, 2, '2026-04-04', 'present', 8, NULL, '2026-04-04 03:25:55', '2026-04-04 03:25:55');

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
(4, 68, 'English', 'English', 'ENG-100', '787-1-00-123456-0', '2026-04-04', NULL, 'issued', 'good', NULL, NULL, NULL, NULL, '2026-04-04 04:30:38', '2026-04-04 04:30:38', 2, 1);

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
(1, 'English', 'English', 'Grade 3', 'ENG-100', '787-1-00-123456-0', NULL, NULL, 50, 48, 4, 0, 0, NULL, NULL, '2026-04-04 03:58:05', '2026-04-04 04:30:38', NULL);

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
('tugawees-sms-cache-app_settings', 'a:9:{s:11:\"system_name\";s:15:\"Tugawe ES - SMS\";s:11:\"school_name\";s:24:\"Tugawe Elementary School\";s:15:\"deped_school_id\";s:6:\"120231\";s:15:\"school_division\";s:27:\"Division of Negros Oriental\";s:13:\"school_region\";s:26:\"NIR - Negros Island Region\";s:11:\"school_head\";s:25:\"MAE HARRIET M. DELA PEÑA\";s:21:\"active_school_year_id\";i:1;s:13:\"passing_grade\";i:75;s:15:\"school_district\";s:14:\"Dauin District\";}', 1775303414);

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
(22, 65, 'Maka-Diyos', 'statement1', '1.1 Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(23, 65, 'Maka-Diyos', 'statement2', '1.2 Shows adherence to ethical principles by upholding truth', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(24, 65, 'Makatao', 'statement1', '2.1 Is sensitive to individual, social, and cultural differences', 'AO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(25, 65, 'Makatao', 'statement2', '2.2 Demonstrates contributions toward solidarity', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(26, 65, 'Maka-Kalikasan', 'statement1', '3.1 Cares for the environment and utilizes resources wisely, judiciously, and economically', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(27, 65, 'Maka-bansa', 'statement1', '4.1 Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(28, 65, 'Maka-bansa', 'statement2', '4.2 Demonstrates appropriate behavior in carrying out activities in the school, community, and country', 'SO', NULL, 4, 2, 66, '2026-04-02 03:31:45', '2026-04-02 03:31:45'),
(29, 65, 'Maka-Diyos', 'statement1', '1.1 Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'AO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(30, 65, 'Maka-Diyos', 'statement2', '1.2 Shows adherence to ethical principles by upholding truth', 'SO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(31, 65, 'Makatao', 'statement1', '2.1 Is sensitive to individual, social, and cultural differences', 'SO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(32, 65, 'Makatao', 'statement2', '2.2 Demonstrates contributions toward solidarity', 'SO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(33, 65, 'Maka-Kalikasan', 'statement1', '3.1 Cares for the environment and utilizes resources wisely, judiciously, and economically', 'AO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(34, 65, 'Maka-bansa', 'statement1', '4.1 Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'AO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40'),
(35, 65, 'Maka-bansa', 'statement2', '4.2 Demonstrates appropriate behavior in carrying out activities in the school, community, and country', 'AO', NULL, 3, 2, 66, '2026-04-03 15:12:40', '2026-04-03 15:12:40');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `school_year_id`, `grade_level_id`, `student_id`, `section_id`, `type`, `status`, `previous_school`, `school_name`, `school_id`, `school_district`, `school_division`, `school_region`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(51, 1, 4, 64, 2, 'continuing', 'completed', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-04-02', '2026-04-01 18:42:45', '2026-04-01 19:28:31'),
(52, 2, 7, 65, 2, 'continuing', 'enrolled', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-04-02', '2026-04-01 22:23:35', '2026-04-02 14:34:13'),
(53, 2, 7, 66, NULL, 'continuing', 'pending', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-04-02', '2026-04-02 15:26:53', '2026-04-02 15:26:53'),
(55, 2, 4, 68, 2, 'continuing', 'enrolled', NULL, 'Tugawe Elementary School', '120231', 'Dauin District', 'Division of Negros Oriental', 'NIR - Negros Island Region', '2026-04-04', '2026-04-04 03:18:21', '2026-04-04 03:19:16');

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
(97, 2, 65, 2, 12, 1, 'written_work', '[\"17\", \"19\", \"15\"]', '[\"Quiz 1\", \"Quiz 2\", \"Quiz 3\"]', '[\"20\", \"20\", \"15\"]', 51, 92.73, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-02 03:29:27', '2026-04-03 14:48:10'),
(98, 2, 65, 2, 12, 1, 'performance_task', '[\"48\", \"27\"]', '[\"Group Report Chapter 1\", \"Group Report Chapter 2\"]', '[\"50\", \"30\"]', 75, 93.75, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-02 03:29:27', '2026-04-03 14:48:10'),
(99, 2, 65, 2, 12, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 37.09, 37.50, 7.60, 82.19, 88, 'Passed', '2026-04-02 03:29:27', '2026-04-03 14:48:10'),
(100, 2, 65, 2, 14, 1, 'written_work', '[\"15\", \"25\", \"17\"]', '[\"Chapter 1 Quiz\", \"Chapter 2 Quiz\", \"Chapter 3 Quiz\"]', '[\"15\", \"30\", \"20\"]', 57, 87.69, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-03 14:45:46', '2026-04-03 15:10:24'),
(101, 2, 65, 2, 14, 1, 'performance_task', '[\"95\", \"36\"]', '[\"SIP\", \"Debate\"]', '[\"100\", \"50\"]', 131, 87.33, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-03 14:45:46', '2026-04-03 15:10:24'),
(102, 2, 65, 2, 14, 1, 'final_grade', NULL, NULL, NULL, NULL, NULL, 35.08, 34.93, 14.00, 84.01, 90, 'Passed', '2026-04-03 14:45:47', '2026-04-03 15:10:24'),
(103, 2, 65, 2, 12, 1, 'quarterly_exam', NULL, NULL, NULL, 38, 38.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-03 14:48:10', '2026-04-03 14:48:10'),
(104, 2, 65, 2, 14, 1, 'quarterly_exam', NULL, NULL, '40', 28, 70.00, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-03 14:51:18', '2026-04-03 15:10:24');

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
(87, '2026_03_31_164346_create_core_values_table', 83),
(88, '2026_04_02_230352_create_promotion_histories_table', 84),
(89, '2026_04_03_021607_create_book_issuances_table', 85),
(90, '2026_04_03_100324_create_sf3_records_table', 86),
(91, '2026_04_03_102314_create_book_inventories_table', 87),
(92, '2026_04_03_102436_create_books_table', 88),
(93, '2026_04_03_233121_add_school_year_id_to_books_table', 89),
(94, '2026_04_04_114613_add_grade_level_id_to_book_inventories', 90),
(95, '2026_04_04_115951_add_book_inventory_id_to_books', 91),
(96, '2026_04_04_120522_modify_condition_in_books', 92);

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
(1, '2026-2027', '2026-06-01', NULL, 0, 'School year 2026-2027 (current)', '2026-03-22 01:56:23', '2026-04-02 16:43:25'),
(2, '2027-2028', '2027-06-01', NULL, 1, 'School year 2027-2028', '2026-03-22 01:56:23', '2026-04-02 16:43:39'),
(3, '2028-2029', '2028-06-01', NULL, 0, 'School year 2028-2029', '2026-03-22 01:56:23', '2026-04-02 16:43:39'),
(4, '2029-2030', '2029-06-01', NULL, 0, 'School year 2029-2030', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(5, '2030-2031', '2030-06-01', '2031-03-31', 0, 'School year 2030-2031', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(6, '2031-2032', '2031-06-01', '2032-03-31', 0, 'School year 2031-2032', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(7, '2032-2033', '2032-06-01', '2033-03-31', 0, 'School year 2032-2033', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(8, '2033-2034', '2033-06-01', '2034-03-31', 0, 'School year 2033-2034', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(9, '2034-2035', '2034-06-01', '2035-03-31', 0, 'School year 2034-2035', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(10, '2035-2036', '2035-06-01', '2036-03-31', 0, 'School year 2035-2036', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(11, '2036-2037', '2036-06-01', '2037-03-31', 0, 'School year 2036-2037', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(12, '2037-2038', '2037-06-01', '2038-03-31', 0, 'School year 2037-2038', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(13, '2038-2039', '2038-06-01', '2039-03-31', 0, 'School year 2038-2039', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(14, '2039-2040', '2039-06-01', '2040-03-31', 0, 'School year 2039-2040', '2026-03-22 01:56:23', '2026-04-02 14:34:38'),
(15, '2040-2041', '2040-06-01', '2041-03-31', 0, NULL, '2026-03-29 06:22:51', '2026-04-02 14:34:38'),
(16, '2041-2042', '2041-06-01', '2042-03-31', 0, 'School Year 2041-2042', '2026-03-29 06:25:27', '2026-04-02 14:34:38');

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
(1, 'SALAS', 2, 2, 'ROOM101', NULL, 40, '2026-03-22 02:05:23', '2026-04-02 16:11:36', 1),
(2, 'ROSE', 4, 2, 'ROOM102', 8, 40, '2026-03-22 23:10:06', '2026-04-02 16:12:44', 1),
(3, 'MENDES', 3, 2, 'ROOM103', 9, 40, '2026-03-27 03:14:07', '2026-04-02 16:20:52', 1),
(4, 'ALAMA', 7, 2, 'ROOM103', NULL, 40, '2026-04-02 16:05:18', '2026-04-02 16:05:18', 1),
(5, 'JUPITER', 6, 2, 'ROOM105', NULL, 40, '2026-04-02 16:06:35', '2026-04-02 16:06:35', 1),
(6, 'SATURN', 5, 2, 'ROOM104', NULL, 40, '2026-04-02 16:34:28', '2026-04-02 16:34:49', 1),
(7, 'MACIAS', 1, 2, 'ROOM100', NULL, 40, '2026-04-02 16:35:30', '2026-04-02 16:35:30', 1);

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
('Q1j0jJ4e72Ii3VBLj5gWJ5EWBscIZKpCQKU3Z7HP', 66, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2lDTTRpaGVqNm9VWGpGdnIxcm9ZMWhKMUtPaFVvUVhJMlBZQXZVTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWFjaGVyL3NmMz9zZWN0aW9uX2lkPTIiO3M6NToicm91dGUiO3M6MTE6InRlYWNoZXIuc2YzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjY7fQ==', 1775305840);

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
  `status` enum('active','inactive','graduated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
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
  `remarks` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `lrn`, `birthdate`, `birth_place`, `gender`, `status`, `mother_tongue`, `ethnicity`, `nationality`, `religion`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `guardian_name`, `guardian_relationship`, `guardian_contact`, `street_address`, `barangay`, `city`, `province`, `zip_code`, `grade_level_id`, `section_id`, `photo`, `created_at`, `updated_at`, `school_year_id`, `remarks`) VALUES
(64, 94, '120231260000', '2004-01-07', 'Dauin', 'Male', 'inactive', 'Bisaya', 'Negrense', 'Filipino', 'Christianity', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purok 5', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 4, 2, NULL, '2026-04-01 18:42:45', '2026-04-01 19:28:31', NULL, NULL),
(65, 95, '120231260001', '2003-10-31', 'Dauin', 'Female', 'active', 'Bisaya', 'Negrense', 'Filipino', 'Roman Catholic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LUCA', 'LIPAYO', 'Dauin', 'Negros Oriental', '6217', 7, 2, NULL, '2026-04-01 22:23:35', '2026-04-02 14:34:13', NULL, NULL),
(66, 96, '120231260003', '2003-11-06', NULL, 'Female', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, '2026-04-02 15:26:53', '2026-04-02 15:26:53', NULL, NULL),
(68, 98, '120231260002', '2003-12-10', 'Dauin', 'Male', 'active', NULL, NULL, 'Filipino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Elithon', 'Tugawe', 'Dauin', 'Negros Oriental', '6217', 4, 2, NULL, '2026-04-04 03:18:21', '2026-04-04 03:19:16', NULL, NULL);

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
(1, 1, 'active', 'admin@tugaweES.edu.ph', NULL, '$2y$12$zXtYoxdECMpT8DvDKSKFee0E.B7PXe4yQgoRJim6sPz/1zutl3Gsu', NULL, 1, 'XwAMcFUQXOEfohCrZhHhtBbGfew7TfIvALcHIXsljHZj0Kf1yd7wyuPecAsr', NULL, 0, NULL, NULL, '2026-01-27 05:37:20', '2026-03-25 06:21:45', NULL, 'TES', NULL, 'ADMIN', NULL, NULL, 'sysadmin'),
(2, 3, 'active', 'registrar@tugaweES.edu.ph', NULL, '$2y$12$U.1P6YsXem2b3PGR94gFeO14UKaqX8ohqvff/ouYL7FnqE9LDE.oi', NULL, 1, 'YrC7y5PHO5Xp4frRjM1cutO36L5FcQK10AAjebcQz46PDBmtxNVsVS9CcL9G', NULL, 0, NULL, NULL, '2026-01-27 05:37:21', '2026-01-27 05:37:21', NULL, '', NULL, '', NULL, NULL, ''),
(4, 4, 'active', 'student@tugaweES.edu.ph', NULL, '$2y$12$WIxeJEYWoAGnKxkiWIWT7uT1s6Owua0cZUsWGVVO1Zs/dImzr.8ee', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-01-27 05:37:22', '2026-01-27 05:37:22', NULL, '', NULL, '', NULL, NULL, ''),
(13, 2, 'active', 'teacher@tugaweES.edu.ph', NULL, '$2y$12$I703bY65xDMTGUJ/NA1hYuoccRQRYjy7INoW2feSbrdmlKoqmEbTO', NULL, 1, NULL, '{\"theme\": \"dark\", \"language\": \"ceb\", \"date_format\": \"MM/DD/YYYY\", \"time_format\": \"12h\", \"system_updates\": \"1\", \"grade_reminders\": \"1\", \"profile_visible\": \"1\", \"show_last_active\": \"1\", \"attendance_alerts\": \"1\", \"sms_notifications\": \"0\", \"email_notifications\": \"1\", \"email_visible_to_students\": \"0\", \"new_student_notifications\": \"0\"}', 0, NULL, NULL, '2026-01-28 21:57:58', '2026-03-22 16:33:32', NULL, 'Teacher', NULL, 'User', NULL, NULL, 'teacheruser1'),
(66, 2, 'active', 'mariasan@gmail.com', NULL, '$2y$12$3kEcB2mHyjA0b0SFLTlhfeVAFFhMXgKZSzPPX0zvJ7QQStLjJVvbS', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 02:22:47', '2026-03-25 02:22:47', NULL, 'Maria', NULL, 'Santos', NULL, NULL, 'msmaria'),
(68, 1, 'active', 'admin123@gmail.com', NULL, '$2y$12$TUqAbwYAVzJkHjkxiwa3peAV2mq7ctJhndKfwpBWb7lZBlocE5TPa', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-25 05:21:01', '2026-03-27 21:57:33', NULL, 'System', NULL, 'Admin', NULL, NULL, 'mysysad12'),
(70, 2, 'active', 'msmendes@gmail.com', NULL, '$2y$12$ws3zhjWNpiifRIzw9fbZgeVbItUrVD3anY5QCm1anpXuOT7q5xNZm', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-03-27 03:13:09', '2026-03-27 03:13:09', NULL, 'Shane', NULL, 'Mendes', NULL, NULL, 'msmendes'),
(94, 4, 'active', 'cresttuayon@gmail.com', NULL, '$2y$12$I2tgIsYk/D0dXf7IbxH2O.Y5La4.yWmpPj1buaNf/9ykYt5HmuzPa', NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-04-01 18:42:45', '2026-04-01 18:42:45', NULL, 'Crestian', 'Bajado', 'Tuayon', NULL, NULL, 'crstn'),
(95, 4, 'active', 'ejiemaestradio@gmail.com', NULL, '$2y$12$Vfyd1wxhsu4akKNnofrdAe6XNUew/m11aMch996uRdpRppPYEfvCa', NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-04-01 22:23:35', '2026-04-01 22:23:35', NULL, 'Ejie Mae', 'Santos', 'Tradio', NULL, NULL, 'ezimei'),
(96, 4, 'active', 'noimetaloretebaldomar@gmail.com', '2026-04-02 15:26:53', '$2y$12$dnkP/2nJBJ82GEXu1ysEnO7HlkIVVNY/WmpoJX8YZp5HUFKQVuhL2', NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-04-02 15:26:53', '2026-04-02 15:26:53', NULL, 'Noime', 'Talorete', 'Baldomar', NULL, NULL, 'evarocksredhell'),
(98, 4, 'active', 'stephendelsocura@gmail.com', NULL, '$2y$12$zDVx0VyrtIl0Eh5NR3IFPOcPEUBgAuO.XlG/1M8p3lYFTF8J3iZXe', NULL, 0, NULL, NULL, 0, NULL, NULL, '2026-04-04 03:18:21', '2026-04-04 03:18:21', NULL, 'Stephen', 'Divino', 'Delsocura', NULL, NULL, 'stephen');

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
  ADD KEY `sections_teacher_id_foreign` (`teacher_id`),
  ADD KEY `school_year_id` (`school_year_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `promotion_histories`
--
ALTER TABLE `promotion_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

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
-- Constraints for table `promotion_histories`
--
ALTER TABLE `promotion_histories`
  ADD CONSTRAINT `promotion_histories_from_grade_level_id_foreign` FOREIGN KEY (`from_grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_from_school_year_id_foreign` FOREIGN KEY (`from_school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_to_grade_level_id_foreign` FOREIGN KEY (`to_grade_level_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_histories_to_school_year_id_foreign` FOREIGN KEY (`to_school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE;

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
