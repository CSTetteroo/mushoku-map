-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2025 at 04:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mushoku-map`
--

-- --------------------------------------------------------

--
-- Table structure for table `place_visits`
--

CREATE TABLE `place_visits` (
  `id` bigint UNSIGNED NOT NULL,
  `place_id` bigint UNSIGNED NOT NULL,
  `travel_number` int UNSIGNED DEFAULT NULL,
  `story_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `travel_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place_visits`
--

INSERT INTO `place_visits` (`id`, `place_id`, `travel_number`, `story_time`, `reason`, `created_at`, `updated_at`, `travel_id`) VALUES
(1, 2, 1, 'N1P180', 'To go teach eris, to earn money to get him and sylphie a ticket to the university of magic.', '2025-11-03 12:39:51', '2025-11-03 12:39:51', 1),
(2, 1, 0, 'N1P80', 'Rudeus is spawned.', '2025-11-03 12:40:36', '2025-11-03 12:40:36', NULL),
(3, 3, 2, 'n1p1000', 'Due to a mana disaster.', '2025-11-03 12:48:33', '2025-11-03 12:48:33', 2),
(7, 4, 3, 'n2p90', 'blerg', '2025-11-03 13:55:54', '2025-11-03 13:55:54', 6),
(8, 3, 4, 'n1p91', 'a', '2025-11-03 13:57:03', '2025-11-03 13:57:03', 8),
(9, 4, 5, 'n20p900', 'testing', '2025-11-03 14:03:29', '2025-11-03 14:03:29', 9),
(12, 6, 6, 'n1p800', 'bob', '2025-11-03 14:44:50', '2025-11-03 14:44:50', 13),
(13, 4, 7, 'n1p901', 'they forgot something', '2025-11-03 14:45:27', '2025-11-03 14:45:27', 14),
(14, 6, 8, 'n1p902', 'to get gras', '2025-11-03 14:46:24', '2025-11-03 14:46:24', 15),
(15, 4, 9, 'n1p903', 'bob', '2025-11-03 14:47:17', '2025-11-03 14:47:17', 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `place_visits`
--
ALTER TABLE `place_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_visits_place_id_foreign` (`place_id`),
  ADD KEY `place_visits_travel_id_foreign` (`travel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `place_visits`
--
ALTER TABLE `place_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `place_visits`
--
ALTER TABLE `place_visits`
  ADD CONSTRAINT `place_visits_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `place_visits_travel_id_foreign` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
