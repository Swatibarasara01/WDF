-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2026 at 07:18 PM
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
-- Database: `student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `course`, `phone`) VALUES
(1, 'Swati Barasara', 'swatibarasara01@gmail.com', 'Comupter Engineering', '6355615172'),
(2, 'Mann Kansagra', 'mannk28@gmail.com', 'Electrical Engineering', '9081058576'),
(3, 'Vraj Barasara', 'vajubarasara77@gmail.com', 'Electronics and Communication Engineering', '8849899274'),
(5, 'Aarav Patel', 'aarav.patel@example.com', 'BCA', '9876543210'),
(6, 'Diya Shah', 'diya.shah@example.com', 'B.Tech', '9876543211'),
(7, 'Krish Mehta', 'krish.mehta@example.com', 'MCA', '9876543212'),
(8, 'Anaya Desai', 'anaya.desai@example.com', 'Computer Engineering', '9876543213'),
(9, 'Dev Joshi', 'dev.joshi@example.com', 'BCA', '9876543214'),
(10, 'Mira Trivedi', 'mira.trivedi@example.com', 'B.Tech', '9876543215'),
(11, 'Rohan Patel', 'rohan.patel@example.com', 'MCA', '9876543216'),
(12, 'Isha Shah', 'isha.shah@example.com', 'Computer Engineering', '9876543217'),
(13, 'Yash Mehta', 'yash.mehta@example.com', 'BCA', '9876543218'),
(14, 'Khushi Desai', 'khushi.desai@example.com', 'B.Tech', '9876543219'),
(15, 'Neel Joshi', 'neel.joshi@example.com', 'MCA', '9876543220'),
(16, 'Riya Trivedi', 'riya.trivedi@example.com', 'Computer Engineering', '9876543221'),
(17, 'Parth Patel', 'parth.patel@example.com', 'BCA', '9876543222'),
(18, 'Jiya Shah', 'jiya.shah@example.com', 'B.Tech', '9876543223'),
(19, 'Om Mehta', 'om.mehta@example.com', 'MCA', '9876543224'),
(20, 'Tara Desai', 'tara.desai@example.com', 'Computer Engineering', '9876543225'),
(21, 'Vivaan Joshi', 'vivaan.joshi@example.com', 'BCA', '9876543226'),
(22, 'Kavya Trivedi', 'kavya.trivedi@example.com', 'B.Tech', '9876543227'),
(23, 'Arjun Patel', 'arjun.patel@example.com', 'MCA', '9876543228'),
(24, 'Nisha Shah', 'nisha.shah@example.com', 'Computer Engineering', '9876543229');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
