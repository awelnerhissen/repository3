-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2018 at 01:30 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nejashiDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblAcadamicAndProfession`
--

CREATE TABLE `tblAcadamicAndProfession` (
  `memberId` int(11) NOT NULL,
  `acadamicBackground` text NOT NULL,
  `professionalBackground` text NOT NULL,
  `communictContributionAndInvolvment` text NOT NULL,
  `areaToConsultAndContribute` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblBasicInformation`
--

CREATE TABLE `tblBasicInformation` (
  `memberId` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `fatherName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `gender` char(1) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `peronalNumber` bigint(20) NOT NULL,
  `familyStatus` int(11) NOT NULL,
  `residentStatus` int(11) NOT NULL,
  `pictureLink` text,
  `registrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblContactAddress`
--

CREATE TABLE `tblContactAddress` (
  `memberId` int(11) NOT NULL,
  `mobileNumber1` text NOT NULL,
  `mobileNumber2` text NOT NULL,
  `telephone` text NOT NULL,
  `country` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `kommun` varchar(20) NOT NULL,
  `streetAddress` varchar(20) NOT NULL,
  `poBox` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblFamilyStatusTypes`
--

CREATE TABLE `tblFamilyStatusTypes` (
  `familyStatusId` int(11) NOT NULL,
  `familyStatusType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblFamilyStatusTypes`
--

INSERT INTO `tblFamilyStatusTypes` (`familyStatusId`, `familyStatusType`) VALUES
(1, 'Single'),
(2, 'Married'),
(3, 'Divorced'),
(4, 'Not specified');

-- --------------------------------------------------------

--
-- Table structure for table `tblLogin`
--

CREATE TABLE `tblLogin` (
  `memberId` int(11) NOT NULL,
  `primaryEmail` varchar(50) NOT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `memberRole` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  `ConfirmationCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblMemberId`
--

CREATE TABLE `tblMemberId` (
  `availableId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblMemberId`
--

INSERT INTO `tblMemberId` (`availableId`) VALUES
(1020);

-- --------------------------------------------------------

--
-- Table structure for table `tblRelationShipKind`
--

CREATE TABLE `tblRelationShipKind` (
  `realationShipId` int(11) NOT NULL,
  `relationShip` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblRelationShipKind`
--

INSERT INTO `tblRelationShipKind` (`realationShipId`, `relationShip`) VALUES
(1, 'husband'),
(2, 'wife'),
(3, 'father'),
(4, 'mother'),
(5, 'brother'),
(6, 'sister'),
(7, 'son'),
(8, 'daughter'),
(9, 'relative');

-- --------------------------------------------------------

--
-- Table structure for table `tblRelationShipList`
--

CREATE TABLE `tblRelationShipList` (
  `memberId1` int(11) NOT NULL,
  `memberId2` int(11) NOT NULL,
  `relationShipMember1WithMember2` int(11) NOT NULL,
  `relationShipMember2WithMember1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblRelationShipList`
--

INSERT INTO `tblRelationShipList` (`memberId1`, `memberId2`, `relationShipMember1WithMember2`, `relationShipMember2WithMember1`) VALUES
(1, 2, 1, 7),
(1, 3, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tblResidenceStatusTypes`
--

CREATE TABLE `tblResidenceStatusTypes` (
  `residenceStatusId` int(11) NOT NULL,
  `residenceStatusType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblResidenceStatusTypes`
--

INSERT INTO `tblResidenceStatusTypes` (`residenceStatusId`, `residenceStatusType`) VALUES
(1, 'Swedish'),
(2, 'Permanent resident'),
(3, 'Work permit'),
(4, 'Student visa'),
(5, 'Temporary visa'),
(6, 'Not specified');

-- --------------------------------------------------------

--
-- Table structure for table `tblSportAndEntertaimentInterest`
--

CREATE TABLE `tblSportAndEntertaimentInterest` (
  `memberId` int(11) NOT NULL,
  `interestedIn` int(11) NOT NULL,
  `fromDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblBasicInformation`
--
ALTER TABLE `tblBasicInformation`
  ADD PRIMARY KEY (`memberId`);

--
-- Indexes for table `tblContactAddress`
--
ALTER TABLE `tblContactAddress`
  ADD PRIMARY KEY (`memberId`);

--
-- Indexes for table `tblFamilyStatusTypes`
--
ALTER TABLE `tblFamilyStatusTypes`
  ADD UNIQUE KEY `familtyStatusId` (`familyStatusId`);

--
-- Indexes for table `tblLogin`
--
ALTER TABLE `tblLogin`
  ADD PRIMARY KEY (`memberId`);

--
-- Indexes for table `tblRelationShipKind`
--
ALTER TABLE `tblRelationShipKind`
  ADD UNIQUE KEY `id` (`realationShipId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;