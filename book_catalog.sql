-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 04 2020 г., 01:26
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `book catalog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id_author` int(11) NOT NULL,
  `author` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`id_author`, `author`) VALUES
(1, 'James Martin'),
(2, 'Lyios Num'),
(3, 'Дж. Роналд Толкиен');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `book_name` varchar(256) NOT NULL,
  `short_descr` varchar(256) NOT NULL,
  `full_descr` text NOT NULL,
  `price` varchar(256) NOT NULL,
  `images` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id_book`, `book_name`, `short_descr`, `full_descr`, `price`, `images`) VALUES
(1, 'The Witcher', 'КУ-КУsssssssss', 'КУ-КУ-КУ-', '600', 'img/uploads/5e4910d85890a.jpeg'),
(2, 'Game of Thrones', 'sdasdadsadasdasdasdasdasdasdasdasd', 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '20', 'img/uploads/5e42f79c8422b.jpeg'),
(3, 'The Day Become', 'vvvvvvvvvv', 'sadadasdasdasdadaasdadasdasdasd\r\nasdasdasd', '30', 'img/phone_no image.png'),
(4, 'The Day Become', 'vvvvvvvvvv', 'sadadasdasdasdadaasdadasdasdasd\r\nasdasdasd', '30', 'img/phone_no image.png'),
(13, 'Хоббит', 'В норе под землей...', '...жил был хоббит', '900', 'img/uploads/5e389a441a08c.jpeg'),
(58, 'asdadas', 'dasda', 'dadasdasd', '10', 'img/phone_no image.png'),
(59, 'какая-тьол', 'фывфыв', 'фывфывфыв', '20', 'img/phone_no image.png'),
(99, 'новая книга', 'new', 'newnewnew', '777', 'img/phone_no image.png');

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
(3, 3, 3),
(4, 4, 1),
(5, 13, 3),
(8, 59, 3),
(15, 58, 1),
(25, 2, 3),
(29, 1, 2),
(44, 99, 1),
(45, 99, 2),
(46, 99, 3);

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
(3, 3, 3),
(4, 4, 2),
(5, 13, 3),
(8, 59, 2),
(13, 58, 1),
(27, 2, 1),
(30, 1, 3),
(44, 99, 1),
(45, 99, 2),
(46, 99, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `genre` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id_genre`, `genre`) VALUES
(1, 'Horror'),
(2, 'Western'),
(3, 'Fentasy');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
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
  ADD KEY `id_book` (`id_book`),
  ADD KEY `id_genre` (`id_genre`);

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
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT для таблицы `books_vs_author`
--
ALTER TABLE `books_vs_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `books_vs_genre`
--
ALTER TABLE `books_vs_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books_vs_author`
--
ALTER TABLE `books_vs_author`
  ADD CONSTRAINT `books_vs_author_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`),
  ADD CONSTRAINT `books_vs_author_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`);

--
-- Ограничения внешнего ключа таблицы `books_vs_genre`
--
ALTER TABLE `books_vs_genre`
  ADD CONSTRAINT `books_vs_genre_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`),
  ADD CONSTRAINT `books_vs_genre_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
