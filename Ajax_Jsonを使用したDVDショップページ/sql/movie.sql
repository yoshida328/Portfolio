-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-04-10 12:40:22
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
-- テーブルの構造 `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 5,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `movie`
--

INSERT INTO `movie` (`id`, `title`, `genre`, `amount`, `stock`, `image_path`) VALUES
(1, '翔んで埼玉 ～琵琶湖より愛をこめて～', 'comedy', 3400.00, 5, 'movies_cinema/tonde.jpg'),
(2, '12人の優しい日本人', 'comedy', 2464.00, 5, 'movies_cinema/junin.jpg'),
(3, 'ゆとりですがなにか インターナショナル', 'comedy', 5914.00, 5, 'movies_cinema/yutpri.jpg'),
(4, '男はつらいよ', 'comedy', 1527.00, 5, 'movies_cinema/otokoha.jpg'),
(5, '春画先生', 'comedy', 4522.00, 5, 'movies_cinema/syunga_.jpg'),
(6, 'TOKYO MER', 'action', 4073.00, 5, 'movies_cinema/tokyo.jpg'),
(8, 'リボルバー・リリー', 'action', 3400.00, 5, 'movies_cinema/riboruba.jpg'),
(9, 'ソナチネ', 'action', 3027.00, 5, 'movies_cinema/sonatine.jpg'),
(10, 'シン・ゴジラ', 'action', 2884.00, 5, 'movies_cinema/gozira.jpg'),
(11, '東京リベンジャーズ2 血のハロウィン編', 'action', 3227.00, 5, 'movies_cinema/ribenjaz.jpg'),
(12, '世界の終わりから', 'fantasy', 7480.00, 5, 'movies_cinema/sekai.jpg'),
(13, 'ホリック xxxHOLiC', 'fantasy', 3309.00, 5, 'movies_cinema/horik.jpg'),
(14, '地下鉄(メトロ)に乗って THXスタンダード・エディション', 'fantasy', 503.00, 5, 'movies_cinema/tikatetu.jpg'),
(15, '夢', 'fantasy', 1200.00, 5, 'movies_cinema/yume.jpg'),
(16, '黄泉がえり', 'fantasy', 3100.00, 5, 'movies_cinema/yomiga.jpg'),
(17, '白石晃士の決して送ってこないで下さい2', 'horror', 3849.00, 5, 'movies_cinema/sirai.jpg'),
(18, '学校の怪談', 'horror', 1831.00, 5, 'movies_cinema/gakkoujpg.jpg'),
(19, '白石晃士の決して送ってこないで下さい1', 'horror', 3849.00, 5, 'movies_cinema/ggakkou.jpg'),
(20, '学校の怪談3', 'horror', 2000.00, 5, 'movies_cinema/gggkou.jpg'),
(21, 'Not Found 52 ―　ネットから削除された禁断動画', 'horror', 1963.00, 5, 'movies_cinema/not.jpg'),
(22, '極道恐怖大劇場 牛頭GOZU', 'horror', 2391.00, 5, 'movies_cinema/gokudo.jpg'),
(23, '岸辺露伴 ルーヴルへ行く', 'mystery', 12980.00, 5, 'movies_cinema/ruburu.jpg'),
(24, 'ミステリと言う勿れ', 'mystery', 3387.00, 5, 'movies_cinema/myste.jpg'),
(25, '怪物の木こり', 'mystery', 5773.00, 5, 'movies_cinema/kikori.jpg'),
(26, 'その男、凶暴につき', 'mystery', 3027.00, 5, 'movies_cinema/sono.jpg'),
(27, '天国と地獄', 'mystery', 1827.00, 5, 'movies_cinema/ten.jpg'),
(28, 'アナログ', 'romance', 3480.00, 5, 'movies_cinema/ana.jpg'),
(29, '私をスキーに連れてって', 'romance', 3227.00, 5, 'movies_cinema/wata.jpg'),
(30, 'わたしの幸せな結婚', 'romance', 3436.00, 5, 'movies_cinema/kekon.jpg'),
(31, '夜が明けたら、いちばんに君に会いにいく', 'romance', 4180.00, 5, 'movies_cinema/yoru.jpg'),
(32, '波の数だけ抱きしめて', 'romance', 3665.00, 5, 'movies_cinema/nami.jpg'),
(33, '連合艦隊', 'war', 1818.00, 5, 'movies_cinema/ren.jpg'),
(34, '激動の昭和史 沖縄決戦', 'war', 4036.00, 5, 'movies_cinema/oki.jpg'),
(35, '男たちの大和 / YAMATO', 'war', 3480.00, 5, 'movies_cinema/yamato.jpg'),
(36, '二百三高地', 'war', 2364.00, 5, 'movies_cinema/nihyaku.jpg'),
(37, 'ビルマの竪琴', 'war', 3689.00, 5, 'movies_cinema/biruma.jpg'),
(38, '母べえ', 'war', 2518.00, 5, 'movies_cinema/kabe.jpg'),
(39, 'ROOKIES -卒業-', 'sports', 1172.00, 5, 'movies_cinema/ruki.jpg'),
(40, 'がんばっていきまっしょい', 'sports', 5980.00, 5, 'movies_cinema/ganbate.jpg'),
(41, 'メッセンジャー', 'sports', 1214.00, 5, 'movies_cinema/mesen.jpg'),
(42, 'ピンポン', 'sports', 1891.00, 5, 'movies_cinema/pinpon.jpg'),
(43, 'がんばっぺ フラガール! ―フクシマに生きる。彼女たちのいま', 'sports', 3610.00, 5, 'movies_cinema/fura.jpg'),
(44, 'メッセンジャー１', 'sports', 1214.00, 5, 'movies_cinema/mesen.jpg'),
(45, 'メッセンジャー２', 'sports', 1214.00, 5, 'movies_cinema/mesen.jpg'),
(46, 'メッセンジャー３', 'sports', 1214.00, 5, 'movies_cinema/mesen.jpg'),
(47, 'メッセンジャー４', 'sports', 1214.00, 5, 'movies_cinema/mesen.jpg');


--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
