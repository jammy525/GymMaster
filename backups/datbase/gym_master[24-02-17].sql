-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2017 at 11:07 AM
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
-- Table structure for table `gym_accessright`
--

CREATE TABLE `gym_accessright` (
  `id` int(11) NOT NULL,
  `controller` text NOT NULL,
  `action` text NOT NULL,
  `menu` text NOT NULL,
  `menu_icon` text NOT NULL,
  `menu_title` text NOT NULL,
  `member` int(11) NOT NULL,
  `staff_member` int(11) NOT NULL,
  `accountant` int(11) NOT NULL,
  `page_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gym_accessright`
--

INSERT INTO `gym_accessright` (`id`, `controller`, `action`, `menu`, `menu_icon`, `menu_title`, `member`, `staff_member`, `accountant`, `page_link`) VALUES
(1, 'StaffMembers', '', 'staff_member', 'staff-member.png', 'Staff Members', 1, 1, 1, '/gym_master/staff-members/staff-list'),
(2, 'Membership', '', 'membership', 'membership-type.png', 'Membership Type', 1, 1, 0, '/gym_master/membership/membership-list'),
(3, 'GymGroup', '', 'group', 'group.png', 'Group', 1, 1, 0, '/gym_master/gym-group/group-list'),
(4, 'GymMember', '', 'member', 'member.png', 'Member', 1, 1, 1, '/gym_master/gym-member/member-list'),
(5, 'Activity', '', 'activity', 'activity.png', 'Activity', 1, 1, 0, '/gym_master/activity/activity-list'),
(6, 'ClassSchedule', '', 'class-schedule', 'class-schedule.png', 'Class Schedule', 1, 1, 0, '/gym_master/class-schedule/class-list'),
(7, 'GymAttendance', '', 'attendance', 'attendance.png', 'Attendance', 0, 1, 0, '/gym_master/gym-attendance/attendance'),
(8, 'GymAssignWorkout', '', 'assign-workout', 'assigne-workout.png', 'Assigned Workouts', 1, 1, 0, '/gym_master/gym-assign-workout/workout-log'),
(9, 'GymDailyWorkout', '', 'workouts', 'workout.png', 'Workouts', 1, 1, 0, '/gym_master/gym-daily-workout/workout-list'),
(10, 'GymAccountant', '', 'accountant', 'accountant.png', 'Accountant', 1, 1, 1, '/gym_master/gym-accountant/accountant-list'),
(11, 'MembershipPayment', '', 'membership_payment', 'fee.png', 'Fee Payment', 1, 0, 1, '/gym_master/membership-payment/payment-list'),
(12, 'MembershipPayment', '', 'income', 'payment.png', 'Income', 0, 0, 1, '/gym_master/membership-payment/income-list'),
(13, 'MembershipPayment', '', 'expense', 'payment.png', 'Expense', 0, 0, 1, '/gym_master/membership-payment/expense-list'),
(14, 'GymProduct', '', 'product', 'products.png', 'Product', 0, 1, 1, '/gym_master/gym-product/product-list'),
(15, 'GymStore', '', 'store', 'store.png', 'Store', 0, 1, 1, '/gym_master/gym-store/sell-record'),
(16, 'GymNewsletter', '', 'news_letter', 'newsletter.png', 'Newsletter', 0, 1, 0, '/gym_master/gym-newsletter/setting'),
(17, 'GymMessage', '', 'message', 'message.png', 'Message', 1, 1, 1, '/gym_master/gym-message/compose-message'),
(18, 'GymNotice', '', 'notice', 'notice.png', 'Notice', 1, 1, 1, '/gym_master/gym-notice/notice-list'),
(19, 'GymNutrition', '', 'nutrition', 'nutrition-schedule.png', 'Nutrition Schedule', 1, 1, 0, '/gym_master/gym-nutrition/nutrition-list'),
(20, 'GymReservation', '', 'reservation', 'reservation.png', 'Reservation', 1, 1, 1, '/gym_master/gym-reservation/reservation-list'),
(21, 'GymProfile', '', 'account', 'account.png', 'Account', 1, 1, 1, '/gym_master/GymProfile/view_profile'),
(22, 'GymSubscriptionHistory', '', 'subscription_history', 'subscription_history.png', 'Subscription History', 1, 0, 0, '/gym_master/GymSubscriptionHistory/'),
(23, 'Reports', '', 'report', 'report.png', 'Report', 0, 1, 1, '/gym_master/reports/membership-report');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gym_accessright`
--
ALTER TABLE `gym_accessright`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gym_accessright`
--
ALTER TABLE `gym_accessright`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
