-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 05:35 AM
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
(6, 'Meats', '1765362574_meats.png'),
(7, 'Fishes', '1765365278_fish.png'),
(8, 'Pastry', '1765371500_pastry.png'),
(9, 'Frozen', '1765374277_frozen.webp');

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
(3, 'irin', 'irin@gmail.com', 'hello', '2025-11-05 03:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `delivery_type` varchar(50) DEFAULT 'Standard',
  `shipping_tracking_number` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `total` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT 0.00,
  `vendor_receive_amount` decimal(10,2) DEFAULT 0.00,
  `total_quantity` int(11) DEFAULT 1,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `vendor_id`, `name`, `email`, `address`, `country`, `state`, `zipcode`, `payment`, `delivery_type`, `shipping_tracking_number`, `notes`, `order_status`, `payment_status`, `total`, `commission`, `vendor_receive_amount`, `total_quantity`, `order_date`, `phone`) VALUES
(1, 1, 0, 'Irin', 'israttalebirin@gmail.com', 'halishahar,boropool,notun para, chattogram', 'Bangladesh', 'Chittagong', '4115', 'Cash on delivery', 'Home Delivery', NULL, NULL, 'Pending', 'pending', 180.00, 0.00, 0.00, 3, '2025-12-09 05:14:50', '01823456567'),
(2, 2, 0, 'kohinoor', 'kohinoor@gmail.com', 'uttor halishahar, boropool', 'Bangladesh', 'Chattogram', '4115', 'Cash on delivery', 'Home Delivery', NULL, NULL, 'Pending', 'pending', 400.00, 0.00, 0.00, 3, '2025-12-09 18:29:48', '01823456567'),
(3, 3, 0, 'Ayesha Siddiqua', 'siddiquamukta29@gmail.com', 'Mirasari,Chattogram', 'Bangladesh', 'Chattogram', '4307', 'Bikash', 'Pickup', NULL, NULL, 'Pending', 'pending', 270.00, 0.00, 0.00, 2, '2025-12-10 06:09:18', '01850547370'),
(4, 3, 0, 'Ayesha Siddiqua', 'siddiquamukta29@gmail.com', 'Mirasari,Chattogram', 'Bangladesh', 'Chattogram', '4307', 'Bikash', 'Home Delivery', NULL, NULL, 'Pending', 'pending', 580.00, 0.00, 0.00, 2, '2025-12-10 06:10:10', '01850547370'),
(5, 3, 0, 'Ayesha Siddiqua', 'siddiquamukta29@gmail.com', 'Mirasari,Chattogram', 'Bangladesh', 'Chattogram', '4307', 'Nagad', 'Pickup', NULL, NULL, 'Pending', 'pending', 250.00, 0.00, 0.00, 1, '2025-12-10 14:23:38', '01850547370');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(200) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price_per_item` decimal(10,2) GENERATED ALWAYS AS (`quantity` * `price`) STORED,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `commission` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `vendor_id`, `quantity`, `price`, `status`, `commission`) VALUES
(1, 1, 26, NULL, 1, 60.00, 'pending', 0.00),
(2, 1, 34, NULL, 1, 20.00, 'pending', 0.00),
(3, 1, 42, NULL, 1, 100.00, 'pending', 0.00),
(4, 2, 26, NULL, 1, 60.00, 'pending', 0.00),
(5, 2, 27, NULL, 2, 170.00, 'pending', 0.00),
(6, 3, 27, NULL, 1, 170.00, 'pending', 0.00),
(7, 3, 28, NULL, 1, 100.00, 'pending', 0.00),
(8, 4, 30, NULL, 1, 180.00, 'pending', 0.00),
(9, 4, 31, NULL, 1, 400.00, 'pending', 0.00),
(10, 5, 66, NULL, 1, 250.00, 'pending', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(20) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `commission` decimal(10,2) DEFAULT 0.00,
  `stock` int(11) DEFAULT 0,
  `low_stock_threshold` int(11) DEFAULT 5,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=active,0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `vendor_id`, `details`, `price`, `commission`, `stock`, `low_stock_threshold`, `status`, `created_at`, `image`) VALUES
(26, 'Banana', 1, NULL, 'Yellow, potassium-rich fruit, excellent quick energy source, versatile snack food.', 60, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '1.webp'),
(27, 'Pineapple', 1, NULL, 'Tropical, spiky, sweet and tangy fruit; great for juice or dessert.', 170, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '2.webp'),
(28, 'Guava', 1, NULL, 'Round or oval tropical fruit, highly fragrant, often used in jams.', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '3.webp'),
(29, 'Red Grapes', 1, NULL, 'Sweet, deep red berries; enjoyed fresh, in wine, or as juice.', 200, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '4.webp'),
(30, 'Malta(Sweet Orange)', 1, NULL, 'Citrus fruit, juicy and sweet, commonly consumed for vitamin C.', 180, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '5.webp'),
(31, 'Dalim(Pomegranate)', 1, NULL, 'Red fruit with edible, jewel-like seeds; rich in antioxidants.', 400, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '6.webp'),
(32, 'Apple', 1, NULL, 'Crisp, nutritious fruit; diverse varieties perfect for eating or baking.', 350, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '7.webp'),
(33, 'Watermelon', 1, NULL, 'Large, hydrating fruit with sweet red pulp; perfect summer refreshment.', 150, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '8.webp'),
(34, 'Potato', 2, NULL, 'Starchy, versatile root vegetable; essential for fries, mash, or baking.', 20, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg1.webp'),
(35, 'Papaya', 2, NULL, 'Soft, sweet, tropical fruit; beneficial for digestion and skin health.', 75, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg10.webp'),
(36, 'Onion', 2, NULL, 'Pungent vegetable used as a base for flavor in almost all savory dishes.', 70, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg3.webp'),
(37, 'Green Chili', 2, NULL, 'Small, fiery pepper used to add heat and spice to cooking.', 25, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg4.webp'),
(38, 'Garlic', 2, NULL, 'Aromatic bulb, fundamental seasoning, known for strong, distinct flavor.', 60, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg5.webp'),
(39, 'Coriander(Dhone pata)', 2, NULL, 'A herb; leaves and seeds used to garnish and flavor curries.', 20, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg6.webp'),
(40, 'Tomato', 2, NULL, 'Red, juicy fruit used as a vegetable; essential for salads and sauces.', 30, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg7.webp'),
(41, 'Pointed Gourd(Potol)', 2, NULL, 'Green vegetable, popular in South Asian curries and stir-fries.', 50, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'veg8.webp'),
(42, 'Aarong Dairy liquid Milk', 3, NULL, 'Pasteurized liquid cow\'s milk, ready-to-drink, rich in calcium.', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy1.webp'),
(43, 'Dano Daily Pusti Milk Powder', 3, NULL, 'Instant powdered milk, nutritious and great for storage.', 400, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy2.webp'),
(44, 'Aarong Dairy Chocolate Drink', 3, NULL, 'Sweetened liquid beverage with a refreshing chocolate flavor.', 50, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy3.webp'),
(45, 'Aarong Dairy Butter', 3, NULL, 'Creamy, salted/unsalted dairy product, spread or used for cooking.', 210, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy4.webp'),
(46, 'Marks Active School 2 in 1 Chocolate Milk Powder', 3, NULL, 'Fortified milk powder, easy chocolate drink mix for kids.', 400, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy5.webp'),
(47, 'Danish condensed milk', 3, NULL, 'Thick, sweet, canned milk; great for desserts and coffee.', 250, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy6.webp'),
(48, 'Bombay Sweets Premium Gulab Jamun', 3, NULL, 'Deep-fried milk solids soaked in a sweet, sticky syrup.', 350, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy7.webp'),
(49, 'Shakti+ Strawberry Delight', 3, NULL, 'Likely a yogurt or dairy dessert with artificial strawberry flavor.', 200, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'dairy8.webp'),
(50, 'Walkers Chips', 4, NULL, 'Popular brand of potato crisps, known for varied, savory flavors.', 30, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks1.png'),
(51, 'Cookies', 4, NULL, 'Sweet, baked dough typically containing chocolate chips, nuts, or oats.', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks2.png'),
(52, 'Corn Flakes', 4, NULL, 'Toasted flakes of corn, a popular breakfast cereal, usually served with milk.', 250, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks3.png'),
(53, 'Dates', 4, NULL, 'Sweet, sticky fruit of the date palm, often dried for extended storage.', 320, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks4.png'),
(54, 'Cashewnut', 4, NULL, 'Kidney-shaped edible seed, popular snack, or addition to savory dishes.', 200, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks5.png'),
(55, 'Popcorn', 4, NULL, 'Heated corn kernels that puff up; light, crunchy, cinema-favorite snack.', 50, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks6.png'),
(56, 'Kurkure Chips', 4, NULL, 'Crunchy, savory extruded snack; distinct texture and spicy seasoning.', 15, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks7.png'),
(57, 'Oreo Biscuit', 4, NULL, 'Chocolate sandwich cookies with a sweet, creamy, white filling.', 20, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'snacks8.png\r\n'),
(58, 'Rice', 5, NULL, 'Staple grain food, cooked by boiling or steaming, eaten worldwide.', 90, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry1.jpg'),
(59, 'Soyabin Oil', 5, NULL, 'Vegetable cooking oil extracted from soybean seeds, light and versatile.', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry2.jpg'),
(60, 'Red Chili Powder', 5, NULL, 'Ground dried red chilies, used to add color and fiery heat.', 55, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry3.png'),
(61, 'Sugar', 5, NULL, 'Sweet crystalline substance, used extensively for baking and sweetening beverages.', 105, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry4.png'),
(62, 'Turmaric Powder', 5, NULL, 'Bright yellow spice, used for color and flavor in South Asian cooking.', 40, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry5.png'),
(63, 'Salt', 5, NULL, 'Essential mineral compound, fundamental seasoning used to enhance food flavor.', 75, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry6.png'),
(64, 'Olive Oil', 5, NULL, 'Healthy oil extracted from olives, great for salads and low-heat cooking.', 130, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry7.jpg'),
(65, 'Coconut Oil', 5, NULL, 'Edible oil extracted from coconuts, used for cooking and personal care.', 150, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pantry8.png'),
(66, 'Raw full Chicken', 6, NULL, '', 250, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat1.webp'),
(67, 'Breast piece', 6, NULL, '', 150, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat2.png'),
(68, 'Drumstick', 6, NULL, '', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat3.png'),
(69, 'Leg piece', 6, NULL, '', 120, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat4.png'),
(70, 'Chicken liver', 6, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat5.png'),
(71, 'Beef Steak', 6, NULL, '', 400, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat6.png'),
(72, 'Beef liver', 6, NULL, '', 450, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat7.png'),
(73, 'Beef Kidney', 6, NULL, '', 400, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat8.webp'),
(74, 'Beef Kima', 6, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat9.png'),
(75, 'Beef Lungs', 6, NULL, '', 600, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat10.png'),
(76, 'Goat meat', 6, NULL, '', 500, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'meat11.png'),
(77, 'Prawn', 7, NULL, '', 1000, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish1.webp'),
(78, 'Pomfret', 7, NULL, '', 460, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish2.webp'),
(79, 'Carp', 7, NULL, '', 350, 0.00, 0, 5, 1, '2025-12-11 03:27:21', '1765370519_fish3.webp'),
(80, 'Tilapia', 7, NULL, '', 320, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish4.png'),
(81, 'Salmon', 7, NULL, '', 380, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish5.png'),
(82, 'Tuna', 7, NULL, '', 420, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish6.png'),
(83, 'Climbing perch (Koi mach)', 7, NULL, '', 280, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish7.png'),
(84, 'Mystus (Tengra)', 7, NULL, '', 260, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish8.png'),
(85, 'Barbs (Puti mach)', 7, NULL, '', 200, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'fish9.png'),
(86, 'Chocolate pastry', 8, NULL, '', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry1.png'),
(87, 'Red velvet pastry', 8, NULL, '', 150, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry2.png'),
(88, 'Croissant', 8, NULL, '', 90, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry3.png'),
(89, 'Danish', 8, NULL, '', 110, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry4.png'),
(90, 'Fruit Tart', 8, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry5.png'),
(91, 'Tiramisu', 8, NULL, '', 170, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry6.png'),
(92, 'Egg Pudding', 8, NULL, '', 100, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'pastry7.png'),
(93, 'Chicken nuggets', 9, NULL, '', 350, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen1.png'),
(94, 'Chicken balls', 9, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen2.png'),
(95, 'Chicken wonton', 9, NULL, '', 160, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen3.png'),
(96, 'Chicken samosa', 9, NULL, '', 150, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen4.png'),
(97, 'Beef roll', 9, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen5.png'),
(98, 'French fry', 9, NULL, '', 200, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen6.png'),
(99, 'Dumplings (Momos)', 9, NULL, '', 180, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen7.png'),
(100, 'Bread Roti', 9, NULL, '', 300, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen8.png'),
(101, 'Paratha', 9, NULL, '', 320, 0.00, 0, 5, 1, '2025-12-11 03:27:21', 'frozen9.png');

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
(1, 'Irin', 'israttalebirin@gmail.com', '$2y$10$G3vXMmuNtFJArSbNWoz5y.dtRmHYYDxdS1nvVQiGk0jsTkgBymSnO', NULL, NULL, 'user', '1_1765257250.png', '01823456567', 'halishahar,boropool,notun para, chattogram', 'Bangladesh', 'Chittagong', '4115'),
(2, 'kohinoor', 'kohinoor@gmail.com', '$2y$10$pApdAORAjFd/TaDIon2sPefmnbtmsYlVTPti/o63gTl47kfB8Tjnm', NULL, NULL, 'user', '2_1765303903.jpg', '01823456567', 'uttor halishahar, boropool', 'Bangladesh', 'Chattogram', '4115'),
(3, 'Ayesha Siddiqua', 'siddiquamukta29@gmail.com', '$2y$10$ioFueRz5rEna862/r9AJi.DfKPEfDP.Q57kJlc9lvYUR.ompBLtsq', NULL, NULL, 'user', '', '01850547370', 'Mirasari,Chattogram', 'Bangladesh', 'Chattogram', '4307');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `shop_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `store_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1 COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `password`, `shop_name`, `phone`, `address`, `store_logo`, `created_at`, `status`) VALUES
(1, 'Ayesha Siddiqua', 'siddiquamukta29@gmail.com', '$2y$10$.oLl1M.5qE6WXb0W4RpDruj77/wv6dPkHTXZRCuSd9mUfRi4KZn0e', 'Virtu Store', NULL, NULL, NULL, '2025-12-10 14:43:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_withdraws`
--

CREATE TABLE `vendor_withdraws` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendor_withdraws`
--
ALTER TABLE `vendor_withdraws`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_withdraws`
--
ALTER TABLE `vendor_withdraws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
