-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 09:48 AM
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
-- Database: `liquor_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_info`
--

CREATE TABLE `delivery_info` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `delivery_status` enum('Processing','Out for Delivery','Delivered') DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `liquor_products`
--

CREATE TABLE `liquor_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `volume_ml` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liquor_products`
--

INSERT INTO `liquor_products` (`id`, `name`, `label`, `price`, `stock`, `created_at`, `image`, `volume_ml`) VALUES
(36, 'Jack Daniel’s Tennessee Whiskey', 'Whiskey', 1999.00, 0, '2025-03-05 03:53:04', 'jack_daniels.jpg', 700),
(37, 'Johnnie Walker Black Label', 'Whiskey', 2499.00, 0, '2025-03-05 03:53:04', 'johnnie_walker_black.jpg', 1000),
(38, 'Jameson Irish Whiskey', 'Whiskey', 1599.00, 0, '2025-03-05 03:53:04', 'jameson.jpg', 750),
(39, 'Macallan 12-Year-Old Scotch', 'Whiskey', 4999.00, 0, '2025-03-05 03:53:04', 'macallan_12.jpg', 700),
(40, 'Absolut Vodka', 'Vodka', 1099.00, 0, '2025-03-05 03:53:04', 'absolut.jpg', 700),
(41, 'Grey Goose', 'Vodka', 2799.00, 0, '2025-03-05 03:53:04', 'grey_goose.jpg', 750),
(42, 'Smirnoff No. 21', 'Vodka', 899.00, 0, '2025-03-05 03:53:04', 'smirnoff.jpg', 1000),
(43, 'Belvedere Vodka', 'Vodka', 3299.00, 0, '2025-03-05 03:53:04', 'belvedere.jpg', 700),
(44, 'Bacardi Gold', 'Rum', 1099.00, 0, '2025-03-05 03:53:04', 'bacardi_gold.jpg', 750),
(45, 'Captain Morgan Spiced Rum', 'Rum', 1299.00, 0, '2025-03-05 03:53:04', 'captain_morgan.jpg', 750),
(46, 'Malibu Coconut Rum', 'Rum', 999.00, 0, '2025-03-05 03:53:04', 'malibu.jpg', 700),
(47, 'Havana Club Añejo', 'Rum', 1599.00, 0, '2025-03-05 03:53:04', 'havana_club.jpg', 750),
(48, 'Patrón Silver', 'Tequila', 3499.00, 0, '2025-03-05 03:53:04', 'patron_silver.jpg', 750),
(49, 'Don Julio Reposado', 'Tequila', 4299.00, 0, '2025-03-05 03:53:04', 'don_julio.jpg', 750),
(50, 'Jose Cuervo Especial', 'Tequila', 1499.00, 0, '2025-03-05 03:53:04', 'jose_cuervo.jpg', 700),
(51, 'Casamigos Blanco', 'Tequila', 3999.00, 0, '2025-03-05 03:53:04', 'casamigos.jpg', 750),
(52, 'Bombay Sapphire', 'Gin', 1699.00, 0, '2025-03-05 03:53:04', 'bombay_sapphire.jpg', 700),
(53, 'Tanqueray London Dry Gin', 'Gin', 1599.00, 0, '2025-03-05 03:53:04', 'tanqueray.jpg', 750),
(54, 'Hendrick’s Gin', 'Gin', 2399.00, 0, '2025-03-05 03:53:04', 'hendricks.jpg', 700),
(55, 'Beefeater Gin', 'Gin', 1299.00, 0, '2025-03-05 03:53:04', 'beefeater.jpg', 700),
(56, 'Cabernet Sauvignon', 'Wine', 799.00, 0, '2025-03-05 03:53:04', 'cabernet_sauvignon.jpg', 750),
(57, 'Merlot', 'Wine', 749.00, 0, '2025-03-05 03:53:04', 'merlot.jpg', 750),
(58, 'Chardonnay', 'Wine', 799.00, 0, '2025-03-05 03:53:04', 'chardonnay.jpg', 750),
(59, 'Pinot Grigio', 'Wine', 699.00, 0, '2025-03-05 03:53:04', 'pinot_grigio.jpg', 750),
(60, 'Heineken', 'Beer', 99.00, 0, '2025-03-05 03:53:04', 'heineken.jpg', 330),
(61, 'Budweiser', 'Beer', 89.00, 0, '2025-03-05 03:53:04', 'budweiser.jpg', 330),
(62, 'Corona Extra', 'Beer', 119.00, 0, '2025-03-05 03:53:04', 'corona_extra.jpg', 355),
(63, 'Guinness Stout', 'Beer', 129.00, 0, '2025-03-05 03:53:04', 'guinness.jpg', 440),
(64, 'Baileys Irish Cream', 'Liqueur', 1499.00, 0, '2025-03-05 03:53:04', 'baileys.jpg', 750),
(65, 'Kahlúa Coffee Liqueur', 'Liqueur', 1099.00, 0, '2025-03-05 03:53:04', 'kahlua.jpg', 750),
(66, 'Cointreau Orange Liqueur', 'Liqueur', 1899.00, 0, '2025-03-05 03:53:04', 'cointreau.jpg', 700),
(67, 'Jägermeister', 'Liqueur', 1399.00, 0, '2025-03-05 03:53:04', 'jagermeister.jpg', 700);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `address`, `phone`, `total_price`, `status`, `ordered_at`) VALUES
(1, 'a', 'a', '09123456789', 0.00, 'Pending', '2025-03-05 02:51:21'),
(2, 'aa', 'aa', '09123456789', 0.00, 'Pending', '2025-03-05 04:29:43'),
(3, 'a', 's', '09123456782', 0.00, 'Pending', '2025-03-05 08:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 2, 36, 1, 1999.00),
(4, 2, 36, 1, 1999.00),
(5, 3, 64, 1, 1499.00);

-- --------------------------------------------------------

--
-- Table structure for table `store_managers`
--

CREATE TABLE `store_managers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_managers`
--

INSERT INTO `store_managers` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userLName` varchar(255) NOT NULL,
  `userFName` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userPhoneNum` varchar(11) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `userBirthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userLName`, `userFName`, `userName`, `userPhoneNum`, `userPass`, `userBirthday`) VALUES
(1, 'Habon', 'Jay', 'jay123', '09123456789', '$2y$10$fz9HeysULg92MO82HpTVuupHhZrGlFbCXm805.C0g4RKHnJIz3yVi', '2001-02-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `delivery_info`
--
ALTER TABLE `delivery_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `liquor_products`
--
ALTER TABLE `liquor_products`
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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `store_managers`
--
ALTER TABLE `store_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_info`
--
ALTER TABLE `delivery_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liquor_products`
--
ALTER TABLE `liquor_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `store_managers`
--
ALTER TABLE `store_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `liquor_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_info`
--
ALTER TABLE `delivery_info`
  ADD CONSTRAINT `delivery_info_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `liquor_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
