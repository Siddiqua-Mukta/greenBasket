-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2025 at 02:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_title` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_title`, `image`) VALUES
(1, 'fruits', 'fruits.png'),
(2, 'vegetables', 'veg.png'),
(3, 'dairy Product', 'dairy.png'),
(4, 'snacks', 'snacks.png'),
(5, 'pantry', 'pantry.png'),
(6, 'Sports', NULL),
(7, 'others', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `address`, `country`, `state`, `zipcode`, `payment`, `total`, `order_date`, `phone`) VALUES
(8, 'kakoli', 'kakoli@gmail.com', 'chattogram', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 400.00, '2025-10-28 14:53:57', '01234556738'),
(9, 'priya', 'priya@gmail.com', 'uttor halishahar, boropool', 'India', 'Dhaka', '4216', 'Nagad', 680.00, '2025-10-28 14:56:16', '01234556738');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(16, 8, 'Guava', 4, 100.00),
(17, 9, 'Pineapple', 4, 170.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `details`, `price`, `image`) VALUES
(26, 'Banana', 1, 'Dress to impress with our premium three-piece suit collection.', 60, '1.webp'),
(27, 'Pineapple', 1, 'Dress to impress with our premium three-piece suit collection.', 170, '2.webp'),
(28, 'Guava', 1, 'Stay effortlessly stylish and comfortable with our classic men&#39;s polo shirt.', 100, '3.webp'),
(29, 'Red Grapes', 1, 'Stay effortlessly stylish and comfortable with our classic men&#39;s polo shirt.', 200, '4.webp'),
(30, 'Malta', 1, 'Stay effortlessly stylish and comfortable with our classic men&#39;s polo shirt.', 180, '5.webp'),
(31, 'Dalim', 1, 'Elevate your everyday look with our versatile men&#39;s shirt collection.', 400, '6.webp'),
(32, 'Apple', 1, 'Elevate your everyday look with our versatile men&#39;s shirt collection.', 350, '7.webp'),
(33, 'Watermelon', 1, 'Make a statement of sophistication with our tailored men&#39;s blazer.', 150, '8.webp'),
(34, 'Potato', 2, 'Make a statement of sophistication with our tailored men&#39;s blazer.', 20, 'veg1.webp'),
(35, 'Papaya', 2, 'Make a statement of sophistication with our tailored men&#39;s blazer.', 75, 'veg10.webp'),
(36, 'Onion', 2, 'Stay cozy and stylish with our modern men&#39;s hoodie, perfect for any occasion.', 70, 'veg3.webp'),
(37, 'Green Chili', 2, 'Stay cozy and stylish with our modern men&#39;s hoodie, perfect for any occasion.', 25, 'veg4.webp'),
(38, 'Garlic', 2, 'Unleash your casual style with our comfortable and durable men&#39;s jeans.', 60, 'veg5.webp'),
(39, 'Coriander', 2, 'Elevate your wardrobe with our versatile trousers, combining comfort, style, and a perfect fit.', 20, 'veg6.webp'),
(40, 'Tomato', 2, 'adv', 30, 'veg7.webp'),
(41, 'Pointed Gourd', 2, 'xxxx', 50, 'veg8.webp'),
(42, 'Aarong Dairy liquid Milk', 3, 'xxx', 100, 'dairy1.webp'),
(43, 'Dano Daily Pusti Milk Powder', 3, 'xxxx', 400, 'dairy2.webp'),
(44, 'Aarong Dairy Chocolate Drink', 3, 'xxxx', 50, 'dairy3.webp'),
(45, 'Aarong Dairy Butter', 3, 'xxx', 210, 'dairy4.webp'),
(46, 'Marks Active School 2 in 1 Chocolate Milk Powder', 3, 'xxx', 400, 'dairy5.webp'),
(47, 'Danish condensed milk', 3, 'sdsxcd', 250, 'dairy6.webp'),
(48, 'Bombay Sweets Premium Gulab Jamun', 3, 'A fun, flared dress perfect for spinning.', 350, 'dairy7.webp'),
(49, 'Shakti+ Strawberry Delight', 3, 'A fun, flared dress perfect for spinning.', 200, 'dairy8.webp'),
(50, 'Walkers Chips', 4, 'Often more formal, suitable for special occasions.\r\n\r\n', 30, 'snacks1.png'),
(51, 'Cookies', 4, 'cvbvn', 100, 'snacks2.png'),
(52, 'Corn Flakes', 4, 'A comfortable, casual dress made from t-shirt material.\r\n\r\n', 250, 'snacks3.png'),
(53, 'Dates', 4, 'A comfortable, casual dress made from t-shirt material.\r\n\r\n', 320, 'snacks4.png'),
(54, 'Cashewnut', 4, 'hsgvcxbn bhd', 200, 'snacks5.png'),
(55, 'Popcorn', 4, 'hjfgtghv nhg v', 50, 'snacks6.png'),
(56, 'Kurkure Chips', 4, 'anbbbbbbbbbbbb', 15, 'snacks7.png'),
(57, 'Oreo Biscuit', 4, 'bbbbbbbbbb', 20, 'snacks8.png\r\n'),
(58, 'Rice', 5, 'ad fd ffff', 90, 'pantry1.jpg'),
(59, 'Soyabin Oil', 5, 'amsndjwd', 100, 'pantry2.jpg'),
(60, 'Red Chili Powder', 5, 'bjhfv', 55, 'pantry3.png'),
(61, 'Sugar', 5, 'dccvvcv', 105, 'pantry4.png'),
(62, 'Turmaric Powder', 5, 'mnjgfvv', 40, 'pantry5.png'),
(63, 'Salt', 5, 'dxcccc', 75, 'pantry6.png'),
(64, 'Olive Oil', 5, 'khug', 130, 'pantry7.jpg'),
(65, 'Coconut Oil', 5, 'bhg', 150, 'pantry8.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`, `token_expiry`, `user_type`, `image`) VALUES
(31, 'ayesha', 'siddiquamukta29@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, 'user', '1.jpeg'),
(32, 'Ayesha', 'ayeshamukta18@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'user', ''),
(33, 'admin', 'admin@gmail.com', '$2y$10$QjzRJFt3guTAFiCXQiH.bu5.Vxmnkn/SSVZcY2TQn5vrjRnbkKd4G', NULL, NULL, 'admin', '4.jfif'),
(34, '', 'xyz@gmail.com', '12345', NULL, NULL, 'user', ''),
(35, '', 'test2@example.com', '$2y$10$7VJ3rN4l4wLzH6k/5EYHVOuKkKZFbZrT3pC27kGzLbN/LwIGV3TnS', NULL, NULL, 'user', ''),
(36, 'Irin', 'israttalebirin@gmail.com', '$2y$10$s2HinW2sZKrmUx4QODmu7egd1CazpT2j3wDHwqTyaODK34mcH878q', NULL, NULL, 'user', ''),
(37, 'priya', 'priya@gmail.com', '$2y$10$iG0qpXfG0/XQm/OFbGqohuyjIUUYQh5zLL1IM.hsMtw1QgUvNPrwu', NULL, NULL, 'user', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
