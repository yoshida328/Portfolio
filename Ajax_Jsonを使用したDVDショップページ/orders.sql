-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-04-22 11:58:44
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
-- データベース: `cinema`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Amount` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `total_price` int(200) NOT NULL,
  `time` datetime NOT NULL,
  `order_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `orders`
--

INSERT INTO `orders` (`id`, `Name`, `Address`, `mail`, `Title`, `Amount`, `quantity`, `total_price`, `time`, `order_id`) VALUES
(13, '', '三軒家西三丁目６－１８', 'tkms0831@gmail.com', '翔んで埼玉 ～琵琶湖より愛をこめて～', 3400, 1, 3400, '2024-04-19 00:00:00', 6621),
(14, '', 'oosaka', 'sss@aa.a', '12人の優しい日本人', 2464, 1, 2464, '2024-04-21 00:00:00', 6624),
(15, '', 'oosaka', 'sss@aa.a', '翔んで埼玉 ～琵琶湖より愛をこめて～', 3400, 1, 3400, '2024-04-21 00:00:00', 6624);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
