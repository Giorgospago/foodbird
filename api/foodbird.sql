-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 18 Απρ 2019 στις 20:49:33
-- Έκδοση διακομιστή: 10.1.36-MariaDB
-- Έκδοση PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `foodbird`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `floor_type` int(11) DEFAULT NULL,
  `floor_num` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `floor_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alias` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `street`, `number`, `postal_code`, `floor_type`, `floor_num`, `floor_name`, `country`, `city`, `alias`, `notes`) VALUES
(1, 'VZDoxr5KCvTdH3BUsC1gfLk1e4O2', 'Kavalas', '41', '56532', 1, '', '', 'Greece', 'Thessaloniki', 'Awesome Home', 'Prosoxh Skylos !!!');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `name`, `photo`, `gender`, `provider`, `email`, `createdAt`) VALUES
('eP7bFLRBsOWjLftQ7LGXLaWtJFl2', 'George Pagonoudis', 'https://lh6.googleusercontent.com/-ZXwqyzK1NR4/AAAAAAAAAAI/AAAAAAAARdo/IkJZX6K2np0/photo.jpg', 'male', 'google.com', 'giorgospago23@gmail.com', '2019-03-21 21:24:44'),
('VZDoxr5KCvTdH3BUsC1gfLk1e4O2', 'George', '', 'male', 'emailPassword', 'info@develobird.gr', '2019-03-28 21:38:54');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
