-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2020 at 07:09 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_people`
--

CREATE TABLE `additional_people` (
  `id` int(11) NOT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `birth_date` date NOT NULL,
  `passport` varchar(20) NOT NULL,
  `created_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `additional_people`
--

INSERT INTO `additional_people` (`id`, `insurance_id`, `name`, `birth_date`, `passport`, `created_at`) VALUES
(127, 53, 'Random Perosn 1', '1990-07-12', '12313', '2020-11-01'),
(128, 53, 'Random Person 2', '1990-07-12', '222222', '2020-11-01'),
(129, 54, 'Random Person 3', '1987-05-23', '11111111', '2020-11-01'),
(130, 54, 'Random Person 4', '1990-08-21', '123321123', '2020-11-01'),
(131, 54, 'Random Person 3', '1990-07-12', '111111111', '2020-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `birth_date` date NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `passport` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `type` enum('single','group') NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `name`, `birth_date`, `phone`, `passport`, `email`, `date_from`, `date_to`, `type`, `number_of_days`, `created_at`) VALUES
(52, 'John Doe', '2020-11-13', '1113123', '13123213', 'john@doe.com', '2020-11-04', '2020-11-11', 'single', 7, '2020-11-01'),
(53, 'Jane Doe', '2020-07-15', '1123123', '11111', 'jane.doe@example.com', '2020-11-04', '2020-11-21', 'group', 17, '2020-11-01'),
(54, 'Joe Smith', '2020-05-13', '12323213', '11111', 'joe.smith@example.com', '2020-11-04', '2020-12-17', 'group', 43, '2020-11-01'),
(55, 'Sean Morrison', '2020-08-05', '12323213', '123123213', 'Sean@example.io', '2020-09-08', '2020-11-19', 'single', 72, '2020-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_people`
--
ALTER TABLE `additional_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_id` (`insurance_id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_people`
--
ALTER TABLE `additional_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_people`
--
ALTER TABLE `additional_people`
  ADD CONSTRAINT `additional_people_ibfk_1` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
