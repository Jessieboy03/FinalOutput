-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 12:31 PM
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
-- Database: `amortization`
--

-- --------------------------------------------------------

--
-- Table structure for table `amortization`
--

CREATE TABLE `amortization` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `principal_amount` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amortization`
--

INSERT INTO `amortization` (`id`, `customer_id`, `principal_amount`, `interest_rate`, `loan_term`, `start_date`) VALUES
(2, 2, 10000.00, 10.00, 6, '2024-05-21'),
(3, 2, 14000.00, 10.00, 9, '2024-05-24'),
(4, 3, 12000.00, 5.00, 6, '2024-05-20'),
(5, 4, 7000.00, 10.00, 6, '2024-05-20'),
(6, 6, 15000.00, 10.00, 6, '2024-05-22'),
(7, 7, 15000.00, 3.00, 12, '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`) VALUES
(2, 'Nissa Malulan', 'jtagnipez96@gmail.com', '09123456781'),
(3, 'Justine', 'justinepalwa@gmail.com', '912345678'),
(4, 'Rejie Lugatiman', 'jessicatagnipez03@gmail.com', '912345678'),
(6, 'Rejie Lugatiman', 'jessicatagnipez03@gmail.com', '912345678'),
(7, 'Joey Brua', 'jessieboyplana@gmail.com', '09123456781');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amortization`
--
ALTER TABLE `amortization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amortization`
--
ALTER TABLE `amortization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amortization`
--
ALTER TABLE `amortization`
  ADD CONSTRAINT `amortization_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
