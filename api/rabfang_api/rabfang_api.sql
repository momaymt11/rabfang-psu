-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2022 at 02:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rabfang_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `admin_username` varchar(100) NOT NULL,
  `admin_password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', '$2y$10$svdgw97z2uUp6sZMkPp2/.suXymMe5gWqTdgi/70z9DQy6efhyVoa');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `a_id` int(11) NOT NULL,
  `a_u_id` int(11) NOT NULL,
  `a_psy_id` int(11) NOT NULL,
  `a_topic` text NOT NULL,
  `a_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`a_id`, `a_u_id`, `a_psy_id`, `a_topic`, `a_date`) VALUES
(12, 13, 12, 'General,Stress', '2022-09-23 11:00:00'),
(13, 13, 12, 'General', '2022-09-22 09:00:00'),
(14, 13, 12, 'General,test', '2022-09-22 11:00:00'),
(15, 13, 12, 'General', '2022-10-06 13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `c_id` int(11) NOT NULL,
  `c_a_id` int(11) NOT NULL,
  `c_u_id` int(11) DEFAULT NULL,
  `c_psy_id` int(11) DEFAULT NULL,
  `c_text` text NOT NULL,
  `c_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`c_id`, `c_a_id`, `c_u_id`, `c_psy_id`, `c_text`, `c_datetime`) VALUES
(31, 13, 13, NULL, 'Hi !', '2022-09-22 09:58:49'),
(32, 13, NULL, 12, 'Hi how are you !', '2022-09-22 09:59:21'),
(33, 13, NULL, 12, 'test', '2022-09-22 14:49:59'),
(34, 13, 13, NULL, 'test', '2022-09-22 14:50:05'),
(35, 13, 13, NULL, 'I want to know..', '2022-09-29 06:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `mentalhealth`
--

CREATE TABLE `mentalhealth` (
  `m_id` int(11) NOT NULL,
  `m_name` varchar(300) NOT NULL,
  `m_email` varchar(300) NOT NULL,
  `m_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentalhealth`
--

INSERT INTO `mentalhealth` (`m_id`, `m_name`, `m_email`, `m_datetime`) VALUES
(70, 'test', 'test@email.com', '2022-09-22 10:00:17'),
(71, 'test2@email.com', 'test2', '2022-09-22 14:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `mentalhealth_ans`
--

CREATE TABLE `mentalhealth_ans` (
  `m_a_id` int(10) NOT NULL,
  `m_a_m_id` int(10) NOT NULL,
  `m_a_q_id` int(10) NOT NULL,
  `m_a_q_value` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentalhealth_ans`
--

INSERT INTO `mentalhealth_ans` (`m_a_id`, `m_a_m_id`, `m_a_q_id`, `m_a_q_value`) VALUES
(642, 69, 6, 3),
(643, 69, 7, 2),
(644, 69, 8, 3),
(645, 69, 9, 3),
(646, 69, 10, 4),
(647, 69, 11, 2),
(648, 69, 12, 2),
(649, 69, 13, 1),
(650, 69, 14, 4),
(651, 69, 15, 4),
(652, 69, 16, 3),
(653, 69, 17, 3),
(654, 69, 18, 3),
(655, 69, 19, 3),
(656, 69, 20, 4),
(657, 70, 1, 1),
(658, 70, 2, 2),
(659, 70, 3, 2),
(660, 70, 4, 3),
(661, 70, 5, 2),
(662, 70, 6, 3),
(663, 70, 7, 2),
(664, 70, 8, 2),
(665, 70, 9, 3),
(666, 70, 10, 3),
(667, 70, 11, 3),
(668, 70, 12, 4),
(669, 70, 13, 3),
(670, 70, 14, 4),
(671, 70, 15, 3),
(672, 70, 16, 3),
(673, 70, 17, 3),
(674, 70, 18, 4),
(675, 70, 19, 4),
(676, 70, 20, 3),
(677, 71, 1, 1),
(678, 71, 2, 2),
(679, 71, 3, 2),
(680, 71, 4, 2),
(681, 71, 5, 1),
(682, 71, 6, 2),
(683, 71, 7, 2),
(684, 71, 8, 3),
(685, 71, 9, 4),
(686, 71, 10, 4),
(687, 71, 11, 3),
(688, 71, 12, 3),
(689, 71, 13, 3),
(690, 71, 14, 3),
(691, 71, 15, 4),
(692, 71, 16, 3),
(693, 71, 17, 3),
(694, 71, 18, 3),
(695, 71, 19, 3),
(696, 71, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `mentalhealth_form`
--

CREATE TABLE `mentalhealth_form` (
  `m_f_id` int(11) NOT NULL,
  `m_f_question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentalhealth_form`
--

INSERT INTO `mentalhealth_form` (`m_f_id`, `m_f_question`) VALUES
(1, 'Fear of malfunction ?'),
(2, 'Did not reach the intended target ?'),
(3, 'Families have conflicts over money or household chores ?'),
(4, 'Concerned about toxins or pollution in the air, water, noise and soil ?'),
(5, 'Feel the need to compete or compare ?'),
(6, 'Not enough money ?'),
(7, 'Muscle stiffness or pain ?'),
(8, 'Headache from tension ?'),
(9, 'Backache ?'),
(10, 'Appetite changes ?'),
(11, 'One-sided headache ?'),
(12, 'Feel anxious ?'),
(13, 'Feel frustrated ?'),
(14, 'Feeling angry or irritable ?'),
(15, 'Feel sad ?'),
(16, 'Bad memory ?'),
(17, 'Confused ?'),
(18, 'Difficulty concentrating ?'),
(19, 'Feel tired easily ?'),
(20, 'Frequent colds ?');

-- --------------------------------------------------------

--
-- Table structure for table `psychiatrist`
--

CREATE TABLE `psychiatrist` (
  `psy_id` int(10) NOT NULL,
  `psy_image` varchar(300) NOT NULL,
  `psy_name` varchar(255) NOT NULL,
  `psy_email` varchar(255) NOT NULL,
  `psy_password` varchar(300) NOT NULL,
  `psy_lang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `psychiatrist`
--

INSERT INTO `psychiatrist` (`psy_id`, `psy_image`, `psy_name`, `psy_email`, `psy_password`, `psy_lang`) VALUES
(12, '63353396a2f56.png', 'Dr.sara', 'doctor@email.com', '$2y$10$PfJLC9e8UA9BsehlUxMeQ.snf9KLeFhDW8ZMjBmeBuA8leWy2qH3m', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `satisfaction`
--

CREATE TABLE `satisfaction` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_email` varchar(150) NOT NULL,
  `s_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satisfaction`
--

INSERT INTO `satisfaction` (`s_id`, `s_name`, `s_email`, `s_datetime`) VALUES
(6, 'test2', 'test2@email.com', '2022-09-22 10:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `satisfaction_ans`
--

CREATE TABLE `satisfaction_ans` (
  `s_a_id` int(11) NOT NULL,
  `s_a_s_id` int(11) NOT NULL,
  `s_a_q_id` int(11) NOT NULL,
  `s_a_q_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satisfaction_ans`
--

INSERT INTO `satisfaction_ans` (`s_a_id`, `s_a_s_id`, `s_a_q_id`, `s_a_q_value`) VALUES
(101, 6, 1, 1),
(102, 6, 2, 1),
(103, 6, 3, 3),
(104, 6, 4, 3),
(105, 6, 5, 2),
(106, 6, 6, 2),
(107, 6, 7, 3),
(108, 6, 8, 3),
(109, 6, 9, 4),
(110, 6, 10, 3),
(111, 6, 11, 5),
(112, 6, 12, 5),
(113, 6, 13, 5),
(114, 6, 14, 4),
(115, 6, 15, 4),
(116, 6, 16, 3),
(117, 6, 17, 3),
(118, 6, 18, 3),
(119, 6, 19, 3),
(120, 6, 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `satisfaction_form`
--

CREATE TABLE `satisfaction_form` (
  `s_f_id` int(11) NOT NULL,
  `s_f_question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satisfaction_form`
--

INSERT INTO `satisfaction_form` (`s_f_id`, `s_f_question`) VALUES
(1, 'question 1'),
(2, 'question 2'),
(3, 'question 3'),
(4, 'question 4'),
(5, 'question 5'),
(6, 'question 6'),
(7, 'question 7'),
(8, 'question 8'),
(9, 'question 9'),
(10, 'question 10'),
(11, 'question 11'),
(12, 'question 12'),
(13, 'question 13'),
(14, 'question 14'),
(15, 'question 15'),
(16, 'question 16'),
(17, 'question 17'),
(18, 'question 18'),
(19, 'question 19'),
(20, 'question 20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(10) NOT NULL,
  `u_image` varchar(300) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(300) NOT NULL,
  `u_faculty` varchar(255) NOT NULL,
  `u_major` varchar(255) NOT NULL,
  `u_year` int(10) NOT NULL,
  `u_phone` int(15) NOT NULL,
  `u_birthday` date NOT NULL,
  `u_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_image`, `u_name`, `u_email`, `u_password`, `u_faculty`, `u_major`, `u_year`, `u_phone`, `u_birthday`, `u_address`) VALUES
(13, '63354537d8263.jpg', 'john doe', 'user@email.com', '$2y$10$5C9i1AuQn0VBlzdwnm4owu1IFeU3ENUD4vNnpjiIOYMVqlnGqTddS', 'College of Computing', 'Digital Engineering', 2019, 987654321, '1998-12-12', '123/456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `mentalhealth`
--
ALTER TABLE `mentalhealth`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `mentalhealth_ans`
--
ALTER TABLE `mentalhealth_ans`
  ADD PRIMARY KEY (`m_a_id`);

--
-- Indexes for table `mentalhealth_form`
--
ALTER TABLE `mentalhealth_form`
  ADD PRIMARY KEY (`m_f_id`);

--
-- Indexes for table `psychiatrist`
--
ALTER TABLE `psychiatrist`
  ADD PRIMARY KEY (`psy_id`);

--
-- Indexes for table `satisfaction`
--
ALTER TABLE `satisfaction`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `satisfaction_ans`
--
ALTER TABLE `satisfaction_ans`
  ADD PRIMARY KEY (`s_a_id`);

--
-- Indexes for table `satisfaction_form`
--
ALTER TABLE `satisfaction_form`
  ADD PRIMARY KEY (`s_f_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `mentalhealth`
--
ALTER TABLE `mentalhealth`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `mentalhealth_ans`
--
ALTER TABLE `mentalhealth_ans`
  MODIFY `m_a_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=697;

--
-- AUTO_INCREMENT for table `mentalhealth_form`
--
ALTER TABLE `mentalhealth_form`
  MODIFY `m_f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `psychiatrist`
--
ALTER TABLE `psychiatrist`
  MODIFY `psy_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `satisfaction`
--
ALTER TABLE `satisfaction`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satisfaction_ans`
--
ALTER TABLE `satisfaction_ans`
  MODIFY `s_a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `satisfaction_form`
--
ALTER TABLE `satisfaction_form`
  MODIFY `s_f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
