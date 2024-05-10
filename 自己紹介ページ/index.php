<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>好きなことページ</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/each.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <?php

    session_start(); // セッションの開始

    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_SESSION['form_submitted'])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        // バリデーション
        if (empty($name) || empty($email) || empty($message)) {
            echo "全ての項目を入力してください。";
        } else {
            $host = 'localhost';
            $dbname = 'sukinakoto';
            $username = 'root';
            $password = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

            $sql = "INSERT INTO contact_form (name, email, message, created_at, status) 
                VALUES (:name, :email, :message, NOW(), 'pending')";

            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':message', $message, PDO::PARAM_STR);

                $stmt->execute();
                echo "データが正常に挿入されました。";
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

            $_SESSION['form_submitted'] = true;
        }
    }
    ?>


    <header class="header">
        <!-- ハンバーガーメニュー -->
        <button id="js-hamburger" class="hamburger"><span class="hamburger__line"></span></button>
        <!-- メニュー -->
        <nav id="js-globalnav" class="globalnav">
            <ul class="globalnav__main">
                <li class="globalnav__item"><a href="index.php">Top</a></li>
                <li class="globalnav__item _has-child"><a href="novel.php">好きなことページ</a>
                    <ul class="globalnav__child">
                        <li><a href="index1.php">breaking down</a></li>
                        <li><a href="">今後追加</a></li>
                        <li><a href="">今後追加</a></li>
                    </ul>
                </li>
                <li class="globalnav__item"><a href="gallery.html">今後追加</a></li>
                <li class="globalnav__item"><a href="comic.html">今後追加</a></li>
                <li class="globalnav__item"><a href="offline.html">今後追加</a></li>
                <li class="globalnav__item"><a href="contact_manage.php">コメント管理画面</a></li>
            </ul>
        </nav><!-- メニューここまで -->
    </header>

    <!-- メインコンテンツ -->
    <main class="mainwrapper" id="js-main">

        <!-- サイト名 -->
        <h1 class="sitename titles">好きなことページ</h1>

        <section id="information">
            <!-- インフォメーション -->
            <h2 class="headingL">Information</h2>
            <p class="bg-white">好きなことページです。
                <!-- 更新履歴 -->
            <section class="bg-white">
                <h3 class="headingM">Update</h3>
                <ul class="update">
                    <li class="update__item">
                        <time>2024/02/28</time><span>お問い合わせ追加</span>
                    </li>
                    <li class="update__item"><time>2024/02/26</time><span>PHP対応</span></li>
                    <li class="update__item"><time>2024/01/17</time><span>内容更新</span></li>
                    <li class="update__item"><time>2024/01/16</time><span>ページできました</span></li>
                    <li class="update__item"><time>20XX/XX/XX</time><span></span></li>
                    <li class="update__item"><time>20XX/XX/XX</time><span></span></li>
                </ul><!-- 更新履歴ここまで -->
            </section>
        </section><!-- インフォメーションここまで -->

        <!--トピック一覧-->
        <section id="topic">
            <h2 class="headingL">Topic</h2>
            <ul class="topiclist">
                <li class="topiclist__item bg-white"><a href="https://p3re.jp/" target="_blank" class="grid">
                        <img src="https://p3re.jp/resources/img/top/product_limited-box_e78476fd6a3b226569c3dc9469d39808.webp" alt="">
                        <p>ペルソナ3今やってます</p>
                        </img></li>
                <li class="topiclist__item bg-white"><a href="https://www.youtube.com/@joevlog7" target="_blank" class="grid"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT40v9v8yRNiYjIBFmGq-BK_jr9gq016J0O0Q&usqp=CAU" alt="">
                        <p>好きなyoutuber</p>
                    </a></li>
                <li class="topiclist__item bg-white"><a href="https://alexandros.jp/" target="_blank" class="grid"><img src="https://www.universal-music.co.jp/alexandros/wp-content/uploads/sites/2522/2023/12/AP-hd_alexandros_231204.jpg" alt="">
                        <p>ずっと聞いてます</p>
                    </a></li>
            </ul>
        </section>
        <!--トピック一覧ここまで-->

        <!-- アバウト -->
        <h2 class="headingL">プロフィール</h2>
        </section><!-- このサイトについてここまで -->
        <section class="profile bg-white">
            <!-- プロフィール -->
            <h3 class="headingM">Profile</h3>
            <div class="profile__inner grid">
                <!-- 横並びに -->
                <!-- プロフィール画像 -->
                <div class="profile__img"><img src="images/image0.jpeg" alt=""></div>
                <!-- プロフィール文章 -->
                <div class="profile__text">
                    <h2>基本情報</h2>
                    <p>名前: 吉田 光希</p>
                    <p>年齢: 27歳</p>
                    <p>性別: 男性</p>
                    <p>出身: 奈良県</p>
                    <!-- SNSリスト -->
                    <ul class="snslist flex">
                        <li class="snslist__item twitter"><a href=""><i class="lab la-twitter"></i></a></li>
                        <li class="snslist__item instagram"><a href=""><i class="lab la-instagram"></i></a></li>
                        <li class="snslist__item facebook"><a href=""><i class="lab la-facebook-square"></i></a></li>
                        <li class="snslist__item youtube"><a href=""><i class="lab la-youtube"></i></a></li>
                    </ul><!-- SNSリストここまで -->
                </div><!-- プロフィール文章ここまで -->
            </div>
        </section><!-- プロフィールここまで -->
        </section>
        <section id="about">
            <h2 class="headingL">自己紹介</h2>
            <section class="aboutsite bg-white">
                <h3 class="headingM">簡単な自分解説</h3>
                <p>1996年奈良県で生まれる</p>
                <p>5歳からサッカーを始め15年ぐらい続ける</p>
                <p>社会人になり大阪・滋賀・岐阜・埼玉に住む（短期間なら他にも）今は大阪</p>
                <p>直近ではフォークリフトメーカーで営業2年半</p>
                <p>2023年12月よりプログラミング訓練校入校←6月まで予定</p>
                <p>就職は東京予定</p>
            </section>



            <!-- リンク -->
            <section id="link">
                <h2 class="headingL">like</h2>
                <section class="bg-white">
                    <h3 class="headingM">favorite</h3>
                    <div class="linklist">
                        <h2>音楽</h2>
                        <ul class="flex">
                            <li class="linklist__item"><a href="https://alexandros.jp/"><img src="" alt="">alexandros</a></li>
                            <li class="linklist__item"><a href="https://www.utadahikaru.jp/"><img src="" alt="">宇多田ヒカル</a></li>
                            <li class="linklist__item"><a href="https://unison-s-g.com/"><img src="" alt="">UNISON SQUARE GARDEN</a></li>
                        </ul>

                        <h2>お笑い</h2>
                        <ul class="flex">
                            <li class="linklist__item"><a href="https://profile.yoshimoto.co.jp/talent/detail?id=5087"><img src="" alt="">霜降り明星</a></li>
                            <li class="linklist__item"><a href="https://www.sarabaseisyunnohikari.com/"><img src="" alt="">さらば青春の光 </a></li>
                            <li class="linklist__item"><a href="https://www.watanabepro.co.jp/mypage/40000114/"><img src="" alt="">サンシャイン池崎</a></li>
                        </ul>

                        <h2>ゲーム</h2>
                        <ul class="flex">
                            <li class="linklist__item"><a href="https://www.ea.com/ja-jp/games/ea-sports-fc/fc-24"><img src="" alt="">fc24</a></li>
                            <li class="linklist__item"><a href="https://www.ubisoft.com/ja-jp/game/rainbow-six/siege"><img src="" alt="">Rainbow Six Siege</a></li>
                            <li class="linklist__item"><a href="https://www.nintendo.co.jp/fe/index.html"><img src="" alt="">Fire Emblem</a></li>
                        </ul>
                    </div>
                </section>
            </section>


            <!-- リンクここまで -->

            <!-- コンタクト -->
            <section id="contact">
                <h2 class="headingL">お問い合わせ</h2>
                <form action="process_form.php" method="post" class="mailform">
                    <input id="name" type="text" name="name" placeholder="お名前" required><br>
                    <input id="mail" type="email" name="email" placeholder="メールアドレス" required><br>
                    <textarea id="message" name="message" placeholder="メッセージ" required></textarea><br>
                    <button type="submit" name="submit" class="btn">送信</button>
                </form>
            </section>

            <section id="comments">
                <h2 class="headingL">コメントセクション</h2>
                <!-- ボタンを追加 -->
                <button id="loadCommentsBtn" class="btn">コメントを読み込む</button>

                <div id="commentsTableContainer"></div>


            </section>

            <!-- コンタクトここまで -->

    </main><!-- メインコンテンツここまで -->


    <footer>
        <button id="js-pageup">ページUP</button>
        <!-- クレジット -->
        <small>© 2024 koki yoshida. Designed by <a href="https://utsusemi.hiroec.com" target="_blank">Utsusemi</a>.</small>
        <!-- クレジットここまで -->
    </footer>

    <!--JavaScrip 読込-->
    <script src="js/common.js" type="text/javascript"></script>
    <?php
    // データベース接続を切断
    $pdo = null;
    ?>
</body>

</html>