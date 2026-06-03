-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2026 at 10:51 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

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
(2, 'Buena Village', 'A small rural farming village in the Fittoa Region. Known for its peaceful countryside, open fields, and close-knit community. It serves as a typical frontier village of the Asura Kingdom and is far removed from major political and economic centers.', 495.40, 1455.50, '2026-06-02 16:43:40', '2026-06-02 16:44:15'),
(3, 'Roa', 'The largest city in the Fittoa Region and the seat of the Boreas Greyrat family. Roa is a prosperous regional capital with noble estates, markets, guild facilities, and strong ties to the surrounding agricultural lands.', 524.30, 1430.80, '2026-06-02 16:44:27', '2026-06-02 16:44:37'),
(4, 'Demon Continent Wilderness', 'A vast and dangerous landmass dominated by deserts, rocky plains, mountains, and monster territories. Human settlements are rare and travel between them is highly hazardous without experienced guides.', 2422.50, 1722.50, '2026-06-02 16:45:53', '2026-06-02 16:46:02'),
(5, 'Migurd Village', 'A small settlement primarily inhabited by the Migurd race. It is culturally isolated and known for its strong magical affinity, particularly in healing and water magic. The village is remote even by Demon Continent standards.', 2471.00, 1717.50, '2026-06-02 16:46:12', '2026-06-02 16:46:19'),
(6, 'Rikaris', 'A large multi-race trade city and one of the central hubs of civilization on the Demon Continent. It serves as a major stop for adventurers and merchants crossing between distant regions.', 2575.00, 1652.50, '2026-06-02 16:46:51', '2026-06-02 16:46:51'),
(7, 'Wind Port', 'A western coastal port city that receives travelers from the Demon Continent. It functions as an entry point into Millis and a transfer hub toward inland regions.', 2507.00, 992.00, '2026-06-02 16:47:24', '2026-06-02 16:47:30'),
(8, 'Zanto Port', 'A major port city on the Millis Continent that receives travelers from the Demon Continent. It functions as a key maritime entry point and trade hub before inland travel begins.', 2456.00, 879.00, '2026-06-02 16:48:25', '2026-06-02 16:49:14'),
(9, 'Dedoldia Village', 'A village inhabited by the Beastfolk Dedoldia tribe. It is part of the broader Great Forest tribal network and is known for its warrior culture and beastman traditions.', 2552.00, 741.50, '2026-06-02 16:50:49', '2026-06-02 16:50:49'),
(10, 'Millishion', 'The capital of the Holy Millis Kingdom and center of the Millis Faith. It is a large religious, political, and economic capital with dense urban infrastructure.', 2361.00, 445.00, '2026-06-02 16:51:25', '2026-06-02 16:51:25'),
(11, 'West Port', 'A coastal port city used as a transit hub after leaving Millishion. It connects inland Millis routes to eastern maritime travel.', 1708.50, 340.80, '2026-06-02 16:51:41', '2026-06-02 16:51:50'),
(12, 'East Port', 'A major seaport used for long-distance maritime travel between continents. It is a key departure point toward the Central Continent.', 1578.25, 347.50, '2026-06-02 16:52:05', '2026-06-02 16:52:05'),
(13, 'Shirone Kingdom', 'A desert kingdom in the southern Central Continent characterized by arid climate, fortified cities, and internal political instability.', 1104.12, 975.88, '2026-06-02 16:53:21', '2026-06-02 16:53:21'),
(14, 'Red Dragon Upper Jaw', 'A dangerous mountainous frontier region filled with high-level monsters and extreme terrain. It forms a natural barrier between major regions.', 276.00, 1590.50, '2026-06-02 16:53:51', '2026-06-02 16:53:51'),
(15, 'Red Dragon Lower Jaw', 'A mountainous frontier region located below the Red Dragon Upper Jaw. It is part of a broader mountain system that forms a natural barrier between the southern deserts and northern continental regions. The area is characterized by steep terrain, dangerous wildlife, and limited established infrastructure, making it difficult for large-scale travel or settlement.', 705.00, 911.75, '2026-06-02 16:56:52', '2026-06-02 16:56:52'),
(16, 'Rosenburg', 'Nicknamed the \"Gateway to the Northern Territories\" is one of largest cities in Duchy of Basherant located two months journey north of the Asuran border. Exports of magical implements to the Asura Kingdom account for half of the cities revenue.', 612.70, 1759.40, '2026-06-02 16:58:43', '2026-06-02 16:59:18'),
(17, 'Sharia', 'One of the largest cities in the Kingdom of Ranoa. Houses the Ranoa Magic Academy and is the headquarters of the Magicians\' Guild and Neris Magical Implements Workshop.', 503.00, 1709.00, '2026-06-02 17:01:40', '2026-06-02 17:01:59'),
(18, 'Gyuranza', 'Capital of Neris and headquarters of the Thunderbolt clan.', 463.90, 1756.10, '2026-06-02 17:02:52', '2026-06-02 17:03:03'),
(19, 'Teleportation Ruin (Begaritt)', NULL, 831.25, 202.75, '2026-06-02 17:03:58', '2026-06-02 17:03:58'),
(20, 'Bazaar', 'An encampment surrounding an oasis.', 832.25, 226.75, '2026-06-02 17:05:10', '2026-06-02 17:05:10'),
(21, 'Labyrinth City of Rapan', 'A major adventurer city built around labyrinth exploration. It functions as the  economic hub for dungeon crawling.', 833.00, 270.75, '2026-06-02 17:06:39', '2026-06-02 17:06:39'),
(22, 'Teleportation Ruin (Sharia)', NULL, 469.50, 1687.75, '2026-06-02 17:07:02', '2026-06-02 17:07:02'),
(23, 'Fort Necross', 'An impregnable fortress built by the immortal Demon King Necross Lacross. Located deep within the Gaslow Region on the Demon Continent, it currently serves as the stronghold and residence of the Demon King Atoferatofe Raibaku.', 2144.50, 1564.00, '2026-06-02 17:07:40', '2026-06-02 17:08:10'),
(24, 'Chaos Breaker', 'When flying above the sky, Chaos Breaker looks like a giant mass of rock covered in dragon scales originating in the Dragon World.[1] Sitting on the rock is a gigantic castle taller than the Silver Palace home of the royal family of Asura Kingdom that has a garden of similar size and a river.', 1733.50, 1256.50, '2026-06-02 17:21:25', '2026-06-02 17:21:33'),
(25, 'Wieden', 'A small town where Rudeus Greyrat and Eris Boreas Greyrat once got kidnapped and held at. It is two settlements away from Roa.', 482.00, 1399.10, '2026-06-02 17:58:04', '2026-06-02 18:00:00'),
(26, 'Smuggelers\' Warehouse', 'Gallus\'s base of operations.', 2439.10, 813.80, '2026-06-03 08:18:35', '2026-06-03 08:18:53');

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
(2, 2, 0, NULL, '- Rudeus Greyrat spends his early childhood in Buena Village after being reincarnated into a new world. There, he lives with his parents, Paul and Zenith, and their maid, Lilia. \n\n- Gifted with strong magical talent, he begins learning magic from Roxy Migurdia, his first teacher. Under her guidance, he masters advanced spells at a young age and overcomes his fear of the outside world. After Roxy leaves, Rudeus tutors a young noble girl named Sylphiette, forming a close bond with her. \n\n- Eventually, when his father arranges for him to study as a tutor for a noble family in Roa, Rudeus leaves Buena Village to begin the next chapter of his life.', '2026-06-02 17:24:42', '2026-06-02 18:17:29', NULL),
(12, 3, 1, 'V2P13 -> V2P34', '- Rudeus reaches Roa and finds himself face-to-face with Eris. She\'s evil incarnate; she punches and chases him around the mansion because she doesn\'t want to study. Rudeus\'s idea to fix this issue is by having them fake-kidnapped. which will allow him to show off his awesome powers to save them both.\n\n- To execute this plan they\'re then departed by the liege-lord (Eris\'s father) to a place 2 towns over, a village called Wieden.', '2026-06-02 17:51:51', '2026-06-02 18:01:46', 10),
(14, 25, 2, 'N2P34 -> V2P47', '- Rudeus and Eris are fake-kidnapped to Wieden to execute Rudeus\'s plan; getting Eris interested in her classes by showing her the importance of math, reading, writing and magic while being in a life-threatening situation.\n\n- Turns out their kidnappers are real, the butler in the Boreas household (that helped to plan Rudeus\'s plan) was seduced by promised money from a neighbouring rich perverted noble that wanted Eris as a slave.\n\n- Eris and Rudeus escape their grasp narrowly and travel back to Roa together.', '2026-06-02 18:00:57', '2026-06-02 18:03:56', 12),
(15, 3, 3, NULL, '- After escaping their kidnappers narrowly, Eris and Rudeus are returning home to Roa by hopping stagecoaches.', '2026-06-02 18:02:21', '2026-06-02 18:02:21', 13),
(16, 4, 4, 'V3P11', '- Rudeus wakes up in a white void, a man stands in front of him; The Man-God. After a quick introduction and a lot of distrust from Rudeus, the Man-God convinced Rudeus to take his advice in order to survive the demon continent and get home.\n\n- \'Soon after you awake, you\'ll see a man. Rely on him, and do what you can to help him.\'', '2026-06-02 18:12:59', '2026-06-02 18:14:12', 14),
(17, 5, 5, NULL, '- The village turns out to be Migurd Village, the hometown of Roxy\'s people. Because Rudeus still carries the pendant Roxy gave him, the villagers quickly recognize his connection to one of their own and welcome the group instead of treating them as suspicious outsiders. \n\n- Rudeus even meets Roxy\'s parents, who are shocked to find a human boy carrying news of their daughter.\n\n- During their stay, Rudeus learns the tragic history of the Superd directly from Ruijerd himself. Hearing how Laplace\'s cursed spears turned the Superd into monsters and destroyed their reputation changes the way he sees his companion. Rather than simply accepting Ruijerd\'s protection, Rudeus decides he wants to help restore the honor of the Superd race.', '2026-06-02 18:30:40', '2026-06-03 07:51:04', 18),
(18, 6, 6, NULL, '- The city of Rikaris is the first major settlement Rudeus and Eris have seen since the Teleportation Incident. Built around the ruins of an ancient fortress and populated by demons of almost every race.\n\n- Before entering the city, Rudeus comes up with the first step of his plan to help Ruijerd. He crafts a stone bandana to hide Ruijerd\'s distinctive features, dyes his green hair blue, and invents a cover story that Ruijerd is actually a Migurd pretending to be a Superd. To Rudeus\'s surprise.\n\n- Inside the city, the group registers as adventurers and forms the party Dead End, deliberately choosing the nickname that people once used to describe Ruijerd as a bloodthirsty monster. Rudeus hopes that if enough people hear stories about the party\'s good deeds, the name will slowly begin to mean something different.\n\n- Their first weeks in Rikaris are far from smooth. They uncover a pet kidnapping scheme, begin taking guild jobs, and quickly learn that adventurers do not always operate by the same moral standards as the people Rudeus grew up around. When Ruijerd instantly kills a criminal who attacks Rudeus, Rudeus is forced to confront the reality that his companion is still a warrior shaped by centuries of violence.\n\n- Determined to raise Dead End\'s rank quickly, Rudeus creates an elaborate quest-swapping scheme with another adventurer party. The plan earns them money and rapid promotions, but it eventually attracts unwanted attention. After a disastrous chain of events involving blackmail, guild regulations, and Ruijerd publicly revealing that he really is a Superd, the party is forced to leave the city.', '2026-06-03 07:29:01', '2026-06-03 07:34:19', 19),
(19, 7, 7, NULL, '- Wind Port is the first place where the group can realistically leave the Demon Continent, but reaching it doesn\'t solve their problems. At the Adventurer\'s Guild, Rudeus learns that Dead End has gained a surprising reputation. Eris is known as the \"Mad Dog,\" Ruijerd has somehow earned a reputation as a dependable and kind-hearted warrior, and Rudeus discovers that rumors have twisted his own role into something much less flattering.\n\n- The biggest problem appears when they try to arrange passage across the sea. Bringing a Superd onto a ship legally would cost an absurd amount of money, far more than the group possesses. Faced with the possibility of spending another year earning funds, Rudeus starts looking for alternatives. \n\n- Following advice from the Man-God, he wanders the city alone one night and ends up meeting Kishirika Kishirisu, the legendary Great Emperor of the Demon World. In exchange for a simple meal, she grants him the Eye of Foresight, a Demon Eye that allows him to briefly see into the future. \n\n- The group eventually decides to work with a smuggler named Gallus Cleaner to get Ruijerd across the sea.', '2026-06-03 07:37:23', '2026-06-03 07:43:13', 20),
(20, 8, 8, NULL, '- After docking at Zanto Port, Rudeus and Eris rush to the warehouse near the wharf to pick up Ruijerd and free the other slaves, holding up their end of the deal with Gallus. \n\n- With the three-month rainy season about to start, basically every inn in town is already fully booked, leaving them stuck with whatever sketchy leftover room they can find.', '2026-06-03 08:04:59', '2026-06-03 08:16:04', 21),
(21, 26, 9, NULL, '- After arriving, Rudeus ends up accidentally crawling into a crate of underwear and blowing his cover, alerting the kidnappers to his presence before he even has a plan.\n\n- Rudeus quickly takes out four kidnappers with weakened Stone Cannons, but reinforcements keep flooding in and he can\'t get out. He eventually gets bailed out when a guy named Geese throws a powder bag at Gallus, buying Rudeus just enough time to hit him with an Explosion spell and knock him out. \n\n- The operation turns out to be way bigger than a single warehouse. The smugglers coordinated simultaneous raids on multiple beast-folk villages, managing to kidnap 50 children in total. While Rudeus was dealing with things inside, Ruijerd and a group of beastfolk warriors intercepted the ship that was about to sail off with the rest of the kids and took it down. \n\n- Gallus gets handed over to the Zanto Port officials. When Rudeus splits off to rescue the beast-folk\'s Sacred Beast from a magic trap, a beastman called Gyes mistakes him for one of the kidnappers and takes him down. Rudeus was then taken back to the beastfolk village as a criminal, while one of the other beastmen found Ruijerd and the kidnapped children. Through their conversation the beastmen learned that Rudeus was Ruijerd companion, and apologized for taking him into custody, but Ruijerd knew that Rudeus would be fine and prioritized returning the children to their parents and getting Eris before setting Rudeus free.', '2026-06-03 08:19:38', '2026-06-03 08:30:21', 23),
(22, 9, 10, NULL, '- After being knocked out by Gyes, Rudeus wakes up stripped naked in a wooden prison cell. He could easily escape but sits tight and waits for Ruijerd to come clear his name, which takes five whole days. \n\n- His cellmate turns out to be Geese, who was thrown in for gambling. Their first interaction is Rudeus, still completely naked, asking Geese for his fur vest because it\'s cold. The vest has bugs in it.\n\n- Eris and Ruijerd eventually show up to free him, and naturally walk in on Rudeus naked with his ass in the air while Geese scratches his back. Great timing as always. \n\n- Once the misunderstanding gets sorted out, village elder Gustav invites the group to wait out the three month rainy season in the village since travel is basically impossible anyway.', '2026-06-03 08:33:13', '2026-06-03 08:34:55', 24),
(23, 10, 11, NULL, '- Geese peaces out the moment they enter the city. On what is supposed to be a chill free day, Rudeus spots yet another kid being stuffed into a burlap sack and chases the group down. It turns out the whole thing is not a kidnapping at all but a rescue operation, and the man running it is none other than Paul, his father, who Rudeus has not seen in a year and a half. \n\n- The reunion goes south fast. Paul gets furious listening to Rudeus recount the journey, feeling like his son was just having fun while Paul himself was desperately scraping for any leads on the family. Rudeus fires back that Paul was fooling around with the women in his group. The two end up in a full brawl, ending with Rudeus on top of Paul punching him in the face repeatedly, only stopped when Norn shows up and tells him to stop bullying her dad. \n\n- After things cool down, Paul passes along a ton of information about the Displacement Incident and hands over a hefty sum of money from the Boreas family for Eris\'s safe return. Ruijerd also manages to get a letter of introduction from an old acquaintance in the city, letting him cross to the Central Continent without paying the insane 100 king\'s coins Superd border fee. \n\n- The group spends a week in Millishion before setting off. Rudeus and Eris even have a proper dinner with Paul and Norn before leaving.', '2026-06-03 08:39:57', '2026-06-03 08:48:57', 25);

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
(10, 'Connection between Buena Village and Roa', 'Carriage', 'red', 'To tutor a small girl named Eris Boreas Greyrat.', '[[1455.5, 495.4], [1430.8, 524.3]]', '2026-06-02 17:51:43', '2026-06-02 17:51:43', 2, 3),
(12, 'Connection between Roa and Wieden', 'Horse-Drawn Carriage', 'red', '- Rudeus and Eris are being brought to Wieden to execute Rudeus\'s plan; getting Eris interested in her classes by showing her the importance of math, reading, writing and magic.', '[[1430.8, 524.3], [1399.1, 482]]', '2026-06-02 18:00:52', '2026-06-02 18:00:52', 3, 25),
(13, 'Connection between Wieden and Roa', 'Horse-Drawn Carriage', 'red', '- After escaping their kidnappers narrowly, Eris and Rudeus are returning home to Roa by hopping stagecoaches.', '[[1399.1, 482], [1430.8, 524.3]]', '2026-06-02 18:02:17', '2026-06-02 18:02:17', 25, 3),
(14, 'Rudeus\'s Displacement Incident Teleportation Path', 'Giant Mana Disaster Teleportation', 'cyan', '- People and animals were teleported in the incident. Everything, from quills and ink to houses were gone. \n\n- It is theorized that a lot people, and presumably most objects, were \"exchanged\" for energy of the disaster. Some survivors were protected by the strength of their destiny.', '[[1430.8, 524.3], [1722.5, 2422.5]]', '2026-06-02 18:12:52', '2026-06-03 07:49:30', 3, 4),
(18, 'Connection between Demon Continent Wilderness and Migurd Village', 'On Foot', 'orange', '- Ruijerd offers to help Rudeus and Eris return home and leads them toward a nearby village where they can rest and gather information. \n\n- Despite the village being less than a mile away, the journey takes hours because Ruijerd repeatedly stops to eliminate monsters lurking nearby. Along the way, Rudeus begins to see just how absurdly powerful Ruijerd really is and starts wondering whether this chance meeting might be the key to getting home.', '[[1722.5, 2422.5], [1717.5, 2471]]', '2026-06-02 18:30:35', '2026-06-03 07:23:58', 4, 5),
(19, 'Connection between Migurd Village and Rikaris', 'On Foot', 'orange', '- After leaving Migurd Village, Rudeus, Eris, and Ruijerd begin the first true stage of their journey home. Roxy\'s parents send them off with supplies, Demon Continent currency, and a short sword, but beyond that they are on their own. Knowing that they cannot rely on Ruijerd forever, Rudeus asks him to teach both him and Eris how to survive in the wild.\n\n- The three-day journey to the nearest city becomes a crash course in life on the Demon Continent. Rudeus kills his first monster, Eris begins learning how to fight as part of a team rather than a noble\'s bodyguard trainee, and Ruijerd teaches them how to hunt, camp, maintain equipment, and react to monster attacks. During the trip, Rudeus naturally settles into the role of rear guard and strategist, Eris becomes the front-line attacker, and Ruijerd fills whatever role is needed to keep them alive.\n\n- As they travel, Rudeus also begins to think seriously about Ruijerd\'s dream of restoring the reputation of the Superd race. If they are going to cross the world together, simply hiding Ruijerd\'s identity won\'t be enough. They need a plan that will make people respect him rather than fear him.', '[[1717.5, 2471], [1652.5, 2575]]', '2026-06-03 07:28:53', '2026-06-03 07:51:30', 5, 6),
(20, 'Connection between Rikaris and Wind Port', 'On Foot', 'orange', '- The journey takes nearly a year.\n\n- During this time, Rudeus continues working on his plan to rehabilitate the Superd name. Whenever they accept a quest, Dead End goes out of its way to rescue people, escort travelers safely, and complete jobs honestly.\n\n- Ruijerd slowly starts to understand what Rudeus is trying to accomplish. Although people are still frightened when they learn a Superd is involved, stories of Dead End begin to spread faster than the old stories about the Superd.\n\n- Eris grows considerably stronger during the trip. Constant battles against monsters and months of training with Ruijerd gradually transform her from a talented noble girl into a true warrior.', '[[1652.5, 2575], [1578, 2594], [1533, 2586], [1489, 2572], [1446, 2546], [1429, 2538], [1416, 2521], [1381, 2488], [1324, 2458], [1289, 2451], [1248, 2461], [1213, 2477], [1179, 2495], [1135, 2506], [1096, 2506], [992, 2507]]', '2026-06-03 07:37:18', '2026-06-03 07:37:18', 6, 7),
(21, 'Ocean between Wind Port and Zanto Port', 'By Boat', 'blue', 'Eris and Rudeus board a normal passenger ship while Ruijerd gets handed off to the smuggler Gallus, who hides him in cargo to sneak him past the border checkpoint.', '[[992, 2507], [879, 2456]]', '2026-06-03 08:04:55', '2026-06-03 08:04:55', 7, 8),
(23, 'Connection between Zanto Port and Smuggelers\' Warehouse', 'On Foot', 'orange', 'While heading back to the inn after grabbing some ink and paper, Rudeus spots a group of guys sprinting through the streets with a kid stuffed in a burlap sack. Dead End has a strict rule about never leaving a child in danger, so he tails them.', '[[879, 2456], [813.8, 2439.1]]', '2026-06-03 08:19:35', '2026-06-03 08:19:35', 8, 26),
(24, 'Connection between Smuggelers\' Warehouse and Dedoldia Village', 'Dragged by Gyes', 'orange', '- Rudeus is being brought to the Dedoldia Village as a criminal. After being wrongfully mistaken for a accomplice to the kidnapping of the sacred beast.', '[[813.8, 2439.1], [741.5, 2552]]', '2026-06-03 08:32:53', '2026-06-03 08:32:53', 26, 9),
(25, 'The Holy Sword Highway', 'Horse-Drawn Carriage', 'red', '- The Dedoldia send Dead End off with a carriage, a horse, travel money, and supplies, so the group can head straight to the capital without having to backtrack to Zanto Port. Geese, their former cellmate, also shamelessly hops on the carriage and tags along at the last second.\n\n- The Holy Sword Highway is the path Saint Milis supposedly created with a single sword swing, cutting straight through the Blue Dragon Mountain Range and the Great Forest all the way to Millishion. According to legend the swing was so powerful it crossed the ocean and killed a Demon King at what is now Wind Port. \n\n- Even after all this time, Saint Milis\' magic still lingers on the road. The surrounding Great Forest is completely flooded from the rainy season, but the highway itself stays perfectly dry, and not a single monster comes anywhere near it the entire journey.\n\n- During the ride Geese fills Rudeus in on the Seven Great Powers, the ranking of the strongest individuals in the world. Learning that people at that level even exist is a big reality check for Rudeus, who up until now thought Dead End was doing pretty well for themselves.', '[[741.5, 2552], [737, 2522.5], [736.5, 2505], [733.5, 2489], [729.5, 2468], [721, 2462.5], [704, 2457.5], [694.5, 2455.5], [682.5, 2452.5], [669.5, 2452.5], [657.5, 2449], [649.5, 2447.5], [637, 2442.5], [615.5, 2435.5], [602.5, 2429.5], [585, 2420], [572, 2415], [557, 2407], [539, 2404.5], [522.5, 2392.5], [508, 2385], [445, 2361]]', '2026-06-03 08:39:54', '2026-06-03 08:41:30', 9, 10);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `place_visits`
--
ALTER TABLE `place_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
