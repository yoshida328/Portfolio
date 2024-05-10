-- データベース作成
CREATE DATABASE IF NOT EXISTS review DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 使用するデータベースを選択
USE review;

-- テーブル作成
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, -- 一意制約を追加
    password VARCHAR(255) NOT NULL
);

-- テーブルのCHARACTER SETとCOLLATIONを設定
ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO users (username, email, password) VALUES
('Koki Yoshida', 'yoshida@example.com', 'Password123!'),
('Alice Smith', 'alice.smith@example.com', 'Pass456!'),
('Bob Johnson', 'bob.johnson@example.com', 'Secret789!'),
('Eva Williams', 'eva.williams@example.com', 'Securepass1!'),
('Michael Brown', 'michael.brown@example.com', 'Mypassword1!');
-- products テーブルの作成
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    average_rating DECIMAL(3,2)
);

-- products テーブルのCHARACTER SETとCOLLATIONの設定
ALTER TABLE products CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- products テーブルにサンプルデータの挿入
INSERT INTO products (name, image_url, price, average_rating) VALUES
('汝、星のごとく', 'image1.jpg', 1760, 3.0),
('ハサミ男', 'image2.jpg', 964, 3.0),
('硝子の塔の殺人', 'image3.jpg', 1782, 3.0),
('麦本三歩の好きなもの', 'image4.jpg', 693, 3.0),
('傲慢と善良', 'image5.jpg', 891, 3.0);



-- reviews テーブルの作成
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating INT,
    comment TEXT,
    nickname VARCHAR(255),  -- Add the nickname column here
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- reviews テーブルのCHARACTER SETとCOLLATIONの設定
ALTER TABLE reviews CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- reviews テーブルにサンプルデータの挿入
INSERT INTO reviews (user_id, product_id, rating, comment, nickname) VALUES
(1, 1, 4, 'ままならない内容で苦しい読書時間が続いていましたが、読後はジンワリと強さと優しさが溢れていて、凪良ゆうさん凄い！と感動✨すぐに続編『星を編む』も手に入れました。こちらも勿論、素晴らしかったです！', 'oniku'),
(1, 2, 5, '残虐な殺人を繰り返すシリアルキラー、ハサミ男。"わたし"と磯部刑事の視点を交えながら物語は進んでいく。伏線があちらこちらに張り巡らされていて、最後まで真相に気づかせない巧みな叙述トリックにあっぱれ。もう一度読みたい本になること間違い無し。', 'oniku'),
(1, 3, 4, '当作の完成度は、一斉を風靡したわが「新本格」時代のクライマックスであり、フィナーレを感じさせる。今後このフィールドから、これを超える作が現れることはないだろう。', 'oniku'),
(1, 4, 4, 'メリハリがあるか？ない、ほんわかとしている。盛り上がりがあるか？ない、ほのぼのしている。物語に華があるか？ない、のほほんとしている。じゃあ何があるの？少しクセがあって、変わり者っぽい雰囲気を持っているけれど、どこか魅力的な麦本三歩という女性の日常が詰まっています。クセになります', 'oniku'),
(1, 5, 5, '結婚を意識している方婚活中の方、彼氏彼女が居て将来を考えている又は片方が考えてる、そこまで考えていない方純粋に恋愛小説が好きという方独身のアラサー、アラフォー年齢関係なく深く考えさせられるオススメ作品です。タイトルの通り人の傲慢と善良至る所に散らばるハッと思わせる言葉が刺さりました。ただの恋愛小説ではない映像化はクソ映画になる事間違いない文字だからこそ心に刺さる作品だと思います。', 'oniku'),
(2, 1, 5, 'エピローグを読んだとき、プロローグを読んだときの気持ちを思い出した。あぁ、幸せな気持ちだったのかって。涙ひとすじながれました。もういちど読み返しています。', '涙ひとすじ');


-- products テーブルの平均評価の更新
UPDATE products
SET average_rating = (
    SELECT AVG(rating)
    FROM reviews
    WHERE reviews.product_id = products.id
);