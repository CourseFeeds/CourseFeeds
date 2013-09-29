-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2013 at 04:29 PM
-- Server version: 5.1.68-community-log
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `C342425_CourseFeeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Poster` varchar(15) NOT NULL,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  `Comment` varchar(8000) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseLinkID` (`CourseLinkID`),
  KEY `Poster` (`Poster`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `CourseLinks`
--

CREATE TABLE IF NOT EXISTS `CourseLinks` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) NOT NULL,
  `Poster` varchar(15) NOT NULL,
  `MediaType` varchar(15) NOT NULL,
  `CourseID` bigint(20) unsigned NOT NULL,
  `URL` varchar(2000) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(1500) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpVotes` bigint(20) unsigned NOT NULL,
  `DownVotes` bigint(20) unsigned NOT NULL,
  `TotalViews` bigint(20) unsigned NOT NULL,
  `LastRatedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseID` (`CourseID`),
  KEY `Poster` (`Poster`),
  KEY `Subject` (`Subject`),
  KEY `MediaType` (`MediaType`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Table structure for table `CourseLinkTags`
--

CREATE TABLE IF NOT EXISTS `CourseLinkTags` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  `Poster` varchar(15) NOT NULL,
  `Tag` varchar(30) NOT NULL,
  `DateTagged` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseLinkID` (`CourseLinkID`),
  KEY `Poster` (`Poster`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=792 ;

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `CourseNumber` varchar(10) NOT NULL,
  `School` varchar(75) NOT NULL,
  `MinCreditHours` tinyint(4) NOT NULL DEFAULT '1',
  `MaxCreditHours` tinyint(4) NOT NULL DEFAULT '1',
  `Type` char(1) DEFAULT NULL,
  `MOOC` varchar(75) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`ID`),
  KEY `Subject` (`Subject`),
  KEY `School` (`School`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=32651 ;

-- --------------------------------------------------------

--
-- Table structure for table `CourseSemesters`
--

CREATE TABLE IF NOT EXISTS `CourseSemesters` (
  `Semester` varchar(20) NOT NULL,
  `CourseID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`Semester`,`CourseID`),
  KEY `FK_CourseSemesters_Course` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `EnrolledCourses`
--

CREATE TABLE IF NOT EXISTS `EnrolledCourses` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `User` varchar(15) NOT NULL,
  `CourseID` bigint(20) unsigned NOT NULL,
  `Archived` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`),
  KEY `User` (`User`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `Favorites`
--

CREATE TABLE IF NOT EXISTS `Favorites` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `User` varchar(15) NOT NULL,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `User` (`User`),
  KEY `CourseLinkID` (`CourseLinkID`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=162 ;

-- --------------------------------------------------------

--
-- Table structure for table `MediaTypes`
--

CREATE TABLE IF NOT EXISTS `MediaTypes` (
  `MediaType` varchar(15) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Type` enum('Web Content','Files') NOT NULL,
  `IconPath` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`MediaType`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `ReportedComments`
--

CREATE TABLE IF NOT EXISTS `ReportedComments` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Reporter` varchar(15) NOT NULL,
  `CommentID` bigint(20) unsigned NOT NULL,
  `ReportedDate` datetime NOT NULL,
  `Reason` varchar(8000) NOT NULL,
  `Description` varchar(8000) NOT NULL,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CommentID` (`CommentID`),
  KEY `Reporter` (`Reporter`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReportedLinks`
--

CREATE TABLE IF NOT EXISTS `ReportedLinks` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Reporter` varchar(15) NOT NULL,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  `ReportedDate` datetime NOT NULL,
  `Reason` varchar(8000) NOT NULL,
  `Description` varchar(8000) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CourseLinkID` (`CourseLinkID`),
  KEY `Reporter` (`Reporter`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `Schools`
--

CREATE TABLE IF NOT EXISTS `Schools` (
  `Name` varchar(75) NOT NULL,
  `City` varchar(75) DEFAULT NULL,
  `State` varchar(75) DEFAULT NULL,
  `MOOC` varchar(75) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `Semester`
--

CREATE TABLE IF NOT EXISTS `Semester` (
  `Semester` varchar(20) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  PRIMARY KEY (`Semester`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `Subject`
--

CREATE TABLE IF NOT EXISTS `Subject` (
  `Subject` varchar(100) NOT NULL,
  `Acronym` varchar(10) DEFAULT NULL,
  `IconPath` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`Subject`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `SubjectLinks`
--

CREATE TABLE IF NOT EXISTS `SubjectLinks` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) NOT NULL,
  `Poster` varchar(15) NOT NULL,
  `MediaType` varchar(15) NOT NULL,
  `URL` varchar(200) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(8000) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpVotes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `DownVotes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `TotalViews` bigint(20) unsigned NOT NULL DEFAULT '0',
  `LastRatedDate` datetime DEFAULT NULL,
  `CustomIconPath` varchar(75) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Poster` (`Poster`),
  KEY `Subject` (`Subject`),
  KEY `MediaType` (`MediaType`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `Name` varchar(15) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `EmailCode` varchar(32) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(75) NOT NULL,
  `Campus` varchar(75) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `Active` bit(1) NOT NULL DEFAULT b'0',
  `IsModerator` tinyint(1) DEFAULT NULL,
  `IsProfessor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Name`),
  UNIQUE KEY `Email` (`Email`),
  KEY `Campus` (`Campus`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

-- --------------------------------------------------------

--
-- Table structure for table `UserCourseLinkVotes`
--

CREATE TABLE IF NOT EXISTS `UserCourseLinkVotes` (
  `Voter` varchar(15) NOT NULL,
  `CourseLinkID` bigint(20) unsigned NOT NULL,
  `UpVote` tinyint(1) NOT NULL,
  PRIMARY KEY (`Voter`,`CourseLinkID`),
  KEY `CourseLinkID` (`CourseLinkID`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `UserSubjectLinkVotes`
--

CREATE TABLE IF NOT EXISTS `UserSubjectLinkVotes` (
  `Voter` varchar(15) NOT NULL,
  `SubjectLinkID` bigint(20) unsigned NOT NULL,
  `UpVote` tinyint(1) NOT NULL,
  PRIMARY KEY (`Voter`,`SubjectLinkID`),
  KEY `SubjectLinkID` (`SubjectLinkID`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `FK_Comments_CourseLinks` FOREIGN KEY (`CourseLinkID`) REFERENCES `CourseLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Comments_User` FOREIGN KEY (`Poster`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CourseLinks`
--
ALTER TABLE `CourseLinks`
  ADD CONSTRAINT `FK_CourseLinks_Courses` FOREIGN KEY (`CourseID`) REFERENCES `Courses` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CourseLinks_MediaType` FOREIGN KEY (`MediaType`) REFERENCES `MediaTypes` (`MediaType`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CourseLinks_Subject` FOREIGN KEY (`Subject`) REFERENCES `Subject` (`Subject`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CourseLinks_User` FOREIGN KEY (`Poster`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CourseLinkTags`
--
ALTER TABLE `CourseLinkTags`
  ADD CONSTRAINT `FK_CourseLinkTags_CourseLinks` FOREIGN KEY (`CourseLinkID`) REFERENCES `CourseLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CourseLinkTags_User` FOREIGN KEY (`Poster`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `FK_Courses_School` FOREIGN KEY (`School`) REFERENCES `Schools` (`Name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Courses_Subject` FOREIGN KEY (`Subject`) REFERENCES `Subject` (`Subject`) ON UPDATE CASCADE;

--
-- Constraints for table `CourseSemesters`
--
ALTER TABLE `CourseSemesters`
  ADD CONSTRAINT `FK_CourseSemesters_Course` FOREIGN KEY (`CourseID`) REFERENCES `Courses` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CourseSemesters_Semester` FOREIGN KEY (`Semester`) REFERENCES `Semester` (`Semester`) ON UPDATE CASCADE;

--
-- Constraints for table `EnrolledCourses`
--
ALTER TABLE `EnrolledCourses`
  ADD CONSTRAINT `FK_EnrolledCourses_Courses` FOREIGN KEY (`CourseID`) REFERENCES `Courses` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EnrolledCourses_User` FOREIGN KEY (`User`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Favorites`
--
ALTER TABLE `Favorites`
  ADD CONSTRAINT `FK_Favorites_CourseLinks` FOREIGN KEY (`CourseLinkID`) REFERENCES `CourseLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Favorites_User` FOREIGN KEY (`User`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ReportedComments`
--
ALTER TABLE `ReportedComments`
  ADD CONSTRAINT `FK_ReportedComments_Comments` FOREIGN KEY (`CommentID`) REFERENCES `Comments` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ReportedComments_User` FOREIGN KEY (`Reporter`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ReportedLinks`
--
ALTER TABLE `ReportedLinks`
  ADD CONSTRAINT `FK_ReportedLinks_CourseLinks` FOREIGN KEY (`CourseLinkID`) REFERENCES `CourseLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ReportedLinks_User` FOREIGN KEY (`Reporter`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `SubjectLinks`
--
ALTER TABLE `SubjectLinks`
  ADD CONSTRAINT `FK_SubjectLinks_MediaTypes` FOREIGN KEY (`MediaType`) REFERENCES `MediaTypes` (`MediaType`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SubjectLinks_Subject` FOREIGN KEY (`Subject`) REFERENCES `Subject` (`Subject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SubjectLinks_User` FOREIGN KEY (`Poster`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `FK_User_Schools` FOREIGN KEY (`Campus`) REFERENCES `Schools` (`Name`) ON UPDATE CASCADE;

--
-- Constraints for table `UserCourseLinkVotes`
--
ALTER TABLE `UserCourseLinkVotes`
  ADD CONSTRAINT `FK_UserCourseLinkVotes_CourseLinks` FOREIGN KEY (`CourseLinkID`) REFERENCES `CourseLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserCourseLinkVotes_User` FOREIGN KEY (`Voter`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UserSubjectLinkVotes`
--
ALTER TABLE `UserSubjectLinkVotes`
  ADD CONSTRAINT `FK_UserSubjectLinkVotes_SubjectLinks` FOREIGN KEY (`SubjectLinkID`) REFERENCES `SubjectLinks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserSubjectLinkVotes_User` FOREIGN KEY (`Voter`) REFERENCES `User` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
