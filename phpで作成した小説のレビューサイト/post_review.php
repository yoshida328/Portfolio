<?php
session_start();

// データベース接続
$dsn = 'mysql:host=localhost;dbname=review;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    // 未ログインの場合はログインページにリダイレクト
    header('Location: login.php');
    exit;
}

// フォームの送信があった場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力データの取得
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $nickname = $_POST['nickname'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // バリデーション
    $errors = [];

    if (!filter_var($rating, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 5)))) {
        $errors[] = '評価は0から5の整数で指定してください。';
    }

    if (mb_strlen($comment) > 1000) {
        $errors[] = 'コメントは1000文字以内で入力してください。';
    }

    // エラーがない場合
    if (empty($errors)) {
        // レビューが既に存在するか確認
        $existing_review = $pdo->prepare('SELECT * FROM reviews WHERE user_id = ? AND product_id = ?');
        $existing_review->execute([$user_id, $product_id]);

        if ($existing_review->rowCount() > 0) {
            // レビューが存在する場合は更新
            $update_review = $pdo->prepare('UPDATE reviews SET nickname = ?, rating = ?, comment = ? WHERE user_id = ? AND product_id = ?');
            $update_review->execute([$nickname, $rating, $comment, $user_id, $product_id]);
            echo 'レビューが更新されました。';
        } else {
            // レビューが存在しない場合は新規追加
            $insert_review = $pdo->prepare('INSERT INTO reviews (user_id, product_id, nickname, rating, comment) VALUES (?, ?, ?, ?, ?)');
            $insert_review->execute([$user_id, $product_id, $nickname, $rating, $comment]);
            echo 'レビューが投稿されました。';
        }
        echo '<a href="product.php?id=' . $product_id . '">商品ページに戻る</a>';
    } else {
        // エラーメッセージを表示
        foreach ($errors as $error) {
            echo $error . '<br>';
        }

        // フォームを再表示
?>
        <!-- HTMLフォーム -->
        <!DOCTYPE html>
        <html lang="ja">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Post Review</title>
            <link rel="stylesheet" href="post_review.css">
        </head>

        <body>
            <h2>商品へのレビュー投稿</h2>
            <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>">

                <label for="nickname">ニックネーム: </label>
                <input type="text" name="nickname" required>
                <br>

                <label for="rating">評価（0から5の整数）: </label>
                <input type="number" name="rating" min="0" max="5" required>
                <br>

                <label for="comment">コメント（最大1000文字）: </label>
                <textarea name="comment" rows="4" cols="50" maxlength="1000" required></textarea>
                <br>

                <input type="submit" value="投稿">
                <a href="main.php">戻る</a>
            </form>
        </body>

        </html>
<?php
    }
}
?>