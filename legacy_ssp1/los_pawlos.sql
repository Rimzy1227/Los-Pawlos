-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 01:09 PM
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
-- Database: `los_pawlos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Food', '2025-09-21 12:30:47'),
(2, 'Toys', '2025-09-21 12:30:47'),
(3, 'Grooming', '2025-09-21 12:30:47'),
(4, 'Accessories', '2025-09-21 12:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) NOT NULL DEFAULT 'General'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `image`, `created_at`, `category`) VALUES
(1, 'Premium Dog Food 5kg', 'High quality dog food for active dogs', 34.49, 25, 1, 'premium-dog-food-5kg.webp', '2025-09-21 12:34:02', 'Food'),
(2, 'Cat Dry Kibble 2kg', 'Healthy kibble for adult cats', 19.75, 40, 1, 'cat-dry-kibble-2kg.jpg', '2025-09-21 12:34:02', 'Food'),
(3, 'Organic Bird Seed 1kg', 'Natural and nutritious seed mix for birds', 13.50, 35, 1, 'Organic-Bird-Seed-1kg.webp', '2025-09-21 12:34:02', 'Food'),
(4, 'Tropical Fish Flakes 500g', 'Complete diet for tropical fish', 11.99, 50, 1, 'Tropical-Fish-Flakes-500g.jpg', '2025-09-21 12:34:02', 'Food'),
(5, 'Puppy Starter Food 3kg', 'Nutrient-rich formula for puppies', 22.00, 30, 1, 'Puppy-Starter-Food-3kg.jpg', '2025-09-21 12:34:02', 'Food'),
(6, 'Kitten Growth Formula 2kg', 'Supports growth and immunity in kittens', 21.75, 28, 1, 'Kitten-Growth-Formula-2kg.jpg', '2025-09-21 12:34:02', 'Food'),
(7, 'Reptile Pellets 1kg', 'Balanced diet for pet reptiles', 15.49, 20, 1, 'Reptile-Pellets-1kg.jpeg', '2025-09-21 12:34:02', 'Food'),
(8, 'Hamster Grain Mix 500g', 'Healthy grains and seeds for hamsters', 8.99, 60, 1, 'Hamster-Grain-Mix-500g.jpg', '2025-09-21 12:34:02', 'Food'),
(9, 'Large Breed Dog Food 10kg', 'Designed for large adult dogs', 47.50, 18, 1, 'Large-Breed-Dog-Food-10kg.jpg', '2025-09-21 12:34:02', 'Food'),
(10, 'Senior Cat Food 1.5kg', 'Gentle and easy to digest for older cats', 17.99, 25, 1, 'Senior-Cat-Food-1.5kg.jpg', '2025-09-21 12:34:02', 'Food'),
(11, 'Rubber Chew Toy', 'Durable chew toy for dogs', 6.99, 100, 2, 'rubber-chew-toy.jpg', '2025-09-21 12:34:02', 'Toys'),
(12, 'Interactive Laser Pointer', 'Fun exercise toy for cats', 9.99, 75, 2, 'interactive-laser-pointer.webp', '2025-09-21 12:34:02', 'Toys'),
(13, 'Bird Swing Toy', 'Colorful swing for small birds', 5.50, 80, 2, 'bird-swing-toy.jpeg', '2025-09-21 12:34:02', 'Toys'),
(14, 'Catnip Mouse Pack', 'Pack of 3 catnip-stuffed toy mice', 7.25, 90, 2, 'catnip-mouse-pack.jpg', '2025-09-21 12:34:02', 'Toys'),
(15, 'Rope Tug Toy', 'Heavy-duty rope toy for tugging games', 8.99, 60, 2, 'rope-tug-toy.jpg', '2025-09-21 12:34:02', 'Toys'),
(16, 'Floating Dog Fetch Toy', 'Perfect for pool or lake play', 10.99, 50, 2, 'floating-dog-fetch-toy.jpg', '2025-09-21 12:34:02', 'Toys'),
(17, 'Hamster Wheel', 'Safe and silent exercise wheel', 12.49, 45, 2, 'hamster-wheel.jpeg', '2025-09-21 12:34:02', 'Toys'),
(18, 'Fish Tank Mirror Toy', 'Floating toy for betta fish', 4.25, 70, 2, 'fish-tank-mirror-toy.webp', '2025-09-21 12:34:02', 'Toys'),
(19, 'Cat Tunnel Tube', 'Collapsible tunnel for interactive play', 16.99, 35, 2, 'cat-tunnel-tube.jpeg', '2025-09-21 12:34:02', 'Toys'),
(20, 'Rabbit Play Ball', 'Edible and rollable fun for rabbits', 6.49, 55, 2, 'rabbit-play-ball.jpg', '2025-09-21 12:34:02', 'Toys'),
(21, 'Dog Shampoo 500ml', 'Hypoallergenic shampoo for sensitive skin', 14.99, 40, 3, 'dog-shampoo-500ml.jpg', '2025-09-21 12:34:02', 'Grooming'),
(22, 'Cat Grooming Brush', 'Removes loose fur and reduces shedding', 11.25, 45, 3, 'cat-grooming-brush.jpg', '2025-09-21 12:34:02', 'Grooming'),
(23, 'Pet Nail Clippers', 'Ergonomic clippers for safe trimming', 9.75, 50, 3, 'pet-nail-clippers.jpg', '2025-09-21 12:34:02', 'Grooming'),
(24, 'Bird Bath Spray', 'Cleans and conditions feathers', 7.99, 30, 3, 'bird-bath-spray.jpg', '2025-09-21 12:34:02', 'Grooming'),
(25, 'Fish Tank Cleaner Tool', 'Multifunction cleaning brush for aquariums', 13.50, 25, 3, 'fish-tank-cleaner-tool.jpg', '2025-09-21 12:34:02', 'Grooming'),
(26, 'Flea Comb', 'Fine-toothed comb for detecting fleas', 5.49, 60, 3, 'flea-comb.jpg', '2025-09-21 12:34:02', 'Grooming'),
(27, 'Dog Deodorizing Wipes', 'Quick clean-up wipes for dogs', 8.99, 35, 3, 'dog-deodorizing-wipes.jpg', '2025-09-21 12:34:02', 'Grooming'),
(28, 'Reptile Shedding Aid', 'Moisturizes skin during shedding', 10.00, 20, 3, 'reptile-shedding-aid.jpeg', '2025-09-21 12:34:02', 'Grooming'),
(29, 'Small Animal Brush', 'Soft bristles for guinea pigs & rabbits', 6.75, 40, 3, 'small-animal-brush.jpeg', '2025-09-21 12:34:02', 'Grooming'),
(30, 'Cat Ear Cleaner', 'Cleans and prevents ear infections', 9.99, 25, 3, 'cat-ear-cleaner.jpeg', '2025-09-21 12:34:02', 'Grooming'),
(31, 'Cat Scratching Post', 'Sturdy scratching post for cats', 45.00, 15, 4, 'cat-scratching-post.jpeg', '2025-09-21 12:34:02', 'Accessories'),
(32, 'Dog Collar - Medium', 'Adjustable nylon collar for dogs', 12.99, 50, 4, 'dog-collar-medium.jpg', '2025-09-21 12:34:02', 'Accessories'),
(33, 'Bird Cage Perch Set', 'Set of natural wooden perches', 10.50, 40, 4, 'bird-cage-perch-set.jpg', '2025-09-21 12:34:02', 'Accessories'),
(34, 'Aquarium Thermometer', 'Digital thermometer for tanks', 7.25, 35, 4, 'aquarium-thermometer.jpg', '2025-09-21 12:34:02', 'Accessories'),
(35, 'Pet Travel Carrier', 'Airline-approved carrier for small pets', 55.99, 12, 4, 'pet-travel-carrier.jpg', '2025-09-21 12:34:02', 'Accessories'),
(36, 'Cat Litter Mat', 'Traps litter from paws', 19.95, 20, 4, 'cat-litter-mat.jpeg', '2025-09-21 12:34:02', 'Accessories'),
(37, 'Hamster Cage Tunnel', 'Plastic tunnel for cage enrichment', 8.49, 60, 4, 'hamster-cage-tunnel.jpg', '2025-09-21 12:34:02', 'Accessories'),
(38, 'Dog Leash 1.5m', 'Strong leash for daily walks', 13.99, 45, 4, 'dog-leash-1-5m.jpeg', '2025-09-21 12:34:02', 'Accessories'),
(39, 'Bird Feeder Clip-on', 'Easy feeder for small cages', 6.25, 70, 4, 'bird-feeder-clip-on.jpg', '2025-09-21 12:34:02', 'Accessories'),
(40, 'Pet Food Storage Bin 10L', 'Keeps pet food fresh and sealed', 24.99, 30, 4, 'pet-food-storage-bin-10l.jpeg', '2025-09-21 12:34:02', 'Accessories'),
(42, 'Grain-Free Salmon Cat Food 3kg', 'Grain-free formula with real salmon for cat with sensitivities', 29.99, 20, NULL, 'Grain-Free-Salmon-Cat-Food-3kg.jpg', '2025-09-22 07:44:27', 'Food'),
(43, 'Elevated Dog Feeding Stand', 'Ergonomic feeding station with stainless steel bowls', 39.99, 24, NULL, 'Elevated-Dog-Feeding-Stand.jpg', '2025-09-22 07:47:56', 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Hermoine Granger', 'wingadiumleviyosa@gmail.com', '$2y$10$mGklUXHPSKKHpWZzUVasdezazAecIMSOjNMKksNVkesZzvf5OWtCm', 'customer', '2025-09-21 19:11:31'),
(7, 'Admin', 'admin@pawlos.com', '$2y$10$CM/0xoEr1W.i1ZeA2qck4upOd2jatWOrKJSIuYCxQn9xXqEP0HupK', 'admin', '2025-09-21 20:08:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
