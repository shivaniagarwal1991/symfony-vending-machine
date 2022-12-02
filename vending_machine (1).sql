-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8111
-- Generation Time: Dec 02, 2022 at 04:06 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vending_machine`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221130191730', '2022-11-30 20:21:35', 108),
('DoctrineMigrations\\Version20221130192239', '2022-11-30 20:22:46', 125),
('DoctrineMigrations\\Version20221201075048', '2022-12-01 08:51:04', 268);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `seller_id`, `quantity`, `cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 1, 0, 15, 1, '2022-12-01 17:57:13', '2022-12-01 21:41:45'),
(2, 'test', 1, 10, 15, 1, '2022-12-01 17:57:35', '2022-12-01 17:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deposit` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `deposit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test@gmail.com', 'ROLE_SELLER', '$2y$13$7vNJcsQmIT/aqxSVOMLjLeJuaspPmx44T2rQhFuerIr91NLORyCwy', 10, 1, '2022-11-30 23:14:07', '2022-12-01 21:41:45'),
(3, 'test1@gmail.com', 'ROLE_BUYER', '$2y$13$Nzjr754J5Syt7Ju3m/6IR.IghbbEZLFjb62rRzszf2yjA7ZqYaVBa', 75, 1, '2022-11-30 23:23:39', '2022-12-02 16:05:07'),
(12, 'test3@gmail.com', 'ROLE_BUYER', '$2y$13$CSq7wkrktLQf4S1CLiu5v.OAxbSefxAa.Fs1c6IPCpStcSuHTxoq6', NULL, 0, '2022-12-01 13:22:26', '2022-12-01 16:58:40'),
(13, 'test4@gmail.com', 'ROLE_BUYER', '$2y$13$iliO1WivjGGW1CT64sWFU.FjnxDvQiJCJZ2fg4EanxMcgcrBuVSoG', NULL, 0, '2022-12-01 16:03:59', '2022-12-01 19:34:08'),
(14, 'test5@gmail.com', 'ROLE_BUYER', '$2y$13$Z5e8z4hKlcDWJYcbBCfuvu1Bc6hkL5U53WflddK0dXxgZQe3BWLzC', NULL, 0, '2022-12-01 16:04:31', '2022-12-01 16:59:47'),
(15, 'test6@gmail.com', 'ROLE_BUYER', '$2y$13$jn8C8GIlXJXxYymkdWeFMes9AHn0ZJSFwG58NvTEkMarESlD9jJUy', NULL, 0, '2022-12-01 16:05:13', '2022-12-01 17:01:27'),
(16, 'test7@gmail.com', 'ROLE_BUYER', '$2y$13$zIaatArHbfzSYQrJceX.NuFnS9g77w4DB8.iYLuaVu7SnAwR71AjC', NULL, 0, '2022-12-01 16:06:11', '2022-12-01 19:35:12'),
(17, 'test8@gmail.com', 'ROLE_BUYER', '$2y$13$tc8oyhgK7A01m37XP.XxleWCMEGlNij7itfCCiqgAzM3oINzCFWdS', NULL, 0, '2022-12-01 16:07:16', '2022-12-01 19:36:16'),
(18, 'test9@gmail.com', 'ROLE_BUYER', '$2y$13$rsERwHZCMWcjvh85hSh45uIeWKsm8aV7P4zi6FVVoOzkZ2e0V8XTS', NULL, 0, '2022-12-01 16:07:39', '2022-12-01 19:38:04'),
(19, 'test10@gmail.com', 'ROLE_BUYER', '$2y$13$1.dXkycM1ynWls7bhDXAieBOUCZcVYj6PfAmnGtgoxphmGxMzyTra', NULL, 0, '2022-12-01 16:10:33', '2022-12-01 19:40:46'),
(20, 'test11@gmail.com', 'ROLE_BUYER', '$2y$13$vcyUehuscbMK3ZSGk9yx3eKKLMxJKF9u0M0jsIRXt4kRFIqaMYc1W', NULL, 0, '2022-12-01 16:10:57', '2022-12-01 20:06:45'),
(21, 'test13@gmail.com', 'ROLE_BUYER', '$2y$13$N5kP7cScCOO9V2rcK1HZDOQ/MheBC8KmabULlkDIXGQqdhTJpiETC', NULL, 1, '2022-12-01 16:12:34', '2022-12-01 16:12:34'),
(22, 'test18@gmail.com', 'ROLE_BUYER', '$2y$13$fdlZcLxBRTJ8V3fbpjK6euPnsePOjEWvGhE8pbWdDBszz11zrlgx2', NULL, 1, '2022-12-01 19:47:01', '2022-12-01 19:47:01'),
(23, 'test89@gmail.com', 'ROLE_BUYER', '$2y$13$Nc4RPGZMyBSq25cZYtM.WunY6BST03OP3.WG05mtSvpd.oGDtmH/e', NULL, 1, '2022-12-02 09:03:53', '2022-12-02 09:03:53'),
(24, 'test28@gmail.com', 'ROLE_BUYER', '$2y$13$ltnd/GDGRiGyv7l.awRFIOMayKGqQfUSmFS9pCz.N79gqT0qWLFPm', NULL, 1, '2022-12-02 10:29:38', '2022-12-02 10:29:38'),
(25, 'test98@gmail.com', 'ROLE_BUYER', '$2y$13$dKz7R92N2ZpGqznbnDZcr.6fscXR83.6vdwRGRzS5pWxKxKdfdrpa', NULL, 1, '2022-12-02 11:12:03', '2022-12-02 11:12:03'),
(26, 'test980@gmail.com', 'ROLE_BUYER', '$2y$13$STjOX1lvJuE4nc/5TXvywOMKc2Qp13FWNOqcfiHY29KStCXyuWvhS', NULL, 1, '2022-12-02 11:12:55', '2022-12-02 11:12:55'),
(27, 'test38@gmail.com', 'ROLE_BUYER', '$2y$13$FBThauzWM.2I8rm/b6TI8.zEOxRgdVnNLxP4SfJSfo.fLTGWz875W', NULL, 1, '2022-12-02 11:16:19', '2022-12-02 11:16:19'),
(28, 'test989@gmail.com', 'ROLE_BUYER', '$2y$13$PmJwKh62FpcQ7sWoV/1fHOobOiyi1poEvnRtW7keoz/RVhNhhEXv.', NULL, 1, '2022-12-02 11:18:20', '2022-12-02 11:18:20'),
(29, 'cronin.juliet@yahoo.com', 'ROLE_BUYER', '$2y$13$A2LrY5.SEaQnkXxIJgGbRegidvhmS3FLM9L/inXNkl6/5CxOYYANy', NULL, 1, '2022-12-02 11:22:40', '2022-12-02 11:22:40'),
(30, 'isabel.witting@ratke.com', 'ROLE_BUYER', '$2y$13$ihLqRWfpUUZAqyeiDh12ouxJx9EeYcsnNEJ14SoU8IxacsIzcnW5q', NULL, 1, '2022-12-02 11:28:21', '2022-12-02 11:28:21'),
(31, 'test@gamil.com', 'ROLE_BUYER', '$2y$13$a4VNwQkU01lMue7hHr.OGOfuuowxvz1HndcfTUGWQIcnS4dMGE5tK', NULL, 1, '2022-12-02 11:29:08', '2022-12-02 11:29:08'),
(32, 'test34@gamil.com', 'ROLE_BUYER', '$2y$13$7GQZQchwnH6PFO9NpMyywuFQ6uFSSXO7Dy0QKGF9q54AqlSMNSgJe', NULL, 1, '2022-12-02 12:14:29', '2022-12-02 12:14:29'),
(33, 'test341@gamil.com', 'ROLE_BUYER', '$2y$13$9V0ggUWm/KwmzqES60BD5..ivi6TJxT/3SEdUiMwr0qKgLy1YT1ju', NULL, 1, '2022-12-02 12:14:57', '2022-12-02 12:14:57'),
(34, 'test342@gamil.com', 'ROLE_BUYER', '$2y$13$rIUpKn5zJCUXLjGopOivmehHSC.MU4/54ROtbnNrwHhfGcTtAW5Se', NULL, 1, '2022-12-02 13:14:18', '2022-12-02 13:14:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
