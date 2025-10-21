-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 03:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homecare_experts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', '$2y$10$IdOvjH57aMJizu1uH2PKTOuthlNDXzHw4TYhVUUFrKXiYhnNubsvK', 'admin', '2025-02-24 13:53:36', '2025-02-24 13:53:36'),
(0, 'admin@prajwal', '$2y$10$jxsVY7nKkw/.UGcbVWClPeQeGeNPkXYJ6sxlI07aJzX35ZV1AubjW', 'Prajwal', '2025-03-02 01:02:23', '2025-03-02 01:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `experience` int(11) NOT NULL,
  `job_role` varchar(50) NOT NULL,
  `job_type` enum('Full-time','Part-time','Contract','Internship') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `id_proof` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `job_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `name`, `gender`, `dob`, `email`, `contact`, `country`, `state`, `district`, `experience`, `job_role`, `job_type`, `photo`, `id_proof`, `resume`, `submission_date`, `job_id`, `status`) VALUES
(48, 'nddfnmn', 'other', '2001-12-21', 'pjsdh@gmail.com', '953235689', 'india', 'ka', 'bgm', 5, 'plumber', 'Full-time', '1741175492_parveen_kaswan-___CDMGjVRjof0___-.jpg', '1741175492_Screenshot (17).png', '1741175492_prajwal resume1.pdf', '2025-03-05 11:51:32', 7, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` int(11) NOT NULL,
  `concern_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `gstin` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `concern_person`, `email`, `password`, `company`, `tagline`, `description`, `website`, `gstin`, `phone`, `status`) VALUES
(15, 'prajwal', 'prajwaljain1008@gmail.com', '$2y$10$j8rrLuxTuYPnWwTM6leS/.oqtomydHkrGU1iF6hWdg9wD5LSo3OCq', 'Urban Company', 'we provide home services', 'nemfjkr', 'https://www.urbancompany.com/', '29EILPK3924E1Z2', '9008341720', 'approved'),
(26, 'kundan', 'allayyanavarprajwal@gmail.com', '$2y$10$DxYtoYkZwuiOFivwPRVj1eoX7u55n7VvfcJYtfdb.FYqqP2hSXXnK', 'Aradhya Engineerings', 'nvndfvndfm.,', '', 'https://www.urbanoutfitters.com/', '29EILPK3924E1Z2', '9008341720', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `hired_candidates`
--

CREATE TABLE `hired_candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `job_role` varchar(255) DEFAULT NULL,
  `job_type` varchar(50) DEFAULT NULL,
  `photo` blob DEFAULT NULL,
  `id_proof` blob DEFAULT NULL,
  `resume` blob DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hired_candidates`
--

INSERT INTO `hired_candidates` (`id`, `name`, `gender`, `dob`, `email`, `contact`, `country`, `state`, `district`, `experience`, `job_role`, `job_type`, `photo`, `id_proof`, `resume`, `submission_date`, `job_id`) VALUES
(1, 'Prajwal', 'male', '2002-02-21', 'prajwaljain1008@gmail.com', '953235689', 'india', 'ka', 'bgm', '2', 'plumber', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Prajwal', 'female', '2025-12-31', 'prajwaljain1008@gmail.com', '9008341720', 'india', 'ka', 'bgm', '0', 'plumber', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('open','closed') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `title`, `description`, `requirements`, `salary`, `location`, `created_at`, `status`) VALUES
(7, 15, 'Plumber', 'jsajfbdbfVDN', 'njvnmxnvn', '15000', 'bgm', '2025-03-04 08:23:52', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` enum('admin','worker','employer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `job_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_job` (`job_id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hired_candidates`
--
ALTER TABLE `hired_candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `hired_candidates`
--
ALTER TABLE `hired_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `hired_candidates`
--
ALTER TABLE `hired_candidates`
  ADD CONSTRAINT `hired_candidates_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
