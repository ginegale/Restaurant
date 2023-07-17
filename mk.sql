-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 05:37 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mk`
--

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL COMMENT 'food code',
  `name` varchar(30) NOT NULL COMMENT 'food name',
  `description` text NOT NULL COMMENT 'food description',
  `price` double NOT NULL COMMENT 'food price',
  `image` varchar(50) NOT NULL COMMENT 'food image path',
  `cat_id` int(11) NOT NULL COMMENT 'food category code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `name`, `description`, `price`, `image`, `cat_id`) VALUES
(1, 'Fried Rice', '-', 65, 'food/image/1_1.jpg', 1),
(2, 'Tonkatsu', 'Fried Pork Cutlet', 120, 'food/image/1_2_1.jpg', 1),
(3, 'Unadon', 'Grilled Eel Rice Bowl', 250, 'food/image/1_3.jpg', 1),
(4, 'Salmon Steak', '-', 200, 'food/image/2_1.jpg', 2),
(5, 'Hamburger', '-', 90, 'food/image/2_2.jpg', 2),
(6, 'Fish and Chips', '-', 100, 'food/image/2_3.jpg', 2),
(7, 'Tomato Soup', '-', 60, 'food/image/3_1.jpg', 3),
(8, 'Salad', '-', 110, 'food/image/3_2.jpg', 3),
(9, 'Veggie Skewers', '-', 70, 'food/image/3_3.jpg', 3),
(10, 'Fig Bread', '-', 45, 'food/image/4_1.jpg', 4),
(11, 'Pancake', '-', 100, 'food/image/4_2.jpg', 4),
(12, 'Strawberry Dessert Cup', '-', 74, 'food/image/4_3.jpg', 4),
(13, 'Shoyu Soba', 'Soba Noodles in Soy Broth', 198, 'food/image/1_4.jpg', 1),
(14, 'Shrimp Pasta', '-', 140, 'food/image/1_5.jpg', 1),
(15, 'Ham Tortellini', 'Pasta', 140, 'food/image/1_6_1.jpg', 1),
(16, 'Carrot Juice', '-', 45, 'food/image/4_4.jpg', 4),
(17, 'Lemon Ginger Tea', '-', 45, 'food/image/4_5.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `food_category`
--

CREATE TABLE `food_category` (
  `id` int(11) NOT NULL COMMENT 'food category code',
  `name` varchar(30) NOT NULL COMMENT 'food category name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `food_category`
--

INSERT INTO `food_category` (`id`, `name`) VALUES
(1, 'Single Dish'),
(2, 'Steak & Fast Food'),
(3, 'Soup & Salad'),
(4, 'Drink & Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `mk_order`
--

CREATE TABLE `mk_order` (
  `id` int(11) NOT NULL COMMENT 'order code',
  `table_no` varchar(30) NOT NULL COMMENT 'table number',
  `status` varchar(30) NOT NULL COMMENT 'order status',
  `insert_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp to new order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mk_order`
--

INSERT INTO `mk_order` (`id`, `table_no`, `status`, `insert_time`) VALUES
(15, '5', 'open', '2023-05-14 03:12:11'),
(17, '3', 'paid', '2023-05-14 04:33:17'),
(18, '1', 'open', '2023-07-17 02:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `mk_order_detail`
--

CREATE TABLE `mk_order_detail` (
  `id` int(11) NOT NULL COMMENT 'code',
  `food_id` int(11) NOT NULL COMMENT 'food code',
  `order_id` int(11) NOT NULL COMMENT 'order code',
  `qty` int(11) NOT NULL COMMENT 'quantity',
  `status` varchar(30) NOT NULL COMMENT 'status',
  `insert_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp to new order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mk_order_detail`
--

INSERT INTO `mk_order_detail` (`id`, `food_id`, `order_id`, `qty`, `status`, `insert_time`) VALUES
(1, 1, 1, 1, 'served', '2023-05-10 16:52:50'),
(2, 2, 1, 1, 'served', '2023-05-10 16:52:57'),
(5, 1, 1, 1, 'served', '2023-05-11 04:19:59'),
(6, 1, 1, 1, 'served', '2023-05-11 04:24:02'),
(87, 7, 1, 1, 'cancel', '2023-05-11 16:06:29'),
(88, 12, 1, 1, 'served', '2023-05-11 16:06:32'),
(89, 8, 1, 1, 'cancel', '2023-05-11 16:06:35'),
(90, 14, 1, 1, 'cancel', '2023-05-11 16:06:43'),
(93, 3, 1, 1, 'cancel', '2023-05-12 02:13:32'),
(94, 2, 1, 1, 'served', '2023-05-12 07:14:26'),
(95, 17, 4, 1, 'confirmed', '2023-05-12 09:14:02'),
(96, 9, 10, 1, 'cancel', '2023-05-13 06:07:10'),
(97, 8, 10, 1, 'cancel', '2023-05-13 06:07:12'),
(98, 11, 11, 1, 'served', '2023-05-13 07:04:59'),
(99, 10, 11, 1, 'served', '2023-05-13 07:05:00'),
(100, 5, 13, 1, 'served', '2023-05-13 11:58:37'),
(101, 6, 13, 1, 'cancel', '2023-05-13 11:58:37'),
(102, 11, 13, 1, 'served', '2023-05-13 11:58:39'),
(103, 9, 14, 1, 'confirmed', '2023-05-13 14:32:54'),
(104, 11, 14, 1, 'confirmed', '2023-05-13 14:32:55'),
(105, 13, 15, 1, 'cancel', '2023-05-14 03:12:17'),
(106, 14, 15, 1, 'served', '2023-05-14 03:12:17'),
(107, 11, 15, 1, 'served', '2023-05-14 03:12:19'),
(108, 8, 15, 1, 'served', '2023-05-14 03:12:22'),
(109, 5, 15, 1, 'served', '2023-05-14 04:02:02'),
(110, 6, 15, 1, 'served', '2023-05-14 04:02:02'),
(111, 1, 16, 1, 'wait_confirm', '2023-05-14 04:10:49'),
(112, 13, 16, 1, 'confirmed', '2023-05-14 04:10:50'),
(113, 14, 16, 1, 'confirmed', '2023-05-14 04:10:50'),
(114, 15, 16, 1, 'confirmed', '2023-05-14 04:10:51'),
(115, 2, 17, 1, 'served', '2023-05-14 04:33:20'),
(116, 15, 17, 1, 'served', '2023-05-14 04:33:20'),
(117, 7, 17, 1, 'served', '2023-05-14 04:33:22'),
(118, 1, 18, 1, 'wait_confirm', '2023-07-17 02:03:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_category`
--
ALTER TABLE `food_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mk_order`
--
ALTER TABLE `mk_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mk_order_detail`
--
ALTER TABLE `mk_order_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'food code', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'food category code', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mk_order`
--
ALTER TABLE `mk_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order code', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mk_order_detail`
--
ALTER TABLE `mk_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'code', AUTO_INCREMENT=119;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
