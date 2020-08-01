-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2020 at 11:45 PM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farm_mgt`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

DROP TABLE IF EXISTS `crops`;
CREATE TABLE IF NOT EXISTS `crops` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `crop_unique_id` varchar(100) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `plot_size` varchar(200) NOT NULL,
  `farm_uniq_id` varchar(100) NOT NULL,
  `planting_status` varchar(100) NOT NULL,
  `season_name` varchar(100) NOT NULL,
  `season_duration` varchar(100) NOT NULL,
  `estimate_yield` varchar(100) NOT NULL,
  `final_yield` varchar(100) NOT NULL,
  `owner_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`crop_unique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `crop_unique_id`, `crop_name`, `location`, `plot_size`, `farm_uniq_id`, `planting_status`, `season_name`, `season_duration`, `estimate_yield`, `final_yield`, `owner_email`) VALUES
(9, 'RPO562037558960', 'Wheat', 'abakaliki,awka', '0', 'field2001404678', 'pending', '0', '0 to 0', '0', '0', 'tester1@gmail.com'),
(8, 'RED671766050446', 'Potatoes', 'ebonyi,abakiliki', '0', '0', 'pending', '0', '0 to 0', '0', '0', 'tester1@gmail.com'),
(5, 'REW561695852059', 'Sweetpotato', 'Enugu, Awgu', '2240', 'field2001404678', 'In Progress', 'Rainy', '07/31/2019   to   09/12/2019', '200', '110', 'tester1@gmail.com'),
(7, 'REK871031427536', 'Rice', 'jos,sokoto', '3500', 'field1668896249', 'Pending', 'Rainy', '08/02/2019 to 12/25/2019', '400', '200', 'tester1@gmail.com'),
(10, 'REU341889500391', 'Sugarcane', 'Enugu, Awgu', '800', 'field2001404678', 'Finished', 'Rainy', '07/24/2019    to    02/11/2020', '400', '380', 'tester1@gmail.com'),
(11, 'REH561501601126', 'Cassava', 'enugu south', '1', '0', 'In Progress', 'Rainy', '07/01/2019 to 09/20/2019', '25', '30', 'nnamanililian90@gmail.com'),
(12, 'RKC672105534659', 'Potatoes', ' Enugu, Awgu', '2000', 'field1872674712', 'In Progress', 'Rainy', '08/13/2019  to  12/20/2019', '1000', '860', 'tester1@gmail.com'),
(13, 'RPF871016595738', 'Cattle', 'lagos,ojota', '0', '0', 'pending', '0', '0 to 0', '0', '0', 'tester1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
CREATE TABLE IF NOT EXISTS `field` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `field_size` varchar(200) NOT NULL,
  `soil_type` varchar(100) NOT NULL,
  `ownership_type` varchar(200) NOT NULL,
  `farm_uniq_id` varchar(100) NOT NULL,
  `farm_owner` varchar(100) NOT NULL,
  `crops_planted` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`farm_uniq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`id`, `name`, `location`, `field_size`, `soil_type`, `ownership_type`, `farm_uniq_id`, `farm_owner`, `crops_planted`) VALUES
(2, 'the animal farm', 'enugu,aninri', '10000', 'Loam Loamy Sand', 'Personal Ownership', 'field1668896249', 'tester1@gmail.com', '1'),
(6, 'umudike school farm', 'umuahia', '6500', 'Loam Loamy Sand', 'Corporate Society', 'field2001404678', 'tester1@gmail.com', '2'),
(7, 'country farm', 'imo,owerri', '33000', 'Clay Loam', 'Owned By Relatives', 'field1872674712', 'tester1@gmail.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

DROP TABLE IF EXISTS `finance`;
CREATE TABLE IF NOT EXISTS `finance` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `net_amount` varchar(200) NOT NULL,
  `payment_method` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  `owner_email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`id`, `transaction_id`, `category`, `item_name`, `net_amount`, `payment_method`, `date`, `owner_email`) VALUES
(1, 'TAH34794985564', 'Sales', '30 bags of rice', '30000', 'wire transfer', 'July 19, 2019, 11:57 am', 'tester1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `link_crop`
--

DROP TABLE IF EXISTS `link_crop`;
CREATE TABLE IF NOT EXISTS `link_crop` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `crop_id` varchar(100) NOT NULL,
  `farm_id` varchar(100) NOT NULL,
  `area_to_cover` varchar(100) NOT NULL,
  `owner_email` varchar(100) NOT NULL,
  `link_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link_crop`
--

INSERT INTO `link_crop` (`id`, `crop_id`, `farm_id`, `area_to_cover`, `owner_email`, `link_id`) VALUES
(19, 'RPO562037558960', 'field2001404678', '2800', 'tester1@gmail.com', 'TDO56862767910'),
(20, 'REW561695852059', 'field2001404678', '500', 'tester1@gmail.com', 'TAZ342063945964'),
(22, 'REK871031427536', 'field1668896249', '800', 'tester1@gmail.com', 'TQO65962109664'),
(23, 'REU341889500391', 'field2001404678', '900', 'tester1@gmail.com', 'RKK451362308208'),
(24, 'RKC672105534659', 'field1872674712', '2000', 'tester1@gmail.com', 'RBB45565808663');

-- --------------------------------------------------------

--
-- Table structure for table `machinery`
--

DROP TABLE IF EXISTS `machinery`;
CREATE TABLE IF NOT EXISTS `machinery` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `manufacturer` varchar(200) NOT NULL,
  `reg_number` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `owner_email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`reg_number`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machinery`
--

INSERT INTO `machinery` (`id`, `name`, `category`, `manufacturer`, `reg_number`, `year`, `owner_email`) VALUES
(1, 'german tractor', 'Tractor', 'budweisser', 'MachineREA901310450468', '2008', 'tester1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

DROP TABLE IF EXISTS `managers`;
CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `date_registered` varchar(100) NOT NULL,
  `main_owner` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `name`, `email`, `gender`, `country`, `password`, `phone_no`, `permission`, `date_registered`, `main_owner`) VALUES
(1, 'tester1', 'tester1@gmail.com', 'male', '0', '$6$rounds=1000$YourSaltyStringz$is.oFzwzGH8kXoq8D8vqJr.UCodEDahfxxT39pnevLeF9xEVQQ/GUBT9wrKURyLNfvQQw528hRHOmBH2FgdP70', '08029183942', 'Level1', 'July 5, 2019, 4:05 pm', 'tester1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `task_duration` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `incharge_email` varchar(200) NOT NULL,
  `workers_email` text NOT NULL,
  `categories` varchar(200) NOT NULL,
  `field_id` varchar(200) NOT NULL,
  `crop_id` varchar(200) NOT NULL,
  `owner_email` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_id`, `name`, `task_duration`, `status`, `incharge_email`, `workers_email`, `categories`, `field_id`, `crop_id`, `owner_email`, `description`) VALUES
(6, 'task1779647838', 'transportation of sweet potato', '07/02/2019 to 07/03/2019', 'In Progress', 'ibu12@hotmail.com', 'sophyjenkins@mail.com,,ibu12@hotmail.com,,', 'Transport', 'field2001404678', 'REW561695852059', 'tester1@gmail.com', 'remind them to follow the highway route that is safer. '),
(5, 'task351507517', 'cow milking', '07/02/2019 to 07/23/2019', 'In Progress', 'sophyjenkins@mail.com', 'ibu12@hotmail.com,,tester1@gmail.com,,', 'Harvesting', 'field2001404678', 'RPO562037558960', 'tester1@gmail.com', 'ibu, remind him to milk that cow well oo. not like last time.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
