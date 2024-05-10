-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2024 年 4 月 12 日 05:01
-- サーバのバージョン： 5.7.39
-- PHP のバージョン: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `cinema`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `orders id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `title` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total prise` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`orders id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `member`
--

INSERT INTO `member` (`orders id`, `name`, `address`, `mail`, `title`, `amount`, `quantity`, `total prise`, `time`) VALUES
(2, '鈴木 花子', '大阪府大阪市2-3-4', 'hanako.suzuki@example.com', '商品B', 1500, 1, 1500, '2024-04-11 13:00:00'),
(3, '高寺', '大阪府泉大津市', 'aaaaaa@aaaaa.com', 'ああああああああああ', 1000, 1, 1000, '2024-04-12 03:15:38'),
(4, '高寺', '大阪府泉大津市', 'aaaaaa@aaaaa.com', 'ああああああああああ', 1000, 1, 1000, '2024-04-12 03:15:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
