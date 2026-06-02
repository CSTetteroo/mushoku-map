-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2026 at 07:48 PM
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_10_31_092917_create_places_table', 1),
(6, '2025_10_31_092918_create_travel_table', 1),
(7, '2025_10_31_153751_place_visits', 1),
(8, '2025_11_03_120000_add_from_to_to_travels_table', 1),
(9, '2025_11_03_120100_add_travel_id_to_place_visits_table', 1);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `x` double(8,2) NOT NULL,
  `y` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `description`, `x`, `y`, `created_at`, `updated_at`) VALUES
(1, 'Buena Village', NULL, 495.47, 1455.47, '2025-11-03 12:28:19', '2025-11-03 13:38:07'),
(2, 'Roa', 'Roa City bob', 524.50, 1432.50, '2025-11-03 12:38:22', '2025-11-07 09:38:23'),
(7, 'Wieden', '\'A town two settlements over from Roa\'', 481.96, 1401.00, '2025-11-07 11:23:53', '2025-11-07 11:23:53'),
(8, 'Outskirts of Rikaris', '\'A reddish-brown stretch of earth.\'', 2421.85, 1721.62, '2025-11-07 12:56:13', '2025-11-07 12:56:13');

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
(1, 2, 1, 'V2P13 -> V2P34', '- Rudeus reaches Roa and finds himself face-to-face with Eris. She\'s evil incarnate; she punches and chases him around the mansion because she doesn\'t want to study. Rudeus\'s idea to fix this issue is by having them fake-kidnapped. which will allow him to show off his awesome powers to save them both.\n\n- To execute this plan they\'re then departed by the liege-lord (Eris\'s father) to a place 2 towns over, a village called Wieden.', '2025-11-03 12:39:51', '2025-11-07 12:08:09', 1),
(2, 1, 0, 'N1P80 -> V1P229', '- Rudeus Greyrat is born. He spends his early childhood in Buena Village after being reincarnated into a new world. There, he lives with his parents, Paul and Zenith, and their maid, Lilia. \n\n- Gifted with strong magical talent, he begins learning magic from Roxy Migurdia, his first teacher. Under her guidance, he masters advanced spells at a young age and overcomes his fear of the outside world. After Roxy leaves, Rudeus tutors a young elf named Sylphiette, forming a close bond with her. He shows interest to study at the University of Magic with her, he needs money for this though.\n\n- Rudeus is 7 years old. After paul contacted people , Sword king Ghislaine came to pick rudeus up. He\'ll be going to tutor Eris, a member of the boreas family in Roa, to earn 2 tuitions for the university of magic for sylphie and himself.', '2025-11-03 12:40:36', '2025-11-07 12:09:44', NULL),
(18, 7, 2, 'N2P34 -> V2P47', '- Rudeus and Eris are fake-kidnapped to Wieden to execute Rudeus\'s plan; getting Eris interested in her classes by showing her the importance of math, reading, writing and magic while being in a life-threatening situation.\n\n- Turns out their kidnappers are real, the butler in the Boreas household (that helped to plan Rudeus\'s plan) was seduced by promised money from a neighbouring rich perverted noble that wanted Eris as a slave. \n\n- Eris and Rudeus escape their grasp narrowly and travel back to Roa together.', '2025-11-07 11:25:48', '2025-11-07 12:07:03', 19),
(19, 2, 3, 'N2P47 -> N2P210', '- On their way home to escape the real kidnappers, Rudy and Eris get interrupted by the kidnappers before reaching the castle. Rudeus tries his best at defending himself and Eris but he\'s just a little too weak. But due to a smart firework spell casted by Rudeus, Ghislaine saves them with no time left to spare.\n \n- With the help of the dictionary Roxy sent him from the Shirone Kingdom for the Demon-God tongue, and Ghislaine’s guidance for the Beast-God tongue, Rudeus manages to learn both languages.\n\n- Eris advanced from intermediate to advanced sword-god style due to Ghislaine\'s training. Rudeus is still beginner-tier.\n\n- At N2P159 Rudeus turns 10. He now knows Demon tongue, Beast tongue and Fighting-god tongue (This was easy because its close to human tongue). His birthday present is Aqua Heartia; his staff for the rest of his life.\n\n- Eris starts to fall in love with Rudeus.\n\n- Across the world, renowned names recognize a pooling ball of mana floating above the fittoa region; The Dragon God Orsted, Roxy Migurdia, The Armoured Dragon King Perugius, The Sword God Fallion & The Great Emperor of the Demon World, Kirishika Kishirisu.\n\n- Perugius sends his spirit; Arumanfi The Bright, after the pool, and Arumanfi almost kills Rudeus as \'source of the mana\' but is thwarted by Ghislaine. Seconds later the manapool explodes. The entire region is turned to grass plains. \n\nToday is the day the Fittoa Region vanished.', '2025-11-07 12:13:37', '2025-11-07 12:35:54', 20),
(20, 8, 4, 'V3P11 -> ?', '- Rudeus wakes up in a white void, a man stands in front of him; The Man-God. After a quick introduction and a lot of distrust from Rudeus, the Man-God convinced Rudeus to take his advice in order to survive the demon continent and get home. \n\'Soon after you awake, you\'ll see a man. Rely on him, and do what you can to help him.\'\n\n- Next', '2025-11-07 12:58:02', '2025-11-07 13:01:50', 22);

-- --------------------------------------------------------

--
-- Table structure for table `travels`
--

CREATE TABLE `travels` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'red',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `path` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `from_place_id` bigint UNSIGNED DEFAULT NULL,
  `to_place_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `travels`
--

INSERT INTO `travels` (`id`, `name`, `type`, `color`, `reason`, `path`, `created_at`, `updated_at`, `from_place_id`, `to_place_id`) VALUES
(1, 'Connection between Buena Village and Roa', 'Horse-Drawn Carriage', 'red', 'Rudeus & Ghislaine travel to Roa to have Rudeus teach a young mistress. (Eris Boreas Greyrat)', '[[1455.5, 495.49], [1432.5, 524.49]]', '2025-11-03 12:38:49', '2025-11-07 11:19:46', 1, 2),
(19, 'Connection between Roa and Wieden', 'Horse-Drawn Carriage', 'red', 'Rudeus and Eris are being brought to Wieden to execute Rudeus\'s plan; getting Eris interested in her classes by showing her the importance of math, reading, writing and magic.', '[[1432.5, 524.5], [1401, 481.96]]', '2025-11-07 11:25:19', '2025-11-07 11:25:19', 2, 7),
(20, 'Connection between Wieden and Roa', 'Horse-Drawn Carriage', 'red', 'After escaping their kidnappers narrowly, Eris and Rudeus are returning home to Roa by hopping stagecoaches.', '[[1401, 481.96], [1432.5, 524.5]]', '2025-11-07 12:13:12', '2025-11-07 12:13:12', 7, 2),
(22, 'Rudeus\'s Displacement Incident Teleportation Path', 'Giant Mana Disaster Teleportation', 'cyan', '- People and animals were teleported in the incident. Everything, from quills and ink to houses were gone.\r\n\r\n- It is theorized that a lot people, and presumably most objects, were \"exchanged\" for energy of the disaster. Some survivors were protected by the strength of their destiny.', '[[1432.5, 524.5], [1721.62, 2421.85]]', '2025-11-07 12:57:20', '2025-11-07 12:57:20', 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_visits`
--
ALTER TABLE `place_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_visits_place_id_foreign` (`place_id`),
  ADD KEY `place_visits_travel_id_foreign` (`travel_id`);

--
-- Indexes for table `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travels_from_place_id_foreign` (`from_place_id`),
  ADD KEY `travels_to_place_id_foreign` (`to_place_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `place_visits`
--
ALTER TABLE `place_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `place_visits`
--
ALTER TABLE `place_visits`
  ADD CONSTRAINT `place_visits_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `place_visits_travel_id_foreign` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `travels`
--
ALTER TABLE `travels`
  ADD CONSTRAINT `travels_from_place_id_foreign` FOREIGN KEY (`from_place_id`) REFERENCES `places` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `travels_to_place_id_foreign` FOREIGN KEY (`to_place_id`) REFERENCES `places` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
