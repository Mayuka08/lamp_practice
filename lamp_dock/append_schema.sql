-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 3 月 24 日 15:38
-- サーバのバージョン： 5.7.33
-- PHP のバージョン: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `purchase_details`
--

CREATE TABLE `purchase_details` (
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT '0',
  `order_datetime` datetime DEFAULT NULL,
  `purchase_price` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `purchase_history`
--

CREATE TABLE `purchase_history` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`order_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
