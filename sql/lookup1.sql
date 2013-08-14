-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2013 at 11:17 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `virtual_jukebox`
--
CREATE DATABASE IF NOT EXISTS `virtual_jukebox` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `virtual_jukebox`;

--
-- Dumping data for table `filetype`
--

INSERT INTO `filetype` (`fileTypeId`, `fileTypeName`, `fileTypeDisplayLabel`, `fileTypeDescription`) VALUES
(1, 'mp3', 'MP3', NULL);

--
-- Dumping data for table `filetype_mediatype`
--

INSERT INTO `filetype_mediatype` (`fileType_mediaType_id`, `mediaTypeId`, `fileTypeId`) VALUES
(1, 1, 1);

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genreId`, `genreName`, `genreDisplayLabel`, `genreDescription`) VALUES
(1, 'classical', 'Classical', NULL),
(2, 'country', 'Country', NULL),
(3, 'religous', 'Religous', NULL),
(4, 'rock', 'Rock', NULL);

--
-- Dumping data for table `genre_mediatype`
--

INSERT INTO `genre_mediatype` (`genre_mediaType_id`, `mediaTypeId`, `genreId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

--
-- Dumping data for table `mediatype`
--

INSERT INTO `mediatype` (`mediaTypeId`, `mediaTypeName`, `mediaTypeDisplayLabel`, `mediaTypeDescription`) VALUES
(1, 'music', 'music', NULL),
(2, 'movie', 'movie', NULL);

--
-- Dumping data for table `quality`
--

INSERT INTO `quality` (`qualityId`, `qualityName`, `qualityDisplayLabel`, `qualityDescription`) VALUES
(1, 'LOW', 'Low', NULL),
(2, 'MEDIUM', 'Medium', NULL),
(3, 'HIGH', 'High', NULL);

--
-- Dumping data for table `quality_mediatype`
--

INSERT INTO `quality_mediatype` (`quality_mediaType_id`, `mediaTypeId`, `qualityId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
