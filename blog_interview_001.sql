-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2022 at 04:52 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_interview_001`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `blogTitle` varchar(50) NOT NULL,
  `blogSubTitle` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `aDate` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-active,1-inactive,2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogId`, `userId`, `blogTitle`, `blogSubTitle`, `description`, `aDate`, `status`) VALUES
(41, 1, 'My First Blog', 'this one is  My First Blog ', 'Thank for your time', '2022-08-20 00:44:13', '0'),
(43, 1, 'OK N', 'OK N', 'OK N', '2022-08-20 07:52:03', '0'),
(44, 1, 'tagName', 'tagName', 'tagName', '2022-08-20 07:53:20', '0'),
(45, 1, 'ff', 'ff', 'ff', '2022-08-20 07:54:20', '0'),
(46, 1, 'cc', 'cc', 'cc', '2022-08-20 07:56:06', '0'),
(47, 1, 'cc', 'cc', 'cc', '2022-08-20 07:56:40', '0');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tag`
--

CREATE TABLE `blog_tag` (
  `bTagId` int(11) NOT NULL,
  `blogId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-ative,1-inactive,2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_tag`
--

INSERT INTO `blog_tag` (`bTagId`, `blogId`, `tagId`, `status`) VALUES
(3, 43, 1, '0'),
(4, 43, 1, '0'),
(5, 44, 1, '0'),
(6, 44, 1, '0'),
(7, 45, 1, '0'),
(8, 45, 1, '0'),
(9, 46, 1, '0'),
(10, 46, 1, '0'),
(11, 47, 3, '0'),
(12, 47, 3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tagId` int(11) NOT NULL,
  `tagName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tagId`, `tagName`) VALUES
(1, 'Funny'),
(2, 'Lol'),
(3, 'cc');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userName`, `userEmail`, `userPassword`) VALUES
(1, 'hari', 'hari@gmail.com', '12345'),
(2, 'sam', 'sam@gmail.com', '12345'),
(3, 'sam1', 'sam1@gmail.com', '123'),
(4, 'sf', 'sf@gmail.com', '123'),
(5, 'pranesh', 'pranesh@gmail.com', '12345'),
(6, 'encrypt', 'encrypt@gmai.com', '234'),
(7, 'ty', 'ty@gmail.com', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD PRIMARY KEY (`bTagId`),
  ADD KEY `blogId` (`blogId`,`tagId`),
  ADD KEY `tagId` (`tagId`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tagId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `blog_tag`
--
ALTER TABLE `blog_tag`
  MODIFY `bTagId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tagId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD CONSTRAINT `blog_tag_ibfk_1` FOREIGN KEY (`blogId`) REFERENCES `blog` (`blogId`),
  ADD CONSTRAINT `blog_tag_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tag` (`tagId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
