-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 23 2020 г., 23:26
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `new_book_catalog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id_author` int(12) NOT NULL,
  `author` text NOT NULL,
  `status` int(12) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`id_author`, `author`, `status`) VALUES
(2, 'J. R. R. Tolkien', 1),
(7, 'James Martin', 1),
(9, 'else', 0),
(10, 'Another Author', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `id_book` int(12) NOT NULL,
  `book_name` text NOT NULL,
  `short_descr` text NOT NULL,
  `full_descr` text NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id_book`, `book_name`, `short_descr`, `full_descr`, `image`, `price`) VALUES
(1, 'Name', 'asdasdas', 'sadasdadadadadadadadadasd', 'img/phone_no image.png', 10),
(2, 'new_book_name1', 'new_short', 'new_full', 'img/phone_no image.png', 100),
(3, 'new_book_name2', 'new_short', 'new_full', 'img/uploads/5f0f854fef6c3.jpeg', 999),
(20, 'Warcraft', 'sadffsdaaaaaaaaaaaaaa', 'sdfsfsfaaaaaa', 'img/uploads/5f19def9648e3.jpeg', 78),
(21, 'Story', 'Some', 'Some New Story', 'img/phone_no image.png', 11);

-- --------------------------------------------------------

--
-- Структура таблицы `books_vs_author`
--

CREATE TABLE `books_vs_author` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books_vs_author`
--

INSERT INTO `books_vs_author` (`id`, `id_book`, `id_author`) VALUES
(15, 2, 2),
(20, 3, 7),
(23, 1, 2),
(24, 1, 7),
(25, 21, 7),
(29, 20, 7),
(30, 20, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `books_vs_genre`
--

CREATE TABLE `books_vs_genre` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books_vs_genre`
--

INSERT INTO `books_vs_genre` (`id`, `id_book`, `id_genre`) VALUES
(1, 1, 1),
(2, 2, 2),
(48, 3, 27),
(52, 21, 1),
(56, 20, 27),
(57, 20, 28),
(58, 20, 29);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(12) NOT NULL,
  `genre` text NOT NULL,
  `status` int(12) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id_genre`, `genre`, `status`) VALUES
(1, 'Horror', 1),
(2, 'Western', 1),
(27, 'Fentasy', 1),
(28, 'новый', 1),
(29, 'new', 1),
(30, 'Another Genre', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_book`);

--
-- Индексы таблицы `books_vs_author`
--
ALTER TABLE `books_vs_author`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_author` (`id_author`),
  ADD KEY `id_book` (`id_book`);

--
-- Индексы таблицы `books_vs_genre`
--
ALTER TABLE `books_vs_genre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_genre` (`id_genre`),
  ADD KEY `id_book` (`id_book`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `books_vs_author`
--
ALTER TABLE `books_vs_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `books_vs_genre`
--
ALTER TABLE `books_vs_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books_vs_author`
--
ALTER TABLE `books_vs_author`
  ADD CONSTRAINT `books_vs_author_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`),
  ADD CONSTRAINT `books_vs_author_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`);

--
-- Ограничения внешнего ключа таблицы `books_vs_genre`
--
ALTER TABLE `books_vs_genre`
  ADD CONSTRAINT `books_vs_genre_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`),
  ADD CONSTRAINT `books_vs_genre_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
