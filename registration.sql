-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 04:53 PM
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
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_db`
--

CREATE TABLE `additional_db` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `region` varchar(250) DEFAULT NULL,
  `district` varchar(250) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `countryCode` varchar(250) DEFAULT NULL,
  `phoneNo` varchar(250) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `choices_db`
--

CREATE TABLE `choices_db` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first` varchar(250) DEFAULT NULL,
  `second` varchar(250) DEFAULT NULL,
  `third` varchar(250) DEFAULT NULL,
  `fourth` varchar(250) DEFAULT NULL,
  `fifth` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_id` int(11) NOT NULL,
  `levels` enum('Masters','Degree','Diploma') NOT NULL,
  `awards` varchar(200) NOT NULL DEFAULT current_timestamp(),
  `indexNo` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `countryCode` int(5) NOT NULL,
  `phoneNo` int(10) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `levels`, `awards`, `indexNo`, `email`, `countryCode`, `phoneNo`, `password`) VALUES
(25, 'Diploma', 'Certificate', 23456789, 'esther@j', 233, 567777777, ''),
(26, 'Degree', 'Foreign/Equivalent', 2147483647, 'S@dd', 222, 444444444, ''),
(27, 'Masters', 'CSEE Awards', 444447, 'd@d', 333, 666666666, ''),
(28, 'Masters', 'CSEE Awards', 1234567, 's@s', 888, 555555555, ''),
(29, 'Degree', 'CSEE Awards', 1234567, 's@s', 222, 111111111, '$2y$10$98aL1ZhaYDK8QLiruBWaKufHk5g5NCcsxwaU.TZIQsKktNAfoVeAO'),
(30, 'Masters', 'Foreign/Equivalent', 1234567, 's@s', 333, 444444444, '$2y$10$TVaUwjuM0rjuUn46dl1i4Om07fm/8UdCc52LIotscaGlLY9JZxQoO'),
(31, 'Diploma', 'CSEE Awards', 1234567, 'd@d', 220, 111111111, '$2y$10$4k.kXu.RY0WGrvK56tVaS.hMmX1k.f.aqLGXI9t4ww9d7I5ylw03G'),
(32, 'Degree', 'CSEE Awards', 123456789, 'a@a', 222, 444444444, '$2y$10$X3yb/OP7aDONq.Lssh8nMuljLL6Or/KWWnzP1H8DhK88eJ7nixYvy'),
(33, 'Diploma', 'Foreign/Equivalent', 123456789, 'a@s', 111, 111111111, '$2y$10$Sl416LOZDYp4PXrKkagWM.3aT7keBJH3j1ITUdFfdYMHSH7YsomgC'),
(34, 'Masters', 'CSEE Awards', 987, 'g@a', 111, 111111111, '$2y$10$kKUFXIRvda9sa0LGed4OtOJpcxvxrZvfD/TK2mXZj.VAdIyJWebVa'),
(35, 'Diploma', 'Foreign/Equivalent', 1234, 'ws@se', 222, 0, '$2y$10$1OKQfOcboW0Tfqo7pFZPcOd43Lnjc2xBMWJrArzAXsUVZnzwo8hZu'),
(36, 'Masters', 'Foreign/Equivalent', 1999, 'df@we', 222, 777777777, '$2y$10$M2vA0dzZ.kEpjvdNCw3VHejltkpYqFxSO0vV1WJP6Y9p3k8/Vq.Ce'),
(37, 'Degree', 'CSEE Awards', 1208, 'es@we', 555, 777777777, '$2y$10$/xmNq6qkTaGV6TDUrnH9T.FdDM5OBRlD9DWyAxQRZjxrIYOlAHI9m'),
(38, 'Diploma', 'CSEE Awards', 7777, 'y@y', 666, 888888888, '$2y$10$O7ZFCAg2zQPSYGWtXcfv4eodmz/OlBD/vPZkCiqF0KrBoPCo9W6Zy'),
(39, 'Diploma', 'CSEE Awards', 1111, 'd@d', 777, 555555555, '$2y$10$0do0bALO0ztSVHCrjGO98OJowOOJxehjKwvNXXosZl9Z5amnKEWA2'),
(40, 'Degree', 'CSEE Awards', 3333, 'f@d', 233, 777777777, '$2y$10$OQrr79ts5Uvasb8YlRKj8um1Pxza6pwsReh3wmbw0hkUL.nWR5Ssm'),
(41, 'Diploma', 'CSEE Awards', 1234, 'd@s', 222, 555555555, '$2y$10$lIBJM4PYd8UJoSVZMu0V2.VKSW3YlwzrkBdqrXg18C19KaYUYzJHu'),
(42, 'Masters', 'CSEE Awards', 111, 's@s', 999, 777777777, '$2y$10$8vU.uclDeT9PfMGjWkIGretFAb65GfLVkYhP.qbNoB8ClYZKHOw0W'),
(43, 'Masters', 'Foreign/Equivalent', 1212, 'e@e', 333, 666666666, '$2y$10$HXyISij25dkqZz//1aykAOBFGVgsqOYZwbmQizUgnm2K8RcMvVIHy'),
(44, 'Diploma', 'CSEE Awards', 123, 'gm@gmail.com', 255, 123456789, '$2y$10$aWYT.wvYT6Xg6uMmu3vlY.WmqpciLyylkWxJvVf8gRJdINvHVIYkm');

-- --------------------------------------------------------

--
-- Table structure for table `status_db`
--

CREATE TABLE `status_db` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `indexNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_db`
--

INSERT INTO `status_db` (`id`, `user_id`, `status`, `indexNo`) VALUES
(2, NULL, 1, 23456);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_db`
--
ALTER TABLE `additional_db`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `choices_db`
--
ALTER TABLE `choices_db`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `status_db`
--
ALTER TABLE `status_db`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_db`
--
ALTER TABLE `additional_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `choices_db`
--
ALTER TABLE `choices_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `status_db`
--
ALTER TABLE `status_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_db`
--
ALTER TABLE `additional_db`
  ADD CONSTRAINT `additional_db_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`);

--
-- Constraints for table `choices_db`
--
ALTER TABLE `choices_db`
  ADD CONSTRAINT `choices_db_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`);

--
-- Constraints for table `status_db`
--
ALTER TABLE `status_db`
  ADD CONSTRAINT `status_db_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
