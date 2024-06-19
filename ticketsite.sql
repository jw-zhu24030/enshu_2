-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-19 09:51:00
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
(2, 1, 2, '2024-06-11 11:53:29', 1, 1),
(3, 1, 3, '2024-06-11 15:07:48', 1, 1),
(4, 1, 8, '2024-06-12 14:18:06', 1, 1),
(5, 1, 9, '2024-06-12 14:47:27', 1, 1),
(6, 3, 9, '2024-06-12 14:48:00', 1, 1),
(7, 2, 1, '2024-06-12 14:48:32', 1, 1),
(8, 2, 9, '2024-06-12 14:48:37', 1, 1),
(9, 2, 7, '2024-06-12 14:48:43', 0, 0),
(10, 14, 9, '2024-06-13 11:18:35', 1, 1),
(11, 1, 12, '2024-06-17 11:54:29', 1, 0),
(12, 1, 6, '2024-06-17 13:01:42', 1, 1),
(13, 1, 10, '2024-06-17 13:01:48', 1, -1),
(14, 16, 1, '2024-06-17 14:26:16', 0, 1),
(15, 16, 7, '2024-06-17 14:26:30', 1, 0),
(16, 18, 1, '2024-06-17 15:53:30', 1, 1),
(17, 18, 2, '2024-06-17 15:53:35', 1, 1),
(18, 18, 3, '2024-06-17 15:53:41', 1, 0),
(19, 18, 4, '2024-06-17 15:54:38', 1, 0),
(20, 18, 11, '2024-06-17 15:55:27', 1, 0),
(21, 18, 5, '2024-06-17 15:55:34', 1, 1),
(22, 18, 6, '2024-06-17 15:55:40', 1, 1),
(23, 18, 9, '2024-06-17 16:29:12', 1, 0),
(24, 16, 14, '2024-06-18 09:41:42', 0, 0),
(25, 16, 12, '2024-06-18 09:41:48', 1, 0),
(26, 16, 11, '2024-06-18 09:41:52', 1, 0),
(27, 16, 10, '2024-06-18 09:41:57', 1, -1),
(28, 16, 6, '2024-06-18 09:46:39', 1, 1),
(29, 19, 12, '2024-06-18 10:25:18', 1, 0),
(30, 19, 11, '2024-06-18 10:25:29', 1, 0),
(31, 19, 10, '2024-06-18 10:25:34', 1, -1),
(32, 19, 5, '2024-06-18 10:26:11', 1, 1),
(33, 19, 14, '2024-06-18 10:26:17', 1, 0),
(34, 25, 18, '2024-06-19 10:00:09', 1, 0),
(35, 25, 17, '2024-06-19 10:00:19', 1, 0),
(36, 25, 16, '2024-06-19 10:00:34', 1, 0),
(37, 25, 12, '2024-06-19 10:00:46', 1, 0),
(38, 16, 8, '2024-06-19 11:52:30', 1, 0);

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
(2, 'aaa', 'adasd@daas', 'dhfkh_kaigyou_]dasfdkfhla_kaigyou_dasdasd_kaigyou_fasdas_kaigyou_fdasda', 2, '2024-06-11 15:04:41', 1),
(3, 'zxcZXZ', 'czxcvazxcas@asdasd', 'asdfafsgaffasfawxvcvsdfvahgreg', 0, '2024-06-11 15:06:02', 1),
(4, 'aaaa', 'sasas@dvs', 'dhshgh_kaigyou_gsdfgsdfgdfg_kaigyou_sfdgsdfgdfs', 0, '2024-06-11 15:11:40', 1),
(5, 'aaa', 'a1234@abc', 'asdasfdsa_kaigyou_456465_kaigyou_121313_kaigyou_wdqefwdgfws', 0, '2024-06-12 14:18:41', 1),
(6, 'aaa', 'a1234@abc', 'SDFagfvadsgagvdf_kaigyou_adsfasdf_kaigyou__kaigyou_asasdsd_kaigyou__kaigyou_dasd_kaigyou_zxcz', 2, '2024-06-17 09:40:46', 1),
(7, 'aaaaaaa', 'asas@dasd', 'afsfasd_kaigyou_kfhkjhkg_kaigyou_ghjghj_kaigyou_kghkjgkjhgjgh', 0, '2024-06-17 09:45:44', 0),
(8, 'aaaaaaa', 'asas@dasd', 'afsfasd_kaigyou_kfhkjhkg_kaigyou_ghjghj_kaigyou_kghkjgkjhgjgh', 0, '2024-06-17 09:45:44', 0),
(9, 'aaaaaaa', 'asas@dasd', 'afsfasd_kaigyou_kfhkjhkg_kaigyou_ghjghj_kaigyou_kghkjgkjhgjgh', 0, '2024-06-17 09:45:44', 1),
(10, 'aa', 'sasas@dvsad.ads', 'adfasd_kaigyou__kaigyou_asdad_kaigyou__kaigyou__kaigyou_qwreweqwe', 0, '2024-06-17 14:36:01', 0),
(11, 'aa', 'sasas@dvsad.ads', 'adfasd_kaigyou__kaigyou_asdad_kaigyou__kaigyou__kaigyou_qwreweqwe', 0, '2024-06-17 14:36:01', 0),
(12, 'aa', 'sasas@dvsad.ads', 'adfasd_kaigyou__kaigyou_asdad_kaigyou__kaigyou__kaigyou_qwreweqwe', 0, '2024-06-17 14:36:01', 0),
(13, 'a', 'a@a.a', 'a', 0, '2024-06-17 15:45:43', 0),
(14, 'gsdg', 'a1234@abc.aa', 'sdgsdfsg_kaigyou_dgfjhdh_kaigyou__kaigyou__kaigyou_dfghsdfgs_kaigyou_dh', 0, '2024-06-18 09:47:46', 0),
(15, 'fgdfgd', 'a1234@abcfa.ff', 'fasfadf', 0, '2024-06-18 10:18:24', 0),
(16, 'aa', 'qwert@zxc.asd', 'asdasfdfvsdVZDvgasdgaDg_kaigyou__kaigyou_sdfa', 0, '2024-06-18 10:26:46', 0),
(17, 'zxcc', 'zxc@zx.zx', '456_kaigyou_asdasd_kaigyou__kaigyou_dasdasd_kaigyou_fwsdas_kaigyou_asd', 12, '2024-06-19 09:59:16', 0),
(18, 'ｆｆｆ', 'sasas@dvsad.ads', 'fadfasdfasfc_kaigyou__kaigyou__kaigyou_dasd_kaigyou_dasda', 0, '2024-06-19 11:51:53', 0),
(19, 'aa', 'aaa@aa.com', 'dasd', 0, '2024-06-19 14:04:30', 1);

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
(4, 'live B', 'bbb', '東京都', '2024-06-29', '18:00:00', NULL, NULL, NULL, NULL, 1, 1),
(5, 'live B', 'bbb', '東京都', '2024-06-22', '15:00:00', NULL, NULL, NULL, NULL, 1, 1),
(6, 'live A', 'a1', '大阪府', '2024-06-22', '18:30:00', NULL, NULL, NULL, NULL, 1, 1),
(7, 'live A', 'a1', '大阪府', '2024-06-22', '15:30:00', NULL, NULL, NULL, NULL, 0, 1),
(8, 'aaa', 'test', '東京都', '2024-06-15', '15:30:00', NULL, NULL, NULL, NULL, 1, 1),
(9, 'c!', 'cccc', '東京都', '2024-06-29', '18:30:00', NULL, NULL, NULL, NULL, 1, 1),
(10, 'c!', 'cccc1', '東京都', '2024-06-30', '18:00:00', NULL, NULL, NULL, NULL, 1, 1),
(11, 'days', 'd15', '東京都', '2024-06-30', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(12, 'days', 'd15', '神奈川県', '2024-06-29', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(13, 'sas', 'test', '北海道', '2024-07-06', '16:30:00', NULL, NULL, NULL, NULL, 0, 0),
(14, 't0', 't00', '北海道', '2024-07-06', '17:30:00', NULL, NULL, NULL, NULL, 1, 1),
(15, '', '', '', '0000-00-00', '00:00:00', NULL, NULL, NULL, NULL, 0, 0),
(16, 'forever', 'ffff', '東京都', '2024-07-06', '18:00:00', NULL, NULL, NULL, NULL, 0, 1),
(17, 'guess', 'g22', '大阪府', '2024-07-06', '17:30:00', NULL, NULL, NULL, NULL, 0, 1),
(18, 'guess', 'g22', '大阪府', '2024-07-06', '14:00:00', NULL, NULL, NULL, NULL, 0, 1),
(19, 'ttt', 't1', '東京都', '2024-06-29', '18:00:00', NULL, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL DEFAULT 0,
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
(1, 'aaa@aa.coｍ', 'あああ', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(2, 'bbb@aa.coｍ', 'ああ', 'bbb123', 1, NULL, NULL),
(3, 'hntshoyo@hq.com', 'shoyo', '3838bd5806d32cd91144865aa822b9551417dd2796c163d390baa7074d3067a7', 1, NULL, NULL),
(4, 'tobio.kageyama@hq.com', 'kgym', '3838bd5806d32cd91144865aa822b9551417dd2796c163d390baa7074d3067a7', 1, NULL, NULL),
(5, 'kodzuken@hq.com', 'kodzuken', '3838bd5806d32cd91144865aa822b9551417dd2796c163d390baa7074d3067a7', 1, NULL, NULL),
(6, 'kuro@hq.com', 'kuro', '3838bd5806d32cd91144865aa822b9551417dd2796c163d390baa7074d3067a7', 1, NULL, NULL),
(7, 'a1234@aa.com', 'a1234', '07c9f005ea0fb70fc48531e25a3a13e434e721dbc858c0b799568c3cafb2534c', 1, NULL, NULL),
(8, 'a4444@abc.abc', '山田太郎', '3838bd5806d32cd91144865aa822b9551417dd2796c163d390baa7074d3067a7', 1, NULL, NULL),
(9, 'bbb5656@abc.abc', '山田二郎', 'ac0993bdb8f880f7648f5cb66efadb46177cdd848c9f3e3b4a1f6775b43bec53', 1, NULL, NULL),
(10, 'a1234@abc.abc', 'yamada', 'b6ae50adeba1f4010fd19b0f3bf7dc20f6522269e22cf6886bc85f911ed5ccc1', 1, NULL, NULL),
(11, 'manager01@at.co.jp', 'manager01', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(12, 'manager02@at.co.jp', 'manager02', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(13, 'kkk', 'kkkk', '330ab5315ad8cdb57233fd00720fc1cb3009b87eec7745d8b31b3e513239a910', 1, NULL, NULL),
(14, 'cccc@aa.coｍ', 'caa', '1aacc9b411e8a85c182dc4859e2cc0a9094d1a6f74b9706a44318f150b951298', 1, NULL, NULL),
(15, 'aaa@aa', 'fdsada', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(16, 'aaa@aa.com', 'aaa', 'aaa123', 1, NULL, NULL),
(17, 'a1234@abc.dd', 'gdsgs', 'e8eeb63f11605324ef956fe761a38ab4b2161242a9216345316a0ded6e900735', 1, NULL, NULL),
(18, 'a4567@abc.dd', 'zxc', 'e8eeb63f11605324ef956fe761a38ab4b2161242a9216345316a0ded6e900735', 1, NULL, NULL),
(19, 'qwert@zxc.asd', 'qwert', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(20, 'qwert@zxc.asd1', 'qwert1', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(21, 'qwert2@zxc.asd', 'qwert2', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(22, 'qwert3@zxc.asd', 'qwert3', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(23, 'qwert4@zxc.asd', 'qwert4', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(24, 'asd@qwert.zxc', 'aaa', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(25, 'zx@zx.zx', 'zx', '7c04837eb356565e28bb14e5a1dedb240a5ac2561f8ed318c54a279fb6a9665e', 1, NULL, NULL),
(26, 'qwe@qw.qw', 'a', 'ef70fa269d0cce2a4edcb51dca96dc6e9aafe4adfb235d80290d08035fa5b236', 1, NULL, NULL),
(27, 'a@asd.asd', 'aaa', 'f64561e04c3be9cea6271afcd2b324f4b8654ed1b011f4f15ff4436e0100d5a0', 1, NULL, NULL),
(28, 'manager03@at.co.jp', 'manager03', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(29, 'manager04@at.co.jp', 'manager04', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `user_backup`
--

CREATE TABLE `user_backup` (
  `uid` int(11) NOT NULL,
  `id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `flag` int(11) DEFAULT 1,
  `login_time` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `user_backup`
--

INSERT INTO `user_backup` (`uid`, `id`, `name`, `pwd`, `flag`, `login_time`, `last_login`) VALUES
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
(11, 'manager01@at.co.jp', 'manager01', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(12, 'manager02@at.co.jp', 'manager02', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(13, 'kkk', 'kkkk', 'kkk123', 1, NULL, NULL),
(14, 'cccc@aa.coｍ', 'caa', 'ccc123', 1, NULL, NULL),
(15, 'aaa@aa', 'fdsada', 'aaa123', 1, NULL, NULL),
(16, 'aaa@aa.com', 'aaa', 'aaa123', 1, NULL, NULL),
(17, 'a1234@abc.dd', 'gdsgs', '1234aaa', 1, NULL, NULL),
(18, 'a4567@abc.dd', 'zxc', '1234aaa', 1, NULL, NULL),
(19, 'qwert@zxc.asd', 'qwert', 'aaa123', 1, NULL, NULL),
(20, 'qwert@zxc.asd1', 'qwert1', 'aaa123', 1, NULL, NULL),
(21, 'qwert2@zxc.asd', 'qwert2', 'aaa123', 1, NULL, NULL),
(22, 'qwert3@zxc.asd', 'qwert3', 'aaa123', 1, NULL, NULL),
(23, 'qwert4@zxc.asd', 'qwert4', 'aaa123', 1, NULL, NULL),
(24, 'asd@qwert.zxc', 'aaa', 'aaa123', 1, NULL, NULL),
(25, 'zx@zx.zx', 'zx', 'a123', 1, NULL, NULL),
(26, 'qwe@qw.qw', 'a', 'q1234', 1, NULL, NULL),
(27, 'a@asd.asd', 'aaa', 'aaa123', 1, NULL, NULL),
(28, 'manager03@at.co.jp', 'manager03', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL),
(29, 'manager04@at.co.jp', 'manager04', 'd6ffbc37b294760b28ff2f1299f9172028ffb18fdbba5b34b294615328da8984', 0, NULL, NULL);

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
-- テーブルのインデックス `user_backup`
--
ALTER TABLE `user_backup`
  ADD PRIMARY KEY (`uid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- テーブルの AUTO_INCREMENT `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- テーブルの AUTO_INCREMENT `livelist`
--
ALTER TABLE `livelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- テーブルの AUTO_INCREMENT `user_backup`
--
ALTER TABLE `user_backup`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
