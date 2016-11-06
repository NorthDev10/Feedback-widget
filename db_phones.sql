-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 06 2016 г., 21:31
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_phones`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contactDetails`
--

CREATE TABLE IF NOT EXISTS `contactDetails` (
  `contactID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apiKeyId` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(512) NOT NULL,
  `phoneNumber` varchar(25) DEFAULT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `userEmail` varchar(128) DEFAULT NULL,
  `userQuestions` varchar(70) DEFAULT NULL,
  `processingStatus` tinyint(1) NOT NULL DEFAULT '0',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'если удалён, то дата удаления',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contactID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `contactDetails`
--

INSERT INTO `contactDetails` (`contactID`, `apiKeyId`, `title`, `url`, `phoneNumber`, `customerName`, `userEmail`, `userQuestions`, `processingStatus`, `dateAdded`, `removed`) VALUES
(23, 1, '', '', '', '', '', '', 0, '2016-04-08 20:19:44', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupsId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupName` varchar(15) NOT NULL,
  `rights` smallint(4) NOT NULL,
  PRIMARY KEY (`groupsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`groupsId`, `groupName`, `rights`) VALUES
(1, 'Администратор', 255),
(2, 'Пользователь', 15);

-- --------------------------------------------------------

--
-- Структура таблицы `tableApiKeys`
--

CREATE TABLE IF NOT EXISTS `tableApiKeys` (
  `userId` int(11) unsigned NOT NULL,
  `apiKeyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `apiKey` varchar(32) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `managerPhone` varchar(25) NOT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `timeZone` varchar(4) NOT NULL DEFAULT '3',
  `daylightSavingTime` tinyint(1) NOT NULL DEFAULT '0',
  `timeZoneId` varchar(6) NOT NULL DEFAULT 'tZ35',
  `workingDays` varchar(141) NOT NULL DEFAULT '[[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"]]',
  `widgetSettings` varchar(5000) NOT NULL DEFAULT '[{"btnType":0,"delayedBtn":5,"position":["","50px","40px",""],"colorRing":"#00c853","colorTube":"#00c853","soundBtn":1},{"winType":0,"bgColor":"rgba(9,121,136,0.901961)","fontColor":"#ffffff","colorCross":"#ffffff","colorBtn":["#5cb85c","#449d44","#4cae4c","#398439"],"textPrompts":"+79261234567","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u0416\\u0414\\u0423 \\u0417\\u0412\\u041e\\u041d\\u041a\\u0410","inputError":"\\u041d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u043e \\u0432\\u0432\\u0435\\u0434\\u0435\\u043d \\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]',
  PRIMARY KEY (`apiKeyId`),
  UNIQUE KEY `apiKey` (`apiKey`),
  UNIQUE KEY `domains` (`domain`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `tableApiKeys`
--

INSERT INTO `tableApiKeys` (`userId`, `apiKeyId`, `apiKey`, `domain`, `managerPhone`, `dateRegistration`, `timeZone`, `daylightSavingTime`, `timeZoneId`, `workingDays`, `widgetSettings`) VALUES
(1, 1, '92b5038dee48a047128f868b2e2a192e', '33xyz.blogspot.com', '+380994603987', '2016-01-27 11:37:45', '2', 1, 'tZ24', '[[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"],[1,"09:30","20:00"],[1,"10:30","17:00"],[1,"10:30","18:20"]]', '[{"btnType":0,"delayedBtn":"5","positionID":"3","position":["","","40px","50px"],"colorRing":"#C80C00","colorTube":"#0038C8","soundBtn":1},{"winType":0,"bgColor":"rgba(9,136,14,0.86)","fontColor":"#FFFFFF","colorCross":"#9AFFA4","colorBtn":["#557FBF","#406AAB","#4672B5","#35578c"],"textPrompts":"+380994603987","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a!","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u043f\\u043e\\u0437\\u0432\\u043e\\u043d\\u0438\\u0442\\u0435 \\u043c\\u043d\\u0435","inputError":"\\u043d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u044b\\u0439\\u00a0\\u00a0\\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]'),
(5, 2, 'edc8722124bf05d85c7bd70214deaed6', 'domiki.com.ua', '+380980228314', '2016-02-05 10:34:42', '3', 0, 'tZ32', '[[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"]]', '[{"btnType":0,"delayedBtn":"7","positionID":"2","position":["40px","50px","",""],"colorRing":"#D19337","colorTube":"#2FC96D","soundBtn":0},{"winType":0,"bgColor":"rgba(136,9,123,0.75)","fontColor":"#00EBEB","colorCross":"#0EB7FF","colorBtn":["#5C60B8","#464AA4","#4C51AE","#393c85"],"textPrompts":"+7777","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u0416\\u0414\\u0423 \\u0417\\u0412\\u041e\\u041d\\u041a\\u0410","inputError":"\\u041d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u043e \\u0432\\u0432\\u0435\\u0434\\u0435\\u043d \\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]'),
(18, 7, 'e00bf05ea2965dcf89c236c293773297', 'youtube.com', '+380980000001', '2016-03-03 21:56:03', '3', 0, 'tZ32', '[[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"]]', '[{"btnType":0,"delayedBtn":"5","positionID":"5","position":["","50px","40px",""],"colorRing":"#00C853","colorTube":"#00C853","soundBtn":1},{"winType":0,"bgColor":"rgba(9,121,136,0.901961)","fontColor":"#FFFFFF","colorCross":"#FFFFFF","colorBtn":["#5CB85C","#449D44","#4CAE4C","#398439"],"textPrompts":"+79261234567","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u0416\\u0414\\u0423 \\u0417\\u0412\\u041e\\u041d\\u041a\\u0410","inputError":"\\u041d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u043e \\u0432\\u0432\\u0435\\u0434\\u0435\\u043d \\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]'),
(1, 10, '1a7eb47ec3e92bd46890436afb40281e', 'habrahabr.ru', '+380000000', '2016-04-01 17:13:44', '3', 0, 'tZ32', '[[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"]]', '[{"btnType":0,"delayedBtn":"5","positionID":"5","position":["","50px","40px",""],"colorRing":"#00C853","colorTube":"#C400C8","soundBtn":1},{"winType":0,"bgColor":"rgba(9,121,136,0.901961)","fontColor":"#FFFFFF","colorCross":"#FFFFFF","colorBtn":["#5CB85C","#449D44","#4CAE4C","#398439"],"textPrompts":"+79261234567","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u0416\\u0414\\u0423 \\u0417\\u0412\\u041e\\u041d\\u041a\\u0410","inputError":"\\u041d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u043e \\u0432\\u0432\\u0435\\u0434\\u0435\\u043d \\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]'),
(1, 13, 'fe9ca7c23bf30e09ed327b6e624c29de', 'ide.c9.io', '+54656435', '2016-04-01 17:32:58', '-9', 1, 'tZ-91', '[[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[1,"09:30","20:00"],[0,"09:30","20:00"],[0,"09:30","20:00"]]', '[{"btnType":0,"delayedBtn":"5","positionID":"5","position":["","50px","40px",""],"colorRing":"#00C853","colorTube":"#00C853","soundBtn":1},{"winType":0,"bgColor":"rgba(9,121,136,0.901961)","fontColor":"#FFFFFF","colorCross":"#FFFFFF","colorBtn":["#5CB85C","#449D44","#4CAE4C","#398439"],"textPrompts":"+79261234567","title":"\\u0417\\u0430\\u043a\\u0430\\u0436\\u0438\\u0442\\u0435 \\u043e\\u0431\\u0440\\u0430\\u0442\\u043d\\u044b\\u0439 \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a","subtitle":"\\u041d\\u0430\\u0448 \\u043b\\u0443\\u0447\\u0448\\u0438\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0441\\u0442 \\u0441\\u0432\\u044f\\u0436\\u0435\\u0442\\u0441\\u044f \\u0441 \\u0432\\u0430\\u043c\\u0438 \\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 30 \\u0441\\u0435\\u043a\\u0443\\u043d\\u0434.","btnText":"\\u0416\\u0414\\u0423 \\u0417\\u0412\\u041e\\u041d\\u041a\\u0410","inputError":"\\u041d\\u0435\\u043a\\u043e\\u0440\\u0440\\u0435\\u043a\\u0442\\u043d\\u043e \\u0432\\u0432\\u0435\\u0434\\u0435\\u043d \\u043d\\u043e\\u043c\\u0435\\u0440 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u0430"}]');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userPwd` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `emailConfirmation` tinyint(1) NOT NULL DEFAULT '0',
  `vkAccessToken` varchar(255) DEFAULT NULL,
  `vkUserId` varchar(50) DEFAULT NULL,
  `googleUserId` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `mobilePhone` varchar(25) DEFAULT NULL,
  `homePhone` varchar(25) DEFAULT NULL,
  `skype` varchar(32) DEFAULT NULL,
  `siteURL` varchar(255) DEFAULT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateLastEntry` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(40) DEFAULT NULL,
  `groupId` int(11) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `vkUserId` (`vkUserId`),
  UNIQUE KEY `googleUserId` (`googleUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`userId`, `userPwd`, `email`, `emailConfirmation`, `vkAccessToken`, `vkUserId`, `googleUserId`, `firstName`, `lastName`, `mobilePhone`, `homePhone`, `skype`, `siteURL`, `dateRegistration`, `dateLastEntry`, `ipAddress`, `groupId`) VALUES
(1, '$2y$10$E5SV/EnRsAoilAGIDd.lgesosVrKY0XKuUMu.k5N6DBekkjO6ZyGK', 'd.drehval@gmail.com', 1, '', '', '', 'Дмитрий', 'Дрегваль', '+380994603987', '+380980228314', 'example', 'https://db-phone-numbers-dregvali-1.c9users.io/', '2016-01-28 10:25:34', '2016-10-31 09:41:50', '10.240.0.177', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
