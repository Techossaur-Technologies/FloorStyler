-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2016 at 03:55 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_floorplanner_v2`
--

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `logo`, `logo_path`, `organization_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'None', '', 'storage/logo/blank_logo.jpg', 1, 'IDLE', NULL, '2016-09-16 03:29:44'),
(2, 'test_agencies_2', '', 'storage/logo/blank_logo.jpg', 1, 'ALIVE', NULL, '2016-09-14 05:59:53'),
(3, 'test_agencies_3', '', 'storage/logo/blank_logo.jpg', 3, 'ALIVE', NULL, NULL),
(4, 'test_agencies_4', '', 'storage/logo/blank_logo.jpg', 2, 'DEAD', NULL, '2016-11-02 08:01:20'),
(5, 'aaaa11hhvhjhhhhhh', 'LA-5-18474.jpg', 'storage/logo/LA-5-18474.jpg', 2, 'ALIVE', NULL, '2016-11-18 08:34:49'),
(6, 'gfdgfgfgfdfgdggfdgdfgdfg', 'LOGO-ID10-07146788906898.jpg', 'storage/logo/LOGO-ID10-07146788906898.jpg', 2, 'ALIVE', '2016-09-13 05:10:01', '2016-11-18 07:37:00'),
(7, 'tyfyfgty', 'L-A1473766874-4728.jpg', 'storage/logo/blank_logo.jpg', 3, 'IDLE', '2016-09-13 06:11:14', '2016-09-13 06:11:14');

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `name`, `user_id`, `organization_id`, `agency_id`, `status`, `created_at`, `updated_at`) VALUES
(13, 'test assignment', 4, 2, 6, 'PENDING', '2016-11-17 06:49:57', '2016-11-17 06:51:08'),
(14, 'null agency', 3, 2, 5, 'PENDING', '2016-11-18 04:34:34', '2016-11-18 08:35:32');

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `parent_id`, `menu_name`, `menu_page`, `icon`, `admin_access`, `superuser_access`, `user_access`, `agency_access`) VALUES
(1, 0, 'Dashboard', '', 'icon-home', 'YES', 'YES', 'NO', 'NO'),
(2, 0, 'Settings', '', 'icon-cog', 'YES', 'YES', 'NO', 'NO'),
(3, 0, 'Report', '', 'icon-film', 'YES', 'YES', 'NO', 'NO'),
(5, 0, 'Log Out', '', 'icon-share-alt', 'YES', 'YES', 'NO', 'NO'),
(11, 1, 'Dashboard', '/', '', 'YES', 'YES', 'NO', 'NO'),
(12, 3, 'Assignment List', 'assignment', '', 'YES', 'YES', 'YES', 'NO'),
(13, 2, 'Edit Profile', 'profile', '', 'YES', 'YES', 'NO', 'NO'),
(15, 2, 'Email Template', 'email_template', '', 'YES', 'NO', 'NO', 'NO'),
(19, 5, 'Log Out', 'logout', '', 'YES', 'YES', 'NO', 'NO'),
(20, 3, 'Agency', 'agency', '', 'YES', 'YES', 'NO', 'NO'),
(21, 3, 'Add Assignment', 'assignment/add', '', 'YES', 'YES', 'YES', 'NO'),
(22, 2, 'Change Password', 'password_change', '', 'YES', 'YES', 'YES', 'YES');

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_09_09_084559_create_organizations_table', 1),
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_09_09_091543_create_menus_table', 1),
('2016_09_09_092014_create_agencies_table', 1),
('2016_09_14_092608_create_assignments_table', 2),
('2016_09_21_083628_create_raw_plans_table', 3),
('2016_11_07_112446_rename_columns_to_users_table', 4),
('2016_11_07_112646_rename_columns_to_raw_plans_table', 5),
('2016_11_07_113747_add_comment_raw_plans_table', 6),
('2016_11_07_114840_add_comment_value_raw_plans_table', 7),
('2016_11_07_130140_add_flag_raw_plans', 8),
('2016_11_18_114807_defaultLogo_agencies', 9);

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'None', 'ALIVE', NULL, NULL),
(2, 'test_org_1', 'ALIVE', NULL, NULL),
(3, 'test_org_2', 'ALIVE', NULL, NULL),
(4, 'test_org_3', 'ALIVE', NULL, NULL),
(5, 'test_org_4', 'ALIVE', NULL, NULL);

--
-- Dumping data for table `raw_plans`
--

INSERT INTO `raw_plans` (`id`, `name`, `assignment_id`, `path`, `type`, `created_at`, `updated_at`, `comment`, `flag`) VALUES
(106, 'BP-ID13-16851.jpg', 13, 'storage/uploads/2016/11/BP-ID13-16851.jpg', 'SKETCH', '2016-11-17 06:51:08', '2016-11-17 06:51:08', '', 1),
(107, 'BP-ID13-272.jpg', 13, 'storage/uploads/2016/11/BP-ID13-272.jpg', 'SKETCH', '2016-11-17 06:51:08', '2016-11-17 06:51:08', '', 1),
(108, 'FP-ID13-1033.jpg', 13, 'storage/uploads/2016/11/FP-ID13-1033.jpg', 'DRAWING', '2016-11-17 06:51:34', '2016-11-17 06:51:34', '', 2),
(109, 'FP-ID13-9742.jpg', 13, 'storage/uploads/2016/11/FP-ID13-9742.jpg', 'DRAWING', '2016-11-17 06:51:34', '2016-11-17 06:51:34', '', 2),
(110, 'FP-ID13-10287.jpg', 13, 'storage/uploads/2016/11/FP-ID13-10287.jpg', 'DRAWING', '2016-11-17 06:51:34', '2016-11-17 06:51:34', '', 2),
(111, 'FP-ID13-7740.jpg', 13, 'storage/uploads/2016/11/FP-ID13-7740.jpg', 'DRAWING', '2016-11-17 06:51:35', '2016-11-17 06:51:35', '', 2),
(112, 'FP-ID13-1419.jpg', 13, 'storage/uploads/2016/11/FP-ID13-1419.jpg', 'DRAWING', '2016-11-17 06:55:16', '2016-11-17 06:55:16', '', 3),
(113, 'FP-ID13-26216.jpg', 13, 'storage/uploads/2016/11/FP-ID13-26216.jpg', 'DRAWING', '2016-11-17 06:55:16', '2016-11-17 06:55:16', '', 3),
(114, 'FP-ID13-31361.jpg', 13, 'storage/uploads/2016/11/FP-ID13-31361.jpg', 'DRAWING', '2016-11-17 06:55:16', '2016-11-17 06:55:16', '', 3),
(115, 'FP-ID13-10022.jpg', 13, 'storage/uploads/2016/11/FP-ID13-10022.jpg', 'DRAWING', '2016-11-17 06:55:16', '2016-11-17 06:55:16', '', 3),
(116, 'FP-ID13-7302.jpg', 13, 'storage/uploads/2016/11/FP-ID13-7302.jpg', 'DRAWING', '2016-11-17 06:57:13', '2016-11-17 06:57:13', '', 4),
(117, 'FP-ID13-10567.jpg', 13, 'storage/uploads/2016/11/FP-ID13-10567.jpg', 'DRAWING', '2016-11-17 06:57:13', '2016-11-17 06:57:13', '', 4),
(118, 'CM-ID13-18364.jpg', 13, 'storage/uploads/2016/11/CM-ID13-18364.jpg', 'COMMENT', '2016-11-17 09:10:40', '2016-11-17 09:10:40', 'eeeeee', 5),
(119, 'CM-ID13-837.jpg', 13, 'storage/uploads/2016/11/CM-ID13-837.jpg', 'COMMENT', '2016-11-17 09:10:40', '2016-11-17 09:10:40', 'eeeeee', 5),
(120, '', 13, '', 'COMMENT', '2016-11-17 09:10:57', '2016-11-17 09:10:57', 'eeeeee', 6),
(121, 'FP-ID14-3134.jpg', 14, 'storage/uploads/2016/11/FP-ID14-3134.jpg', 'DRAWING', '2016-11-18 04:34:56', '2016-11-18 04:34:56', '', 1),
(122, 'FP-ID14-18111.jpg', 14, 'storage/uploads/2016/11/FP-ID14-18111.jpg', 'DRAWING', '2016-11-18 05:10:25', '2016-11-18 05:10:25', '', 2),
(123, 'FP-ID14-396.jpg', 14, 'storage/uploads/2016/11/FP-ID14-396.jpg', 'DRAWING', '2016-11-18 05:11:10', '2016-11-18 05:11:10', '', 3),
(124, 'FP-ID14-213.jpg', 14, 'storage/uploads/2016/11/FP-ID14-213.jpg', 'DRAWING', '2016-11-18 05:11:53', '2016-11-18 05:11:53', '', 4),
(125, 'FP-ID14-19103.jpg', 14, 'storage/uploads/2016/11/FP-ID14-19103.jpg', 'DRAWING', '2016-11-18 05:12:05', '2016-11-18 05:12:05', '', 5),
(126, 'FP-ID14-26604.jpg', 14, 'storage/uploads/2016/11/FP-ID14-26604.jpg', 'DRAWING', '2016-11-18 05:12:23', '2016-11-18 05:12:23', '', 6),
(127, 'FP-ID14-22453.jpg', 14, 'storage/uploads/2016/11/FP-ID14-22453.jpg', 'DRAWING', '2016-11-18 05:12:33', '2016-11-18 05:12:33', '', 7),
(128, 'FP-ID14-28906.jpg', 14, 'storage/uploads/2016/11/FP-ID14-28906.jpg', 'DRAWING', '2016-11-18 05:15:16', '2016-11-18 05:15:16', '', 8),
(129, 'FP-ID14-11850.jpg', 14, 'storage/uploads/2016/11/FP-ID14-11850.jpg', 'DRAWING', '2016-11-18 05:15:26', '2016-11-18 05:15:26', '', 9),
(130, 'FP-ID14-4059.jpg', 14, 'storage/uploads/2016/11/FP-ID14-4059.jpg', 'DRAWING', '2016-11-18 05:16:23', '2016-11-18 05:16:23', '', 10),
(131, 'FP-ID14-29115.jpg', 14, 'storage/uploads/2016/11/FP-ID14-29115.jpg', 'DRAWING', '2016-11-18 05:19:00', '2016-11-18 05:19:00', '', 11),
(132, 'FP-ID14-10872.jpg', 14, 'storage/uploads/2016/11/FP-ID14-10872.jpg', 'DRAWING', '2016-11-18 05:24:43', '2016-11-18 05:24:43', '', 12),
(133, 'FP-ID14-21841.jpg', 14, 'storage/uploads/2016/11/FP-ID14-21841.jpg', 'DRAWING', '2016-11-18 05:28:00', '2016-11-18 05:28:00', '', 13),
(134, 'FP-ID14-5848.jpg', 14, 'storage/uploads/2016/11/FP-ID14-5848.jpg', 'DRAWING', '2016-11-18 05:28:04', '2016-11-18 05:28:04', '', 14),
(135, 'FP-ID14-14897.jpg', 14, 'storage/uploads/2016/11/FP-ID14-14897.jpg', 'DRAWING', '2016-11-18 05:36:01', '2016-11-18 05:36:01', '', 15),
(136, 'FP-ID14-12726.jpg', 14, 'storage/uploads/2016/11/FP-ID14-12726.jpg', 'DRAWING', '2016-11-18 05:36:05', '2016-11-18 05:36:05', '', 16),
(137, 'FP-ID14-20151.jpg', 14, 'storage/uploads/2016/11/FP-ID14-20151.jpg', 'DRAWING', '2016-11-18 06:03:43', '2016-11-18 06:03:43', '', 17),
(138, 'FP-ID14-25878.jpg', 14, 'storage/uploads/2016/11/FP-ID14-25878.jpg', 'DRAWING', '2016-11-18 06:04:26', '2016-11-18 06:04:26', '', 18),
(139, 'FP-ID14-30244.jpg', 14, 'storage/uploads/2016/11/FP-ID14-30244.jpg', 'DRAWING', '2016-11-18 06:06:45', '2016-11-18 06:06:45', '', 19),
(140, 'FP-ID14-28311.jpg', 14, 'storage/uploads/2016/11/FP-ID14-28311.jpg', 'DRAWING', '2016-11-18 06:07:19', '2016-11-18 06:07:19', '', 20),
(141, 'FP-ID14-30093.jpg', 14, 'storage/uploads/2016/11/FP-ID14-30093.jpg', 'DRAWING', '2016-11-18 06:07:55', '2016-11-18 06:07:55', '', 21),
(142, 'FP-ID14-18564.jpg', 14, 'storage/uploads/2016/11/FP-ID14-18564.jpg', 'DRAWING', '2016-11-18 06:08:52', '2016-11-18 06:08:52', '', 22),
(143, 'FP-ID14-13122.jpg', 14, 'storage/uploads/2016/11/FP-ID14-13122.jpg', 'DRAWING', '2016-11-18 06:08:59', '2016-11-18 06:08:59', '', 23),
(144, 'FP-ID14-23859.jpg', 14, 'storage/uploads/2016/11/FP-ID14-23859.jpg', 'DRAWING', '2016-11-18 06:50:29', '2016-11-18 06:50:29', '', 24),
(145, 'FP-ID14-7447.jpg', 14, 'storage/uploads/2016/11/FP-ID14-7447.jpg', 'DRAWING', '2016-11-18 06:52:12', '2016-11-18 06:52:12', '', 25),
(146, 'FP-ID14-26864.jpg', 14, 'storage/uploads/2016/11/FP-ID14-26864.jpg', 'DRAWING', '2016-11-18 06:52:20', '2016-11-18 06:52:20', '', 26),
(147, 'FP-ID14-12448.jpg', 14, 'storage/uploads/2016/11/FP-ID14-12448.jpg', 'DRAWING', '2016-11-18 06:52:49', '2016-11-18 06:52:49', '', 27),
(148, 'FP-ID14-14143.jpg', 14, 'storage/uploads/2016/11/FP-ID14-14143.jpg', 'DRAWING', '2016-11-18 08:32:29', '2016-11-18 08:32:29', '', 28),
(149, 'FP-ID13-22990.jpg', 13, 'storage/uploads/2016/11/FP-ID13-22990.jpg', 'DRAWING', '2016-11-18 08:33:00', '2016-11-18 08:33:00', '', 7);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `user_type`, `user_image`, `image_path`, `organization_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Test', 'Admin', 'test@coredigita.com', '$2y$10$stQZ4ZyavEmkD4n6BwzQ.eTZTWd3qU46h8zL4A288fXuHs6Mr5vuK', 'USER', '', '', 1, 'ALIVE', 'MqgAcOOeJPMye5i0dCD89DRaFL7MnxBY03dZWpDMMJlz82cWF9uqXEHEKxbc', '2016-09-08 22:13:31', '2016-09-14 03:52:31'),
(3, 'test_2', 'Admin_2', '', '', 'SUPERUSER', '', '', 2, 'ALIVE', NULL, NULL, NULL),
(4, 'Super', 'Mannnn', 'superman@gmail.com', '$2y$10$4UDLkHCnJtICpXeaKU4FKuWUSYPFW35DzVM/iJKOs3NsWrpeD0NHq', 'SUPERUSER', 'UID41353.jpg', 'storage/user_images/UID41353.jpg', 2, 'ALIVE', 'PCdCiLgA57X3Fduk9f5YQBZ7aW1n0To3qMI5mcEbeOlEAzPkSzxfc15Np4vO', '2016-10-25 09:32:03', '2016-11-21 08:15:14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
