-- phpMyAdmin SQL Dump
-- version 3.4.6
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 13 2013 г., 15:53
-- Версия сервера: 5.1.58
-- Версия PHP: 5.3.6-13ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `testing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `BLOCKS`
--

CREATE TABLE IF NOT EXISTS `BLOCKS` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `BLOCK_ITEMS`
--

CREATE TABLE IF NOT EXISTS `BLOCK_ITEMS` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `block_id` int(11) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `active_from` int(11) NOT NULL,
  `preview_text` text NOT NULL,
  `full_text` text NOT NULL,
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `DOMAINS`
--

CREATE TABLE IF NOT EXISTS `DOMAINS` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(100) NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `DOMAINS`
--

INSERT INTO `DOMAINS` (`id`, `domain_name`, `site_id`) VALUES
(1, 'test.vm', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ROLES`
--

CREATE TABLE IF NOT EXISTS `ROLES` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `access` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ROLES`
--

INSERT INTO `ROLES` (`id`, `name`, `access`) VALUES
(1, 'admin', '{"allow":{"index":"*","admin":"*"},"deny":{}}');

-- --------------------------------------------------------

--
-- Структура таблицы `SITES`
--

CREATE TABLE IF NOT EXISTS `SITES` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `folder` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `SITES`
--

INSERT INTO `SITES` (`id`, `title`, `folder`) VALUES
(1, 'Тестовый сайт', 'test');

-- --------------------------------------------------------

--
-- Структура таблицы `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL,
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `USERS`
--

INSERT INTO `USERS` (`id`, `username`, `password`, `active`, `role_id`, `changed`, `created`) VALUES
(1, 'admin', '123', 1, 1, '2013-02-12 10:31:44', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
