-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0
-- Время создания: Сен 17 2025 г., 22:03
-- Версия сервера: 8.0.42
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `news_portal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Politics', 'politics', 'Political news and analysis', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(2, 'World', 'world', 'International news from around the globe', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(3, 'Technology', 'technology', 'Latest tech news and innovations', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(4, 'Science', 'science', 'Scientific discoveries and research', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(5, 'Health', 'health', 'Health and medical news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(6, 'Sports', 'sports', 'Sports news and updates', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(7, 'Entertainment', 'entertainment', 'Celebrity and entertainment news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(8, 'Business', 'business', 'Business and financial news', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(9, 'Culture', 'culture', 'Arts, culture and lifestyle', '2025-09-14 22:13:17', '2025-09-14 22:13:17'),
(10, 'Environment', 'environment', 'Environmental news and climate change', '2025-09-14 22:13:17', '2025-09-14 22:13:17');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int NOT NULL,
  `author_id` int NOT NULL,
  `published_at` datetime NOT NULL,
  `views` int DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `excerpt`, `image_url`, `category_id`, `author_id`, `published_at`, `views`, `is_published`, `created_at`, `updated_at`) VALUES
(11, 'The Future of AI in Healthcare', 'Detailed article about how artificial intelligence is transforming the healthcare industry...', 'AI is revolutionizing healthcare with new diagnostic tools and personalized treatment plans.', '/images/ai-healthcare.jpg', 4, 1, '2025-09-14 22:14:30', 1256, 1, '2025-09-14 22:14:30', '2025-09-17 20:52:19'),
(12, 'Global Climate Summit Reaches Historic Agreement', 'World leaders have agreed on a comprehensive plan to combat climate change...', 'Nations commit to ambitious carbon reduction targets in landmark climate deal.', '/images/climate-summit.jpg', 2, 1, '2025-09-13 22:14:30', 3423, 1, '2025-09-14 22:14:30', '2025-09-16 22:58:09'),
(13, 'New Smartphone Breaks Sales Records', 'The latest flagship smartphone has shattered sales records in its first week...', 'Innovative features and competitive pricing drive unprecedented demand.', '/images/smartphone.jpg', 3, 1, '2025-09-12 22:14:30', 5678, 1, '2025-09-14 22:14:30', '2025-09-14 22:14:30'),
(14, 'Stock Market Reaches All-Time High', 'Investors celebrate as major indices hit record levels amid strong economic data...', 'Bull market continues as corporate earnings exceed expectations.', '/images/stock-market.jpg', 8, 1, '2025-09-11 22:14:30', 2348, 1, '2025-09-14 22:14:30', '2025-09-17 21:32:03'),
(15, 'Major Breakthrough in Cancer Research', 'Scientists announce a promising new treatment approach that could revolutionize cancer care...', 'Clinical trials show remarkable results with minimal side effects.', '/images/cancer-research.jpg', 5, 1, '2025-09-10 22:14:30', 4123, 1, '2025-09-14 22:14:30', '2025-09-14 22:14:30'),
(16, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Ut enim ad minim veniam, quis nostrud', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUsbmTZu_uMrmJ0z--CrG-o1UIXytu1OCizQ&s', 8, 1, '2025-09-16 21:37:00', 0, 0, '2025-09-16 21:40:21', '2025-09-16 21:40:21'),
(17, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUsbmTZu_uMrmJ0z--CrG-o1UIXytu1OCizQ&s', 8, 1, '2025-09-16 21:40:00', 0, 0, '2025-09-16 21:41:12', '2025-09-16 21:41:12'),
(18, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', NULL, 8, 1, '2025-09-16 22:12:00', 0, 0, '2025-09-16 22:13:18', '2025-09-16 22:13:18'),
(19, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUsbmTZu_uMrmJ0z--CrG-o1UIXytu1OCizQ&s', 8, 1, '2025-09-16 22:13:00', 14, 1, '2025-09-16 22:13:32', '2025-09-17 21:49:02');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` text COLLATE utf8mb4_unicode_ci,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `phone`, `preferences`, `is_admin`, `created_at`, `last_login`, `updated_at`) VALUES
(1, 'maks', 'maksvokulov@mail.ru', '$2y$10$CXZdmFTTpTeC3Lna/ujVWOfQZOighRmkjOY4dwSBQGeRr3/7hwL/O', '', '{\"categories\":[]}', 1, '2025-09-14 23:35:32', '2025-09-17 21:34:40', '2025-09-17 21:34:40'),
(2, 'keny', 'keny2880@gmail.com', '$2y$10$hs9SiopA8phzowh4.CmpF.Y55zwpyhlzi8eTakX98oOrtPNfH2H/m', '', '{\"categories\":[]}', 0, '2025-09-17 21:34:22', '2025-09-17 21:34:23', '2025-09-17 21:34:23');

-- --------------------------------------------------------

--
-- Структура таблицы `user_interests`
--

CREATE TABLE `user_interests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `weight` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_category_published` (`category_id`,`is_published`),
  ADD KEY `idx_published_date` (`is_published`,`published_at`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_category` (`user_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_interests`
--
ALTER TABLE `user_interests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_interests_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
