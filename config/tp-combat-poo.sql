-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 02, 2024 at 03:08 PM
-- Server version: 10.6.12-MariaDB-1:10.6.12+maria~ubu2004-log
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tp-combat-poo`
--

-- --------------------------------------------------------

--
-- Table structure for table `fight`
--

CREATE TABLE `fight` (
  `id` int(11) NOT NULL,
  `action` varchar(511) NOT NULL,
  `hero_hp` int(11) NOT NULL,
  `monster_hp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hall_of_fame`
--

CREATE TABLE `hall_of_fame` (
  `id` int(11) NOT NULL,
  `id_hero` int(11) NOT NULL,
  `boss_defeat` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `ts` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero`
--

CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `nom` varchar(31) NOT NULL,
  `atk` int(11) NOT NULL DEFAULT 100,
  `hp` int(11) NOT NULL DEFAULT 100,
  `maxHp` int(11) NOT NULL DEFAULT 100,
  `armor` int(11) NOT NULL DEFAULT 10,
  `lvl` int(11) NOT NULL DEFAULT 1,
  `sprite` varchar(255) DEFAULT 'magikarp.gif',
  `respawn` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`id`, `nom`, `atk`, `hp`, `maxHp`, `armor`, `lvl`, `sprite`, `respawn`) VALUES
(1, 'Adam', 107, 107, 107, 119, 2, 'pikachu.png', 1),
(2, 'Jorge', 100, 150, 150, 10, 1, 'bulbasaur.png', 0),
(3, 'Willy', 100, 100, 100, 10, 1, 'gyarados.png', 0),
(8, 'Orlane', 100, 99, 99, 10, 1, 'magikarp.gif', 1),
(14, 'Stephane', 100, 100, 100, 10, 1, 'magikarp.gif', 0),
(15, 'Red the Trainer', 100, 100, 100, 10, 1, 'magikarp.gif', 0);

-- --------------------------------------------------------

--
-- Table structure for table `monstre`
--

CREATE TABLE `monstre` (
  `id` int(11) NOT NULL,
  `nom` int(11) NOT NULL,
  `description` varchar(1023) NOT NULL,
  `atk` int(11) NOT NULL DEFAULT 100,
  `hp` int(11) NOT NULL,
  `maxHp` int(11) NOT NULL DEFAULT 100,
  `armor` int(11) NOT NULL,
  `sprite` varchar(511) NOT NULL,
  `lvl` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruleset`
--

CREATE TABLE `ruleset` (
  `rule` varchar(31) NOT NULL,
  `val` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruleset`
--

INSERT INTO `ruleset` (`rule`, `val`) VALUES
('lvlMax', '20'),
('respawn max', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fight`
--
ALTER TABLE `fight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hall_of_fame`
--
ALTER TABLE `hall_of_fame`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hero` (`id_hero`);

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `monstre`
--
ALTER TABLE `monstre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruleset`
--
ALTER TABLE `ruleset`
  ADD PRIMARY KEY (`rule`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fight`
--
ALTER TABLE `fight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hall_of_fame`
--
ALTER TABLE `hall_of_fame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `monstre`
--
ALTER TABLE `monstre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hall_of_fame`
--
ALTER TABLE `hall_of_fame`
  ADD CONSTRAINT `hall_of_fame_ibfk_1` FOREIGN KEY (`id_hero`) REFERENCES `hero` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
