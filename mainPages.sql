-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 01 2016 г., 21:12
-- Версия сервера: 5.5.45
-- Версия PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mainPages`
--

CREATE TABLE IF NOT EXISTS `mainPages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `href` varchar(77) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `href` (`href`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `mainPages`
--

INSERT INTO `mainPages` (`id`, `href`, `title`, `description`, `text`) VALUES
(1, '', 'Главная', 'Наш сайт - самый гуманный сайт в мире', 'Мы создаём эксклюзив'),
(2, 'about', 'о нас', 'О нас', 'О нас .......................... '),
(3, 'contacts', 'Наши контакты', 'Свяжитесь с нами, и будете довольны', 'Свяжитесь с нами, и будете довольны'),
(4, 'portfolio', 'Портфолио', 'Наше портфолио', 'Тут пока пусто :D'),
(5, 'plugins', 'Плагины', 'Мы пишем плагины', 'Мы пишем плагины в любое время суток');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
