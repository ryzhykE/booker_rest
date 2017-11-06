-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 06 2017 г., 15:29
-- Версия сервера: 5.7.11
-- Версия PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `booker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `description` text NOT NULL,
  `time_start` timestamp NOT NULL,
  `time_end` timestamp NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `id_user`, `id_room`, `description`, `time_start`, `time_end`, `id_parent`, `create_time`) VALUES
(1, 1, 1, '1www', '2017-11-03 10:00:00', '2017-11-03 12:00:00', 1, '2017-11-03 20:49:04'),
(2, 1, 1, '11111', '2017-11-01 07:00:00', '2017-11-01 11:00:00', 1, '2017-11-03 20:53:23'),
(3, 1, 1, 'fgdfsg', '2017-11-03 08:00:00', '2017-11-03 12:00:00', 1, '2017-11-03 20:55:05'),
(4, 1, 2, '1wsadsss', '2017-11-03 11:00:38', '2017-11-03 13:00:00', 1, '2017-11-04 06:51:38'),
(5, 1, 1, 'орпор', '2017-11-04 15:30:00', '2017-11-04 17:00:00', 3, '2017-11-04 15:07:17'),
(6, 1, 2, 'кег', '2017-11-04 08:00:00', '2017-11-07 22:00:00', 2, '2017-11-04 15:07:55'),
(37, 51, 1, 'gjgjg', '2018-02-01 08:00:00', '2018-02-01 12:00:00', NULL, '2017-11-06 10:47:45'),
(38, 51, 1, 'gjgjg', '2018-02-01 08:00:00', '2018-02-01 12:00:00', NULL, '2017-11-06 10:52:54'),
(39, 51, 1, 'gjgjg', '2018-02-01 12:00:00', '2018-02-01 15:00:00', NULL, '2017-11-06 10:53:26'),
(40, 51, 1, 'gjgjg', '2018-02-01 12:00:00', '2018-02-01 15:00:00', NULL, '2017-11-06 12:28:50');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `name`) VALUES
(1, 'Room1'),
(2, 'Room2'),
(3, 'Room 3');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT '2',
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL DEFAULT 'Null'
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `id_role`, `login`, `pass`, `email`, `hash`) VALUES
(1, 1, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'test@test.ru', '3cfd02623e0e8f2edb8035054102de54'),
(49, 2, 'wwwww', '63ee451939ed580ef3c4b6f0109d1fd0', 'test@test.ru', 'Null'),
(51, 2, 'eeeee', '6e875c1fe1227c8a2adf9d625230a605', 'evgenii_r84@mail.ru', 'Null');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_fk1` (`id_room`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_fk0` (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_fk1` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk0` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
