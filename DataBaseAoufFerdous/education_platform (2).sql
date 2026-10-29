-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2026 at 10:43 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `education_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `youtube` varchar(100) DEFAULT NULL,
  `disc` text DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `name`, `type`, `subject_id`, `website`, `youtube`, `disc`, `file_url`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Lecture 1 - Introduction', 'Course', 1, NULL, 'aqz-KE-bpKQ', 'Course introduction and goals.', NULL, 1, '2026-10-29 20:43:03', NULL),
(2, 'TD Series 1', 'TD', 1, NULL, NULL, 'Exercises on variables and loops.', NULL, 1, '2026-10-29 20:43:03', NULL),
(3, 'Exam 2024', 'Exam', 1, NULL, NULL, 'Previous final exam.', NULL, 1, '2026-10-29 20:43:03', NULL),
(4, 'SQL Basics', 'Course', 4, 'https://www.w3schools.com/sql/', 'aqz-KE-bpKQ', 'SELECT, INSERT, UPDATE, DELETE.', NULL, 1, '2026-10-29 20:43:03', NULL),
(5, 'TP 1 - Create tables', 'TP', 4, NULL, NULL, 'Lab on CREATE TABLE.', NULL, 1, '2026-10-29 20:43:03', NULL),
(6, 'Limits Cheat Sheet', 'Course', 6, NULL, NULL, 'Summary of limit rules.', NULL, 1, '2026-10-29 20:43:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_year` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `name`, `id_year`) VALUES
(1, 'Semester 1', 1),
(2, 'Semester 2', 1),
(3, 'Semester 3', 2),
(4, 'Semester 4', 2),
(5, 'Semester 5', 3),
(6, 'Semester 6', 3);

-- --------------------------------------------------------

--
-- Table structure for table `spc`
--

CREATE TABLE `spc` (
  `id` int(10) UNSIGNED NOT NULL,
  `sname` varchar(150) NOT NULL,
  `disc` text DEFAULT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `creat_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spc`
--

INSERT INTO `spc` (`id`, `sname`, `disc`, `url_image`, `active`, `creat_at`, `update_at`) VALUES
(1, 'Computer Science', 'Programming, databases, networks and software engineering.', 'uploads/sp_image/1793308853.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:20:53'),
(2, 'Mathematics', 'Algebra, analysis, probability and statistics.', 'uploads/sp_image/1793308874.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:21:14'),
(3, 'Physics', 'Mechanics, thermodynamics, optics and electromagnetism.', 'uploads/sp_image/1793308886.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:21:26'),
(4, 'Biology', 'Cell biology, genetics, ecology and biochemistry.', 'uploads/sp_image/1793309023.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `coef` int(11) NOT NULL DEFAULT 1,
  `id_sp` int(10) UNSIGNED NOT NULL,
  `id_sem` int(10) UNSIGNED NOT NULL,
  `disc` text DEFAULT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `coef`, `id_sp`, `id_sem`, `disc`, `url_image`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Algorithms 1', 0, 1, 1, 'Introduction to algorithmic thinking and basic data structures.', 'uploads/subject_images/1793309851.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:37:31'),
(2, 'Mathematics 1', 0, 1, 1, 'Analysis and linear algebra foundations.', 'uploads/subject_images/1793309868.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:37:48'),
(3, 'Computer Architecture', 0, 1, 1, 'Binary systems, logic gates and processor basics.', 'uploads/subject_images/1793309838.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:37:18'),
(4, 'Databases', 3, 1, 2, 'Relational model, SQL and normalization.', 'uploads/subject_images/1793310059.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:40:59'),
(5, 'Web Development', 6, 1, 2, 'HTML, CSS, PHP and MySQL fundamentals.', 'uploads/subject_images/1793310045.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:40:45'),
(6, 'Analysis 1', 0, 2, 1, 'Real sequences, limits and continuity.', 'uploads/subject_images/1793309901.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:38:21'),
(7, 'Algebra 1', 4, 2, 1, 'Sets, groups and matrices.', 'uploads/subject_images/1793309889.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:38:33'),
(8, 'Mechanics', 5, 3, 1, 'Kinematics and dynamics of a particle.', 'uploads/subject_images/1793309946.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `url_image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `gender`, `url_image`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Admin Principal', 'admin@unilearn.test', '', 'admin', 'male', 'uploads/user_image/1793309277.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:27:57'),
(2, 'Sara Benali', 'sara@unilearn.test', '', 'user', 'female', 'uploads/user_image/1793309307.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:28:27'),
(3, 'Karim Haddad1', 'karim@unilearn.test', '', 'user', 'male', 'uploads/user_image/1793309267.jpg', 1, '2026-10-29 20:43:03', '2026-10-29 22:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `webinfo`
--

CREATE TABLE `webinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `objective` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webinfo`
--

INSERT INTO `webinfo` (`id`, `objective`, `email`, `phone`, `youtube`, `facebook`, `adress`) VALUES
(1, 'A university platform to share courses, exercises and exams with students.', 'contact@unilearn.test', '+213 555 00 00 00', 'https://youtube.com/@unilearn', 'https://facebook.com/unilearn', 'University Campus, Ouargla, Algeria');

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`id`, `name`) VALUES
(1, 'L1'),
(2, 'L2'),
(3, 'L3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_con_sub` (`subject_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sem_year` (`id_year`);

--
-- Indexes for table `spc`
--
ALTER TABLE `spc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sp_sem` (`id_sp`,`id_sem`),
  ADD KEY `fk_sub_sem` (`id_sem`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `webinfo`
--
ALTER TABLE `webinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `spc`
--
ALTER TABLE `spc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `webinfo`
--
ALTER TABLE `webinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `fk_con_sub` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `fk_sem_year` FOREIGN KEY (`id_year`) REFERENCES `year` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_sub_sem` FOREIGN KEY (`id_sem`) REFERENCES `semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sub_spc` FOREIGN KEY (`id_sp`) REFERENCES `spc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
