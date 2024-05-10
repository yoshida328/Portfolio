-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-04-22 11:14:42
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
-- テーブルの構造 `member`
--

CREATE TABLE `member` (
  `id` int(100) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `order_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `member`
--

INSERT INTO `member` (`id`, `Name`, `Address`, `mail`, `password`, `order_id`) VALUES
(41, 'uechi', 'oosaka', 'sss@aa.a', '$2y$10$li8PX5vtWU5V4NI6ZSwNKuesOqVmsf3AHNN1fZZ2jVB055fqMhuBi', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `amount` int(15) NOT NULL,
  `stock` int(11) DEFAULT 5,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `movie`
--

INSERT INTO `movie` (`id`, `title`, `genre`, `amount`, `stock`, `image_path`) VALUES
(1, '翔んで埼玉 ～琵琶湖より愛をこめて～', 'comedy', 3400, 1, '\"tonde.jpg\"'),
(2, '12人の優しい日本人', 'comedy', 2464, 4, '\"junin.jpg\"'),
(3, 'ゆとりですがなにか インターナショナル', 'comedy', 5914, 5, '\"yutpri.jpg\"'),
(4, '男はつらいよ', 'comedy', 1527, 4, '\"otokoha.jpg\"'),
(5, '春画先生', 'comedy', 4522, 5, '\"syunga_.jpg\"'),
(6, 'TOKYO MER', 'action', 4073, 4, '\"tokyo.jpg\"'),
(8, 'リボルバー・リリー', 'action', 3400, 5, '\"riboruba.jpg\"'),
(9, 'ソナチネ', 'action', 3027, 5, '\"sonatine.jpg\"'),
(10, 'シン・ゴジラ', 'action', 2884, 5, '\"gozira.jpg\"'),
(11, '東京リベンジャーズ2 血のハロウィン編', 'action', 3227, 5, '\"ribenjaz.jpg\"'),
(12, '世界の終わりから', 'fantasy', 7480, 5, '\"sekai.jpg\"'),
(13, 'ホリック xxxHOLiC', 'fantasy', 3309, 5, '\"horik.jpg\"'),
(14, '地下鉄(メトロ)に乗って THXスタンダード・エディション', 'fantasy', 503, 5, '\"tikatetu.jpg\"'),
(15, '夢', 'fantasy', 1200, 5, '\"yume.jpg\"'),
(16, '黄泉がえり', 'fantasy', 3100, 5, '\"yomiga.jpg\"'),
(17, '白石晃士の決して送ってこないで下さい2', 'horror', 3849, 5, '\"sirai.jpg\"'),
(18, '学校の怪談', 'horror', 1831, 5, '\"gakkoujpg.jpg\"'),
(19, '白石晃士の決して送ってこないで下さい1', 'horror', 3849, 5, '\"ggakkou.jpg\"'),
(20, '学校の怪談3', 'horror', 2000, 5, '\"gggkou.jpg\"'),
(21, 'Not Found 52 ―　ネットから削除された禁断動画', 'horror', 1963, 5, '\"not.jpg\"'),
(22, '極道恐怖大劇場 牛頭GOZU', 'horror', 2391, 5, '\"gokudo.jpg\"'),
(23, '岸辺露伴 ルーヴルへ行く', 'mystery', 12980, 5, '\"ruburu.jpg\"'),
(24, 'ミステリと言う勿れ', 'mystery', 3387, 5, '\"myste.jpg\"'),
(25, '怪物の木こり', 'mystery', 5773, 5, '\"kikori.jpg\"'),
(26, 'その男、凶暴につき', 'mystery', 3027, 5, '\"sono.jpg\"'),
(27, '天国と地獄', 'mystery', 1827, 5, '\"ten.jpg\"'),
(28, 'アナログ', 'romance', 3480, 5, '\"ana.jpg\"'),
(29, '私をスキーに連れてって', 'romance', 3227, 5, '\"wata.jpg\"'),
(30, 'わたしの幸せな結婚', 'romance', 3436, 5, '\"kekon.jpg\"'),
(31, '夜が明けたら、いちばんに君に会いにいく', 'romance', 4180, 5, '\"yoru.jpg\"'),
(32, '波の数だけ抱きしめて', 'romance', 3665, 5, '\"nami.jpg\"'),
(33, '連合艦隊', 'war', 1818, 5, '\"ren.jpg\"'),
(34, '激動の昭和史 沖縄決戦', 'war', 4036, 5, '\"oki.jpg\"'),
(35, '男たちの大和 / YAMATO', 'war', 3480, 5, '\"yamato.jpg\"'),
(36, '二百三高地', 'war', 2364, 5, '\"nihyaku.jpg\"'),
(37, 'ビルマの竪琴', 'war', 3689, 5, '\"biruma.jpg\"'),
(38, '母べえ', 'war', 2518, 5, '\"kabe.jpg\"'),
(39, 'ROOKIES -卒業-', 'sports', 1172, 5, '\"ruki.jpg\"'),
(40, 'がんばっていきまっしょい', 'sports', 5980, 5, '\"ganbate.jpg\"'),
(41, 'メッセンジャー', 'sports', 1214, 5, '\"mesen.jpg\"'),
(42, 'ピンポン', 'sports', 1891, 5, '\"pinpon.jpg\"'),
(43, 'がんばっぺ フラガール! ―フクシマに生きる。彼女たちのいま', 'sports', 3610, 5, '\"fura.jpg\"');

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
(13, '', '三軒家西三丁目６－１８', 'tkms0831@gmail.com', '翔んで埼玉 ～琵琶湖より愛をこめて～', 3400, 1, 3400, '2024-04-19', 6621),
(14, '', 'oosaka', 'sss@aa.a', '12人の優しい日本人', 2464, 1, 2464, '2024-04-21', 6624),
(15, '', 'oosaka', 'sss@aa.a', '翔んで埼玉 ～琵琶湖より愛をこめて～', 3400, 1, 3400, '2024-04-21', 6624);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- テーブルの AUTO_INCREMENT `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
