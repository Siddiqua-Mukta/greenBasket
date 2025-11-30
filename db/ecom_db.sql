-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2025 at 04:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `reset_token`, `token_expiry`) VALUES
(1, 'admin', '$2y$10$SVLJViYq3jp0U/YnYZZQZeg0bN7zBExIzImeHRdjFgOR8ItMRotmy', '7d246825b7da08d281da4ad3391bf5276a5430ea32cec2661503d833fee53cd7e8c74a72c55fb656d3cfdce2e9dd50357d16', '2025-11-24 07:28:34');

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
(1, 'Fruits', 'fruits.png'),
(2, 'Vegetables', 'veg.png'),
(3, 'Dairy Product', 'dairy.png'),
(4, 'Snacks', 'snacks.png'),
(5, 'Pantry', 'pantry.png'),
(8, 'Refrigerated item', 'default.png'),
(10, 'Meat & Fish', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Ayesha Siddiqua', 'ayeshamukta18@gmail.com', 'Is delivery provided nationwide?', '2025-10-27 16:02:13'),
(2, 'Ayesha Siddiqua', 'ayeshamukta18@gmail.com', 'Is delivery provided nationwide?', '2025-10-27 16:03:14'),
(3, 'irin', 'irin@gmail.com', 'hello', '2025-11-05 03:56:14'),
(4, 'kaniz fatema', 'kaniz10@gmail.com', 'Are your products locally sourced?', '2025-11-10 02:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `delivery_type` varchar(50) DEFAULT 'Standard',
  `order_status` varchar(50) DEFAULT 'Pending',
  `total` decimal(10,2) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT 1,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `address`, `country`, `state`, `zipcode`, `payment`, `delivery_type`, `order_status`, `total`, `total_quantity`, `order_date`, `phone`) VALUES
(8, 1, 'kakoli', 'kakoli@gmail.com', 'chattogram', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Standard', 'Pending', 400.00, 1, '2025-10-28 14:53:57', '01234556738'),
(9, 37, 'priya', 'priya@gmail.com', 'uttor halishahar, boropool', 'India', 'Dhaka', '4216', 'Nagad', 'Standard', 'Pending', 680.00, 1, '2025-10-28 14:56:16', '01234556738'),
(10, 1, 'ayesha', 'ayesha@gmail.com', 'uttor halishahar, boropool', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Standard', 'Pending', 345.00, 1, '2025-11-05 03:35:16', '01234567891'),
(11, 38, 'Meer Ahmed', 'meer@gmail.com', 'ctg', 'Bangladesh', 'Dhaka', '1234', 'Cash on delivery', 'Standard', 'Pending', 590.00, 1, '2025-11-05 05:09:40', '01823456567'),
(12, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Standard', 'Pending', 100.00, 1, '2025-11-07 15:53:11', '01823456567'),
(13, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '1234', 'Nagad', 'Standard', 'Pending', 120.00, 1, '2025-11-16 17:27:08', '01823456567'),
(14, 41, 'afrin', 'afrin@gmail.com', 'chadpur, kochuya thana', 'Bangladesh', 'Chittagong', '1234', 'Cash on delivery', 'Standard', 'Pending', 165.00, 1, '2025-11-16 17:42:38', '+8801823456718'),
(15, 41, 'afrin', 'afrin@gmail.com', 'chadpur, kochuya thana', 'Bangladesh', 'Chittagong', '1234', 'Cash on delivery', 'Home Delivery', 'Pending', 100.00, 1, '2025-11-16 17:55:45', '+8801823456718'),
(16, 36, 'irin', 'israttalebirin@gmail.com', 'uttor halishahar, boropool', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Home Delivery', 'Pending', 520.00, 1, '2025-11-17 03:55:40', '01823456567'),
(17, 36, 'Irin', 'israttalebirin@gmail.com', 'boropool, notun para', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Home Delivery', 'Pending', 260.00, 1, '2025-11-19 04:46:08', '01823456567'),
(18, 36, 'Irin', 'israttalebirin@gmail.com', 'boropool, notun para', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Pickup', 'Pending', 800.00, 6, '2025-11-19 04:55:41', '01823456567'),
(19, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '1234', 'Cash on delivery', 'Pickup', 'Pending', 1450.00, 12, '2025-11-20 06:50:30', '+8801823456567'),
(20, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '1234', 'Nagad', 'Home Delivery', 'Pending', 1050.00, 10, '2025-11-20 07:24:43', '+8801823456567'),
(21, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Home Delivery', 'Pending', 340.00, 2, '2025-11-20 15:41:35', '01823456567'),
(22, 36, 'Irin', 'israttalebirin@gmail.com', 'boropool, notun para', 'Bangladesh', 'Chittagong', '4215', 'Cash on delivery', 'Pickup', 'Pending', 170.00, 1, '2025-11-20 15:43:43', '01823456567'),
(23, 39, 'taleb', 'taleb@gmail.com', 'ctg', 'Bangladesh', 'Chittagong', '4216', 'Cash on delivery', 'Home Delivery', 'Pending', 810.00, 6, '2025-11-24 03:57:05', '01823456567'),
(24, 42, 'Kawser Sultana', 'kawsersultana@gmail.com', 'Mirasari,Chattogram', 'Bangladesh', 'Chittagong', '4320', 'Bikash', 'Pickup', 'Pending', 420.00, 3, '2025-11-25 16:03:05', '01850547370');

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
(17, 9, 'Pineapple', 4, 170.00),
(18, 10, 'Onion', 1, 70.00),
(19, 10, 'Green Chili', 1, 25.00),
(20, 10, 'Aarong Dairy Chocolate Drink', 1, 50.00),
(21, 10, 'Red Grapes', 1, 200.00),
(22, 11, 'Popcorn', 1, 50.00),
(23, 11, 'Aarong Dairy Chocolate Drink', 1, 50.00),
(24, 11, 'Banana', 2, 60.00),
(25, 11, 'Guava', 2, 100.00),
(26, 11, 'Pineapple', 1, 170.00),
(27, 12, 'Guava', 1, 100.00),
(28, 13, 'Banana', 2, 60.00),
(29, 14, 'Kurkure Chips', 1, 15.00),
(30, 14, 'Salt', 1, 75.00),
(31, 14, 'Papaya', 1, 75.00),
(32, 15, 'Guava', 1, 100.00),
(33, 16, 'Pineapple', 1, 170.00),
(34, 16, 'Apple', 1, 350.00),
(35, 17, 'Red Grapes', 1, 200.00),
(36, 17, 'Banana', 1, 60.00),
(37, 18, 'Guava', 4, 100.00),
(38, 18, 'Red Grapes', 2, 200.00),
(39, 19, 'Guava', 7, 100.00),
(40, 19, 'Red Grapes', 3, 200.00),
(41, 19, 'Papaya', 2, 75.00),
(42, 20, 'Pineapple', 2, 170.00),
(43, 20, 'Malta', 2, 180.00),
(44, 20, 'Tomato', 5, 30.00),
(45, 20, 'Red Grapes', 1, 200.00),
(46, 21, 'Pineapple', 2, 170.00),
(47, 22, 'Pineapple', 1, 170.00),
(48, 23, 'Guava', 1, 100.00),
(49, 23, 'Tomato', 1, 30.00),
(50, 23, 'Aarong Dairy Butter', 3, 210.00),
(51, 23, 'Aarong Dairy Chocolate Drink', 1, 50.00),
(52, 24, 'Guava', 1, 100.00),
(53, 24, 'Onion', 1, 70.00),
(54, 24, 'Corn Flakes', 1, 250.00);

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
(26, 'Banana', 1, 'Yellow, potassium-rich fruit, excellent quick energy source, versatile snack food.', 60, '1.webp'),
(27, 'Pineapple', 1, 'Tropical, spiky, sweet and tangy fruit; great for juice or dessert.', 170, '2.webp'),
(28, 'Guava', 1, 'Round or oval tropical fruit, highly fragrant, often used in jams.', 100, '3.webp'),
(29, 'Red Grapes', 1, 'Sweet, deep red berries; enjoyed fresh, in wine, or as juice.', 200, '4.webp'),
(30, 'Malta(Sweet Orange)', 1, 'Citrus fruit, juicy and sweet, commonly consumed for vitamin C.', 180, '5.webp'),
(31, 'Dalim(Pomegranate)', 1, 'Red fruit with edible, jewel-like seeds; rich in antioxidants.', 400, '6.webp'),
(32, 'Apple', 1, 'Crisp, nutritious fruit; diverse varieties perfect for eating or baking.', 350, '7.webp'),
(33, 'Watermelon', 1, 'Large, hydrating fruit with sweet red pulp; perfect summer refreshment.', 150, '8.webp'),
(34, 'Potato', 2, 'Starchy, versatile root vegetable; essential for fries, mash, or baking.', 20, 'veg1.webp'),
(35, 'Papaya', 2, 'Soft, sweet, tropical fruit; beneficial for digestion and skin health.', 75, 'veg10.webp'),
(36, 'Onion', 2, 'Pungent vegetable used as a base for flavor in almost all savory dishes.', 70, 'veg3.webp'),
(37, 'Green Chili', 2, 'Small, fiery pepper used to add heat and spice to cooking.', 25, 'veg4.webp'),
(38, 'Garlic', 2, 'Aromatic bulb, fundamental seasoning, known for strong, distinct flavor.', 60, 'veg5.webp'),
(39, 'Coriander(Dhone pata)', 2, 'A herb; leaves and seeds used to garnish and flavor curries.', 20, 'veg6.webp'),
(40, 'Tomato', 2, 'Red, juicy fruit used as a vegetable; essential for salads and sauces.', 30, 'veg7.webp'),
(41, 'Pointed Gourd(Potol)', 2, 'Green vegetable, popular in South Asian curries and stir-fries.', 50, 'veg8.webp'),
(42, 'Aarong Dairy liquid Milk', 3, 'Pasteurized liquid cow\'s milk, ready-to-drink, rich in calcium.', 100, 'dairy1.webp'),
(43, 'Dano Daily Pusti Milk Powder', 3, 'Instant powdered milk, nutritious and great for storage.', 400, 'dairy2.webp'),
(44, 'Aarong Dairy Chocolate Drink', 3, 'Sweetened liquid beverage with a refreshing chocolate flavor.', 50, 'dairy3.webp'),
(45, 'Aarong Dairy Butter', 3, 'Creamy, salted/unsalted dairy product, spread or used for cooking.', 210, 'dairy4.webp'),
(46, 'Marks Active School 2 in 1 Chocolate Milk Powder', 3, 'Fortified milk powder, easy chocolate drink mix for kids.', 400, 'dairy5.webp'),
(47, 'Danish condensed milk', 3, 'Thick, sweet, canned milk; great for desserts and coffee.', 250, 'dairy6.webp'),
(48, 'Bombay Sweets Premium Gulab Jamun', 3, 'Deep-fried milk solids soaked in a sweet, sticky syrup.', 350, 'dairy7.webp'),
(49, 'Shakti+ Strawberry Delight', 3, 'Likely a yogurt or dairy dessert with artificial strawberry flavor.', 200, 'dairy8.webp'),
(50, 'Walkers Chips', 4, 'Popular brand of potato crisps, known for varied, savory flavors.', 30, 'snacks1.png'),
(51, 'Cookies', 4, 'Sweet, baked dough typically containing chocolate chips, nuts, or oats.', 100, 'snacks2.png'),
(52, 'Corn Flakes', 4, 'Toasted flakes of corn, a popular breakfast cereal, usually served with milk.', 250, 'snacks3.png'),
(53, 'Dates', 4, 'Sweet, sticky fruit of the date palm, often dried for extended storage.', 320, 'snacks4.png'),
(54, 'Cashewnut', 4, 'Kidney-shaped edible seed, popular snack, or addition to savory dishes.', 200, 'snacks5.png'),
(55, 'Popcorn', 4, 'Heated corn kernels that puff up; light, crunchy, cinema-favorite snack.', 50, 'snacks6.png'),
(56, 'Kurkure Chips', 4, 'Crunchy, savory extruded snack; distinct texture and spicy seasoning.', 15, 'snacks7.png'),
(57, 'Oreo Biscuit', 4, 'Chocolate sandwich cookies with a sweet, creamy, white filling.', 20, 'snacks8.png\r\n'),
(58, 'Rice', 5, 'Staple grain food, cooked by boiling or steaming, eaten worldwide.', 90, 'pantry1.jpg'),
(59, 'Soyabin Oil', 5, 'Vegetable cooking oil extracted from soybean seeds, light and versatile.', 100, 'pantry2.jpg'),
(60, 'Red Chili Powder', 5, 'Ground dried red chilies, used to add color and fiery heat.', 55, 'pantry3.png'),
(61, 'Sugar', 5, 'Sweet crystalline substance, used extensively for baking and sweetening beverages.', 105, 'pantry4.png'),
(62, 'Turmaric Powder', 5, 'Bright yellow spice, used for color and flavor in South Asian cooking.', 40, 'pantry5.png'),
(63, 'Salt', 5, 'Essential mineral compound, fundamental seasoning used to enhance food flavor.', 75, 'pantry6.png'),
(64, 'Olive Oil', 5, 'Healthy oil extracted from olives, great for salads and low-heat cooking.', 130, 'pantry7.jpg'),
(65, 'Coconut Oil', 5, 'Edible oil extracted from coconuts, used for cooking and personal care.', 120, 'pantry8.png');

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
  `image` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`, `token_expiry`, `user_type`, `image`, `phone`, `address`, `country`, `state`, `zip_code`) VALUES
(31, 'ayesha', 'siddiquamukta29@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, 'user', '1.jpeg', NULL, NULL, NULL, NULL, NULL),
(32, 'Ayesha', 'ayeshamukta18@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'user', '', NULL, NULL, NULL, NULL, NULL),
(33, 'admin', 'admin@gmail.com', '$2y$10$QjzRJFt3guTAFiCXQiH.bu5.Vxmnkn/SSVZcY2TQn5vrjRnbkKd4G', NULL, NULL, 'admin', '4.jfif', NULL, NULL, NULL, NULL, NULL),
(34, '', 'xyz@gmail.com', '12345', NULL, NULL, 'user', '', NULL, NULL, NULL, NULL, NULL),
(35, '', 'test2@example.com', '$2y$10$7VJ3rN4l4wLzH6k/5EYHVOuKkKZFbZrT3pC27kGzLbN/LwIGV3TnS', NULL, NULL, 'user', '', NULL, NULL, NULL, NULL, NULL),
(36, 'Irin', 'israttalebirin@gmail.com', '$2y$10$rMD7j8Z2ZT7yOFPbG648SuKZ.4IwTpxJWE1YLij4TJYQda7ECm8Ke', NULL, NULL, 'user', 'user_36.jpg', '01823456567', 'boropool, notun para', 'Bangladesh', 'Chittagong', '4215'),
(37, 'priya', 'priya@gmail.com', '$2y$10$LHdL/KjLTTsJexYD9tXr3eBXwHpxHGJJzXDrdSegX516sQgsMNl22', NULL, NULL, 'user', 'uploads/profile_pics/pimple face.jpg', NULL, NULL, NULL, NULL, NULL),
(38, 'Meer Ahmed', 'meer@gmail.com', '$2y$10$e7gNPaWG6bDKfdFkevDkJuIl6GGlMBIw1oaIl8F/WcU9E/CXvOAnK', 'a1c51910f70cda1c15fa7185b11fb261ca1ca3405015f22f30f1c6bf5a9b6521f8529f098b216748bfde9d2bf8d23a5e0f5f', '2025-11-05 07:05:40', 'user', '', NULL, NULL, NULL, NULL, NULL),
(39, 'taleb', 'taleb@gmail.com', '$2y$10$DD17E7.IITaa0Dj8a4P1Mura2lm3/.iZmsKW1rdXWg2Mi8OkfmerW', NULL, NULL, 'user', 'user_39.jpg', '01823456567', 'ctg', 'Bangladesh', 'Chittagong', '4216'),
(40, 'israt', 'israt@gmail.com', '$2y$10$qhpHPqC83mY.pNa5IulnKOgbZAd/YtslRYPveFyJswmeAlYxIIpci', NULL, NULL, 'user', '', NULL, NULL, NULL, NULL, NULL),
(41, 'afrin', 'afrin@gmail.com', '$2y$10$SstF4QJ4eUks3n2MpQxSA.rOQC4lHmOfWSQPLGNJxlO0iGCF7VNBK', NULL, NULL, 'user', 'user_41.png', '01823456718', 'chadpur, kochuya thana', NULL, NULL, NULL),
(42, 'Kawser Sultana', 'kawsersultana@gmail.com', '$2y$10$/4KK.g4G0/ObEQl4J/b4sOqig0Hrya8qw0sbxPXtQ/C1Y9RvBng2m', NULL, NULL, 'user', '', '01850547370', 'Mirasari,Chattogram', 'Bangladesh', 'Chittagong', '4320');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
