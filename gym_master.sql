-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2017 at 10:28 AM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gym_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `cat_id`, `title`, `assigned_to`, `created_by`, `created_date`) VALUES
(1, 5, 'Hyperextension', 2, 1, '2016-08-22'),
(2, 3, 'Crunch', 2, 1, '2016-08-22'),
(3, 4, 'Leg curl', 2, 1, '2016-08-22'),
(4, 4, 'Reverse Leg Curl', 2, 1, '2016-08-22'),
(5, 6, 'Body Conditioning', 2, 1, '2016-10-19'),
(6, 6, 'Free Weights', 2, 1, '2016-10-19'),
(7, 3, 'Fixed Weights', 2, 1, '2016-10-19'),
(8, 3, 'Resisted Crunch', 2, 1, '2016-10-19'),
(9, 6, 'Plank', 2, 1, '2016-10-19'),
(10, 4, 'High Leg Pull-In', 2, 1, '2016-10-19'),
(11, 4, 'Low Leg Pull-In', 2, 1, '2016-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Regular'),
(2, 'Limited'),
(3, 'Total Gym Exercises for Abs (Abdomininals)'),
(4, 'Total Gym Exercises for Legs'),
(5, 'Total Gym Exercises for Biceps'),
(6, 'Exercise');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE IF NOT EXISTS `class_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) NOT NULL,
  `assign_staff_mem` int(11) NOT NULL,
  `assistant_staff_member` int(11) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `days` varchar(200) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` varchar(30) NOT NULL,
  `end_date` date NOT NULL,
  `end_time` varchar(30) NOT NULL,
  `pay_rate` varchar(20) NOT NULL,
  `total_capacity` int(12) NOT NULL,
  `wait_list` int(12) NOT NULL,
  `online_schedule` tinyint(4) NOT NULL,
  `online_capacity` int(12) NOT NULL,
  `signup_unpaid` tinyint(4) NOT NULL,
  `free_class` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(12) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `class_name`, `assign_staff_mem`, `assistant_staff_member`, `location_id`, `days`, `start_date`, `start_time`, `end_date`, `end_time`, `pay_rate`, `total_capacity`, `wait_list`, `online_schedule`, `online_capacity`, `signup_unpaid`, `free_class`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(12, '1', 7, 0, '8', '["Sunday","Monday"]', '2017-03-02', '10:30:AM', '2017-03-31', '12:45:PM', '20', 20, 2, 0, 5, 1, 0, 1, 1, '2017-03-01 06:48:01', '2017-03-01 09:42:08'),
(13, '2', 8, 0, '1', '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '2017-03-01', '7:00:AM', '2017-03-17', '8:00:AM', '12', 22, 0, 1, 12, 1, 1, 1, 1, '2017-03-01 10:49:12', '2017-03-01 13:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule_list`
--

CREATE TABLE IF NOT EXISTS `class_schedule_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `days` varchar(255) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `class_schedule_list`
--

INSERT INTO `class_schedule_list` (`id`, `class_id`, `days`, `start_time`, `end_time`) VALUES
(1, 8, '["Sunday","Monday","Tuesday"]', '1:15:PM', '3:15:PM'),
(2, 8, '["Sunday","Monday","Tuesday"]', '3:15:PM', '5:15:PM'),
(3, 8, '["Sunday","Monday","Tuesday"]', '4:15:PM', '7:15:PM'),
(4, 9, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '8:15:AM', '10:30:PM'),
(11, 12, '["Sunday","Monday"]', '10:30:AM', '12:45:PM'),
(13, 13, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '9:15:AM', '11:15:AM'),
(14, 13, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '7:00:AM', '8:00:AM');

-- --------------------------------------------------------

--
-- Table structure for table `class_type`
--

CREATE TABLE IF NOT EXISTS `class_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text,
  `created_by` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `class_type`
--

INSERT INTO `class_type` (`id`, `title`, `description`, `created_by`, `status`, `created_date`, `updated_date`, `updated_by`) VALUES
(3, 'Boot Camp', 'Boot Camp', 1, '1', '2017-02-28 07:12:33', '2017-02-28 07:12:33', 1),
(4, 'Flexibility', 'Flexibility', 1, '1', '2017-02-28 07:12:56', '2017-02-28 07:12:56', 1),
(5, 'High Intensity Interval Training', 'High Intensity Interval Training', 1, '1', '2017-02-28 07:13:42', '2017-02-28 07:13:42', 1),
(8, 'test', NULL, 1, '1', '2017-02-28 10:59:03', '2017-02-28 10:59:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE IF NOT EXISTS `general_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `start_year` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `office_number` varchar(20) NOT NULL,
  `country` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_format` varchar(15) NOT NULL,
  `calendar_lang` text NOT NULL,
  `gym_logo` varchar(200) NOT NULL,
  `cover_image` varchar(200) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `chest` varchar(100) NOT NULL,
  `waist` varchar(100) NOT NULL,
  `thing` varchar(100) NOT NULL,
  `arms` varchar(100) NOT NULL,
  `fat` varchar(100) NOT NULL,
  `member_can_view_other` int(11) NOT NULL,
  `staff_can_view_own_member` int(11) NOT NULL,
  `enable_sandbox` int(11) NOT NULL,
  `paypal_email` varchar(50) NOT NULL,
  `currency` varchar(20) NOT NULL,
  `enable_alert` int(11) NOT NULL,
  `reminder_days` varchar(100) NOT NULL,
  `reminder_message` varchar(255) NOT NULL,
  `enable_message` int(11) NOT NULL,
  `left_header` varchar(100) NOT NULL,
  `footer` varchar(100) NOT NULL,
  `system_installed` int(11) NOT NULL,
  `enable_rtl` int(11) DEFAULT '0',
  `datepicker_lang` text,
  `system_version` text,
  `sys_language` varchar(20) NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `general_setting`
--

INSERT INTO `general_setting` (`id`, `name`, `start_year`, `address`, `office_number`, `country`, `email`, `date_format`, `calendar_lang`, `gym_logo`, `cover_image`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `member_can_view_other`, `staff_can_view_own_member`, `enable_sandbox`, `paypal_email`, `currency`, `enable_alert`, `reminder_days`, `reminder_message`, `enable_message`, `left_header`, `footer`, `system_installed`, `enable_rtl`, `datepicker_lang`, `system_version`, `sys_language`) VALUES
(1, 'GYM Master - GYM Management System', '2017', 'address', '8899665544', 'us', 'barkha@rnf.tech', 'F j, Y', 'en', '', '', 'KG', 'Centimeter', 'Inches', 'Inches', 'Inches', 'Inches', 'Percentage', 1, 1, 0, 'your_id@paypal.com', 'USD', 1, '5', 'Hello GYM_MEMBERNAME,\r\n      Your Membership  GYM_MEMBERSHIP  started at GYM_STARTDATE and it will expire on GYM_ENDDATE.\r\nThank You.', 1, 'GYM MASTER', 'Copyright © 2016-2017. All rights reserved.', 1, 0, 'en-CA', '4', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `gym_accessright`
--

CREATE TABLE IF NOT EXISTS `gym_accessright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `module` text NOT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `page_link` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `assigned_roles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `gym_accessright`
--

INSERT INTO `gym_accessright` (`id`, `name`, `module`, `controller`, `action`, `page_link`, `order`, `assigned_roles`) VALUES
(1, 'List All Members Roles', 'Members Role', 'GymAccessRoles', 'AccessRolesList', '/gym_master/gym-access-roles/access-roles-list', 1, '1'),
(2, 'Add New Members Role', 'Members Role', 'GymAccessRoles', 'addAccessRoles', '/gym_master/gym-access-roles/add-access-roles', 2, '1'),
(3, 'Edit New Members Role', 'Members Role', 'GymAccessRoles', 'editAccessRoles', '/gym_master/gym-access-roles/edit-access-roles', 3, '1'),
(4, 'List All Groups', 'Groups', 'GymGroup', 'GroupList', '/gym_master/gym-group/group-list', 1, '1,2,3'),
(5, 'Add New Groups', 'Groups', 'GymGroup', 'addGroup', '/gym_master/gym-group/add-group', 2, '1,2'),
(6, 'Edit New Groups', 'Groups', 'GymGroup', 'editGroup', '/gym_master/gym-group/edit-group', 3, '1,2'),
(7, 'Assigned Permission to Roles ', 'Permissions', 'GymAccessright', 'accessRight', '/gym_master/gym-accessright/access-right', 1, '1'),
(8, 'List All Franchise List', 'Franchise', 'Franchise', 'franchiseList', '/gym_master/franchise/franchise-list', 1, '1'),
(9, 'Add Franchise', 'Franchise', 'Franchise', 'addFranchise', '/gym_master/franchise/add-franchise', 1, '1'),
(10, 'Dashboard', 'Dashboard', 'Dashboard', 'index', '/gym_master/dashboard/admin-dashboard', 1, '1,2,3,4'),
(11, 'Edit Franchise', 'Franchise', 'Franchise', 'editFranchise', '/gym_master/franchise/edit-franchise', 1, '1,2'),
(12, 'Delete Franchise', 'Franchise', 'Franchise', 'deleteFranchise', '/gym_master/franchise/delete-franchise', 1, '1'),
(13, 'List Location', 'Location', 'GymLocation', 'locationList', '/gym_master/location/location-list', 1, '1,2,3'),
(14, 'Add Location', 'Location', 'GymLocation', 'addLocation', '/gym_master/location/add-location', 1, '1,2,3'),
(15, 'Edit Location', 'Location', 'GymLocation', 'editLocation', '/gym_master/location/edit-location', 1, '1,2,3'),
(16, 'Delete Location', 'Location', 'GymLocation', 'deleteLocation', '/gym_master/location/delete-location', 1, '1,2,3'),
(17, 'List Classes', 'Classes Manager', 'ClassSchedule', 'classList', '/gym_master/class-schedule/class-list', 1, '1,2,3'),
(18, 'Add Classes', 'Classes Manager', 'ClassSchedule', 'addClass', '/gym_master/class-schedule/add-class', 1, '1,2,3'),
(19, 'Edit Classes', 'Classes Manager', 'ClassSchedule', 'editClass', '/gym_master/class-schedule/edit-class', 1, '1,2,3'),
(20, 'Delete Classes', 'Classes Manager', 'ClassSchedule', 'deleteClass', '/gym_master/class-schedule/delete-class', 1, '1,2,3'),
(21, 'List Classes Type', 'Classes Type Manager', 'ClassType', 'classtypeList', '/gym_master/class-type/classtype-list', 1, '1,2,3'),
(22, 'Add Class Type', 'Class Type', 'ClassType', 'addclassType', '/gym_master/class-type/addclass-type', 1, '1,2,3'),
(23, 'Edit Class Type', 'Class Type', 'ClassType', 'editclassType', '/gym_master/class-type/editclass-type', 1, '1,2,3'),
(24, 'Delete Class Type', 'Class Type', 'ClassType', 'deleteclassType', '/gym_master/class-type/deleteclass-type', 1, '1,2,3'),
(25, 'List All Clases', 'Classes', 'GymClass', 'ClassesList', '/gym_master/gym-class/classes-list', 1, '1,2,3'),
(26, 'Add New Classes', 'Classes', 'GymClass', 'addClasses', '/gym_master/gym-class/add-classes', 2, '1,2'),
(27, 'Edit Classes', 'Classes', 'GymClass', 'editClasses', '/gym_master/gym-class/edit-classes', 3, '1,2'),
(28, 'Delete Classes', 'Classes', 'GymClass', 'deleteClasses', '/gym_master/gym-class/delete-classes', 3, '1,2');

-- --------------------------------------------------------

--
-- Table structure for table `gym_access_roles`
--

CREATE TABLE IF NOT EXISTS `gym_access_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gym_access_roles`
--

INSERT INTO `gym_access_roles` (`id`, `name`, `slug`, `status`, `created_date`) VALUES
(1, 'Administrator', 'administrator', 1, '2017-02-20'),
(2, 'Franchise Manager', 'franchise', 1, '2017-02-20'),
(3, 'Staff Member', 'staff_member', 1, '2017-02-20'),
(4, 'Editor', 'editor', 1, '2017-02-20'),
(5, 'Customer', 'customer', 1, '2017-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `gym_assign_workout`
--

CREATE TABLE IF NOT EXISTS `gym_assign_workout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `level_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `direct_assign` tinyint(1) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_attendance`
--

CREATE TABLE IF NOT EXISTS `gym_attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `attendance_by` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_class`
--

CREATE TABLE IF NOT EXISTS `gym_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `class_type_id` int(12) NOT NULL,
  `description` text,
  `updated_date` datetime NOT NULL,
  `updated_by` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gym_class`
--

INSERT INTO `gym_class` (`id`, `name`, `image`, `created_by`, `created_date`, `class_type_id`, `description`, `updated_date`, `updated_by`) VALUES
(1, 'Open Gym', '1488275800_636335.jpg', 1, '2017-02-28 00:00:00', 3, '<p>Test Descriptions</p>', '2017-02-28 11:07:36', 1),
(2, 'Toluca Lake Small Group', '', 1, '2017-03-01 09:58:45', 4, '', '2017-03-01 09:58:45', 1),
(3, 'Toluca Lake Yoga', '', 1, '2017-03-01 09:59:14', 4, '', '2017-03-01 09:59:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gym_daily_workout`
--

CREATE TABLE IF NOT EXISTS `gym_daily_workout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workout_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `result_measurment` varchar(50) NOT NULL,
  `result` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `time_of_workout` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_event_place`
--

CREATE TABLE IF NOT EXISTS `gym_event_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_group`
--

CREATE TABLE IF NOT EXISTS `gym_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_income_expense`
--

CREATE TABLE IF NOT EXISTS `gym_income_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_type` varchar(100) NOT NULL,
  `invoice_label` varchar(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `entry` text NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `total_amount` double NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_interest_area`
--

CREATE TABLE IF NOT EXISTS `gym_interest_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interest` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_levels`
--

CREATE TABLE IF NOT EXISTS `gym_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_location`
--

CREATE TABLE IF NOT EXISTS `gym_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `location` varchar(250) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `gym_location`
--

INSERT INTO `gym_location` (`id`, `title`, `location`, `created_by`, `status`, `created_date`) VALUES
(1, 'LANKERSHIM BLVD', '4444 LANKERSHIM BLVD #108 LOS ANGELES CA 91602', 1, '1', '2017-02-20 14:57:56'),
(6, 'New Location by mukesh', 'Mukesh place', 4, '1', '2017-02-22 11:44:38'),
(8, 'Youth Baseball Coaches Meeting', '1010 Ninth St.  Wichita Falls, TX 76301 United States', 1, '1', '0000-00-00 00:00:00'),
(9, 'Youth Baseball Coaches Meeting', '1010 Ninth St.  Wichita Falls, TX 76301 United States', 6, '1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gym_measurement`
--

CREATE TABLE IF NOT EXISTS `gym_measurement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_measurment` varchar(100) DEFAULT NULL,
  `result` float DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `result_date` date NOT NULL,
  `image` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_member`
--

CREATE TABLE IF NOT EXISTS `gym_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activated` int(11) NOT NULL DEFAULT '0',
  `role_name` text NOT NULL,
  `role_id` int(2) NOT NULL,
  `member_id` text,
  `associated_franchise` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `location_id` int(4) DEFAULT NULL,
  `member_type` text,
  `role` int(11) DEFAULT NULL,
  `s_specialization` varchar(255) DEFAULT NULL,
  `gender` text,
  `birth_date` date DEFAULT NULL,
  `assign_class` int(11) DEFAULT NULL,
  `assign_group` varchar(150) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `weight` varchar(10) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `chest` varchar(10) DEFAULT NULL,
  `waist` varchar(10) DEFAULT NULL,
  `thing` varchar(10) DEFAULT NULL,
  `arms` varchar(10) DEFAULT NULL,
  `fat` varchar(10) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `assign_staff_mem` int(11) DEFAULT NULL,
  `intrested_area` int(11) DEFAULT NULL,
  `g_source` int(11) DEFAULT NULL,
  `referrer_by` int(11) DEFAULT NULL,
  `inquiry_date` date DEFAULT NULL,
  `trial_end_date` date DEFAULT NULL,
  `selected_membership` varchar(100) DEFAULT NULL,
  `membership_status` text,
  `membership_valid_from` date DEFAULT NULL,
  `membership_valid_to` date DEFAULT NULL,
  `first_pay_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `alert_sent` int(11) NOT NULL,
  `class_type` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `gym_member`
--

INSERT INTO `gym_member` (`id`, `activated`, `role_name`, `role_id`, `member_id`, `associated_franchise`, `first_name`, `middle_name`, `last_name`, `location_id`, `member_type`, `role`, `s_specialization`, `gender`, `birth_date`, `assign_class`, `assign_group`, `address`, `city`, `state`, `zipcode`, `mobile`, `phone`, `email`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `username`, `password`, `image`, `assign_staff_mem`, `intrested_area`, `g_source`, `referrer_by`, `inquiry_date`, `trial_end_date`, `selected_membership`, `membership_status`, `membership_valid_from`, `membership_valid_to`, `first_pay_date`, `created_by`, `created_date`, `alert_sent`, `class_type`) VALUES
(1, 0, 'administrator', 1, '', 0, 'Admin', '', 'GoTribe', 0, '', 0, '', 'male', '2016-07-01', 0, '', 'null', 'null', 't', '123123', '123123123', '', 'admin@admin.com', '', '', '', '', '', '', '', 'admin', '$2y$10$Qdg.AvH8XtGCoK7aQHnz7.WoVg1wkAxJzQbrdfixfltyzBbf9vkbi', '1487324042_473783.jpg', 0, 0, 0, 0, '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 0, '2017-02-17', 0, NULL),
(3, 1, 'franchise', 2, 'FR123', 0, 'New Franchise', '', '', 2, '1', 1, '', 'male', '2017-02-14', 1, '1', 'Delhi', 'New Delhi', '1', '12234', '9865741230', '', 'nirsssaj@test.com', '1', '1', '1', '1', '1', '', '1', 'admin11', '$2y$10$SVkXDBXtZpbioRgXWDHxKufFV3NNx/LMkn6aH8VYbUOv53bWtDqGW', '1487754742_782095.jpg', 1, 1, 1, 1, '2017-01-10', '2017-01-10', '1', '1', '2017-01-10', '2017-01-10', '2017-01-10', 1, '2017-02-21', 1, NULL),
(4, 1, 'franchise', 2, NULL, NULL, 'New Franchise1', 'middle', 'last', 1, NULL, NULL, NULL, 'male', '2017-02-22', NULL, NULL, 'Delhi', 'New Delhi', 'Delhi', '12345', '9865741230', '09582313900', 'mukesh@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mukesh', '$2y$10$GbQxcn9iRJzmU.SfvsnxNegL9FJ8TqNp3M6Xs/W5DQZKVYuhrRvJ.', '1487682443_501339.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-02-21', 1, NULL),
(5, 0, 'staff_member', 3, NULL, 4, 'New Staff', 'middlewqewr', 'under franchise1', NULL, NULL, 2, '["1","2","4"]', 'male', '2017-02-16', NULL, NULL, 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'atul@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'atul', '$2y$10$CH4lTptuc6EJLqr9Ea0.hebelMK1G8i39uBLkUBmSeSfgNLwGQYZC', '1487857297_949070.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-02-23', 1, NULL),
(6, 1, 'franchise', 2, NULL, NULL, 'My Franchise', '', '', 2, NULL, NULL, NULL, 'male', '2017-02-22', NULL, NULL, 'c-117', 'New york', 'New york', '110023', '9874561230', '', 'alan@yopmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alan', '$2y$10$C3chz2f9BnlKY1Vr3t/I3.XWydc4b3qOP.xaiRuZw..TBdaSNV.Pi', 'profile-placeholder.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-02-24', 1, NULL),
(7, 0, 'staff_member', 3, NULL, 6, 'John', '', 'Rau', NULL, NULL, 1, '["1"]', 'male', '2017-02-28', NULL, NULL, 'A-123', 'canada', 'canada', '123456', '1234567890', '', 'alan1@yopmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alan1', '$2y$10$RwQ7fZBY9U4qkMNHdJ3olubu2rNpKFyfWLfpNdVjk.cXe5X62QLIi', 'logo.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2017-02-24', 1, NULL),
(8, 0, 'staff_member', 3, NULL, 6, 'Emplyee', '', 'task', NULL, NULL, 2, '["1"]', 'male', '2017-01-24', NULL, NULL, 'A-123', 'canada', 'canada', '110023', '9874561230', '', 'joshi.pankaj489@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'root', '$2y$10$LIBHvcTAjbrjc69OtqH3Jut8pW3HWuuIgQv8w74VQ4lHzgQkL.BKq', 'logo.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2017-02-27', 1, NULL),
(11, 1, 'member', 0, 'M92717', NULL, 'John', 'sasa', 'dsad', NULL, 'Member', NULL, NULL, 'male', '1970-01-01', 1, '0', 'A-123', 'canada', 'canada', '110023', '1234546789', '1234546789', 'alan.pankaj489@gmail.com', '', '', '', '', '', '', '', 'root12345', '$2y$10$uEVtlcSaP.ahusj4DhLwOuOHEd1a1mgGrdYS4bo3k5aZZkAIQkPmm', 'logo.png', NULL, NULL, NULL, NULL, '1970-01-01', '1970-01-01', '1', 'Continue', '2017-02-28', '1970-12-27', '2017-02-21', 1, '2017-02-27', 0, 'Individual'),
(14, 1, 'member', 0, 'M122717', NULL, 'json', 'sasa', 'Rau', NULL, 'Prospect', NULL, NULL, 'male', '2016-12-20', 1, '0', 'A-123', 'canada', 'canada', '110023', '1234546789', '1234546789', 'jsed.pankaj489@gmail.com', '', '', '', '', '', '', '', 'rootssss', '$2y$10$hFcBLAaCvNA4sdxSKKuEMu5FV9aLBYQCLTt3i.GgV5ynx3BWJL.hK', 'logo.png', NULL, NULL, NULL, 5, '1970-01-01', '1970-01-01', '', 'Not Available', '1970-01-01', '1970-01-01', '2017-02-02', 1, '2017-02-27', 0, 'Group');

-- --------------------------------------------------------

--
-- Table structure for table `gym_member_class`
--

CREATE TABLE IF NOT EXISTS `gym_member_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `assign_class` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `gym_member_class`
--

INSERT INTO `gym_member_class` (`id`, `member_id`, `assign_class`) VALUES
(8, 11, 4),
(9, 11, 5),
(10, 11, 6),
(11, 13, 3),
(12, 13, 4),
(13, 14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `gym_message`
--

CREATE TABLE IF NOT EXISTS `gym_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message_body` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_newsletter`
--

CREATE TABLE IF NOT EXISTS `gym_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_notice`
--

CREATE TABLE IF NOT EXISTS `gym_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(100) NOT NULL,
  `notice_for` text NOT NULL,
  `class_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `comment` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_nutrition`
--

CREATE TABLE IF NOT EXISTS `gym_nutrition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `breakfast` text NOT NULL,
  `midmorning_snack` text NOT NULL,
  `lunch` text NOT NULL,
  `afternoon_snack` text NOT NULL,
  `dinner` text NOT NULL,
  `afterdinner_snack` text NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `expire_date` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_nutrition_data`
--

CREATE TABLE IF NOT EXISTS `gym_nutrition_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_name` varchar(30) NOT NULL,
  `nutrition_time` varchar(30) NOT NULL,
  `nutrition_value` text NOT NULL,
  `nutrition_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `create_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_product`
--

CREATE TABLE IF NOT EXISTS `gym_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_reservation`
--

CREATE TABLE IF NOT EXISTS `gym_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_roles`
--

CREATE TABLE IF NOT EXISTS `gym_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gym_roles`
--

INSERT INTO `gym_roles` (`id`, `name`) VALUES
(1, 'Yoga'),
(2, 'Boxing'),
(3, 'New Role');

-- --------------------------------------------------------

--
-- Table structure for table `gym_source`
--

CREATE TABLE IF NOT EXISTS `gym_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_store`
--

CREATE TABLE IF NOT EXISTS `gym_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `sell_date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `sell_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_user_workout`
--

CREATE TABLE IF NOT EXISTS `gym_user_workout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_workout_id` int(11) NOT NULL,
  `workout_name` int(11) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `kg` float NOT NULL,
  `rest_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gym_workout_data`
--

CREATE TABLE IF NOT EXISTS `gym_workout_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_name` varchar(15) NOT NULL,
  `workout_name` varchar(100) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `kg` float NOT NULL,
  `time` int(11) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `installment_plan`
--

CREATE TABLE IF NOT EXISTS `installment_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `duration` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `installment_plan`
--

INSERT INTO `installment_plan` (`id`, `number`, `duration`) VALUES
(1, 1, 'Month'),
(2, 1, 'Week'),
(3, 1, 'Year');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_label` varchar(100) NOT NULL,
  `membership_cat_id` int(11) NOT NULL,
  `membership_length` int(11) NOT NULL,
  `membership_class_limit` varchar(20) NOT NULL,
  `limit_days` int(11) NOT NULL,
  `limitation` varchar(20) NOT NULL,
  `install_plan_id` int(11) NOT NULL,
  `membership_amount` double NOT NULL,
  `membership_class` varchar(255) NOT NULL,
  `installment_amount` double NOT NULL,
  `signup_fee` double NOT NULL,
  `gmgt_membershipimage` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `membership_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `membership_label`, `membership_cat_id`, `membership_length`, `membership_class_limit`, `limit_days`, `limitation`, `install_plan_id`, `membership_amount`, `membership_class`, `installment_amount`, `signup_fee`, `gmgt_membershipimage`, `created_date`, `created_by_id`, `membership_description`) VALUES
(1, 'Platinum Membership', 1, 360, 'Unlimited', 0, '', 1, 500, '[''1'',''2'',''3'',''4'',''5'',''6'',''7'']', 42, 5, '', '2016-08-22', 1, '<p>Platinum membership description<br></p>'),
(2, 'Gold Membership', 1, 300, 'Unlimited', 0, '', 1, 450, '[''1'',''2'',''3'',''4'',''5'']', 37, 5, '', '2016-08-22', 1, '<p>Gold membership description<br></p>'),
(3, 'Silver Membership', 2, 180, 'Limited', 0, 'per_week', 2, 200, '[''4'',''6'',''7'']', 5, 5, '', '2016-08-22', 1, '<p>Silver &nbsp;membership description</p>');

-- --------------------------------------------------------

--
-- Table structure for table `membership_activity`
--

CREATE TABLE IF NOT EXISTS `membership_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `membership_history`
--

CREATE TABLE IF NOT EXISTS `membership_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `selected_membership` int(11) NOT NULL,
  `assign_staff_mem` int(11) NOT NULL,
  `intrested_area` int(11) NOT NULL,
  `g_source` int(11) NOT NULL,
  `referrer_by` int(11) NOT NULL,
  `inquiry_date` date NOT NULL,
  `trial_end_date` date NOT NULL,
  `membership_valid_from` date NOT NULL,
  `membership_valid_to` date NOT NULL,
  `first_pay_date` date NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membership_history`
--

INSERT INTO `membership_history` (`id`, `member_id`, `selected_membership`, `assign_staff_mem`, `intrested_area`, `g_source`, `referrer_by`, `inquiry_date`, `trial_end_date`, `membership_valid_from`, `membership_valid_to`, `first_pay_date`, `created_date`) VALUES
(1, 11, 1, 0, 0, 0, 0, '1970-01-01', '1970-01-01', '2017-02-28', '1970-12-27', '2017-02-21', '2017-02-27'),
(2, 12, 0, 0, 0, 0, 0, '1970-01-01', '1970-01-01', '0000-00-00', '0000-00-00', '2017-02-14', '2017-02-27'),
(3, 13, 0, 0, 0, 0, 0, '2017-02-27', '2017-02-23', '0000-00-00', '0000-00-00', '2017-02-28', '2017-02-27'),
(4, 14, 0, 0, 0, 0, 5, '1970-01-01', '1970-01-01', '0000-00-00', '0000-00-00', '2017-02-02', '2017-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `membership_payment`
--

CREATE TABLE IF NOT EXISTS `membership_payment` (
  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `membership_amount` double NOT NULL,
  `paid_amount` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `membership_status` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`mp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `membership_payment`
--

INSERT INTO `membership_payment` (`mp_id`, `member_id`, `membership_id`, `membership_amount`, `paid_amount`, `start_date`, `end_date`, `membership_status`, `payment_status`, `created_date`, `created_by`) VALUES
(1, 11, 1, 500, 0, '2017-02-28', '1970-12-27', 'Continue', '0', '2017-02-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `membership_payment_history`
--

CREATE TABLE IF NOT EXISTS `membership_payment_history` (
  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mp_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `paid_by_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `trasaction_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE IF NOT EXISTS `specialization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`id`, `name`) VALUES
(1, 'Boxing Specialist'),
(2, 'Yoga Specialist'),
(3, 'Chest Workout Specialist'),
(4, 'New Specialization1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
