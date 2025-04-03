-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 03:06 AM
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
-- Database: `mt.labawanproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_tours`
--

CREATE TABLE `active_tours` (
  `at_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `Gender_ID` int(11) NOT NULL,
  `Gender` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`Gender_ID`, `Gender`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Gay'),
(5, 'Lesbian'),
(6, 'Transgender'),
(7, 'Bisexual'),
(8, 'Asexual'),
(9, 'Pansexual'),
(11, 'Non-Binary');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `TourID` int(100) NOT NULL,
  `Tour_Number` int(11) NOT NULL,
  `TouristID` int(100) NOT NULL,
  `TourGuideID` int(100) NOT NULL,
  `StartDateTime` date NOT NULL,
  `EndDateTime` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Duration` time NOT NULL,
  `Blood_Pressure` varchar(8) NOT NULL,
  `Status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`TourID`, `Tour_Number`, `TouristID`, `TourGuideID`, `StartDateTime`, `EndDateTime`, `StartTime`, `EndTime`, `Duration`, `Blood_Pressure`, `Status`) VALUES
(129, 1, 57, 2, '2024-12-05', '2024-12-05', '09:31:47', '09:39:27', '00:07:40', '120/85', '1'),
(131, 1, 59, 2, '2024-12-05', '2024-12-05', '09:31:47', '09:39:27', '00:07:40', '120/80', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tourist`
--

CREATE TABLE `tourist` (
  `TouristID` int(100) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Age` int(200) NOT NULL,
  `GenderID` int(11) NOT NULL,
  `Nationality` varchar(50) NOT NULL,
  `TouristTypeID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourist`
--

INSERT INTO `tourist` (`TouristID`, `FirstName`, `LastName`, `Age`, `GenderID`, `Nationality`, `TouristTypeID`) VALUES
(57, 'Anna', 'Rae', 24, 2, 'Filipino (Philippines)', 2),
(59, 'Mike', 'Angelo', 18, 7, 'Japanese (Japan)', 3),
(60, 'Chan', 'Park', 19, 1, 'Korean (South Korea)', 3),
(62, 'Mar', 'Row', 23, 1, 'South African (South Africa)', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tourist_type`
--

CREATE TABLE `tourist_type` (
  `TouristTypeID` int(100) NOT NULL,
  `Class` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourist_type`
--

INSERT INTO `tourist_type` (`TouristTypeID`, `Class`) VALUES
(1, 'Local Mabini'),
(2, 'Local Bohol'),
(3, 'International Asia'),
(4, 'Regional Cebu'),
(5, 'Regional Manila'),
(6, 'Foreign'),
(10, 'Europe');

-- --------------------------------------------------------

--
-- Table structure for table `tour_guide`
--

CREATE TABLE `tour_guide` (
  `TourGuideID` int(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Age` int(100) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_guide`
--

INSERT INTO `tour_guide` (`TourGuideID`, `Name`, `Age`, `Address`) VALUES
(1, 'Jayrald N. Bernales', 21, 'Cawayanan, Mabini, Bohol'),
(2, 'Juan Dela Cruz', 34, 'Cogtong, Candijay, Bohol'),
(3, 'Maria Santos', 28, 'Tangkigan, Mabini, Bohol'),
(4, 'Josefa Reyes', 40, 'Tagbilaran City'),
(5, 'Andres Bernaldez', 36, 'Carmen, Bohol'),
(6, 'Gerald Aquino', 55, 'Batuan, Bohol'),
(7, 'Rizalito Alonzo', 30, 'Pilar, Bohol'),
(8, 'Ligaya Sarmiento', 25, 'Talibon, Bohol'),
(9, 'Jyle Aquino', 45, 'Alicia, Bohol'),
(14, 'Chris Olandria', 24, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Role` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Role`) VALUES
(1, 'Bernalesj28@gmail.com', '12345', 'Admin'),
(2, 'chan1231@gmail.com', '123', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_tours`
--
ALTER TABLE `active_tours`
  ADD PRIMARY KEY (`at_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`Gender_ID`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`TourID`),
  ADD KEY `fk_touristGuideID` (`TourGuideID`),
  ADD KEY `fk_tourTouristID` (`TouristID`);

--
-- Indexes for table `tourist`
--
ALTER TABLE `tourist`
  ADD PRIMARY KEY (`TouristID`),
  ADD KEY `fk_touristTypeId` (`TouristTypeID`),
  ADD KEY `GenderID` (`GenderID`);

--
-- Indexes for table `tourist_type`
--
ALTER TABLE `tourist_type`
  ADD PRIMARY KEY (`TouristTypeID`);

--
-- Indexes for table `tour_guide`
--
ALTER TABLE `tour_guide`
  ADD PRIMARY KEY (`TourGuideID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_tours`
--
ALTER TABLE `active_tours`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `Gender_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `TourID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `tourist`
--
ALTER TABLE `tourist`
  MODIFY `TouristID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tourist_type`
--
ALTER TABLE `tourist_type`
  MODIFY `TouristTypeID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tour_guide`
--
ALTER TABLE `tour_guide`
  MODIFY `TourGuideID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_tours`
--
ALTER TABLE `active_tours`
  ADD CONSTRAINT `active_tours_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`TourID`);

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `fk_tourTouristID` FOREIGN KEY (`TouristID`) REFERENCES `tourist` (`TouristID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_touristGuideID` FOREIGN KEY (`TourGuideID`) REFERENCES `tour_guide` (`TourGuideID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tourist`
--
ALTER TABLE `tourist`
  ADD CONSTRAINT `fk_touristTypeId` FOREIGN KEY (`TouristTypeID`) REFERENCES `tourist_type` (`TouristTypeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tourist_ibfk_1` FOREIGN KEY (`GenderID`) REFERENCES `gender` (`Gender_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
