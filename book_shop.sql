-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 26 2017 г., 08:18
-- Версия сервера: 5.7.11
-- Версия PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `aaaas`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
  (1, 'Mark Mazower'),
  (9, 'Ronalds Hutton'),
  (10, 'Brendan Simms'),
  (11, 'Peter Godfrey'),
  (12, 'Niels Birbaumer'),
  (13, 'Rob Percival'),
  (14, 'Mark O Connell');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `description` text NOT NULL,
  `discount` decimal(7,2) DEFAULT '0.00',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `img` varchar(255) NOT NULL DEFAULT 'static/img/no_image.jpg'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `title`, `price`, `description`, `discount`, `active`, `img`) VALUES
  (1, '11What You Did Not Tell', '12.95', 'this story abot', '15.00', 'yes', 'static/img/12.jpg'),
  (5, 'The Witch', '21.00', 'Why have societies all across the world feared witchcraft? This book delves deeply into its context, beliefs, and origins in Europe''s history The witch came to prominence-and often a painful death-in early modern Europe, yet her origins are much more geographically diverse and historically deep. In this landmark book, Ronald Hutton traces witchcraft from the ancient world to the early-modern stake. ', '0.00', 'yes', 'static/img/13.jpg'),
  (6, 'Britain''s Europe', '9.00', '''Dazzling ... a trenchant, provocative account of the intimate relations of Britain and Europe and how each shaped the other'' Prospect Magazine''Elegant, refreshing and wide-ranging ... this is essentially a brief history of the UK but a deliciously different one'' Literary ReviewBritain has always had a tangled, complex, paradoxical role in Europe''s history. It has invaded and been invaded, changed sides, stood aloof, acted with both brazen cynicism and the cloudiest idealism. ', '12.00', 'yes', 'static/img/14.jpg'),
  (7, 'Other Minds', '21.00', '`Brilliant'' Guardian `Fascinating and often delightful'' The Times SHORTLISTED FOR THE 2017 ROYAL SOCIETY SCIENCE BOOK PRIZE What if intelligent life on Earth evolved not once, but twice? The octopus is the closest we will come to meeting an intelligent alien. What can we learn from the encounter? In Other Minds, Peter Godfrey-Smith, a distinguished philosopher of science and a skilled scuba diver, tells a bold new story of how nature became aware of itself - a story that largely occurs in the ocean, where animals first appeared. ', '9.00', 'yes', 'static/img/15.jpg'),
  (8, 'Your Brain Knows More', '11.20', 'Our brains are more powerful than we ever realised. Too often, we assume that people''s natures are fixed, immutable. For sufferers of depression, anxiety, ADHD, addiction, or the after-effects of stroke, this can be a difficult thought. For those with extreme conditions, such as locked-in syndrome or psychopathy, it can feel as if there is no hope at all. However, in Your Brain Knows More Than You Think, leading neurobiologist Niels Birbaumer turns these assumptions on their head, arguing that neuroplasticity - the virtually limitless capacity of the brain to remould itself - is enough to overcome almost any condition, however life-limiting it seems. Like the fathers and mothers of psychiatry, Birbaumer explores the sometimes-wild frontiers of a new way of thinking about our brains and behaviour. Through actual cases from his research and practice, he shows how we can change through brain training alone - and without risky drugs - if we simply open our minds.', '0.00', 'yes', 'static/img/16.jpg'),
  (9, 'Life 3.0', '11.00', '''This is the most important conversation of our time, and Tegmark''s thought-provoking book will help you join it'' Stephen Hawking''This is a rich and visionary book and everyone should read it'' The TimesWe stand at the beginning of a new era. What was once science fiction is fast becoming reality, as AI transforms war, crime, justice, jobs and society-and, even, our very sense of what it means to be human. More than any other technology, AI has the potential to revolutionize our collective future - and there''s nobody better situated to explore that future than Max Tegmark, an MIT professor and co-founder of the Future of Life Institute, whose work has helped mainstream research on how to keep AI beneficial.In this deeply researched and vitally important new book, Tegmark takes us to the heart of thinking about AI and the human condition, bringing us face to face with the essential questions of our time. How can we grow our prosperity through ', '3.00', 'yes', 'static/img/17.jpg'),
  (10, 'Confident Coding', '112.00', 'If you want to master the fundamentals of coding and kick start your career, Confident Coding is the book for you. Everyone has a digital life, but too few truly understand how the software that dominates the world actually works. Coding is one of the most in demand skills on the job market and grasping the basics can advance your creative potential and make you stand out from the crowd. Rob Percival gives you a step-by-step learning guide to HTML, CSS, JavaScript, Python, building iPhone apps, building Android apps and debugging.', '23.00', 'yes', 'static/img/18.jpg'),
  (11, 'To Be a Machine', '123.00', 'Shortlisted for The Baillie Gifford Prize for Non-Fiction 2017What is transhumanism? Simply put, it is a movement whose aim is to use technology to fundamentally change the human condition, to improve our bodies and minds to the point where we become something other, and better, than the animals we are. It''s a philosophy that, depending on how you look at it, can seem hopeful, or terrifying, or absurd. In To Be a Machine, Mark O''Connell presents us with the first full-length exploration of transhumanism: its philosophical and scientific roots, its key players and possible futures. From charismatic techies seeking to enhance the body to immortalists who believe in the possibility of ''solving'' death; from computer programmers quietly re-designing the world to vast competitive robotics conventions; ', '0.00', 'yes', 'static/img/19.jpg'),
  (32, '1What You Did Not Tell', '112.95', 'description', '15.00', 'yes', 'static/img/no_image.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `book_to_author`
--

CREATE TABLE IF NOT EXISTS `book_to_author` (
  `id_book` int(11) NOT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book_to_author`
--

INSERT INTO `book_to_author` (`id_book`, `id_author`) VALUES
  (1, 1),
  (1, 9),
  (5, 9),
  (5, 11),
  (6, 10),
  (6, 11),
  (7, 12),
  (8, 14),
  (9, 13),
  (9, 14),
  (9, 1),
  (10, 10),
  (11, 10),
  (11, 11),
  (11, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `book_to_genre`
--

CREATE TABLE IF NOT EXISTS `book_to_genre` (
  `id_book` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book_to_genre`
--

INSERT INTO `book_to_genre` (`id_book`, `id_genre`) VALUES
  (5, 2),
  (6, 2),
  (6, 3),
  (7, 1),
  (7, 3),
  (8, 1),
  (9, 2),
  (10, 1),
  (10, 2),
  (10, 3),
  (11, 3),
  (1, 2),
  (1, 1),
  (1, 3),
  (1, 1),
  (1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `login` varchar(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `login`, `pass`, `discount`, `hash`, `role`, `active`) VALUES
  (22, 'Evgen', 'Ryzh', 'evgeniy', '63ee451939ed580ef3c4b6f0109d1fd0', 12, 'd096aaa2f0c9d27bf965f14691ef1620', 'user', 'yes'),
  (23, 'admin', 'admin', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 0, '6327d43f64ca4f4881a72b11fc000d65', 'admin', 'yes'),
  (49, 'rttttttttffff', 'rtttttttt', 'rtttttttt', '4104d0f5d294e4f52793a4b0b1e05bc1', 3, NULL, 'user', 'yes');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
  (1, 'History'),
  (2, 'Psychology'),
  (3, 'Technology');

-- --------------------------------------------------------

--
-- Структура таблицы `history_book`
--

CREATE TABLE IF NOT EXISTS `history_book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` decimal(7,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `history_book`
--

INSERT INTO `history_book` (`id`, `title`, `genre`, `author`, `price`) VALUES
  (4, 'bokk', 'History Psychology ', 'Mark Mazower Ronalds Hutton ', '11.00');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `total_discount` decimal(7,0) DEFAULT NULL,
  `status` enum('processed','sent') NOT NULL DEFAULT 'processed',
  `id_payment` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(7,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_client`, `total_discount`, `status`, `id_payment`, `date_time`, `total_price`) VALUES
  (120, 22, '13', 'processed', 2, '2017-10-22 10:08:30', '134'),
  (121, 23, '10', 'sent', 1, '2017-10-22 11:16:33', '395'),
  (122, 22, '3', 'processed', 1, '2017-10-23 10:58:21', '18');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_full_info`
--

CREATE TABLE IF NOT EXISTS `orders_full_info` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `title_book` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(7,0) NOT NULL,
  `discount_book` decimal(7,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_full_info`
--

INSERT INTO `orders_full_info` (`id`, `id_order`, `id_book`, `title_book`, `count`, `price`, `discount_book`) VALUES
  (9, 120, 7, 'Other Minds', 7, '21', '9'),
  (10, 121, 1, 'What You Did Not Tell', 15, '13', '5'),
  (11, 121, 5, 'The Witch', 10, '21', '0'),
  (12, 122, 5, 'The Witch', 1, '21', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `name`) VALUES
  (1, 'Visa'),
  (2, 'MasterCart'),
  (3, 'QIWI'),
  (4, 'Webmoney');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `book_to_author`
--
ALTER TABLE `book_to_author`
ADD KEY `book_to_author_fk0` (`id_author`),
ADD KEY `book_to_author_fk1` (`id_book`);

--
-- Индексы таблицы `book_to_genre`
--
ALTER TABLE `book_to_genre`
ADD KEY `book_to_genre_fk0` (`id_genre`),
ADD KEY `book_to_genre_fk1` (`id_book`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
ADD PRIMARY KEY (`id`),
ADD KEY `cart_fk0` (`id_book`),
ADD KEY `cart_fk1` (`id_client`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `login_2` (`login`),
ADD KEY `login` (`login`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history_book`
--
ALTER TABLE `history_book`
ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
ADD PRIMARY KEY (`id`),
ADD KEY `orders_fk0` (`id_client`),
ADD KEY `orders_fk1` (`id_payment`);

--
-- Индексы таблицы `orders_full_info`
--
ALTER TABLE `orders_full_info`
ADD PRIMARY KEY (`id`),
ADD KEY `orders_full_info_fk0` (`id_order`),
ADD KEY `orders_full_info_fk1` (`id_book`);

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `history_book`
--
ALTER TABLE `history_book`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT для таблицы `orders_full_info`
--
ALTER TABLE `orders_full_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book_to_author`
--
ALTER TABLE `book_to_author`
ADD CONSTRAINT `book_to_author_fk0` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `book_to_author_fk1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `book_to_genre`
--
ALTER TABLE `book_to_genre`
ADD CONSTRAINT `book_to_genre_fk0` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `book_to_genre_fk1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
ADD CONSTRAINT `cart_fk0` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `cart_fk1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_fk0` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_fk1` FOREIGN KEY (`id_payment`) REFERENCES `payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_full_info`
--
ALTER TABLE `orders_full_info`
ADD CONSTRAINT `orders_full_info_fk0` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_full_info_fk1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
