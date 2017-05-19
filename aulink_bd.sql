-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 19 2017 г., 06:49
-- Версия сервера: 5.7.16
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `aulink_bd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Authors`
--

CREATE TABLE `Authors` (
  `id_author` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_group` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Authors`
--

INSERT INTO `Authors` (`id_author`, `name`, `email`, `password`, `create_date`, `user_group`) VALUES
(1, 'Admin', 'markbelinskiy94@gmail.com', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4', '2017-05-17 10:25:20', 0),
(5, 'Mark', 'korshun94z@gmail.com', 'f1b5a91d4d6ad523f2610114591c007e75d15084', '2017-05-18 12:34:18', 1),
(6, 'TestMar', 'belinskijmark@gmail.com', '69fee7082a4ee534af1380c6b90a838c37d633b3', '2017-05-19 03:40:01', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Events`
--

CREATE TABLE `Events` (
  `id_event` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Events`
--

INSERT INTO `Events` (`id_event`, `id_author`, `name`, `description`, `date_start`, `date_end`, `color`) VALUES
(1, 1, 'From Admin updated', 'From Admin', '2017-05-17 00:00:00', '2017-05-20 22:30:00', '#fffff0'),
(3, 1, 'From Admin updated second', 'From Admin', '2017-05-08 00:00:00', '2017-05-11 22:30:00', '#fffff0'),
(4, 1, 'From Admin updated', 'From Admin', '2017-05-21 00:00:00', '2017-05-22 22:30:00', '#00ffff'),
(6, 5, 'Mark update', 'MarkMark', '2017-05-19 02:00:00', '2017-05-20 03:00:00', '#8080ff'),
(7, 5, 'Mark', 'MarkMark', '2017-05-23 02:00:00', '2017-05-24 03:00:00', '#f1291f'),
(8, 6, 'TestMarkEvent', 'loremloremloremloremloremlorem loremlore', '2017-05-19 10:00:00', '2017-05-19 13:30:00', '#ff8040');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Authors`
--
ALTER TABLE `Authors`
  ADD PRIMARY KEY (`id_author`),
  ADD UNIQUE KEY `e` (`email`);

--
-- Индексы таблицы `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_author` (`id_author`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Authors`
--
ALTER TABLE `Authors`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `Events`
--
ALTER TABLE `Events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Events`
--
ALTER TABLE `Events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `Authors` (`id_author`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
