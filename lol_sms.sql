-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2026 at 12:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lol_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(10) NOT NULL,
  `tittle` varchar(15) NOT NULL,
  `message` varchar(40) NOT NULL,
  `publication_date` date NOT NULL,
  `postedby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `tittle`, `message`, `publication_date`, `postedby`) VALUES
(2, 'assistant', 'hello', '2026-10-06', 'sdfghjkl');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `date` date NOT NULL,
  `attendance_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date`, `attendance_status`) VALUES
(3, 2, '2026-09-29', 'qwertyui;');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(10) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `academic_year` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `academic_year`) VALUES
(9, 'civil engineering', '2026-2028 '),
(10, 'mechanical engineering', '2025-2026'),
(11, 'computer engineering', '2026-2028 ');

-- --------------------------------------------------------

--
-- Table structure for table `fruits`
--

CREATE TABLE `fruits` (
  `fruit_id` int(10) NOT NULL,
  `fruit_name` varchar(30) NOT NULL,
  `price` int(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fruits`
--

INSERT INTO `fruits` (`fruit_id`, `fruit_name`, `price`, `status`, `date`) VALUES
(5, 'orang2', 4000, 'productin', '2009-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `assessment_type` varchar(30) NOT NULL,
  `marks` varchar(20) NOT NULL,
  `academic_year` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `student_id`, `subject_id`, `assessment_type`, `marks`, `academic_year`) VALUES
(4, 2, 2, 'public', '100', '2026-2027');

-- --------------------------------------------------------

--
-- Table structure for table `login_user`
--

CREATE TABLE `login_user` (
  `u_id` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_user`
--

INSERT INTO `login_user` (`u_id`, `username`, `password`) VALUES
(1, 'David', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(10) NOT NULL,
  `sale_company` varchar(35) NOT NULL,
  `quantity` int(40) NOT NULL,
  `date` date NOT NULL,
  `fruit_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(10) NOT NULL,
  `adminission_number` varchar(20) NOT NULL,
  `names` varchar(30) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `adress` varchar(30) NOT NULL,
  `class_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `adminission_number`, `names`, `gender`, `date_of_birth`, `phone_number`, `adress`, `class_id`) VALUES
(3, '1', 'egidia nibakuze', 'Male', '2026-11-20', '0789876543', 'ruhango', 1),
(4, '2', 'keza jesca', 'Femal', '2026-11-01', '0789876543', 'ruhango', 2),
(7, '15', 'ADUHIRE Blandine', 'Femal', '2025-05-29', '0987654234', 'Rwamagana', 3),
(8, '5', 'IRAGABA Obald', 'Male', '2026-12-03', '079345669', 'Gisagara', 4),
(9, '6', 'YVETTE Celerine', 'Femal', '2026-12-04', '078987654', 'Kigali', 5),
(10, '7', 'UWIMPUHWE Julienne', 'Femal', '2026-11-05', '0797432754321', 'Kamonyi', 6),
(11, '8', 'NTWARI Ivan', 'Male', '2026-11-06', '0798753212345', 'Muhanga', 7),
(12, '9', 'BINGWI Arnold', 'Male', '2026-11-06', '0789955666', 'Gasabo', 8),
(13, '10', 'MANZI Migel', 'Male', '2026-11-02', '0789875465', 'Rwamagana', 9),
(14, '11', 'GISIGO Eric', 'Male', '2026-11-01', '078987654', 'Kigali', 10);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(10) NOT NULL,
  `subject_name` varchar(30) NOT NULL,
  `subject_code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `subject_code`) VALUES
(1, 'backend development', 'ITLBP602'),
(4, 'java  script', 'ITLBP602'),
(6, 'window server', 'ITLWS601'),
(7, 'small network', 'ITDSN602'),
(8, 'large network', 'ITLLG602');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(8) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `role`) VALUES
(5, 'Davidee', '12345', 'teacher'),
(8, 'egidia', '123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `foreign key` (`student_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `fruits`
--
ALTER TABLE `fruits`
  ADD PRIMARY KEY (`fruit_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `need` (`student_id`),
  ADD KEY `needs` (`subject_id`);

--
-- Indexes for table `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `zeros` (`fruit_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `cla` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fruits`
--
ALTER TABLE `fruits`
  MODIFY `fruit_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login_user`
--
ALTER TABLE `login_user`
  MODIFY `u_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
