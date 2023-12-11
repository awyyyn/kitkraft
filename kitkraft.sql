-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 01:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30 2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitkraft`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `step_id` int(11) NOT NULL,
  `price_amt` decimal(6,2) NOT NULL,
  `ingredient_description` text NOT NULL,
  `ingredient_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_name`, `step_id`, `price_amt`, `ingredient_description`, `ingredient_img`) VALUES
(1, 'Thin Crust', 1, 100.00, 'Super Thin Crispy Crust', 'thin_crust.jpeg'),
(2, 'Thick Crust', 1, 80.00, 'an Inch of Crust', 'thick_crust.jpeg'),
(3, 'Plain Pizza Dough', 1, 50.00, 'Plain only', 'plain_crust.jpeg'),
(4, 'Salsa Sauce', 2, 40.00, 'Salsa Sauce', ''),
(5, 'Cheezy Sauce', 2, 50.00, 'Sauce made of Cheese Fondue', ''),
(6, 'Pesto Sauce', 2, 70.00, 'Green Sauce', ''),
(7, 'Olives', 3, 20.00, 'Sliced Olives', ''),
(8, 'Pepperoni', 3, 30.00, 'Meaty Toppings', ''),
(9, 'Chorizo', 3, 50.00, 'Sliced Meat Sausage', ''),
(10, 'Four Cheese', 3, 100.00, 'made of Mozzarella, Parmegiano Reggiano, Eden Cheese, Blue Cheese', ''),
(11, 'Coca-Cola', 4, 30.00, 'Coca-Cola Soda', ''),
(12, 'All Purpose Dough', 1, 10.00, 'Harina', 'pesto_crust.jpeg'),
(13, 'Sprite', 4, 30.00, 'Sprite lemon Soda', ''),
(14, 'None', 4, 0.00, 'Skip Add Ons', ''),
(15, 'Royal Tru Orange', 4, 30.00, 'Orange', ''),
(16, 'Pesto Dough', 1, 200.00, 'Yucky', 'Overnight Sourdough Herb Pizza Crust.jpeg'),
(18, 'Cheezy Dough', 1, 90.00, 'madaming cheese', 'Cheezy Dough.jpeg'),
(19, 'Pineapple Dough', 1, 300.00, 'pinya yuck', 'Pineapple Dough.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(55) NOT NULL,
  `item_price` float(6,2) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `item_img` varchar(100) NOT NULL,
  `item_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `step_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `material_description` varchar(150) NOT NULL,
  `material_price` float NOT NULL,
  `material_img` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `multi_order`
--

CREATE TABLE `multi_order` (
  `order_step_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `date_ordered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `multi_order`
--

INSERT INTO `multi_order` (`order_step_id`, `step_id`, `ingredient_id`, `user_id`, `order_qty`, `date_ordered`) VALUES
(4, 5, 1, 3, 100, '2023-11-15 06:34:47'),
(5, 5, 2, 3, 100, '2023-11-15 06:34:47'),
(6, 5, 1, 3, 1000, '2023-11-15 06:37:56'),
(7, 5, 1, 3, 2, '2023-11-15 07:46:20'),
(8, 5, 2, 3, 2, '2023-11-15 07:46:20'),
(9, 5, 3, 3, 2, '2023-11-15 07:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `step1` int(11) NOT NULL,
  `step2` int(11) NOT NULL,
  `step3` int(11) NOT NULL,
  `step4` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `date_ordered` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_type` char(1) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `user_address`, `user_type`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'Polangui, Albay', 'A', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `multi_order`
--
ALTER TABLE `multi_order`
  ADD PRIMARY KEY (`order_step_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `multi_order`
--
ALTER TABLE `multi_order`
  MODIFY `order_step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
