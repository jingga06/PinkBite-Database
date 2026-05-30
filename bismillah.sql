-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 30, 2025 at 05:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bismillah`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `name`, `email`, `password`, `phone`, `created_at`, `user_id`) VALUES
(3, '', 'alya1', 'alya123@gmai.com', '', NULL, '2025-04-22 23:29:44', 0),
(7, '', 'marsha', 'marsha@gmail.com', '', NULL, '2025-04-22 16:18:30', 0),
(8, '', 'Fatwa Putri Jingga', 'marsha@gmail.cou', '', NULL, '2025-04-22 16:21:09', 0),
(9, '', 'Fasya Cantik Banget', 'fasya.cantik@cantik.com', '', NULL, '2025-04-22 16:56:13', 0),
(35, '', 'kaila', 'kai@gmail.com', '', NULL, '2025-04-22 22:20:07', 0),
(36, '', 'cantik', 'cantik@gmail.com', '', NULL, '2025-04-22 22:34:17', 0),
(39, '', 'jingga', 'fatwaptrjingga@gmail.com', '', NULL, '2025-04-23 02:14:00', 3),
(40, '', 'dyar', 'dyar@gmail.com', '', NULL, '2025-04-23 02:18:14', 8),
(41, '', 'put', 'put@gmail.com', '', NULL, '2025-04-23 03:54:54', 9),
(42, '', 'maya', 'maya@gmail.com', '', NULL, '2025-04-23 04:08:24', 10),
(50, '', 'Angger Kalehandya', 'anggerkalehandya99@gmail.com', '', NULL, '2025-04-26 15:47:24', 11),
(51, '', 'Rifqiaufaa', 'Rifqiaufaa@gmail.com', '', NULL, '2025-04-27 09:48:55', 12),
(52, '', 'Rifqiaufaa2', 'Rifqiaufaa2@gmail.com', '', NULL, '2025-04-27 09:51:50', 13),
(53, '', 'rikip ginanjarr', 'rikip@gmail.com', '', NULL, '2025-04-28 12:31:18', 14),
(55, '', 'Salwa Reva Andini', 'salwa@gmail.com', '', NULL, '2025-04-29 05:02:07', 15),
(56, '', 'Nor Umayah', 'may@gmail.com', '', NULL, '2025-04-29 07:24:25', 16),
(57, '', 'stefvany reva ginting', 'pani@gmail.com', '', NULL, '2025-04-29 12:45:54', 17),
(58, '', 'Kaila Anisa Syafitri', 'kaila@gmail.com', '', NULL, '2025-04-29 13:24:25', 18),
(59, '', 'reva', 'reva@gmail.com', '', NULL, '2025-04-29 13:36:06', 0),
(60, '', 'Alifea Mega Tistafatriana Jova ', 'jova@gmail.com', '', NULL, '2025-04-29 16:02:18', 19),
(61, '', 'ziaaa', 'zia@gmail.com', '', NULL, '2025-04-29 17:31:36', 0),
(62, '', 'Balqis Putri Azzahra', 'kistot@gmail.com', '', NULL, '2025-04-29 17:47:34', 20),
(63, '', 'syakira latifah awliya', 'syakira@gmail.com', '', NULL, '2025-04-30 02:06:54', 21),
(64, '', 'Fatimah Azzahra', 'fatimah@gmail.com', '', NULL, '2025-04-30 02:26:48', 22),
(65, '', 'eileen daneaya', 'eileen@gmail.com', '', NULL, '2025-04-30 02:41:22', 23);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `price`, `image`) VALUES
(1, 'Strawberry Cake', 25000, 'strawberry_cake.jpg'),
(2, 'Rosy Latte', 20000, 'rosy_latte.webp'),
(3, 'Pink Creamy Pasta', 22000, 'pink_pasta.jpg'),
(4, 'Strawberry Cupcake', 35000, 'strawberry_cupcake.jpg'),
(5, 'Pink Milkshake', 40000, 'pink_milkshake.webp'),
(6, 'Sweet Macarons', 30000, 'sweet_macarons.webp'),
(9, 'Banana Split', 45000, 'uploads/banana-split-9.jpg'),
(10, 'Strawberry Nougats', 15000, 'uploads/Sugar_Cookie_Cake_014-b61634cfed5b4d5e8e1a2ccee00fb3b1.jpg'),
(21, 'ice cream', 15000, 'uploads/Strawberry-Ice-Cream-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `party_size` int(11) NOT NULL DEFAULT 1,
  `status` enum('waiting','called','done','seated') DEFAULT 'waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `user_id`, `queue_number`, `party_size`, `status`, `created_at`) VALUES
(20, 11, 1, 1, 'done', '2025-04-26 17:48:31'),
(21, 12, 2, 1, 'done', '2025-04-27 09:49:36'),
(22, 13, 3, 1, 'done', '2025-04-27 09:53:41'),
(24, 13, 5, 6, 'done', '2025-04-27 10:07:51'),
(25, 13, 6, 2, 'done', '2025-04-27 10:09:05'),
(26, 13, 7, 10, 'done', '2025-04-27 10:26:40'),
(27, 13, 8, 2, 'done', '2025-04-27 10:27:16'),
(28, 14, 9, 6, 'done', '2025-04-28 12:33:06'),
(29, 15, 10, 2, 'done', '2025-04-29 05:02:43'),
(30, 16, 11, 5, 'done', '2025-04-29 07:35:17'),
(31, 17, 12, 7, 'done', '2025-04-29 12:47:52'),
(32, 18, 13, 5, 'done', '2025-04-29 13:25:31'),
(33, 19, 14, 7, 'done', '2025-04-29 16:03:56'),
(34, 18, 15, 4, 'done', '2025-04-29 17:22:14'),
(35, 20, 16, 9, 'done', '2025-04-29 17:48:54'),
(36, 21, 17, 5, 'done', '2025-04-30 02:07:57'),
(37, 22, 18, 8, 'done', '2025-04-30 02:28:13'),
(38, 23, 19, 5, 'waiting', '2025-04-30 02:42:23'),
(39, 15, 20, 2, 'waiting', '2025-04-30 02:55:00'),
(40, 18, 21, 7, 'waiting', '2025-04-30 02:56:16'),
(41, 20, 22, 4, 'waiting', '2025-04-30 02:56:56'),
(42, 21, 23, 8, 'waiting', '2025-04-30 02:57:30'),
(43, 22, 24, 2, 'waiting', '2025-04-30 02:58:14'),
(44, 10, 25, 7, 'waiting', '2025-04-30 02:59:00'),
(45, 17, 26, 3, 'waiting', '2025-04-30 03:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reservation_time` datetime DEFAULT NULL,
  `party_size` int(11) DEFAULT NULL,
  `status` enum('pending','seated','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `phone`, `reservation_time`, `party_size`, `status`, `created_at`, `user_id`) VALUES
(37, 'mayaw', NULL, '2025-04-30 18:15:00', 3, 'completed', '2025-04-29 08:15:12', 16),
(38, 'kaila', '0877', '2025-04-30 22:31:00', 8, 'completed', '2025-04-29 13:32:05', 18),
(42, 'jova', NULL, '2025-04-29 02:17:00', 8, 'pending', '2025-04-29 16:19:01', 19),
(43, 'jova', NULL, '2025-04-30 13:19:00', 7, 'completed', '2025-04-29 16:19:18', 19),
(45, 'kaila', NULL, '2025-04-30 16:28:00', 6, 'completed', '2025-04-29 17:28:29', 18),
(47, 'kistot', NULL, '2025-04-30 16:54:00', 6, 'completed', '2025-04-29 17:55:06', 20),
(48, 'syakira', NULL, '2025-04-30 14:13:00', 3, 'completed', '2025-04-30 02:13:48', 21),
(49, 'Fatimah', NULL, '2025-04-30 10:35:00', 4, 'completed', '2025-04-30 02:31:38', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_number` varchar(10) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `status` enum('available','occupied','reserved') DEFAULT 'available',
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `capacity`, `status`, `is_available`) VALUES
(3, 'T05', 5, 'occupied', 1),
(5, 'T07', 6, 'occupied', 1),
(6, 'T08', 7, 'occupied', 1),
(8, 'T01', 2, 'occupied', 1),
(9, 'T02', 2, 'available', 1),
(10, 'T03', 4, 'occupied', 1),
(11, 'T04', 4, 'available', 1),
(14, 'T06', 6, 'available', 1),
(15, 'T09', 10, 'occupied', 1),
(16, 'T10', 10, 'available', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_assignments`
--

CREATE TABLE `table_assignments` (
  `id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `queue_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed','cancelled') DEFAULT 'active',
  `reservation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_assignments`
--

INSERT INTO `table_assignments` (`id`, `table_id`, `queue_id`, `assigned_at`, `status`, `reservation_id`) VALUES
(38, 3, NULL, '2025-04-26 17:44:17', 'completed', 27),
(39, 2, 20, '2025-04-26 17:48:45', 'completed', NULL),
(40, 2, 21, '2025-04-27 10:02:37', 'completed', NULL),
(41, 3, 22, '2025-04-27 10:02:38', 'completed', NULL),
(42, 2, 23, '2025-04-27 10:03:19', 'active', NULL),
(43, 3, 24, '2025-04-27 10:08:10', 'completed', NULL),
(44, 3, 25, '2025-04-27 10:09:15', 'completed', NULL),
(45, 3, 26, '2025-04-27 10:27:01', 'completed', NULL),
(46, 5, 27, '2025-04-27 10:27:25', 'completed', NULL),
(47, 5, 28, '2025-04-28 12:43:07', 'completed', NULL),
(48, 10, NULL, '2025-04-28 12:48:48', 'completed', 31),
(49, 8, 29, '2025-04-29 05:04:12', 'completed', NULL),
(50, 3, 30, '2025-04-29 08:03:20', 'completed', NULL),
(51, 10, NULL, '2025-04-29 08:27:59', 'completed', 37),
(52, 3, 32, '2025-04-29 13:29:34', 'completed', NULL),
(53, 15, NULL, '2025-04-29 13:33:15', 'completed', 38),
(54, 6, 31, '2025-04-29 15:31:08', 'completed', NULL),
(55, 6, 33, '2025-04-29 16:08:31', 'completed', NULL),
(56, 6, NULL, '2025-04-29 16:21:05', 'completed', 43),
(57, 10, 34, '2025-04-29 17:25:57', 'completed', NULL),
(58, 5, NULL, '2025-04-29 17:29:02', 'completed', 45),
(59, 15, 35, '2025-04-29 17:52:39', 'completed', NULL),
(60, 5, NULL, '2025-04-29 17:56:09', 'completed', 47),
(61, 3, 36, '2025-04-30 02:11:23', 'completed', NULL),
(62, 10, NULL, '2025-04-30 02:14:16', 'completed', 48),
(63, 15, 37, '2025-04-30 02:30:00', 'completed', NULL),
(64, 10, NULL, '2025-04-30 02:32:28', 'completed', 49);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'pinkbite', 'admin@pinkbite.com', '$2y$10$D7l3F9mvcRonojiE84Kk1.YvVUcMcrwSxihieo6JhJsUzXhkIMalu', 'admin', '2025-04-21 17:39:26'),
(3, 'jingga', 'fatwaptrjingga@gmail.com', '$2y$10$MtWdpAs0Rpbk6fhwQM7IgewapGWPjj1bDX0c2xAyHmZcAhOOBTdwi', 'customer', '2025-04-22 06:08:37'),
(4, 'putri', 'putri@gmail.com', '$2y$10$dJch5y3IT.QCsYbBhPG/hOtlccv5bd9azEwVD1TASI75zU1DBO2fe', 'customer', '2025-04-22 06:47:03'),
(5, 'pasa', 'fasya@gmail.com', '$2y$10$hSqC6ougDM08/fxJJjiL5O/n2n8UbtKY6Z6hORPexf3Fr8K0UqUea', 'customer', '2025-04-22 10:39:16'),
(6, 'paca', 'paca@gmail.com', '$2y$10$NOqIf8/2uRn2.ylVj3fhcODyzUT/BQk1s3CbADln5g3FqvJmABU7W', 'customer', '2025-04-22 15:43:40'),
(7, 'sasal', 'sasal@gmail.com', '$2y$10$LiV8tqLu3NwjP37T/lIUL..m79eU5KE4yuz6we93.z8zn7scoooE.', 'customer', '2025-04-22 23:05:00'),
(8, 'dyar', 'dyar@gmail.com', '$2y$10$ZSxfKCzTPGzzG3CTJ9lUmOGfJeW53JNDN76.0vr1Gg0OKw/LJJ7Wq', 'customer', '2025-04-23 02:18:04'),
(9, 'put', 'put@gmail.com', '$2y$10$K56ZpziPuyqVvCct8X1GNOndNfkZJkDxH7A9NXog8UsADEny5BiSe', 'customer', '2025-04-23 03:54:38'),
(10, 'maya', 'maya@gmail.com', '$2y$10$2xdudg4nHCu2j6DeUgMHwOELuh.QPQ1jLY/E23/rNiWSwgJXxGXIu', 'customer', '2025-04-23 04:02:06'),
(11, 'Angger Kalehandya', 'anggerkalehandya99@gmail.com', '$2y$10$tj7IafCwbDmAh5I82HHp4eE0Npjt8SjdFa1QWmPFiNpzH0J8Px5ua', 'customer', '2025-04-26 15:47:24'),
(12, 'Rifqiaufaa', 'Rifqiaufaa@gmail.com', '$2y$10$pO6PhE3rETUexDL/bRiaA.JiAb0z10/4aJcZ9ds7f26RWxk1EWauS', 'admin', '2025-04-27 09:48:55'),
(13, 'Rifqiaufaa2', 'Rifqiaufaa2@gmail.com', '$2y$10$r1y5bd6yr7oUvMIO1NNx0OB0pDP2PRTuHxPMuIRw94DCDRhR7qqI.', 'customer', '2025-04-27 09:51:50'),
(14, 'rikip ginanjar', 'rikip@gmail.com', '$2y$10$2O98aT3mSQ176tglVH3nKuMc97f1iyJFRtGuZ0nPFQ7WeWXQxgbgy', 'customer', '2025-04-28 12:31:18'),
(15, 'Salwa Reva Andini', 'salwa@gmail.com', '$2y$10$DSEeFenu7OmLmQogPakzJumif58duW2e0biCn5fGrRtJidP/4u1/S', 'customer', '2025-04-29 05:02:07'),
(16, 'Nor Umayah', 'may@gmail.com', '$2y$10$8Cj4NUME3Hk6H.RS8FIkg.lFGE3pH2.gjgGDOTZkcWHz8LmEay4HS', 'customer', '2025-04-29 07:24:25'),
(17, 'stefvany reva ginting', 'pani@gmail.com', '$2y$10$AfkJSgQx/5T73nY0gkVQl.ZxO18zZvsKgXsu8PHAItm7lzWWrJiru', 'customer', '2025-04-29 12:45:54'),
(18, 'Kaila Anisa Syafitri', 'kaila@gmail.com', '$2y$10$.wqPwqMKMIjgSTEFYpS4ceiNSuJ8QG.cCeG61Xj7YPjr/5Iv5.eb.', 'customer', '2025-04-29 13:24:25'),
(19, 'Alifea Mega Tistafatriana Jova ', 'jova@gmail.com', '$2y$10$ZA9hq6EGP.vohANVyYmjzOvnYAJ4ET1ImTejH7uQHK.zjUbs3nmIO', 'customer', '2025-04-29 16:02:18'),
(20, 'Balqis Putri Azzahra', 'kistot@gmail.com', '$2y$10$n.ftBLK8WmI/SKjg6gUJuOlcikLzqzik8zibh7Sn8taqow8Thqndy', 'customer', '2025-04-29 17:47:34'),
(21, 'syakira latifah awliya', 'syakira@gmail.com', '$2y$10$sFaA.qST/MNphjBnqlw57u12eFKPlrVjJjEcVCFLnXUTnr49CXu1.', 'customer', '2025-04-30 02:06:54'),
(22, 'Fatimah Azzahra', 'fatimah@gmail.com', '$2y$10$R8QZZS8jmbxo.Kj4LR7VNOnKpZ3ucpmWRWBaETO0sMSsPeg0G9tpa', 'customer', '2025-04-30 02:26:48'),
(23, 'eileen daneaya', 'eileen@gmail.com', '$2y$10$V8OUihleBlrU6Cl9TJ4WV.iE730CeZEA3TbM9GKveO0l6mIqI5hKi', 'customer', '2025-04-30 02:41:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_number` (`table_number`);

--
-- Indexes for table `table_assignments`
--
ALTER TABLE `table_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `queue_id` (`queue_id`),
  ADD KEY `fk_reservation` (`reservation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `table_assignments`
--
ALTER TABLE `table_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
