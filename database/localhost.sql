-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2014 at 04:14 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `survey`
--
CREATE DATABASE `survey` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `survey`;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_category` int(11) NOT NULL,
  `activity_title` varchar(255) NOT NULL,
  `activity_description` text NOT NULL,
  `has_survey` int(11) NOT NULL,
  `activity_dated` datetime NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `activity_category`, `activity_title`, `activity_description`, `has_survey`, `activity_dated`) VALUES
(1, 3, 'For BSIT', 'Sample desc', 0, '2013-12-21 03:35:14'),
(2, 0, 'For General', 'General desc', 0, '2013-12-21 03:39:02'),
(3, 10, 'My BSACT', 'Hello BSACT!', 1, '2013-12-26 04:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `activity_image`
--

CREATE TABLE IF NOT EXISTS `activity_image` (
  `activity_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `activity_image`
--

INSERT INTO `activity_image` (`activity_image_id`, `image_name`, `activity_id`) VALUES
(2, '654b4f6ba596ac318e9c367c7df2f729.jpg', 2),
(3, '76c7f06533835552c01a3173e7b66db6.png', 3),
(4, 'f2f92750fefdd0545a334a5d27476891.png', 3),
(5, '9dc23ec3f42f7ecc80c42e0596b0925e.png', 3),
(6, '9026c80003dd895d6cb4929995d6b883.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `choose_log`
--

CREATE TABLE IF NOT EXISTS `choose_log` (
  `pick_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`pick_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `choose_log`
--

INSERT INTO `choose_log` (`pick_id`, `user_id`, `survey_id`, `question_id`) VALUES
(1, 1, 1, 1),
(2, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment_message` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `comment_message`, `comment_date`, `activity_id`) VALUES
(1, 1, 'Hello.', '2013-12-21 04:36:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  `department_status` int(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_status`) VALUES
(2, 'IT Department', 1),
(3, 'BSIT', 0),
(4, 'BSED', 0),
(5, 'BSBA', 0),
(6, 'BSA', 0),
(7, 'CHS', 0),
(8, 'BEED', 0),
(9, 'CC', 0),
(10, 'BSACT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `survey_question` text NOT NULL,
  `question_choose` int(11) NOT NULL,
  `question_status` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `survey_id`, `survey_question`, `question_choose`, `question_status`) VALUES
(1, 1, 'Jaylord', 1, 0),
(2, 1, 'Hello', 1, 0),
(3, 1, 'hihgasdasd', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_id`
--

CREATE TABLE IF NOT EXISTS `student_id` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique` varchar(100) NOT NULL,
  `id_status` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `student_id`
--

INSERT INTO `student_id` (`student_id`, `unique`, `id_status`, `department_id`) VALUES
(1, '1', 0, 0),
(2, '2', 0, 3),
(5, '3', 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `survey_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_title` varchar(255) NOT NULL,
  `survey_description` text NOT NULL,
  `survey_dated` datetime NOT NULL,
  `survey_status` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `user_id`, `survey_title`, `survey_description`, `survey_dated`, `survey_status`, `activity_id`) VALUES
(1, 1, 'BSACT Survey', 'Hello world!', '2013-12-26 04:23:40', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_picture` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_birthday` datetime NOT NULL,
  `civil_status` int(11) NOT NULL,
  `student_address` varchar(255) NOT NULL,
  `student_phone_number` varchar(255) NOT NULL,
  `user_status` int(2) NOT NULL,
  `user_std_id` varchar(100) NOT NULL,
  `user_level` int(11) NOT NULL,
  `ban_date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `profile_picture`, `user_name`, `user_email`, `user_password`, `user_birthday`, `civil_status`, `student_address`, `student_phone_number`, `user_status`, `user_std_id`, `user_level`, `ban_date`) VALUES
(1, '94da72f82dfb035475be397422e76183.jpg', 'Glace', 'glace@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2013-11-29 00:00:00', 0, 'Purok 9, Brgy. Aguisan, Himamaylan City, Negros Occidental', '090558721813', 0, '1', 99, '0000-00-00'),
(2, '7d750538122c9d44fd7b42d4316c9708.jpg', 'Limson', 'limson@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2013-11-29 00:00:00', 0, 'Hello world!`', '123123021301230123', 0, '2', 0, '0000-00-00'),
(3, '', 'Juan Dela Cruz', 'juan@delacruz.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2013-12-21 00:00:00', 0, '', '', 0, '3', 0, '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
