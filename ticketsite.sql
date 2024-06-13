-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-13 09:48:55
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `ticketsite`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `history`
--

CREATE TABLE `history` (
  `hid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `apply_time` datetime NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1,
  `hit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `history`
--

INSERT INTO `history` (`hid`, `uid`, `lid`, `apply_time`, `flag`, `hit`) VALUES
(1, 1, 1, '2024-06-11 11:23:43', 1, 1),
(2, 1, 2, '2024-06-11 11:53:29', 1, -1),
(3, 1, 3, '2024-06-11 15:07:48', 1, 1),
(4, 1, 8, '2024-06-12 14:18:06', 1, 1),
(5, 1, 9, '2024-06-12 14:47:27', 1, 1),
(6, 3, 9, '2024-06-12 14:48:00', 1, 1),
(7, 2, 1, '2024-06-12 14:48:32', 1, 1),
(8, 2, 9, '2024-06-12 14:48:37', 1, 1),
(9, 2, 7, '2024-06-12 14:48:43', 1, 0),
(10, 14, 9, '2024-06-13 11:18:35', 1, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `inquiry`
--

CREATE TABLE `inquiry` (
  `no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `lid` int(11) DEFAULT 0,
  `time` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `inquiry`
--

INSERT INTO `inquiry` (`no`, `name`, `email`, `text`, `lid`, `time`, `status`) VALUES
(1, 'dasd', 'aaa@aa.coｍ', 'dasda_kaigyou_sdasdasda_kaigyou_asdasdas', 0, '2024-06-11 15:00:59', 1),
(2, 'aaa', 'adasd@daas', 'dhfkh_kaigyou_]dasfdkfhla_kaigyou_dasdasd_kaigyou_fasdas_kaigyou_fdasda', 2, '2024-06-11 15:04:41', 0),
(3, 'zxcZXZ', 'czxcvazxcas@asdasd', 'asdfafsgaffasfawxvcvsdfvahgreg', 0, '2024-06-11 15:06:02', 1),
(4, 'aaaa', 'sasas@dvs', 'dhshgh_kaigyou_gsdfgsdfgdfg_kaigyou_sfdgsdfgdfs', 0, '2024-06-11 15:11:40', 0),
(5, 'aaa', 'a1234@abc', 'asdasfdsa_kaigyou_456465_kaigyou_121313_kaigyou_wdqefwdgfws', 0, '2024-06-12 14:18:41', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `livelist`
--

CREATE TABLE `livelist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `artist` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `day` date DEFAULT NULL,
  `daytime` time DEFAULT NULL,
  `lprofile` text DEFAULT NULL,
  `lclass` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `flag` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `livelist`
--

INSERT INTO `livelist` (`id`, `name`, `artist`, `place`, `day`, `daytime`, `lprofile`, `lclass`, `price`, `type`, `status`, `flag`) VALUES
(1, 'aaa', 'test', '千葉県', '2024-06-16', '15:30:00', NULL, NULL, NULL, NULL, 1, 1),
(2, 'aaa', 'test', '東京都', '2024-06-15', '18:30:00', NULL, NULL, NULL, NULL, 1, 1),
(3, 'aaa', 'test', '千葉県', '2024-06-16', '18:30:00', NULL, NULL, NULL, NULL, 1, 1),
(4, 'live B', 'bbb', '東京都', '2024-06-29', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(5, 'live B', 'bbb', '東京都', '2024-06-22', '15:00:00', NULL, NULL, NULL, NULL, 0, 1),
(6, 'live A', 'a1', '大阪府', '2024-06-22', '18:30:00', NULL, NULL, NULL, NULL, 0, 1),
(7, 'live A', 'a1', '大阪府', '2024-06-22', '15:30:00', NULL, NULL, NULL, NULL, 0, 1),
(8, 'aaa', 'test', '東京都', '2024-06-15', '15:30:00', NULL, NULL, NULL, NULL, 1, 1),
(9, 'c!', 'cccc', '東京都', '2024-06-29', '18:30:00', NULL, NULL, NULL, NULL, 1, 1),
(10, 'c!', 'cccc', '東京都', '2024-06-30', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(11, 'days', 'd15', '東京都', '2024-06-30', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(12, 'days', 'd15', '神奈川県', '2024-06-29', '18:00:00', NULL, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `place`
--

CREATE TABLE `place` (
  `pid` int(11) NOT NULL,
  `prefecture` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `numberofpeople` int(11) DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `flag` int(11) DEFAULT 1,
  `login_time` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`uid`, `id`, `name`, `pwd`, `flag`, `login_time`, `last_login`) VALUES
(1, 'aaa@aa.coｍ', 'あああ', 'aaa123', 1, NULL, NULL),
(2, 'bbb@aa.coｍ', 'ああ', 'bbb123', 1, NULL, NULL),
(3, 'hntshoyo@hq.com', 'shoyo', 'pwd123', 1, NULL, NULL),
(4, 'tobio.kageyama@hq.com', 'kgym', 'pwd123', 1, NULL, NULL),
(5, 'kodzuken@hq.com', 'kodzuken', 'pwd123', 1, NULL, NULL),
(6, 'kuro@hq.com', 'kuro', 'pwd123', 1, NULL, NULL),
(7, 'a1234@aa.com', 'a1234', 'pwd111', 1, NULL, NULL),
(8, 'a4444@abc.abc', '山田太郎', 'pwd123', 1, NULL, NULL),
(9, 'bbb5656@abc.abc', '山田二郎', 'ppp123', 1, NULL, NULL),
(10, 'a1234@abc.abc', 'yamada', 'bbb123', 1, NULL, NULL),
(11, 'manager01@at.co.jp', 'manager01', 'aaa!!!123', 0, NULL, NULL),
(12, 'manager02@at.co.jp', 'manager02', 'bbb!!!123', 0, NULL, NULL),
(13, 'kkk', 'kkkk', 'kkk123', 1, NULL, NULL),
(14, 'cccc@aa.coｍ', 'caa', 'ccc123', 1, NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`hid`);

--
-- テーブルのインデックス `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`no`);

--
-- テーブルのインデックス `livelist`
--
ALTER TABLE `livelist`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`pid`);

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `livelist`
--
ALTER TABLE `livelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- テーブルの AUTO_INCREMENT `place`
--
ALTER TABLE `place`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
