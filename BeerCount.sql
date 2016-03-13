-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 13, 2016 at 01:25 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `BeerCount`
--
CREATE DATABASE IF NOT EXISTS `BeerCount` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `BeerCount`;

-- --------------------------------------------------------

--
-- Table structure for table `Beers`
--

DROP TABLE IF EXISTS `Beers`;
CREATE TABLE `Beers` (
  `beerId` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `brewery` varchar(45) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `alcohol` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Drinkers`
--

DROP TABLE IF EXISTS `Drinkers`;
CREATE TABLE `Drinkers` (
  `drinkerId` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Log`
--

DROP TABLE IF EXISTS `Log`;
CREATE TABLE `Log` (
  `entryId` int(11) NOT NULL,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `drinkerId` int(11) NOT NULL,
  `beerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Beers`
--
ALTER TABLE `Beers`
  ADD PRIMARY KEY (`beerId`);

--
-- Indexes for table `Drinkers`
--
ALTER TABLE `Drinkers`
  ADD PRIMARY KEY (`drinkerId`);

--
-- Indexes for table `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`entryId`),
  ADD KEY `drinkerId` (`drinkerId`),
  ADD KEY `beerId` (`beerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Beers`
--
ALTER TABLE `Beers`
  MODIFY `beerId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Drinkers`
--
ALTER TABLE `Drinkers`
  MODIFY `drinkerId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Log`
--
ALTER TABLE `Log`
  MODIFY `entryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Log`
--
ALTER TABLE `Log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`drinkerId`) REFERENCES `Drinkers` (`drinkerId`),
  ADD CONSTRAINT `log_ibfk_2` FOREIGN KEY (`beerId`) REFERENCES `Beers` (`beerId`);