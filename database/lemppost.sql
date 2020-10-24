-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2020 at 07:47 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lemppost`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `followers` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `followers`, `following`, `created_at`, `updated_at`) VALUES
(2, 15, 2, NULL, NULL),
(3, 15, 17, NULL, NULL),
(5, 2, 17, NULL, NULL),
(6, 2, 15, NULL, NULL),
(7, 2, 20, NULL, NULL),
(8, 22, 2, NULL, NULL),
(11, 37, 2, NULL, NULL),
(13, 17, 2, NULL, NULL),
(17, 2, 20200415, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coin` int(10) NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `url`, `coin`, `icon`, `action`, `created_at`, `updated_at`) VALUES
(1, 'Like our facebook page', 'https://web.facebook.com/bmjnews24/?ref=bookmarks', 50, '', 'facebook page', NULL, NULL),
(2, 'Like our facebook page', 'https://web.facebook.com/%E0%A6%86%E0%A6%AC%E0%A7%8D%E0%A6%A6%E0%A7%81%E0%A6%B2-%E0%A6%86%E0%A6%9C%E0%A6%BF%E0%A6%9C-%E0%A6%B0%E0%A6%BF%E0%A6%AE%E0%A6%A8-126601895591142/?ref=bookmarks', 100, '', 'youtube', NULL, NULL),
(3, 'Subscribe Youtube Channel', 'https://www.youtube.com/channel/UCqFH5k4uBVijwMSCbApoiJQ?fbclid=IwAR1vL-4qgIjQT4LupqtwhuRAgXpSYWwLR3dfGTsqgGJIyJFagW2zrCeg5I8', 10, '', 'youtube', NULL, NULL),
(5, 'Subscribe Youtube Channel ', 'https://www.youtube.com/channel/UCyoqCYUCgo9Oma0XQVRWLNA?fbclid=IwAR2Lp2JNFjbN-dpGbJmCi2Em0REe-j_xy9TCVed3jBt7QQGdMkTBh7VGcuE', 100, '', 'youtube', NULL, NULL),
(6, 'Visit website ', 'www.freedownloadimage.com\r\n', 10, '', 'web', NULL, NULL),
(7, 'Share on whatsApp', 'https://play.google.com/store/apps/details?id=com.ringid.ring&hl=en', 0, '', 'whatsapp share', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `link_user`
--

CREATE TABLE `link_user` (
  `id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `user_id` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_01_04_164641_create_settings_table', 2),
(5, '2020_01_06_170554_create_sliders_table', 3),
(9, '2020_01_14_165010_create_withdraws_table', 4),
(10, '2020_01_14_165042_create_links_table', 4),
(11, '2020_01_14_165415_create_profiles_table', 4),
(13, '2020_02_05_171112_create_followers_table', 5),
(15, '2020_08_26_171718_create_partners_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `title`, `logo`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Images Site', 'images/partner/boss.png', 'http://www.freedownloadimage.com/', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy`
--

CREATE TABLE `policy` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policy`
--

INSERT INTO `policy` (`id`, `text`) VALUES
(1, '<h4>Welcome to Locations!</h4>\r\n								<p>These terms and conditions outline the rules and regulations for the use of Listing Portal\'s Website. Listing Portal is located at:</p>\r\n								<span>2708 Burwell Heights Road,</span>\r\n								<span>Warren, TX 77664</span>\r\n								<span>United States</span>\r\n								<p>By accessing this website we assume you accept these terms and conditions in full. Do not continue to use Listing Portal\'s website if you do not accept all of the terms and conditions stated on this page.</p>\r\n								<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and any or all Agreements: \"Client\", “You” and “Your” refers to you, the person accessing this website and accepting the Company’s terms and conditions. \"The Company\", “Ourselves”, “We”, “Our” and \"Us\", refers to our Company. “Party”, “Parties”, or “Us”, refers to both the Client and ourselves, or either the Client or ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services/products, in accordance with and subject to, prevailing law of United States. Any use of the above terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>\r\n								<h4>License</h4>\r\n								<p>Unless otherwise stated, Listing Portal and/or it’s licensors own the intellectual property rights for all material on Listing Portal All intellectual property rights are reserved. You may view and/or print pages from http://www.example.com for your own personal use subject to restrictions set in these terms and conditions.</p>\r\n								<p>You must not:</p>\r\n								<ul>\r\n									<li>Republish material from http://www.example.com</li>\r\n									<li>Sell, rent or sub-license material from http://www.example.com</li>\r\n									<li>Reproduce, duplicate or copy material from http://www.example.com</li>\r\n									<li>Redistribute content from Listing Portal (unless content is specifically made for redistribution).</li>\r\n								</ul>\r\n								<h4>Reservation of Rights</h4>\r\n								<p>We reserve the right at any time and in its sole discretion to request that you remove all links or any particular link to our Web site. You agree to immediately remove all links to our Web site upon such request. We also reserve the right to amend these terms and conditions and its linking policy at any time. By continuing to link to our Web site, you agree to be bound to and abide by these linking terms and conditions.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `photo`, `first_name`, `last_name`, `number`, `email`, `description`, `facebook`, `youtube`, `twitter`, `linkin`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'images/photo/0fe37ae2aa1032deb430238f19f06555.jpg', 'saiful', 'saiful', '0179999999999', 'saiful@gmail.com', 'Sep 28, 2018 - I installed Laravel 5.7 Added a form to the file ... Post request in Laravel 5.7 --- Error - 419 Sorry, your session has expired. ... login function maybe we used same route with that page and token was renewed after we submit.', '#', '#', '#', '#', '2', NULL, NULL),
(2, 'images/photo/0fe37ae2aa1032deb430238f19f06555.jpg', 'fahad', 'fahad', NULL, 'fahad@gmail.com', NULL, NULL, NULL, NULL, NULL, '15', '2020-02-01 21:59:29', '2020-02-01 21:59:29'),
(5, 'images/user/user.jpg', 'saif', 'khan', NULL, '123@gmail.com', NULL, NULL, NULL, NULL, NULL, '17', '2020-02-01 23:27:43', '2020-02-01 23:27:43'),
(7, 'images/photo/r1.jpg', 'saiful', 'saiful', '0179999999999', 'saiful@gmail.com', 'Sep 28, 2018 - I installed Laravel 5.7 Added a form to the file ... Post request in Laravel 5.7 --- Error - 419 Sorry, your session has expired. ... login function maybe we used same route with that page and token was renewed after we submit.', '#', '#', '#', '#', '1', NULL, NULL),
(8, 'images/user/user.jpg', 'admin', 'admin', NULL, 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, '20', '2020-02-15 22:25:18', '2020-02-15 22:25:18'),
(9, 'images/user/user.jpg', 'sss', 'sss', NULL, 'sssss@gmail.com', 'fffss', NULL, NULL, NULL, NULL, '21', '2020-02-25 00:26:23', '2020-02-25 01:07:57'),
(10, 'images/photo/FB_IMG_15808140892988680.jpg', 'Abdul', 'Aziz', '01955847283', 'abdulaziz163ah@gmail.com', 'Photo courtesy', 'https://www.facebook.com/abdulaziz.rimon.73', 'https://youtu.be/ypf8N5ZhQdQ', NULL, NULL, '22', '2020-02-26 01:00:25', '2020-02-26 01:25:48'),
(11, 'images/user/user.jpg', 'Sabrina', 'Ferduse', NULL, 'sabrinaferdose73@gmail.com', NULL, NULL, NULL, NULL, NULL, '23', '2020-02-26 02:30:08', '2020-02-26 02:30:08'),
(12, 'images/logo/logo.png', 'sazzad hossain', 'fahad', NULL, 'sazzad22@gmail.com', NULL, NULL, NULL, NULL, NULL, '24', NULL, NULL),
(13, 'images/logo/logo.png', 'Abdul ', 'Aziz', NULL, 'abdulaziz1hero@gmail.com', NULL, NULL, NULL, NULL, NULL, '25', NULL, NULL),
(14, 'images/logo/logo.png', 'md', 'Rimom', NULL, 'abdulaziz74ah@gmail.com', NULL, NULL, NULL, NULL, NULL, '35', NULL, NULL),
(15, 'images/logo/logo.png', 'saiful', 'saif', NULL, 'saiful1@gmail.com', NULL, NULL, NULL, NULL, NULL, '37', NULL, NULL),
(16, 'images/logo/logo.png', 'text', 'text', NULL, 'text', NULL, NULL, NULL, NULL, NULL, '20200339', NULL, NULL),
(17, 'images/user/user.jpg', 'Saiful', 'Saif', NULL, 'sajid@infobizsoft.com', NULL, NULL, NULL, NULL, NULL, '20200341', '2020-03-18 06:03:57', '2020-03-18 06:03:57'),
(18, 'images/logo/logo.png', 'playstore', 'cnx', NULL, 'playstorecnx13@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200342', NULL, NULL),
(19, 'images/logo/logo.png', 'Tadiqul', 'Islam', NULL, 'alam7@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200343', NULL, NULL),
(20, 'images/photo/FB_IMG_15845705027000912.jpg', 'Md', 'Babu', '', 'Abdulaziz10ah@gmail.com', '', '', '', '', '', '20200345', NULL, NULL),
(21, 'images/logo/logo.png', '15666666666', '15666666666', NULL, '15666666666', NULL, NULL, NULL, NULL, NULL, '20200365', NULL, NULL),
(22, 'images/photo/beautiful-bouqowers-3-1024px-536x401.jpg', 'Abdul', 'Aziz Rimon', '', 'abdulaziz2019ah@gmail.com', 'à¦°à¦¿à¦®à¦¨', '', '', '', '', '20200395', NULL, NULL),
(23, 'images/logo/logo.png', 'mr', 'babu', NULL, 'Abdulazizrimon136@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200415', NULL, NULL),
(24, 'images/logo/logo.png', 'john', 'doe', NULL, 'theonsnow.230550@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200416', NULL, NULL),
(25, 'images/logo/logo.png', 'md', 'aziz', NULL, 'abdulaziz1992ah@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200448', NULL, NULL),
(26, 'images/user/user.jpg', 'Abdul Aziz', 'Abdul Aziz', NULL, 'abdulaziz143ah@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200451', '2020-05-09 08:12:53', '2020-05-09 08:12:53'),
(27, 'images/logo/logo.png', 'masud', 'rana', NULL, 'masud@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200452', NULL, NULL),
(28, 'images/logo/logo.png', 'jahidul', 'islam', NULL, 'ji278318@gmail.com', NULL, NULL, NULL, NULL, NULL, '20200454', NULL, NULL),
(29, 'images/logo/logo.png', 'Ranjit', 'Diwakar', NULL, 'rdiwakar305.@gamil com.', NULL, NULL, NULL, NULL, NULL, '20200455', NULL, NULL),
(30, 'images/logo/logo.png', 'kailash', 'hirhmate', NULL, 'kailashemilo', NULL, NULL, NULL, NULL, NULL, '20200457', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `footer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `favicon`, `title`, `header1`, `header2`, `facebook`, `twitter`, `youtube`, `address`, `phone`, `gmail`, `description`, `footer`, `created_at`, `updated_at`) VALUES
(1, 'images/logo/logo.png', '', '', 'Welcome to our website', 'Free download photos of your choice', 'https://www.facebook.com/abdulaziz.rimon.73?ref=bookmarks', 'https://l.facebook.com/l.php?u=https%3A%2F%2Ftwitter.com%2FAbdulaz48904407&h=AT0N0w9m9bnB4ceIAIi0ANPWvwpvNndxJ1lTz9FqZQNX07LWb7nrjs3JsQSzvqq6sfZYeE6fZZ_odSNyIPvfbnzJsdbsGPVYJeuqzlKXDAb7bVXERvvH-EzK6wkbhwPj6O4RdgrvTtSIxrQ&s=1', 'https://www.youtube.com/channel/UCqFH5k4uBVijwMSCbApoiJQ', 'Doha,Qater', '+97474454868', 'abdulaziz74ah@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscingelit. Nulla ultrices nisi vitae laoreet dapibus. Etiampulvinar non justo at tincidunt. Cras turpis erat, ornare eget sem ut, tempus scelerisque lorem.', 'Copyright amrsoft© 2020. All Rights Reserved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `slider`, `created_at`, `updated_at`) VALUES
(9, 'images/slider/parallax1.jpg', '2020-01-30 20:38:32', '2020-01-30 20:38:32'),
(10, 'images/slider/parallax2.jpg', '2020-01-30 20:38:40', '2020-01-30 20:38:40'),
(11, 'images/slider/parallax3.jpg', '2020-01-30 20:38:47', '2020-01-30 20:38:47'),
(12, 'images/slider/parallax4.jpg', '2020-01-30 20:38:54', '2020-01-30 20:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `text`) VALUES
(1, '<h4>Welcome to Locations!</h4>\r\n								<p>These terms and conditions outline the rules and regulations for the use of Listing Portal\'s Website. Listing Portal is located at:</p>\r\n								<span>2708 Burwell Heights Road,</span>\r\n								<span>Warren, TX 77664</span>\r\n								<span>United States</span>\r\n								<p>By accessing this website we assume you accept these terms and conditions in full. Do not continue to use Listing Portal\'s website if you do not accept all of the terms and conditions stated on this page.</p>\r\n								<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and any or all Agreements: \"Client\", “You” and “Your” refers to you, the person accessing this website and accepting the Company’s terms and conditions. \"The Company\", “Ourselves”, “We”, “Our” and \"Us\", refers to our Company. “Party”, “Parties”, or “Us”, refers to both the Client and ourselves, or either the Client or ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services/products, in accordance with and subject to, prevailing law of United States. Any use of the above terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>\r\n								<h4>License</h4>\r\n								<p>Unless otherwise stated, Listing Portal and/or it’s licensors own the intellectual property rights for all material on Listing Portal All intellectual property rights are reserved. You may view and/or print pages from http://www.example.com for your own personal use subject to restrictions set in these terms and conditions.</p>\r\n								<p>You must not:</p>\r\n								<ul>\r\n									<li>Republish material from http://www.example.com</li>\r\n									<li>Sell, rent or sub-license material from http://www.example.com</li>\r\n									<li>Reproduce, duplicate or copy material from http://www.example.com</li>\r\n									<li>Redistribute content from Listing Portal (unless content is specifically made for redistribution).</li>\r\n								</ul>\r\n								<h4>Reservation of Rights</h4>\r\n								<p>We reserve the right at any time and in its sole discretion to request that you remove all links or any particular link to our Web site. You agree to immediately remove all links to our Web site upon such request. We also reserve the right to amend these terms and conditions and its linking policy at any time. By continuing to link to our Web site, you agree to be bound to and abide by these linking terms and conditions.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referral_id` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `role`, `email`, `referral_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', 'admin', 'admin@gmail.com', NULL, NULL, '$2y$10$jeu5vWf3rqlo5PH1LnTOCOp3pIM2epbUHShXt691OZM4AEZLGZKKG', 'lgtbjjH38KYoPQK8J5UwxDoszZGArpJPCjlQnNUC1EPWssSkL4Z2JxvyA2pg', '2019-12-30 23:18:24', '2019-12-30 23:18:24'),
(2, 'Saif', '', 'user', 'user@gmail.com', NULL, NULL, '$2y$10$jeu5vWf3rqlo5PH1LnTOCOp3pIM2epbUHShXt691OZM4AEZLGZKKG', 'u13NuO9TITBZP0U7vUPJatxwQlgpmNcSfBMOtJqvTS7oDXqbpIjdbext9aGP', '2019-12-30 23:18:24', '2019-12-30 23:18:24'),
(3, 'robin', 'khan', 'user', 'robinkhan5854@gmail.com', NULL, NULL, '$2y$10$URELIBdn8a0IkexVsisRduxqq7B9/TYere2lyURlyxy8k24qbKlu2', NULL, '2020-01-04 21:46:59', '2020-01-04 21:46:59'),
(4, 'rajib', 'mia', 'user', 'rajib@gmail.com', NULL, NULL, '$2y$10$DG35MPKVphmIyM9HrchXRu8Y4bYZUGWd9AoE2ieePkGTQSWxZEDLi', NULL, '2020-01-30 23:41:57', '2020-01-30 23:41:57'),
(15, 'fahad', 'khan', 'user', 'fahad@gmail.com', NULL, NULL, '$2y$10$ACRbDWaNfKak18FmAD7myOeGBGLUZIasafEoOTR3ycTH0XK4ROdPu', NULL, '2020-02-01 21:59:29', '2020-02-01 21:59:29'),
(17, 'saif', 'khan', 'user', '123@gmail.com', NULL, NULL, '$2y$10$UbQ5R6L/qhS5KsjVbhod3u9aCxoyIflULSvq2mUarLoZWry2/o6aK', NULL, '2020-02-01 23:27:43', '2020-02-01 23:27:43'),
(20, 'admin', 'admin', 'admin', 'admin@admin.com', NULL, NULL, 'd54d1702ad0f8326224b817c796763c9', NULL, '2020-02-15 22:25:18', '2020-02-15 22:25:18'),
(21, 'sss', 'ss', 'user', 'sssss@gmail.com', NULL, NULL, '$2y$10$3uX.9CwmTSYXi6OuU7KQb.F3y6hRBIyw8kebubY1379awZhxC88bK', NULL, '2020-02-25 00:26:23', '2020-02-25 00:26:23'),
(22, 'Aziz', 'Bmj', 'user', 'abdulaziz163ah@gmail.com', NULL, NULL, '$2y$10$IBVKBUYk8HtkABAaTPOE7.XwHq7ypja2KeeCg5bKRHzctHhER3FtG', NULL, '2020-02-26 01:00:25', '2020-02-26 01:00:25'),
(23, 'Sabrina', 'Ferduse', 'user', 'sabrinaferdose73@gmail.com', NULL, NULL, '$2y$10$3mp74YiQaOnaPt0FpxlvO.rCWVhHwLrqg5K72mUzWP/hYlkEGbRTC', NULL, '2020-02-26 02:30:08', '2020-02-26 02:30:08'),
(24, 'sazzad hossain', 'fahad', 'user', 'sazzad22@gmail.com', NULL, NULL, '$2y$10$xhoPBGdrEW/KZvJiHIBE/uWN8dIxrbxQwBV9N2G4H81N2uhKPGnEW', NULL, NULL, NULL),
(25, 'Abdul ', 'Aziz', 'user', 'abdulaziz1hero@gmail.com', NULL, NULL, '$2y$10$.AS30C1Wj0cjGpXu5AvYK.KiwEunycbRi.4PFWRECDXn.Qu.pyLhy', NULL, NULL, NULL),
(35, 'md', 'Rimom', 'user', 'abdulaziz74ah@gmail.com', NULL, NULL, '$2y$10$5dqqawGPSyY9cJK13.h96eNUSMDnQLrJw8f.2vxh3rFSRGS2R9erW', NULL, NULL, NULL),
(20200337, 'saiful', 'saif', 'user', 'saiful1@gmail.com', '2', NULL, '$2y$10$idn/2o1iLmgXxmkuH0zhM.0TP812Ktz0uiYgrN3RJOs0Me6IPLiry', NULL, NULL, NULL),
(20200339, 'text', 'text', 'user', 'text', NULL, NULL, '$2y$10$sPUerN.n.MdBqoi5rvLDp.NjCSww27HY1VnmeqIIgsoJERZBYZO7S', NULL, NULL, NULL),
(20200341, 'Saiful', 'Saif', 'user', 'sajid@infobizsoft.com', NULL, NULL, '$2y$10$4JMckc4rJIzzDv.HZXPN1OrvOihU1sfg.v9phzXy1MDpdkCfXdPUC', NULL, '2020-03-18 06:03:57', '2020-03-18 06:03:57'),
(20200342, 'playstore', 'cnx', 'user', 'playstorecnx13@gmail.com', NULL, NULL, '$2y$10$dmtFXhtuNYFnEK4corWXaeMRhUC9eL3.JnJod7zaIt0FwEG3qxBc2', NULL, NULL, NULL),
(20200343, 'Tadiqul', 'Islam', 'user', 'alam7@gmail.com', NULL, NULL, '$2y$10$VilzZsNVtYoADBFstd7hK.ZThGa7TWh8a/up30yCv/qfyZkdgqO4e', NULL, NULL, NULL),
(20200345, 'Md', 'Babu', 'user', 'Abdulaziz10ah@gmail.com', NULL, NULL, '$2y$10$c4a7ZGaxGAJHA2Uw5ypGtOPEPZv9U3E8vSGkG1Og2Vd6tlo2.G6sG', NULL, NULL, NULL),
(20200365, '15666666666', '15666666666', 'user', '15666666666', NULL, NULL, '$2y$10$cgo7bF1bE68jYoDwAA9UyOj53mudIzvNa3dpiuOYB8GInaW6215na', NULL, NULL, NULL),
(20200395, 'Abdul', 'Aziz Rimon', 'user', 'abdulaziz2019ah@gmail.com', NULL, NULL, '$2y$10$iikdUjTwCY79CwRf0svuRuDT.VPftEiw7KdTuRzBfA21Ky4n9IHwm', NULL, NULL, NULL),
(20200415, 'mr', 'babu', 'user', 'Abdulazizrimon136@gmail.com', NULL, NULL, '$2y$10$4MCDHKMSowX2k0EBCVN16uKyWul6Fm463cn1gJgWejxTE07O1YMPq', NULL, NULL, NULL),
(20200416, 'john', 'doe', 'user', 'theonsnow.230550@gmail.com', NULL, NULL, '$2y$10$LoO6Poh3o747PySjlRgsMeYJr4cDQnFMct4bvr9PdjQVpHfgJXe4W', NULL, NULL, NULL),
(20200448, 'md', 'aziz', 'user', 'abdulaziz1992ah@gmail.com', NULL, NULL, '$2y$10$V5yzDdngMwuNXG14xnHWVOPym44tcK.LKUe.SuYVgXWOu.pqQCR2m', NULL, NULL, NULL),
(20200451, 'Abdul Aziz', 'Abdul Aziz', 'admin', 'abdulaziz143ah@gmail.com', NULL, NULL, '$2y$10$bFv4AbWHjF0DRVN12RrH8Og5XlnlmPbOknML.xupRcY230SGBKU4C', NULL, '2020-05-09 08:12:53', '2020-05-09 08:12:53'),
(20200452, 'masud', 'rana', 'user', 'masud@gmail.com', NULL, NULL, '$2y$10$gUDXG11xuEbi3gidg0r9rOydPWgFOy.iLolpgOswrdXhH8STWZX7S', NULL, NULL, NULL),
(20200454, 'jahidul', 'islam', 'user', 'ji278318@gmail.com', NULL, NULL, '$2y$10$h3H.pPfRmS66Lvq2m2ARvePQui37mVPqV0P65ND/bwppFQy.mzovO', NULL, NULL, NULL),
(20200455, 'Ranjit', 'Diwakar', 'user', 'rdiwakar305.@gamil com.', NULL, NULL, '$2y$10$nCQW1jELM/RnpwcK6n1h7u.OUtQiSdLwUkmXBqH7sknituMNqX4tC', NULL, NULL, NULL),
(20200457, 'kailash', 'hirhmate', 'user', 'kailashemilo', NULL, NULL, '$2y$10$BAwui07PLeu8JNaIBcVhV.TvvWaHgAWwpKa4Y4kYieGy5G4lu3t06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `point` double(15,2) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Pennding'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`id`, `user_id`, `point`, `amount`, `date`, `status`) VALUES
(1, '2', 15000.00, '15', '2020-04-23 03:18:11', 'pending'),
(2, '2', 30000.00, '30', '2020-04-23 09:07:44', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_user`
--
ALTER TABLE `link_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `policy`
--
ALTER TABLE `policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `link_user`
--
ALTER TABLE `link_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `policy`
--
ALTER TABLE `policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20200459;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
