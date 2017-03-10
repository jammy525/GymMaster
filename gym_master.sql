-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2017 at 03:07 PM
-- Server version: 5.7.15-0ubuntu0.16.04.1-log
-- PHP Version: 7.0.15-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
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
  `role_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `class_name`, `assign_staff_mem`, `assistant_staff_member`, `location_id`, `days`, `start_date`, `start_time`, `end_date`, `end_time`, `pay_rate`, `total_capacity`, `wait_list`, `online_schedule`, `online_capacity`, `signup_unpaid`, `free_class`, `created_by`, `updated_by`, `created_date`, `updated_date`, `role_name`) VALUES
(12, '1', 7, 0, '8', '["Sunday","Monday"]', '2017-03-02', '10:30:AM', '2017-03-31', '12:45:PM', '20', 20, 2, 0, 5, 1, 0, 1, 1, '2017-03-01 06:48:01', '2017-03-01 09:42:08', 'administrator'),
(13, '2', 8, 0, '1', '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '2017-03-01', '7:00:AM', '2017-03-17', '8:00:AM', '12', 22, 0, 1, 12, 1, 1, 1, 1, '2017-03-01 10:49:12', '2017-03-01 13:13:02', 'administrator'),
(15, '4', 7, 0, '6', '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '2017-03-01', '10:00:AM', '2017-03-30', '11:00:AM', '12', 12, 1, 1, 12, 1, 1, 4, 4, '2017-03-03 09:17:12', '2017-03-03 09:17:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule_list`
--

CREATE TABLE `class_schedule_list` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `days` varchar(255) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class_schedule_list`
--

INSERT INTO `class_schedule_list` (`id`, `class_id`, `days`, `start_time`, `end_time`) VALUES
(11, 12, '["Sunday","Monday"]', '10:30:AM', '12:45:PM'),
(13, 13, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '9:15:AM', '11:15:AM'),
(14, 13, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '7:00:AM', '8:00:AM'),
(15, 15, '["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]', '10:00:AM', '11:00:AM');

-- --------------------------------------------------------

--
-- Table structure for table `class_type`
--

CREATE TABLE `class_type` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `created_by` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(12) NOT NULL,
  `role_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_type`
--

INSERT INTO `class_type` (`id`, `title`, `description`, `created_by`, `status`, `created_date`, `updated_date`, `updated_by`, `role_name`) VALUES
(3, 'Boot Camp', 'Boot Camp', 1, '1', '2017-02-28 07:12:33', '2017-03-03 11:28:38', 1, 'administrator'),
(4, 'Flexibility', 'Flexibility', 1, '1', '2017-02-28 07:12:56', '2017-03-03 07:38:41', 1, 'administrator'),
(5, 'High Intensity Interval Training', 'High Intensity Interval Training', 1, '1', '2017-02-28 07:13:42', '2017-03-03 07:38:45', 1, 'administrator'),
(10, 'High Intensity Interval Training2', '', 6, '1', '2017-03-03 07:43:25', '2017-03-03 07:43:36', 6, 'franchise'),
(12, 'test', NULL, 4, '1', '2017-03-03 08:49:52', '2017-03-03 08:49:52', 4, 'franchise');

-- --------------------------------------------------------

--
-- Table structure for table `discount_code`
--

CREATE TABLE `discount_code` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `discount` varchar(20) NOT NULL COMMENT '%discount',
  `created_by` int(11) NOT NULL,
  `membership` varchar(100) NOT NULL,
  `valid_till` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discount_code`
--

INSERT INTO `discount_code` (`id`, `code`, `discount`, `created_by`, `membership`, `valid_till`, `created_at`, `status`) VALUES
(9, 'GTALL25', '15', 1, '["1","2","3"]', '1496188800', '2017-03-09 10:44:18', '1'),
(10, 'GTPT30', '30', 1, '["1"]', '1', '2017-03-09 10:45:06', '1'),
(11, 'GTGD25', '25', 1, '["2"]', '1', '2017-03-09 10:45:53', '1'),
(12, 'GTSL20', '20', 1, '["3"]', '0', '2017-03-09 10:46:25', '1'),
(13, 'gdg', '30', 1, '["1"]', '1', '2017-03-09 11:00:58', '1');

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE `general_setting` (
  `id` int(11) NOT NULL,
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
  `sys_language` varchar(20) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_setting`
--

INSERT INTO `general_setting` (`id`, `name`, `start_year`, `address`, `office_number`, `country`, `email`, `date_format`, `calendar_lang`, `gym_logo`, `cover_image`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `member_can_view_other`, `staff_can_view_own_member`, `enable_sandbox`, `paypal_email`, `currency`, `enable_alert`, `reminder_days`, `reminder_message`, `enable_message`, `left_header`, `footer`, `system_installed`, `enable_rtl`, `datepicker_lang`, `system_version`, `sys_language`) VALUES
(1, 'GoTribe -  Management System', '2017', 'address', '8899665544', 'us', 'barkha@rnf.tech', 'MM d, yyyy', 'en', '1488473908_714673.png', '', 'KG', 'Centimeter', 'Inches', 'Inches', 'Inches', 'Inches', 'Percentage', 1, 1, 0, 'your_id@paypal.com', 'USD', 1, '5', 'Hello GYM_MEMBERNAME,\r\n      Your Membership  GYM_MEMBERSHIP  started at GYM_STARTDATE and it will expire on GYM_ENDDATE.\r\nThank You.', 1, 'GoTribe', 'Copyright © 2016-2017. All rights reserved.', 1, 0, 'en-CA', '4', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `gym_accessright`
--

CREATE TABLE `gym_accessright` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` text NOT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `page_link` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `assigned_roles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_accessright`
--

INSERT INTO `gym_accessright` (`id`, `name`, `module`, `controller`, `action`, `page_link`, `order`, `assigned_roles`) VALUES
(1, 'List All Members Roles', 'Members Role', 'GymAccessRoles', 'AccessRolesList', '/gym-access-roles/access-roles-list', 1, '1'),
(2, 'Add New Members Role', 'Members Role', 'GymAccessRoles', 'addAccessRoles', '/gym-access-roles/add-access-roles', 2, '1'),
(3, 'Edit New Members Role', 'Members Role', 'GymAccessRoles', 'editAccessRoles', '/gym-access-roles/edit-access-roles', 3, '1'),
(4, 'List All Groups', 'Groups', 'GymGroup', 'GroupList', '/gym-group/group-list', 1, '1,2,3'),
(5, 'Add New Groups', 'Groups', 'GymGroup', 'addGroup', '/gym-group/add-group', 2, '1,2'),
(6, 'Edit New Groups', 'Groups', 'GymGroup', 'editGroup', '/gym-group/edit-group', 3, '1,2'),
(7, 'Assigned Permission to Roles ', 'Permissions', 'GymAccessright', 'accessRight', '/gym-accessright/access-right', 1, '1'),
(8, 'List All Licensee List', 'Licensee', 'Licensee', 'licenseeList', '/licensee/licensee-list', 1, '1'),
(9, 'Add Franchise', 'Licensee', 'Licensee', 'addLicensee', '/licensee/add-licensee', 1, '1'),
(10, 'Dashboard', 'Dashboard', 'Dashboard', 'index', '/dashboard/admin-dashboard', 1, '1,2,3,4'),
(11, 'Edit Licensee', 'Licensee', 'Licensee', 'editFranchise', '/licensee/edit-licensee', 1, '1,2'),
(12, 'Delete Licensee', 'Licensee', 'Licensee', 'deleteFranchise', '/licensee/delete-licensee', 1, '1'),
(13, 'List Location', 'Location', 'GymLocation', 'locationList', '/location/location-list', 1, '1,2,3'),
(14, 'Add Location', 'Location', 'GymLocation', 'addLocation', '/location/add-location', 1, '1,2,3'),
(15, 'Edit Location', 'Location', 'GymLocation', 'editLocation', '/location/edit-location', 1, '1,2,3'),
(16, 'Delete Location', 'Location', 'GymLocation', 'deleteLocation', '/location/delete-location', 1, '1,2,3'),
(29, 'List Membership Type', 'Membership', 'Membership', 'membershipList', '/membership/membership-list', 1, '1,2,3,4'),
(30, 'Add Membership Type', 'Membership', 'Membership', 'add', '/membership/add', 1, '1,2,3,4'),
(31, 'Edit Membership Type', 'Membership', 'Membership', 'editMembership', '/membership/edit-membership', 1, '1,2,3,4'),
(32, 'Dashboard', 'Dashboard', 'Dashboard', 'adminDashboard', '/dashboard/admin-dashboard', 1, '1,2,3,4'),
(33, 'List Staff Members', 'Staff Members', 'StaffMembers', 'StaffList', '/staff-members/staff-list', 1, '1,2'),
(34, 'Add Staff Members', 'Staff Members', 'StaffMembers', 'addStaff', '/staff-members/add-staff', 1, '1,2'),
(35, 'Edit Staff Members', 'Staff Members', 'StaffMembers', 'editStaff', '/staff-members/edit-staff', 1, '1,2'),
(36, 'Delete Staff Members', 'Staff Members', 'StaffMembers', 'deleteStaff', '/staff-members/delete-staff', 1, '1,2'),
(37, 'List Member', 'Member', 'GymMember', 'memberList', '/gym-member/member-list', 1, '1,2'),
(38, 'Add Member', 'Member', 'GymMember', 'addMember', '/gym-member/add-member', 1, '1,2'),
(39, 'Edit Member', 'Member', 'GymMember', 'editMember', '/gym-member/edit-member', 1, '1,2'),
(40, 'Delete Member', 'Member', 'GymMember', 'deleteMember', '/gym-member/delete-member', 1, '1,2'),
(41, 'View Member', 'Member', 'GymMember', 'viewMember', '/gym-member/view-member', 1, '1,2'),
(42, 'Add Member Payment History', 'Member', 'GymMember', 'addPaymentHistory', '/gym-member/add-payment-history', 1, '1,2'),
(43, 'View Member Attendance', 'Member', 'GymMember', 'viewAttendance', '/gym-member/view-attendance', 1, '1,2'),
(44, 'Activate Member', 'Member', 'GymMember', 'activateMember', '/gym-member/activate-member', 1, '1,2'),
(45, 'Settings', 'General', 'GeneralSetting', 'saveSetting', '/general-setting/save-setting', 1, '1'),
(46, 'List Accountant', 'Accountant', 'GymAccountant', 'accountantList', '/gym-accountant/accountant-list', 1, '1'),
(47, 'Add Accountant', 'Accountant', 'GymAccountant', 'addAccountant', '/gym-accountant/add-accountant', 1, '1'),
(48, 'Edit Accountant', 'Accountant', 'GymAccountant', 'editAccountant', '/gym-accountant/edit-accountant', 1, '1'),
(49, 'Delete Accountant', 'Accountant', 'GymAccountant', 'deleteAccountant', '/gym-accountant/delete-accountant', 1, '1'),
(64, 'List Classes', 'Classes Manager', 'ClassSchedule', 'classList', '/class-schedule/class-list', 1, '1,2,3'),
(65, 'Add Classes', 'Classes Manager', 'ClassSchedule', 'addClass', '/class-schedule/add-class', 1, '1,2,3'),
(66, 'Edit Classes', 'Classes Manager', 'ClassSchedule', 'editClass', '/class-schedule/edit-class', 1, '1,2,3'),
(67, 'Delete Classes', 'Classes Manager', 'ClassSchedule', 'deleteClass', '/class-schedule/delete-class', 1, '1,2,3'),
(68, 'List Classes Type', 'Classes Type Manager', 'ClassType', 'classtypeList', '/class-type/classtype-list', 1, '1,2,3'),
(69, 'Add Class Type', 'Class Type', 'ClassType', 'addclassType', '/class-type/addclass-type', 1, '1,2,3'),
(70, 'Edit Class Type', 'Class Type', 'ClassType', 'editclassType', '/class-type/editclass-type', 1, '1,2,3'),
(71, 'Delete Class Type', 'Class Type', 'ClassType', 'deleteclassType', '/class-type/deleteclass-type', 1, '1,2,3'),
(72, 'List All Clases', 'Classes', 'GymClass', 'ClassesList', '/gym-class/classes-list', 1, '1,2,3'),
(73, 'Add New Classes', 'Classes', 'GymClass', 'addClasses', '/gym-class/add-classes', 2, '1,2'),
(74, 'Edit Classes', 'Classes', 'GymClass', 'editClasses', '/gym-class/edit-classes', 3, '1,2'),
(75, 'Delete Classes', 'Classes', 'GymClass', 'deleteClasses', '/gym-class/delete-classes', 3, '1,2'),
(76, 'List Schedule', 'Classes Manager', 'ClassSchedule', 'viewSchedules', '/class-schedule/view-schedules', 1, '1,2,3'),
(77, 'Delete Schedule Classes', 'Classes Manager', 'ClassSchedule', 'deleteSchedule', '/class-schedule/delete-schedule', 1, '1,2,3'),
(78, 'List Discount Code', 'Referral & Discount', 'DiscountCode', 'discountCodeList', '/discount-code/discount-code-list', 1, '1,2'),
(79, 'Edit Discount Code', 'Referral & Discount', 'DiscountCode', 'editDiscountCode', '/discount-code/edit-discount-code', 1, '1,2'),
(80, 'Add Discount Code', 'Referral & Discount', 'DiscountCode', 'addDiscountCode', '/discount-code/add-discount-code', 1, '1,2'),
(81, 'Delete Discount Code', 'Referral & Discount', 'DiscountCode', 'deleteDiscountCode', '/discount-code/delete-discount-code', 1, '1,2'),
(82, 'List Referral URl', 'Referral & Discount', 'ReferralUrl', 'referralUrlList', '/referral-url/referral-url-list', 1, '1,2'),
(83, 'Add Referral URl', 'Referral & Discount', 'ReferralUrl', 'addReferralUrl', '/referral-url/add-referral-url', 1, '1,2'),
(84, 'Edit Referral URl', 'Referral & Discount', 'ReferralUrl', 'editReferralUrl', '/referral-url/edit-referral-url', 1, '1,2'),
(85, 'Delete Referral URl', 'Referral & Discount', 'ReferralUrl', 'deleteReferralUrl', '/referral-url/delete-referral-url', 1, '1,2'),
(86, 'Member Attendance', 'Attendance', 'GymAttendance', 'attendance', '/gym_master/gym-attendance/attendance', 1, '1,2,3'),
(87, 'Staff Attendance', 'Attendance', 'GymAttendance', 'staffAttendance', '/gym_master/gym-attendance/staff-attendance', 1, '1,2,3'),
(88, 'Assign Member', 'Member', 'GymMember', 'assignMember', '/gym_master/gym-member/assign-member', 1, '1,2');

-- --------------------------------------------------------

--
-- Table structure for table `gym_access_roles`
--

CREATE TABLE `gym_access_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `gym_assign_workout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `level_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `direct_assign` tinyint(1) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_attendance`
--

CREATE TABLE `gym_attendance` (
  `attendance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `attendance_by` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `schedule_id` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_attendance`
--

INSERT INTO `gym_attendance` (`attendance_id`, `user_id`, `class_id`, `attendance_date`, `status`, `attendance_by`, `role_name`, `schedule_id`) VALUES
(5, 17, 2, '2017-03-07', 'Present', 1, 'member', 13),
(6, 17, 2, '2017-03-07', 'Absent', 1, 'member', 18),
(7, 17, 2, '2017-03-06', 'Present', 1, 'member', 13),
(10, 7, 2, '2017-03-01', 'Present', 1, 'staff_member', 19),
(11, 8, 2, '2017-03-01', 'Absent', 1, 'staff_member', 13),
(12, 8, 2, '2017-03-01', 'Present', 1, 'staff_member', 14),
(13, 7, 4, '2017-03-01', 'Present', 1, 'staff_member', 15),
(14, 17, 2, '2017-03-09', 'Absent', 1, 'member', 13);

-- --------------------------------------------------------

--
-- Table structure for table `gym_class`
--

CREATE TABLE `gym_class` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `class_type_id` int(12) NOT NULL,
  `description` text,
  `updated_date` datetime NOT NULL,
  `updated_by` int(12) NOT NULL,
  `role_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_class`
--

INSERT INTO `gym_class` (`id`, `name`, `image`, `created_by`, `created_date`, `class_type_id`, `description`, `updated_date`, `updated_by`, `role_name`) VALUES
(1, 'Open Gym', '1488275800_636335.jpg', 1, '2017-02-28 00:00:00', 3, '<p>Test Descriptions</p>', '2017-02-28 11:07:36', 1, 'administrator'),
(2, 'Toluca Lake Small Group', '', 1, '2017-03-01 09:58:45', 4, '', '2017-03-01 09:58:45', 1, 'administrator'),
(3, 'Toluca Lake Yoga', '', 1, '2017-03-01 09:59:14', 4, '', '2017-03-01 09:59:14', 1, 'administrator'),
(4, 'my class', '', 4, '2017-03-03 08:54:57', 3, '', '2017-03-03 08:54:57', 4, 'franchise'),
(5, 'testing classs', '', 6, '2017-03-03 09:04:28', 3, '', '2017-03-03 09:04:28', 6, 'franchise');

-- --------------------------------------------------------

--
-- Table structure for table `gym_daily_workout`
--

CREATE TABLE `gym_daily_workout` (
  `id` int(11) NOT NULL,
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
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_event_place`
--

CREATE TABLE `gym_event_place` (
  `id` int(11) NOT NULL,
  `place` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_group`
--

CREATE TABLE `gym_group` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_group`
--

INSERT INTO `gym_group` (`id`, `name`, `image`, `created_by`, `created_date`) VALUES
(1, 'New Group', '', 1, '2017-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `gym_income_expense`
--

CREATE TABLE `gym_income_expense` (
  `id` int(11) NOT NULL,
  `invoice_type` varchar(100) NOT NULL,
  `invoice_label` varchar(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `entry` text NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `total_amount` double NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_interest_area`
--

CREATE TABLE `gym_interest_area` (
  `id` int(11) NOT NULL,
  `interest` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_levels`
--

CREATE TABLE `gym_levels` (
  `id` int(11) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_location`
--

CREATE TABLE `gym_location` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `location` varchar(250) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `role_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gym_location`
--

INSERT INTO `gym_location` (`id`, `title`, `location`, `created_by`, `status`, `created_date`, `role_name`) VALUES
(1, 'LANKERSHIM BLVD', '4444 LANKERSHIM BLVD #108 LOS ANGELES CA 91602', 1, '1', '2017-02-20 14:57:56', 'administrator'),
(6, 'New Location by mukesh', 'Mukesh place', 4, '1', '2017-02-22 11:44:38', 'licensee'),
(8, 'Youth Baseball Coaches Meeting', '1010 Ninth St.  Wichita Falls, TX 76301 United States', 1, '1', '0000-00-00 00:00:00', 'administrator'),
(9, 'Youth Baseball Coaches Meeting', '1010 Ninth St.  Wichita Falls, TX 76301 United States', 6, '1', '0000-00-00 00:00:00', 'licensee');

-- --------------------------------------------------------

--
-- Table structure for table `gym_measurement`
--

CREATE TABLE `gym_measurement` (
  `id` int(11) NOT NULL,
  `result_measurment` varchar(100) DEFAULT NULL,
  `result` float DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `result_date` date NOT NULL,
  `image` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_measurement`
--

INSERT INTO `gym_measurement` (`id`, `result_measurment`, `result`, `user_id`, `result_date`, `image`, `created_by`, `created_date`) VALUES
(1, 'Height', 122, 23, '2017-03-08', '1488523041_349683.jpg', 4, '2017-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `gym_member`
--

CREATE TABLE `gym_member` (
  `id` int(11) NOT NULL,
  `activated` int(11) NOT NULL DEFAULT '0',
  `role_name` text NOT NULL,
  `role_id` int(2) NOT NULL,
  `member_id` text,
  `associated_licensee` int(11) DEFAULT NULL,
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
  `assign_staff_mem` int(11) DEFAULT '0',
  `intrested_area` int(11) DEFAULT '0',
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
  `created_role` varchar(20) DEFAULT NULL,
  `created_date` date NOT NULL,
  `alert_sent` int(11) NOT NULL,
  `class_type` varchar(200) DEFAULT NULL,
  `reset_password_token` varchar(250) DEFAULT NULL,
  `token_created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_member`
--

INSERT INTO `gym_member` (`id`, `activated`, `role_name`, `role_id`, `member_id`, `associated_licensee`, `first_name`, `middle_name`, `last_name`, `location_id`, `member_type`, `role`, `s_specialization`, `gender`, `birth_date`, `assign_class`, `assign_group`, `address`, `city`, `state`, `zipcode`, `mobile`, `phone`, `email`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `username`, `password`, `image`, `assign_staff_mem`, `intrested_area`, `g_source`, `referrer_by`, `inquiry_date`, `trial_end_date`, `selected_membership`, `membership_status`, `membership_valid_from`, `membership_valid_to`, `first_pay_date`, `created_by`, `created_role`, `created_date`, `alert_sent`, `class_type`, `reset_password_token`, `token_created_at`) VALUES
(1, 0, 'administrator', 1, '', 0, 'Admin', '', 'GoTribe', 0, '', 0, '', 'male', '2016-07-01', 0, '', 'null', 'null', 't', '123123', '123123123', '', 'admin@admin.com', '', '', '', '', '', '', '', 'admin', '$2y$10$Qdg.AvH8XtGCoK7aQHnz7.WoVg1wkAxJzQbrdfixfltyzBbf9vkbi', '1487324042_473783.jpg', 0, 0, 0, 0, '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 0, NULL, '2017-02-17', 0, NULL, NULL, NULL),
(3, 1, 'licensee', 2, 'FR123', 0, 'New Franchise', '', '', 2, '1', 1, '', 'male', '2017-02-14', 1, '1', 'Delhi', 'New Delhi', '1', '12234', '9865741230', '', 'nirsssaj@test.com', '1', '1', '1', '1', '1', '', '1', 'admin11', '$2y$10$SVkXDBXtZpbioRgXWDHxKufFV3NNx/LMkn6aH8VYbUOv53bWtDqGW', '1487754742_782095.jpg', 1, 1, 1, 1, '2017-01-10', '2017-01-10', '1', '1', '2017-01-10', '2017-01-10', '2017-01-10', 1, NULL, '2017-02-21', 1, NULL, NULL, NULL),
(4, 1, 'licensee', 2, NULL, NULL, 'New Franchise1', 'middle', 'last', 1, NULL, NULL, NULL, 'male', '2017-02-22', NULL, NULL, 'Delhi', 'New Delhi', 'Delhi', '12345', '9865741230', '09582313900', 'mukesh@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mukesh', '$2y$10$8bosIKBOQWUlMfKFt.WpGOyVsW0GYmJF17Yho4Bc6pbLjK/Owggd6', '1487682443_501339.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-02-21', 1, NULL, NULL, NULL),
(5, 0, 'staff_member', 3, NULL, 4, 'New Staff', 'middlewqewr', 'under franchise1', NULL, NULL, 2, '["1","2","4"]', 'male', '2017-02-16', NULL, NULL, 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'atul@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'atul', '$2y$10$CH4lTptuc6EJLqr9Ea0.hebelMK1G8i39uBLkUBmSeSfgNLwGQYZC', '1487857297_949070.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-02-23', 1, NULL, NULL, NULL),
(6, 1, 'licensee', 2, NULL, NULL, 'My Franchise', '', '', 2, NULL, NULL, NULL, 'male', '2017-02-22', NULL, NULL, 'c-117', 'New york', 'New york', '110023', '9874561230', '', 'alan@yopmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alan', '$2y$10$C3chz2f9BnlKY1Vr3t/I3.XWydc4b3qOP.xaiRuZw..TBdaSNV.Pi', 'profile-placeholder.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-02-24', 1, NULL, NULL, NULL),
(7, 0, 'staff_member', 3, NULL, 6, 'John', '', 'Rau', NULL, NULL, 1, '["1"]', 'male', '2017-02-28', NULL, NULL, 'A-123', 'canada', 'canada', '123456', '1234567890', '', 'alan1@yopmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alan1', '$2y$10$RwQ7fZBY9U4qkMNHdJ3olubu2rNpKFyfWLfpNdVjk.cXe5X62QLIi', 'logo.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, '2017-02-24', 1, NULL, NULL, NULL),
(8, 0, 'staff_member', 3, NULL, 6, 'Emplyee', '', 'task', NULL, NULL, 2, '["1"]', 'male', '2017-01-24', NULL, NULL, 'A-123', 'canada', 'canada', '110023', '9874561230', '', 'joshi.pankaj489@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'root', '$2y$10$LIBHvcTAjbrjc69OtqH3Jut8pW3HWuuIgQv8w74VQ4lHzgQkL.BKq', 'logo.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, '2017-02-27', 1, NULL, NULL, NULL),
(15, 1, 'member', 4, 'M150217', NULL, 'New Customer', 'middle', 'last', NULL, 'Member', NULL, NULL, 'male', '2016-03-17', NULL, '0', 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'mukesh111@rnf.tech', '12', '12', '12', '12', '12', '12', '12', 'user11', '$2y$10$Lfre1O7HhNpZmRQd99pYu.1E7.c9xfDBxVsCTCIOd8t4sYvIgya7O', '1488460252_578825.jpg', NULL, NULL, NULL, NULL, '2017-03-08', '2017-04-07', '1', 'Continue', '2017-03-01', '2018-02-24', '2017-03-08', 1, NULL, '2017-03-02', 1, 'Group', NULL, NULL),
(17, 1, 'member', 4, 'M170217', NULL, 'Customer2', 'sad', 'daws', NULL, 'Member', NULL, NULL, 'male', '2017-03-08', NULL, '0', 'Delhi', 'dgf', 'Delhi', '12234', '9865741230', '09582313900', 'mukesh2@rnf.tech', '12', '12', '12', '12', '12', '12', '12', 'user3', '$2y$10$ofOKq.dy1OgC34hL/AuU6O4fb.vCUmMUUzm054OAC4Ui.7ND31qeS', 'profile-placeholder.png', NULL, NULL, NULL, 6, '2017-03-01', '2017-03-08', '1', 'Continue', '2017-03-01', '2018-02-24', '2017-03-15', 1, NULL, '2017-03-02', 1, 'Individual', NULL, NULL),
(18, 1, 'member', 4, 'M180217', NULL, '', '', '', NULL, 'Member', NULL, NULL, 'male', '1970-01-01', NULL, '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '$2y$10$/Xz3irz5d3rI5AT09PsDd.KBi3KmJrVrt1GbvdggFqrEvSazVr9ve', 'profile-placeholder.png', 0, NULL, NULL, NULL, '1970-01-01', '1970-01-01', '', 'Continue', '1970-01-01', '1970-01-01', '1970-01-01', 1, NULL, '2017-03-02', 1, 'Group', NULL, NULL),
(19, 1, 'member', 4, 'M180217', NULL, 'new member1', 'middle', 'last', NULL, 'Member', NULL, NULL, 'male', '2017-03-02', NULL, '0', 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'mukesh1111@rnf.tech', '12', '12', '12', '12', '12', '12', '12', 'user33', '$2y$10$uhkFCtcj9nrA8DiyQbHHA.5ymTLNw21irf2AeZ4ZvDxVwPNrjoQdO', 'profile-placeholder.png', 7, NULL, NULL, 3, '2017-03-08', '1970-01-01', '3', 'Continue', '2017-03-02', '2017-08-29', '2017-03-02', 1, NULL, '2017-03-02', 1, 'Group', NULL, NULL),
(20, 0, 'staff_member', 3, NULL, 4, 'Staff1', 'middle', 'last', NULL, NULL, 1, '["1","2","3"]', 'male', '2017-03-29', NULL, NULL, 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'atul111@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff1', '$2y$10$i8JBgS8F2F/cNyr3jt4SqeyKh.4K4.ZkVSv.0jmudZhjjG7dTbwXa', '1488519857_499429.jpg', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, '2017-03-03', 1, NULL, NULL, NULL),
(22, 1, 'member', 4, 'M200317', NULL, 'member', 'middle', 'last', NULL, 'Member', NULL, NULL, 'male', '2017-03-08', NULL, '0', 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'mukesh1212@rnf.tech', '12', '12', '12', '12', '12', '12', '12', 'member', '$2y$10$2fd36bLgm96Uq2b0K1RD1OdK62yuLHOlzK5fQWamKryQpMrm.Z6VG', 'profile-placeholder.png', 5, 0, NULL, 3, '2017-03-22', '2017-03-02', '3', 'Continue', '2017-03-29', '2017-09-25', '2017-03-22', 4, NULL, '2017-03-03', 1, 'Group', NULL, NULL),
(23, 1, 'member', 4, 'M200317', NULL, 'memr', 'middle', 'last', NULL, 'Member', NULL, NULL, 'male', '2017-03-22', NULL, '0', 'Delhi', 'New Delhi', 'Delhi', '12234', '9865741230', '09582313900', 'mukesh5445@rnf.tech', '12', '12', '12', '12', '12', '12', '12', 'mem', '$2y$10$uniQB4xdqrTB6KtbYKttN.A5Zc..J4xex06oUih6SQpa2sycPG912', 'profile-placeholder.png', 5, 0, NULL, 20, '2017-03-08', '2017-03-15', '1', 'Continue', '2017-03-22', '2018-03-17', '2017-03-28', 4, NULL, '2017-03-03', 1, 'Group', NULL, NULL),
(24, 1, 'accountant', 5, NULL, NULL, 'Accountant', 'middle', 'last', NULL, NULL, NULL, NULL, 'male', '2017-03-01', NULL, NULL, 'Delhi', 'New Delhi', '', '', '9865741230', '09582313900', 'mukesh11@rnf.tech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'accountant', '$2y$10$FXTp55eyY9MNHvGNBJ/YKechZrxinB8kfTOO353XQLsqHFQm4EJJm', '1488525452_83341.jpg', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-03-03', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gym_member_class`
--

CREATE TABLE `gym_member_class` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `assign_class` int(11) NOT NULL,
  `assign_schedule` int(12) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_member_class`
--

INSERT INTO `gym_member_class` (`id`, `member_id`, `assign_class`, `assign_schedule`) VALUES
(16, 17, 1, 11),
(17, 17, 2, 13),
(18, 17, 2, 18),
(19, 23, 2, 19);

-- --------------------------------------------------------

--
-- Table structure for table `gym_message`
--

CREATE TABLE `gym_message` (
  `id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message_body` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_newsletter`
--

CREATE TABLE `gym_newsletter` (
  `id` int(11) NOT NULL,
  `api_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_notice`
--

CREATE TABLE `gym_notice` (
  `id` int(11) NOT NULL,
  `notice_title` varchar(100) NOT NULL,
  `notice_for` text NOT NULL,
  `class_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `comment` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_nutrition`
--

CREATE TABLE `gym_nutrition` (
  `id` int(11) NOT NULL,
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
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_nutrition_data`
--

CREATE TABLE `gym_nutrition_data` (
  `id` int(11) NOT NULL,
  `day_name` varchar(30) NOT NULL,
  `nutrition_time` varchar(30) NOT NULL,
  `nutrition_value` text NOT NULL,
  `nutrition_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_product`
--

CREATE TABLE `gym_product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_reservation`
--

CREATE TABLE `gym_reservation` (
  `id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_roles`
--

CREATE TABLE `gym_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `gym_source` (
  `id` int(11) NOT NULL,
  `source_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_store`
--

CREATE TABLE `gym_store` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `sell_date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `sell_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_user_workout`
--

CREATE TABLE `gym_user_workout` (
  `id` int(11) NOT NULL,
  `user_workout_id` int(11) NOT NULL,
  `workout_name` int(11) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `kg` float NOT NULL,
  `rest_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gym_workout_data`
--

CREATE TABLE `gym_workout_data` (
  `id` int(11) NOT NULL,
  `day_name` varchar(15) NOT NULL,
  `workout_name` varchar(100) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `kg` float NOT NULL,
  `time` int(11) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `installment_plan`
--

CREATE TABLE `installment_plan` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `membership_label` varchar(100) NOT NULL,
  `membership_cat_id` int(11) NOT NULL,
  `membership_length` int(11) NOT NULL,
  `membership_class_limit` varchar(20) NOT NULL,
  `limit_days` int(11) DEFAULT NULL,
  `limitation` varchar(20) DEFAULT NULL,
  `install_plan_id` int(11) NOT NULL,
  `membership_amount` double NOT NULL,
  `membership_class` varchar(255) NOT NULL,
  `installment_amount` double NOT NULL,
  `signup_fee` double NOT NULL,
  `gmgt_membershipimage` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `membership_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `membership_label`, `membership_cat_id`, `membership_length`, `membership_class_limit`, `limit_days`, `limitation`, `install_plan_id`, `membership_amount`, `membership_class`, `installment_amount`, `signup_fee`, `gmgt_membershipimage`, `created_date`, `created_by_id`, `membership_description`) VALUES
(1, 'Platinum Membership', 1, 360, 'Unlimited', NULL, NULL, 1, 500, '["1","2","3","4"]', 42, 5, '', '2016-08-22', 1, '<p>Platinum membership description<br></p>'),
(2, 'Gold Membership', 1, 300, 'Unlimited', 0, '', 1, 450, '[\'1\',\'2\',\'3\',\'4\',\'5\']', 37, 5, '', '2016-08-22', 1, '<p>Gold membership description<br></p>'),
(3, 'Silver Membership', 2, 180, 'Limited', 0, 'per_week', 2, 200, '[\'4\',\'6\',\'7\']', 5, 5, '', '2016-08-22', 1, '<p>Silver &nbsp;membership description</p>');

-- --------------------------------------------------------

--
-- Table structure for table `membership_activity`
--

CREATE TABLE `membership_activity` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membership_history`
--

CREATE TABLE `membership_history` (
  `id` int(11) NOT NULL,
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
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membership_history`
--

INSERT INTO `membership_history` (`id`, `member_id`, `selected_membership`, `assign_staff_mem`, `intrested_area`, `g_source`, `referrer_by`, `inquiry_date`, `trial_end_date`, `membership_valid_from`, `membership_valid_to`, `first_pay_date`, `created_date`) VALUES
(1, 11, 1, 0, 0, 0, 0, '1970-01-01', '1970-01-01', '2017-02-28', '1970-12-27', '2017-02-21', '2017-02-27'),
(2, 12, 0, 0, 0, 0, 0, '1970-01-01', '1970-01-01', '0000-00-00', '0000-00-00', '2017-02-14', '2017-02-27'),
(3, 13, 0, 0, 0, 0, 0, '2017-02-27', '2017-02-23', '0000-00-00', '0000-00-00', '2017-02-28', '2017-02-27'),
(4, 14, 0, 0, 0, 0, 5, '1970-01-01', '1970-01-01', '0000-00-00', '0000-00-00', '2017-02-02', '2017-02-27'),
(5, 23, 1, 5, 0, 0, 20, '2017-03-08', '2017-03-15', '2017-03-22', '2018-03-17', '2017-03-28', '2017-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `membership_payment`
--

CREATE TABLE `membership_payment` (
  `mp_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `membership_amount` double NOT NULL,
  `paid_amount` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `membership_status` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membership_payment`
--

INSERT INTO `membership_payment` (`mp_id`, `member_id`, `membership_id`, `membership_amount`, `paid_amount`, `start_date`, `end_date`, `membership_status`, `payment_status`, `created_date`, `created_by`) VALUES
(1, 11, 1, 500, 0, '2017-02-28', '1970-12-27', 'Continue', '0', '2017-02-27', 0),
(2, 23, 1, 500, 0, '2017-03-22', '2018-03-17', 'Continue', '0', '2017-03-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `membership_payment_history`
--

CREATE TABLE `membership_payment_history` (
  `payment_history_id` bigint(20) NOT NULL,
  `mp_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `paid_by_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `trasaction_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`id`, `name`) VALUES
(1, 'Boxing Specialist'),
(2, 'Yoga Specialist'),
(3, 'Chest Workout Specialist'),
(4, 'New Specialization1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_schedule_list`
--
ALTER TABLE `class_schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_type`
--
ALTER TABLE `class_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_code`
--
ALTER TABLE `discount_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `general_setting`
--
ALTER TABLE `general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_accessright`
--
ALTER TABLE `gym_accessright`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_access_roles`
--
ALTER TABLE `gym_access_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_assign_workout`
--
ALTER TABLE `gym_assign_workout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_attendance`
--
ALTER TABLE `gym_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `gym_class`
--
ALTER TABLE `gym_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_daily_workout`
--
ALTER TABLE `gym_daily_workout`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `gym_event_place`
--
ALTER TABLE `gym_event_place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_group`
--
ALTER TABLE `gym_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_income_expense`
--
ALTER TABLE `gym_income_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_interest_area`
--
ALTER TABLE `gym_interest_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_levels`
--
ALTER TABLE `gym_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_location`
--
ALTER TABLE `gym_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_measurement`
--
ALTER TABLE `gym_measurement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_member`
--
ALTER TABLE `gym_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `gym_member_class`
--
ALTER TABLE `gym_member_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_message`
--
ALTER TABLE `gym_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_newsletter`
--
ALTER TABLE `gym_newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_notice`
--
ALTER TABLE `gym_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_nutrition`
--
ALTER TABLE `gym_nutrition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_nutrition_data`
--
ALTER TABLE `gym_nutrition_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_product`
--
ALTER TABLE `gym_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_reservation`
--
ALTER TABLE `gym_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_roles`
--
ALTER TABLE `gym_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_source`
--
ALTER TABLE `gym_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_store`
--
ALTER TABLE `gym_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_user_workout`
--
ALTER TABLE `gym_user_workout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_workout_data`
--
ALTER TABLE `gym_workout_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installment_plan`
--
ALTER TABLE `installment_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_activity`
--
ALTER TABLE `membership_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_history`
--
ALTER TABLE `membership_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_payment`
--
ALTER TABLE `membership_payment`
  ADD PRIMARY KEY (`mp_id`);

--
-- Indexes for table `membership_payment_history`
--
ALTER TABLE `membership_payment_history`
  ADD PRIMARY KEY (`payment_history_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `class_schedule_list`
--
ALTER TABLE `class_schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `class_type`
--
ALTER TABLE `class_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `discount_code`
--
ALTER TABLE `discount_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `general_setting`
--
ALTER TABLE `general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gym_accessright`
--
ALTER TABLE `gym_accessright`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `gym_access_roles`
--
ALTER TABLE `gym_access_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gym_assign_workout`
--
ALTER TABLE `gym_assign_workout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_attendance`
--
ALTER TABLE `gym_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `gym_class`
--
ALTER TABLE `gym_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gym_daily_workout`
--
ALTER TABLE `gym_daily_workout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_event_place`
--
ALTER TABLE `gym_event_place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_group`
--
ALTER TABLE `gym_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gym_income_expense`
--
ALTER TABLE `gym_income_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_interest_area`
--
ALTER TABLE `gym_interest_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_levels`
--
ALTER TABLE `gym_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_location`
--
ALTER TABLE `gym_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `gym_measurement`
--
ALTER TABLE `gym_measurement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gym_member`
--
ALTER TABLE `gym_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `gym_member_class`
--
ALTER TABLE `gym_member_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `gym_message`
--
ALTER TABLE `gym_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_newsletter`
--
ALTER TABLE `gym_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_notice`
--
ALTER TABLE `gym_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_nutrition`
--
ALTER TABLE `gym_nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_nutrition_data`
--
ALTER TABLE `gym_nutrition_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_product`
--
ALTER TABLE `gym_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_reservation`
--
ALTER TABLE `gym_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_roles`
--
ALTER TABLE `gym_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gym_source`
--
ALTER TABLE `gym_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_store`
--
ALTER TABLE `gym_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_user_workout`
--
ALTER TABLE `gym_user_workout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym_workout_data`
--
ALTER TABLE `gym_workout_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `installment_plan`
--
ALTER TABLE `installment_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `membership_activity`
--
ALTER TABLE `membership_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `membership_history`
--
ALTER TABLE `membership_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `membership_payment`
--
ALTER TABLE `membership_payment`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `membership_payment_history`
--
ALTER TABLE `membership_payment_history`
  MODIFY `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
