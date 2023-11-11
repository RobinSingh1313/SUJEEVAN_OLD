-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2023 at 12:05 AM
-- Server version: 5.7.39-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sujeevan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_credentials_master`
--

CREATE TABLE `admin_login_credentials_master` (
  `alcm_id` tinyint(4) NOT NULL,
  `alcm_status` tinyint(4) NOT NULL,
  `alcm_username` char(30) NOT NULL,
  `alcm_password` char(100) NOT NULL,
  `alcm_created_at` datetime NOT NULL,
  `alcm_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login_credentials_master`
--

INSERT INTO `admin_login_credentials_master` (`alcm_id`, `alcm_status`, `alcm_username`, `alcm_password`, `alcm_created_at`, `alcm_updated_at`) VALUES
(1, 1, 'admin', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2021-11-17 11:35:22', '2022-01-05 05:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(255) NOT NULL,
  `b_email` varchar(255) NOT NULL,
  `b_mobile` bigint(20) NOT NULL,
  `b_address` text NOT NULL,
  `b_program` varchar(255) NOT NULL,
  `b_package` varchar(255) DEFAULT NULL,
  `b_plan` varchar(255) DEFAULT NULL,
  `b_message` text NOT NULL,
  `b_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`b_id`, `b_name`, `b_email`, `b_mobile`, `b_address`, `b_program`, `b_package`, `b_plan`, `b_message`, `b_created_on`) VALUES
(1, 'test', 'test@gmail.com', 8888888888, 'testing from svapps', '#', '#', '#', 'test', '2023-02-20 06:55:37'),
(2, 'tharun', 'tharun.svapps@gmail.com', 1234567890, 'gshjk', 'Whight Loss', 'Prevention', '3 MONTHS', 'sdfghj', '2023-02-20 07:02:22'),
(3, 'preethi', 'supriya.aadhya@gmail.com', 9988778899, 'H.no 6-2-280', 'Whight Loss', 'Prevention', '3 MONTHS', 'dddd', '2023-02-20 10:15:24'),
(4, 'tharun', 'tharun.svapps@gmail.com', 123456789, 'dsfgh', 'Whight Loss', 'Prevention', '6 MONTHS', 'ghjk', '2023-02-20 10:47:42'),
(5, 'preethika', 'supriya.aadhya@gmail.com', 9988998899, 'H.no 6-2-280', 'Diabetes care', 'Prevention', '3 MONTHS', '', '2023-02-20 10:49:58'),
(6, 'test', 'test@gmail.com', 8096052513, 'testing from svapps', 'Whight Loss', NULL, NULL, 'test', '2023-02-22 05:54:12'),
(7, 'test', 'test@gmail.com', 8096052513, 'testing from svapps', 'Weight Loss,Cardiac care', NULL, NULL, 'test', '2023-02-22 06:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories_data_postings`
--

CREATE TABLE `main_categories_data_postings` (
  `mcdp_id` bigint(20) NOT NULL,
  `mcdp_category_id` int(11) NOT NULL,
  `mcdp_status` tinyint(4) NOT NULL,
  `mcdp_title` text CHARACTER SET utf8 NOT NULL,
  `mcdp_date_of_post` date NOT NULL,
  `mcdp_image` text NOT NULL,
  `mcdp_post_content` longtext NOT NULL,
  `mcdp_created_at` datetime NOT NULL,
  `mcdp_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_categories_data_postings`
--

INSERT INTO `main_categories_data_postings` (`mcdp_id`, `mcdp_category_id`, `mcdp_status`, `mcdp_title`, `mcdp_date_of_post`, `mcdp_image`, `mcdp_post_content`, `mcdp_created_at`, `mcdp_updated_at`) VALUES
(1, 3, 2, 'svapps 2', '2023-01-19', '7883301674118980.png', '<p>gybubh</p>\r\n', '2023-01-19 14:33:00', '2023-01-19 09:53:47'),
(2, 4, 2, 'test', '2023-01-19', '9109291674119091.jpg', '<p>adsfghjkl</p>\r\n', '2023-01-19 14:34:51', '2023-01-19 09:10:47'),
(3, 2, 1, 'sujeevan', '2023-01-20', '4466381674119793.jpg', '<p>aaaaa</p>\r\n', '2023-01-19 14:46:33', '2023-01-19 09:16:33'),
(4, 1, 1, 'aadhya', '2023-01-21', '2272581674120013.jpg', '<p>dfgdgdg</p>\r\n', '2023-01-19 14:50:13', '2023-01-19 09:20:13'),
(5, 1, 1, 'aadhya2', '2023-01-20', '7048141674120272.jpg', '<p>sssss</p>\r\n', '2023-01-19 14:54:32', '2023-01-19 09:24:32'),
(6, 1, 1, 'aadhya3', '2023-01-20', '4608581674120324.jpg', '<p>uyu</p>\r\n', '2023-01-19 14:55:24', '2023-01-19 09:25:24'),
(7, 3, 2, 'srujana', '2023-01-19', '9093091674120334.jpg', '<p>gfgeafiubuh rewuvriu ugwir</p>\r\n', '2023-01-19 14:55:34', '2023-01-19 09:52:52'),
(8, 1, 1, 'aadhya3', '2023-01-20', '8528621674120396.jpg', '<p>khkhkhkh</p>\r\n', '2023-01-19 14:56:36', '2023-01-19 09:26:36'),
(9, 3, 2, 'shannu', '2023-01-19', '9853371674120402.jpg', '<p>fruits images</p>\r\n', '2023-01-19 14:56:42', '2023-01-19 09:50:33'),
(10, 1, 2, 'aadhya4', '2023-01-20', '8275591674120444.jpg', '<p>khkh</p>\r\n', '2023-01-19 14:57:24', '2023-01-31 08:06:31'),
(11, 3, 2, 'sai', '2023-01-19', '6927191674120490.jpg', '<p>fkbefjbafraf</p>\r\n', '2023-01-19 14:58:10', '2023-01-19 09:49:18'),
(12, 1, 2, 'aadhya4', '2023-01-20', '3123331674120508.jpg', '<p>hjhgjg</p>\r\n', '2023-01-19 14:58:28', '2023-01-19 09:56:23'),
(13, 3, 2, 'sruthi', '2023-01-19', '6703961674120561.jpg', '<p>hgjdtjdjd</p>\r\n', '2023-01-19 14:59:21', '2023-01-19 09:43:29'),
(14, 1, 2, 'aadhya5', '2023-01-20', '6032321674120592.jpg', '<p>te</p>\r\n', '2023-01-19 14:59:52', '2023-01-19 09:44:52'),
(15, 2, 1, 'chinna', '2023-01-20', '3324101674120866.jpg', '<p>dhfff</p>\r\n', '2023-01-19 15:04:26', '2023-01-19 09:34:26'),
(16, 4, 2, 'naresh', '2023-01-19', '3533821674120874.jpeg', '<p>rsgetsehgtrshg</p>\r\n', '2023-01-19 15:04:34', '2023-01-19 09:58:12'),
(17, 4, 2, 'sunil', '2023-01-19', '7520961674120925.jpg', '<p>sfhgstrhrsth</p>\r\n', '2023-01-19 15:05:25', '2023-01-19 09:56:38'),
(18, 2, 2, 'chinna1', '2023-01-20', '4132631674120947.jpg', '<p>kjlkhh</p>\r\n', '2023-01-19 15:05:47', '2023-01-19 09:59:41'),
(19, 4, 1, 'murthy', '2023-03-19', '2366821674120985.jpg', '<p>ergtgtrgtrgtrs</p>\r\n', '2023-01-19 15:06:25', '2023-01-19 09:36:25'),
(20, 2, 2, 'chinna3', '2023-01-20', '6187161674121000.jpg', '<p>kjhkh</p>\r\n', '2023-01-19 15:06:40', '2023-01-19 09:55:11'),
(21, 4, 2, 'shannubaby', '2023-01-19', '3114261674121048.jpg', '<p>erwgtwegtgtr</p>\r\n', '2023-01-19 15:07:28', '2023-01-19 09:55:31'),
(22, 2, 2, 'chinna5', '2023-01-20', '6057781674121118.jpg', '<p>hghfhg</p>\r\n', '2023-01-19 15:08:38', '2023-01-19 09:41:04'),
(23, 4, 2, 'dad', '2023-01-19', '2132441674121140.jpg', '<p>rthryhyhh</p>\r\n', '2023-01-19 15:09:00', '2023-01-19 09:45:35'),
(24, 2, 2, 'chandu', '2023-01-31', '8980631675151965.png', '<p>eavsbclbeabsvibljblb</p>\r\n', '2023-01-31 13:29:25', '2023-02-01 10:13:56'),
(25, 1, 1, 'abc', '2023-01-31', '5089821675161479.jfif', '<p>Regular physical activity is one of the most important things you can do for your health. Being physically active can improve your brain health, help manage weight, reduce the risk of disease, strengthen bones and muscles, and improve your ability to do everyday activities. Adults who sit less and do any amount of moderate-to-vigorous physical activity gain some health benefits. Only a few lifestyle choices have as large an impact on your health as physical activity.</p>\r\n\r\n<p>Everyone can experience the health benefits of physical activity – age, abilities, ethnicity, shape, or size do not matter.</p>\r\n\r\n<p>Some benefits of physical activity on brain health happen right after a session of moderate-to-vigorous physical activity. Benefits include improved thinking or cognition for children 6 to 13 years of age and reduced short-term feelings of anxiety for adults. Regular physical activity can help keep your thinking, learning, and judgment skills sharp as you age. It can also reduce your risk of depression and anxiety and help you sleep better.</p>\r\n\r\n<p>Everyday activities include climbing stairs, grocery shopping, or playing with your grandchildren. Being unable to do everyday activities is called a functional limitation. Physically active middle-aged or older adults have a lower risk of functional limitations than people who are inactive.</p>\r\n\r\n<p>For older adults, doing a variety of physical activity improves physical function and decreases the risk of falls or injury from a fall.</p>\r\n', '2023-01-31 16:07:59', '2023-01-31 10:37:59'),
(26, 3, 1, 'chandu velakanti', '2023-03-03', '6201451675245535.jpg', '<p>chandu is a good boy</p>\r\n', '2023-02-01 15:28:55', '2023-02-01 09:58:55'),
(27, 2, 1, 'chandu velakanti', '2023-03-03', '7927301675245671.jpg', '<p>chandu is a good boy </p>\r\n', '2023-02-01 15:31:11', '2023-02-01 10:01:11'),
(28, 2, 2, 'svapps', '2023-02-07', '6886051675756591.jpg', '<p>Instantly Fix Hundreds of Types of Errors That Other Book <em>Writing</em> Tools Can&#39;t Find. Get the Best <em>Writing</em> Enhancement Tool. See Immediate Results. Try Grammarly Now! Easily Improve Any Text. AI <em>Writing</em> Assistant. Eliminate Grammar Errors. Fix Punctuation Errors.</p>\r\n', '2023-02-07 13:26:31', '2023-02-07 07:57:37'),
(29, 2, 1, 'health and diet', '2023-02-13', '1758411676279978.jpg', '<p><em>Lorem ipsum</em>, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown</p>\r\n', '2023-02-13 14:49:38', '2023-02-13 09:19:38'),
(30, 2, 1, 'testing', '2023-02-13', '3614271676288803.jpg', '<p>We will consult you via our APP for the initial consultation – where we will be discussing about your diet history, medical history, previous history of diet if any, your food psychology and relationship with food, metabolism, hormonal function, current physical activity, Food likes and dislikes, allergy/intolerance.<img alt= src=https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?auto=compress&cs=tinysrgb&w=600></p>\r\n', '2023-02-13 17:16:43', '2023-02-13 11:46:43'),
(31, 5, 1, 'sujeevan', '2023-02-20', '4783071676891592.jfif', '<p>SDFGHJK</p>\r\n', '2023-02-20 04:13:12', '2023-02-20 11:13:12'),
(32, 2, 1, 'final', '2023-02-22', '4786451677045818.jpg', '<p>hsgcjjjjjjjjjwvhklqjdgvcueiufdwgqevchjwvedilcvwehjvcjkbvdsfgwekljegfclkqwveasfnldvqweavsfchjewvefhv23orevcbkwq efcg gcewuvuhwvefuhe wc webdcwehvedhoxvq<img alt= src=https://thumbs.dreamstime.com/b/environment-earth-day-hands-trees-growing-seedlings-bokeh-green-background-female-hand-holding-tree-nature-field-gra-130247647.jpg xss=removed></p>\r\n', '2023-02-21 23:03:38', '2023-02-22 06:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories_information_master`
--

CREATE TABLE `main_categories_information_master` (
  `mcim_id` smallint(6) NOT NULL,
  `mcim_status` tinyint(4) NOT NULL COMMENT '1 -> Active 2 : Inactive',
  `mcim_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mcim_created_at` datetime NOT NULL,
  `mcim_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_categories_information_master`
--

INSERT INTO `main_categories_information_master` (`mcim_id`, `mcim_status`, `mcim_name`, `mcim_created_at`, `mcim_updated_at`) VALUES
(1, 1, 'Health', '2023-01-11 09:46:00', '2023-01-11 08:46:10'),
(2, 1, 'Diet and Nutrition', '2023-01-11 09:46:00', '2023-01-11 08:46:10'),
(3, 1, 'Fitness', '2023-01-11 09:46:00', '2023-01-11 08:46:10'),
(4, 1, 'Wellness', '2023-01-11 09:46:00', '2023-01-11 08:46:10'),
(5, 1, 'Recipes', '2023-02-18 14:37:28', '2023-02-18 09:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_demos`
--

CREATE TABLE `schedule_demos` (
  `sd_id` int(11) NOT NULL,
  `sd_name` varchar(255) NOT NULL,
  `sd_mobile` bigint(20) NOT NULL,
  `sd_email` varchar(255) NOT NULL,
  `sd_time` varchar(255) NOT NULL,
  `sd_date` date NOT NULL,
  `sd_address` text NOT NULL,
  `sd_city` varchar(255) NOT NULL,
  `sd_state` varchar(255) NOT NULL,
  `sd_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_demos`
--

INSERT INTO `schedule_demos` (`sd_id`, `sd_name`, `sd_mobile`, `sd_email`, `sd_time`, `sd_date`, `sd_address`, `sd_city`, `sd_state`, `sd_message`) VALUES
(4, 'surya', 8096052513, 'test@gmail.com', '10:30AM - 11:00AM', '2023-01-12', 'test', 'test', 'test', 'test'),
(5, 'tharun', 2345678901, 'tharun.svapps@gmail.com', '05:30PM - 06:00PM', '2023-02-02', 'warangal', 'warangal', 'telangana', 'hello'),
(6, 'surya', 8096052513, 'surya.svapps@gmail.com', '10:00AM - 10:30AM', '2023-02-04', 'test', 'test', 'test', 'ee'),
(7, 'surya', 8096052513, 'surya.svapps@gmail.com', '10:00AM - 10:30AM', '2023-02-04', 'test', 'test', 'test', 'ee'),
(8, 'surya', 8096052513, 'surya.svapps@gmail.com', '12:00PM - 12:30PM', '2023-02-04', 'Warangal', 'Kazipet', 'Telangana', 'Need appointment'),
(9, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(10, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(11, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(12, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(13, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(14, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(15, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(16, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(17, 'test', 8096052513, 'test@gmail.com', '11:00AM - 11:30AM', '2023-02-09', 'test', 'test', 'test', 'tt'),
(18, 'Supriya', 9933121212, 'supriya.aadhya@gmail.com', '09:30AM - 10:00AM', '2023-02-04', 'H.no 6-2-280', 'Warangal', 'Telangana', 'gdg'),
(19, 'raveena', 0, 'raveena.ravi@gmail.com', '10:30AM - 11:00AM', '2023-02-04', 'H.no 6-2-282', 'Warangal', 'Telangana', 'gfghg'),
(20, 'harini', 0, 'harini123@gmail.com', '09:00AM - 09:30AM', '2023-02-04', 'H.no 6-2-287', 'Warangal', 'Telangana', 'khhkhkhjhj'),
(21, 'hima', 9966332233, 'hima123@gmail.com', '11:00AM - 11:30AM', '2023-02-04', 'H.no 6-2-289', 'Warangal', 'Telangana', 'khkhlh'),
(22, 'Srujana', 986543453, 'srujaaah@gmail.com', '02:30PM - 03:00PM', '2023-02-15', '12-56-767', 'Waranal', 'Telangna', 'srhthrthrd'),
(23, 'kritesh', 8899009988, 'kritesh123@gmail.com', '01:00PM - 01:30PM', '2023-02-04', 'H.no 6-2-289', 'Warangal', 'Telangana', 'sdffasffasf'),
(24, 'Srujana suma', 9656232642, 'srujaaah@gmail.com', '06:30PM - 07:00PM', '2023-02-04', '12-56-767', 'Waranal', 'Telangna', 'hi this'),
(25, 'leela', 7788990099, 'leela123@gmail.com', '12:30PM - 01:00PM', '2023-02-04', 'H.no 6-2-291', 'Warangal', 'Telangana', 'jkhjkhgkhgkghhgj'),
(26, 'raju', 9988009988, 'raju123@gmail.com', '02:00PM - 02:30PM', '2023-02-04', 'H.no 6-2-293', 'Warangal', 'Telangana', 'fdggdfgd'),
(27, 'sai sri', 9656745631, 'saisri@gmail.com', '04:00PM - 04:30PM', '2023-02-09', '2-54-234', 'Waranal', 'Telangna', 'hi this'),
(28, 'srividya', 56345634563456435, 'srividya@gmail.com', '06:30PM - 07:00PM', '2023-02-10', '12-3-3333', 'Waranal', 'Telangna', 'hi this'),
(29, 'srividya', 7676573756757, 'srividya@gmai.com', '09:00AM - 09:30AM', '2023-02-05', '2-54-234', 'Waranal', 'Telangna', 'hi this'),
(30, 'Dev', 9786375376, 'Dev@gmail.com', '03:00PM - 03:30PM', '2023-02-04', '12-56-767', 'Waranal', 'Telangna', 'this is Dev'),
(31, 'karuna', 9856456465, 'karuna@gmail.com', '09:30AM - 10:00AM', '2023-02-05', '12-56-767', 'Waranal', 'Telangna', 'this is karuna'),
(32, 'pallavi', 85674543536, 'pallavi@gmail.com', '10:30AM - 11:00AM', '2023-02-05', '12-56-78', 'Waranal', 'Telangna', 'this is karuna'),
(33, 'DEVI', 9456345634, 'DEVI@gamil.com', '10:00AM - 10:30AM', '2023-02-05', '12-3-3333', 'Waranal', 'Telangna', 'ftergreg'),
(34, 'tharun', 1324567890, 'tharun.svapps@gmail.com', '09:00AM - 09:30AM', '2023-02-10', 'wgl', 'wgl', 'telangana', 'sfdghjk'),
(35, 'sss', 762309573457, 'srividya@gmail.com', '09:00AM - 09:30AM', '2023-02-20', '12-56-767', 'Waranal', 'Telangna', 'rgtrgtg grtgrt'),
(36, 'kalyani', 762309573457, 'srividya@gmail.com', '10:00AM - 10:30AM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', 'rgtrgtg grtgrt'),
(37, 'shreshta', 9746532543, 'shreshta@gmail.com', '10:00AM - 10:30AM', '2023-02-20', '12-56-767', 'Waranal', 'Telangna', 'gtrhthtyythytj'),
(38, 'shreshta', 974653254345, 'shreshta@gmail.com', '09:00AM - 09:30AM', '2023-02-21', '12-56-769', 'Waranal', 'Telangna', 'gtrhthtyythytj'),
(39, 'shreshtaaa', 974653254345, 'shreshta1@gmail.com', '09:00AM - 09:30AM', '2023-02-22', '12-56-763', 'Waranal', 'Telangna', 'gtrhthtyythytj'),
(40, 'shreshtaaaq', 974653254345, 'shreshta1@gmail.com', '10:00AM - 10:30AM', '2023-02-22', '12-56-763', 'Waranal', 'Telangna', 'gtrhthtyythytj'),
(41, 'shreshtaaaq', 974653254345, 'shreshta1@gmail.com', '09:30AM - 10:00AM', '2023-02-22', '2-54-234', 'Waranal', 'Telangna', ''),
(42, 'shreshtaaaq', 974653254345, 'shreshta1@gmail.com', '10:30AM - 11:00AM', '2023-02-22', '2-54-234', 'Waranal', 'Telangna', ''),
(43, 'honey', 7456546464, 'shreshta122@gmail.com', '10:00AM - 10:30AM', '2023-02-22', '2-54-234', 'Waranal', 'Telangna', 'ghgfhfhgf'),
(44, 'supraba', 7456546, 'shreshta1@gmail.com', '11:00AM - 11:30AM', '2023-02-22', '2-54-234', 'Waranal', 'Telangna', 'ghgfhfhgf'),
(45, 'suprabaq', 7456546, 'shreshta1@gmail.com', '12:00PM - 12:30PM', '2023-02-22', '2-54-234', 'Waranal', 'Telangna', 'ghgfhfhgf'),
(46, 'sneha', 75645654646, 'sneha@gmail.com', '09:30AM - 10:00AM', '2023-02-21', '12-56-769', 'Waranal', 'Telangna', 're 5 y6 66thhhhhhhnhn'),
(47, 'snehaqq', 75645654646, 'sneha@gmail.com', '10:30AM - 11:00AM', '2023-02-21', '12-56-769', 'Waranal', 'Telangna', 're 5 y6 66thhhhhhhnhn'),
(48, 'snehaqq', 745655, 'sneha1@gmail.com', '11:00AM - 11:30AM', '2023-02-21', '12-56-769', 'Waranal', 'Telangna', 're 5 y6 66thhhhhhhnhn'),
(49, 'sushamth', 765348483, 'sushanth@gmail.com', '12:00PM - 12:30PM', '2023-02-21', '12-56-78', 'Waranal', 'Telangna', ''),
(50, 'nchcgc', 76534, 'gfhhhj@gmail.com', '12:30PM - 01:00PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', 'jhyjyj'),
(51, 'sumalatha', 7874626262525, 'sumalatha@gmail.com', '01:00PM - 01:30PM', '2023-02-21', '12-56-78', 'Waranal', 'Telangna', 'jffgfs ygfysfyfg owaefggw'),
(52, 'sumalatha', 7874626262525, 'sumalatha@gmail.com', '01:30PM - 02:00PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', ''),
(53, 'susrty', 7872, 'shreshta1@gmail.com', '02:00PM - 02:30PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', 'hfytt'),
(54, 'swathi', 7872, 'swathi@gmail.com', '02:30PM - 03:00PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', 'hfytt'),
(55, 'swathik', 7872, 'swathik@gmail.com', '03:00PM - 03:30PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', ''),
(56, 'swathik', 7872, 'swathik@gmail.com', '03:30PM - 04:00PM', '2023-02-21', '12-56-767', 'Waranal', 'Telangna', 'njhjcf'),
(57, 'shreshtaaaq', 6756, 'swathik@gmail.com', '04:00PM - 04:30PM', '2023-02-21', '2-54-234', 'Waranal', 'Telangna', 'njhjcf'),
(58, 'sree', 9223372036854775807, 'supriya.aadhya@gmail.com', '12:30PM - 01:00PM', '2023-02-22', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fsfdsdffdsfds'),
(59, 'laya', 9988009988, 'laya.1990@gmail.com', '09:30AM - 10:00AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fvfvvfvfvfffd'),
(60, 'laya', 9988009988, 'laya.1990@gmail.com', '09:30AM - 10:00AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fvfvvfvfvfffd'),
(61, 'lasya', 9900889988, 'lasya1990@gmail.com', '01:00PM - 01:30PM', '2023-02-22', 'H.no 6-2-280', 'Warangal', 'Telangana', ''),
(63, 'rajesh', 1234567890, 'tharun.svapps@gmail.com', '09:30AM - 10:00AM', '2023-02-10', 'warangal', 'Telangana ', 'Telangana ', 'hi'),
(64, 'test', 8096052513, 'test@gmail.com', '03:30PM - 04:00PM', '2023-02-22', 'test', 'test', 'Telangana', 'test'),
(65, 'test', 8096052513, 'test@gmail.com', '05:30PM - 06:00PM', '2023-02-21', 'test', 'test', 'test', 'test'),
(66, 'lathika', 9988778899, 'laya.1990@gmail.com', '09:00AM - 09:30AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fvdfgfgf'),
(67, 'keerthi', 9223372036854775807, 'keerthi123@gmail.com', '10:00AM - 10:30AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'dsffds'),
(68, 'deepika', 9988778899, 'deepika123@gmial.com', '10:30AM - 11:00AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'ffgdgf'),
(69, 'test', 8096052513, 'surya.svapps@gmail.com', '06:30PM - 07:00PM', '2023-02-16', 'test', 'test', 'test', 'testing from svapps'),
(70, 'pooja', 9988009988, 'pooja123@gmail.com', '11:00AM - 11:30AM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'dfff'),
(71, 'gay', 8899889988, 'gay123@gmail.com', '01:00PM - 01:30PM', '2023-02-25', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fdffddffd'),
(72, 'test', 8096052513, 'surya.svapps@gmail.com', '10:30AM - 11:00AM', '2023-02-28', 'test', 'test', 'test', 'test'),
(73, 'sudha', 8899009988, 'sudha123@gmail.com', '09:00AM - 09:30AM', '2023-02-25', 'H.no 6-2-280', 'Warangal', 'Telangana', 'fdsddssdf'),
(74, 'supi', -9900889900, 'laya.1990@gmail.com', '12:00PM - 12:30PM', '2023-02-23', 'H.no 6-2-280', 'Warangal', 'Telangana', 'ddss'),
(75, 'test', 8096052513, 'test@gmail.com', '12:30PM - 01:00PM', '2023-02-28', 'test', 'test', 'test', 'test'),
(76, 'test', 8096052513, 'surya.svapps@gmail.com', '12:30PM - 01:00PM', '2023-02-23', 'test', 'test', 'test', 'test'),
(77, 'test', 8096052513, 'surya.svapps@gmail.com', '01:30PM - 02:00PM', '2023-02-24', 'test', 'test', 'test', 'test'),
(78, 'test', 8096052513, 'surya.svapps@gmail.com', '03:00PM - 03:30PM', '2023-02-23', 'test', 'test', 'test', 'test'),
(79, 'test', 8096052513, 'suryaprakashttt12@gmail.com', '04:00PM - 04:30PM', '2023-02-24', 'test', 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `s_email` varchar(255) NOT NULL,
  `s_mobile` bigint(20) NOT NULL,
  `s_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`s_id`, `s_name`, `s_email`, `s_mobile`, `s_date`) VALUES
(1, 'surya', 'surya.svapps@gmail.com', 8096052513, '2023-02-04'),
(2, 'tharun', 'tharun.svapps@gmail.com', 1234568790, '2023-02-04'),
(3, 'supriya', 'supriya.svapps@gmail.com', 9398810933, '2023-02-04'),
(4, 'tharun', 'tharun.svapps@gmail.com', 1234567890, '2023-02-09'),
(5, 'chandu', 'vchandu@gmail.com', 98765432111, '2023-02-18'),
(6, 'chandu', 'vchandu@gmail.com', 98765432111, '2023-02-18'),
(7, 'chandu', 'vchandu@gmail.com', 98765432111, '2023-02-18'),
(8, 'supriya', 'supriya.svapps@gmail.com', 9398810933, '2023-02-18'),
(9, 'sukntay', 'suntay@gmail.com', 8674454454, '2023-02-20'),
(10, 'tharun', 'tharun.svapps@gmail.com', 1234567890, '2023-02-20'),
(11, 'tharun', 'tharun.svapps@gmail.com', 1234567890, '2023-02-20'),
(12, 'aadhya', 'supriya.svapps@gmail.com', 9398810933, '2023-02-22'),
(13, 'supriya', 'supriya.svapps@gmail.com', 9988998877, '2023-02-22'),
(14, 'surya', 'surya.svapps@gmail.com', 8096052513, '2023-02-22'),
(15, 'surya', 'test@gmail.com', 1111111111, '2023-02-22'),
(16, 'surya', 'surya.svapps@gmail.com', 2323232323, '2023-02-22');

-- --------------------------------------------------------

--
-- Table structure for table `website_contacts_information_master`
--

CREATE TABLE `website_contacts_information_master` (
  `wcim_id` bigint(20) NOT NULL,
  `wcim_name` varchar(255) NOT NULL,
  `wcim_mobile` bigint(20) NOT NULL,
  `wcim_email` varchar(255) NOT NULL,
  `wcim_message` text NOT NULL,
  `wcim_city` varchar(255) DEFAULT NULL,
  `wcim_state` varchar(255) DEFAULT NULL,
  `wcim_profile_photo` text,
  `wcim_medical_report` text,
  `wcim_dept` varchar(255) DEFAULT NULL,
  `wcim_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `website_contacts_information_master`
--

INSERT INTO `website_contacts_information_master` (`wcim_id`, `wcim_name`, `wcim_mobile`, `wcim_email`, `wcim_message`, `wcim_city`, `wcim_state`, `wcim_profile_photo`, `wcim_medical_report`, `wcim_dept`, `wcim_created_at`) VALUES
(6, 'jonu', 9988778899, 'supriya.aadhya@gmail.com', 'dffds', 'Warangal', 'Telangana', 'mrg4-removebg-preview_(1).png', 'icons8-potted-plant-emoji-16.png', '#', '2023-02-18 10:04:47'),
(7, 'chandu demo ', 9876543211, 'vchandusvapps@gamil.com', 'aswsdc', 'chityal', 'telangana', 'index.html', 'index1.html', NULL, '2023-02-18 10:06:16'),
(8, 'chandu demo ', 9876543211, 'vchandusvapps@gamil.com', 'aswsdc', 'chityal', 'telangana', 'index2.html', 'index3.html', NULL, '2023-02-18 10:06:17'),
(9, 'Nataly', 21, 'natalykomovawrites@gmail.com', 'Hi\r\n\r\nBy way of an introduction, I am a freelance writer and expert contributor for several magazines and blogs. I am presently aiming to build up my online presence, and would therefore, like to offer you to write some expert articles for your blog on sujeevanhealth.com (free of charge).\r\n\r\nIf you are interested, please send me up to five topics that you would like me to cover. It will take me around a week or maybe less to write up the articles.\r\n\r\nI look forward to hearing from you. Please ensure that you copy in my personal email in your reply, as sometimes, my work emails tend to go to the spam folder: natalykomova1992@gmail.com\r\n\r\nKind regards\r\n\r\nNataly Komova', 'Payerne', 'NA', NULL, NULL, '#', '2023-02-20 13:34:52'),
(10, 'Sharon', 7314389711, 'sharon@livealltheway.com', 'Hi there,\r\n\r\nCan I write for your website on how to turn a mid-life crisis into a good thing? I’ll offer tips and guidance on how to use a mid-life crisis as a time of growth and renewal--helping people find inspiration and positivity. \r\n\r\nPlease let me know if you’re interested, and if so, I’ll get started on the article.\r\n\r\nThank you so much!\r\nSharon Redd\r\nLive All The Way\r\n\r\n\r\nP.S. If you’re interested but would prefer an article on a different topic, please let me know. I’m happy to accommodate! That said, please just let me know if you don’t want to hear from me again.', 'Memphis', 'TN', NULL, NULL, '#', '2023-02-21 02:21:29'),
(11, 'Sharon', 7314389711, 'sharon@livealltheway.com', 'Hi there,\r\n\r\nCan I write for your website on how to turn a mid-life crisis into a good thing? I’ll offer tips and guidance on how to use a mid-life crisis as a time of growth and renewal--helping people find inspiration and positivity. \r\n\r\nPlease let me know if you’re interested, and if so, I’ll get started on the article.\r\n\r\nThank you so much!\r\nSharon Redd\r\nLive All The Way\r\n\r\n\r\nP.S. If you’re interested but would prefer an article on a different topic, please let me know. I’m happy to accommodate! That said, please just let me know if you don’t want to hear from me again.', 'Memphis', 'TN', NULL, NULL, '#', '2023-02-21 02:22:37'),
(12, 'Sharon', 7314389711, 'sharon@livealltheway.com', 'Hi there,\r\n\r\nCan I write for your website on how to turn a mid-life crisis into a good thing? I’ll offer tips and guidance on how to use a mid-life crisis as a time of growth and renewal--helping people find inspiration and positivity. \r\n\r\nPlease let me know if you’re interested, and if so, I’ll get started on the article.\r\n\r\nThank you so much!\r\nSharon Redd\r\nLive All The Way\r\n\r\n\r\nP.S. If you’re interested but would prefer an article on a different topic, please let me know. I’m happy to accommodate! That said, please just let me know if you don’t want to hear from me again.', 'Memphis', 'TN', NULL, NULL, '#', '2023-02-21 02:22:40'),
(13, 'Sharon', 7314389711, 'sharon@livealltheway.com', 'Hi there,\r\n\r\nCan I write for your website on how to turn a mid-life crisis into a good thing? I’ll offer tips and guidance on how to use a mid-life crisis as a time of growth and renewal--helping people find inspiration and positivity. \r\n\r\nPlease let me know if you’re interested, and if so, I’ll get started on the article.\r\n\r\nThank you so much!\r\nSharon Redd\r\nLive All The Way\r\n\r\n\r\nP.S. If you’re interested but would prefer an article on a different topic, please let me know. I’m happy to accommodate! That said, please just let me know if you don’t want to hear from me again.', 'Memphis', 'TN', NULL, NULL, '#', '2023-02-21 02:22:57'),
(14, 'Mike Mathews\r\n', 0, 'no-replyAround@gmail.com', 'Hi there \r\n \r\nI Just checked your sujeevanhealth.com ranks and saw that your site is trending down for some time. \r\n \r\nIf you are looking for a trend reversal, we have the right solution for you \r\n \r\nWe are offering affordable Content Marketing plans with humanly written SEO content \r\n \r\nFor more information, please check our offers \r\nhttps://www.digital-x-press.com/product/content-marketing/ \r\n \r\nThanks and regards \r\nMike Mathews\r\n', 'Boston', 'United States', NULL, NULL, '#', '2023-02-21 10:41:48'),
(15, 'tharun', 123456782, 'tharun.svapps@gmail.com', 'hj', 'warangal', 'telangan', NULL, NULL, NULL, '2023-02-22 05:56:03'),
(16, 'Roberttoord', 0, 'michaelrp62@gmail.com', 'Hi. I\'m reaching out to see whether you’ve applied for the covid-related Employee Retention Tax Credit? This credit is worth up to $26k per employee, and you *can* qualify for both this and PPP (the rules changed Nov 2021).  We can help you maximize this credit and have already done this for more than 250 businesses. All our work is free until you receive a refund. Give us a call at 888-479-6055 or email hello@refundspro.com for more info.', 'Avarua', 'Cook Islands', NULL, NULL, '#', '2023-02-22 06:16:53'),
(17, 'jonu', 998899009990000, 'supriya.aadhya@gmail.com', 'ggfgf', 'Warangal', 'Telangana', 'mrg4-removebg-preview_(1)1.png', 'xyz_(1).jpg', '#', '2023-02-22 06:22:22'),
(18, 'pandu', 1234567890, 'pandu@gmail.com', 'hi', 'warangal', 'Telangana ', NULL, NULL, NULL, '2023-02-22 06:26:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login_credentials_master`
--
ALTER TABLE `admin_login_credentials_master`
  ADD PRIMARY KEY (`alcm_id`),
  ADD UNIQUE KEY `alcm_username` (`alcm_username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `main_categories_data_postings`
--
ALTER TABLE `main_categories_data_postings`
  ADD PRIMARY KEY (`mcdp_id`),
  ADD KEY `mcdp` (`mcdp_date_of_post`,`mcdp_id`);

--
-- Indexes for table `main_categories_information_master`
--
ALTER TABLE `main_categories_information_master`
  ADD PRIMARY KEY (`mcim_id`),
  ADD UNIQUE KEY `mcim_name` (`mcim_name`),
  ADD KEY `mcim` (`mcim_status`);

--
-- Indexes for table `schedule_demos`
--
ALTER TABLE `schedule_demos`
  ADD PRIMARY KEY (`sd_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `website_contacts_information_master`
--
ALTER TABLE `website_contacts_information_master`
  ADD PRIMARY KEY (`wcim_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login_credentials_master`
--
ALTER TABLE `admin_login_credentials_master`
  MODIFY `alcm_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `main_categories_data_postings`
--
ALTER TABLE `main_categories_data_postings`
  MODIFY `mcdp_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `main_categories_information_master`
--
ALTER TABLE `main_categories_information_master`
  MODIFY `mcim_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule_demos`
--
ALTER TABLE `schedule_demos`
  MODIFY `sd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `website_contacts_information_master`
--
ALTER TABLE `website_contacts_information_master`
  MODIFY `wcim_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
