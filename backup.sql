-- phpMyAdmin SQL Dump
-- version 4.6.6deb1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 16 2017 г., 14:02
-- Версия сервера: 10.1.21-MariaDB-5+b1
-- Версия PHP: 7.0.16-3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `portal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `name`, `text`) VALUES
(1, 'Вася', 'Отличная компания'),
(2, 'Вася', 'Приятно с Вам работать!'),
(3, 'Петя', 'Спасибо за Плодотворное сотрудничество!'),
(4, 'Петя', 'Огромное спасибо! У Вас самый лучший сервис!'),
(5, 'Коля', 'Отличное качество!');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` char(10) NOT NULL,
  `password` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(1, 'admin', 'MegaSecretPassword'),
(2, 'admin2', 'BestPassword'),
(3, 'user', 'Mypassword');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
