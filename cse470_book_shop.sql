-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2023 at 10:29 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse470_book_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_news`
--

CREATE TABLE `admin_news` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `blog_title` text DEFAULT NULL,
  `admin_blog_message` varchar(100) NOT NULL,
  `blog_type` varchar(100) DEFAULT NULL,
  `blog_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_news`
--

INSERT INTO `admin_news` (`id`, `user_id`, `admin_name`, `blog_title`, `admin_blog_message`, `blog_type`, `blog_date`) VALUES
(11, 3, 'Admin', 'Voucher Has Been Announced', 'Use the voucher EID to have 45 TK off each books', 'Offers', '29/04/2023 08:13:36 am');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_product_details`
--

CREATE TABLE `current_product_details` (
  `product_id` int(100) NOT NULL,
  `author_name` text NOT NULL,
  `description` text DEFAULT NULL,
  `book_language` varchar(100) DEFAULT NULL,
  `page_numbers` int(100) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `book_genre` varchar(100) DEFAULT NULL,
  `book_sample` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current_product_details`
--

INSERT INTO `current_product_details` (`product_id`, `author_name`, `description`, `book_language`, `page_numbers`, `publication_date`, `book_genre`, `book_sample`) VALUES
(11, 'Kentaro Miura', 'Created by Kentaro Miura, Berserk is manga mayhem to the extreme - violent, horrifying, and mercilessly funny - and the wellspring for the internationally popular anime series. Not for the squeamish or the easily offended, Berserk asks for no quarter - and offers none!\r\nHis name is Guts, the Black Swordsman, a feared warrior spoken of only in whispers. Bearer of a gigantic sword, an iron hand, and the scars of countless battles and tortures, his flesh is also indelibly marked with The Brand, an unholy symbol that draws the forces of darkness to him and dooms him as their sacrifice. But Guts won\'t take his fate lying down; he\'ll cut a crimson swath of carnage through the ranks of the damned - and anyone else foolish enough to oppose him! Accompanied by Puck the Elf, more an annoyance than a companion, Guts relentlessly follows a dark, bloodstained path that leads only to death...or vengeance.', 'English', 696, '2019-04-19', 'Action', 'Assignment-3.pdf'),
(12, 'awe', 'awe', 'English', 231, '2023-04-20', 'Action', ''),
(13, 'awe', 'awe', 'English', 23, '2023-04-27', 'Action', 'Assignment-3.pdf'),
(14, 'ewfwef', 'werewr', 'English', 324, '2023-04-27', 'Action', '20101149_Md.AnasMahmud_A4_CSE472.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(100) NOT NULL,
  `message_sender_id` int(100) NOT NULL,
  `message_receiver_id` int(100) NOT NULL,
  `message_detail` varchar(100) NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_sender_id`, `message_receiver_id`, `message_detail`, `message_time`) VALUES
(1, 3, 4, 'I am the admin', '2023-04-30 07:58:29'),
(2, 4, 3, 'I am the user', '2023-04-30 08:06:26'),
(3, 4, 3, 'hey there bro', '2023-04-30 08:10:34'),
(4, 3, 4, 'I am the admin 2', '2023-04-30 07:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bkash_transaction` varchar(100) DEFAULT NULL,
  `offline_address` varchar(100) DEFAULT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(255) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `bkash_transaction`, `offline_address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `payment_method`) VALUES
(1, 3, 'Tshirt', '0130', 'abid@gmail.com', 'Bkash', NULL, '1', 100, '01/10/2020', 'pending', ''),
(3, 4, 'Anas Mahmud Abid', '123', '12@gmail.com', '123', NULL, ', Berserk Volume 1 (1) ', 5999, '25-Apr-2023', 'pending', ''),
(4, 4, 'Offline Delivery', '213', 'offline@gmail.com', '', 'My address', ', Berserk Volume 1 (1) ', 5999, '28-Apr-2023', 'pending', ''),
(5, 4, 'Berserk Online', '2313', 'online@gmail.com', '$#JIF_(#I$#(FUIO', '', ', Berserk Volume 1 (3) ', 17997, '28-Apr-2023', 'pending', ''),
(6, 4, 'Total Online', '23123', '23@gmail.com', 'qwe213', '', ', weq (1) ', 232, '28-Apr-2023', 'pending', 'Online Delivery'),
(7, 4, 'Test', '1234', '1234@gmail.com', '', 'My home', ', Berserk Volume 1 (1) ', 5999, '28-Apr-2023', 'pending', 'Physical Delivery'),
(8, 4, 'Testing 2', '2323', '23123@gmail.com', '43534534', '', ', Berserk Volume 1 (1) ', 5954, '29-Apr-2023', 'pending', 'Online Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(11, 'Berserk Volume 1', 5999, 'CSE472 Assignment 4.png'),
(12, 'weq', 232, '5.jpg'),
(13, 'asd', 213, '337042535_221668020435983_2077114486837850193_n.jpg'),
(14, 'random book', 213, '341608618_1632571130593633_8514893130373055754_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `review_id` int(100) NOT NULL,
  `user_reviewer_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `user_rating` int(100) NOT NULL,
  `review_details` varchar(100) NOT NULL,
  `review_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`review_id`, `user_reviewer_id`, `product_id`, `reviewer_name`, `user_rating`, `review_details`, `review_time`) VALUES
(2, 0, 11, 'Nancel', 0, 'Masterpiece', '2023-04-28 20:27:56'),
(3, 4, 11, 'user', 4, 'The book was good', '2023-04-28 22:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(3, 'Abid', 'abid@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
(4, 'user', 'user@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucher_id` int(100) NOT NULL,
  `voucher_code` varchar(100) NOT NULL,
  `voucher_discount` int(100) NOT NULL,
  `voucher_creation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `voucher_expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucher_id`, `voucher_code`, `voucher_discount`, `voucher_creation_date`, `voucher_expiration_date`) VALUES
(1, 'EID45', 45, '2023-04-29 02:17:33', '2023-05-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_news`
--
ALTER TABLE `admin_news`
  ADD PRIMARY KEY (`id`,`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_product_details`
--
ALTER TABLE `current_product_details`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_news`
--
ALTER TABLE `admin_news`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `review_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_news`
--
ALTER TABLE `admin_news`
  ADD CONSTRAINT `admin_news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `current_product_details`
--
ALTER TABLE `current_product_details`
  ADD CONSTRAINT `current_product_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
