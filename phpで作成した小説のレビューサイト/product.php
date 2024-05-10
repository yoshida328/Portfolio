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

// 商品ID取得
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // 商品情報取得
    $stmt_product = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt_product->execute([$product_id]);
    $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

    // 商品ごとのレビュー情報取得
    $stmt_reviews = $pdo->prepare('SELECT * FROM reviews WHERE product_id = ?');
    $stmt_reviews->execute([$product_id]);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
} else {
    // 商品IDが不正な場合、エラー処理またはリダイレクトを行う
    header('Location: main.php');
    exit;
}

// レビューを投稿または更新
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $nickname = $_POST['nickname'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // バリデーションなどの処理を追加

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
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?>レビュー</title>
    <link rel="stylesheet" href="product.css">
</head>

<body>
    <h2><?php echo $product['name']; ?></h2>

    <div class="product-detail">
        <img src="image/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
        <p>商品名: <?php echo $product['name']; ?></p>
        <p>価格: <?php echo number_format($product['price']); ?>円</p>
        <p>平均評価: <?php echo number_format($product['average_rating'], 1); ?> / 5</p>

        <!-- レビュー投稿フォーム -->
        <?php if (isset($_SESSION['user_id'])) : ?>
            <form method="post" action="post_review.php">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <label for="nickname">ニックネーム: </label>
                <input type="text" name="nickname" required>
                <br>
                <label for="rating">評価（0から5の整数）: </label>
                <input type="number" name="rating" min="0" max="5" required>
                <br>
                <label for="comment">コメント: </label>
                <textarea name="comment" rows="4" cols="50" required></textarea>
                <br>
                <input type="submit" value="レビューを投稿">
            </form>
        <?php else : ?>
            <p>レビューを投稿するにはログインが必要です。</p>
        <?php endif; ?>

        <h3>レビュー一覧</h3>
        <?php foreach ($reviews as $review) : ?>
            <div class="review">
                <p> <?php echo $review['nickname']; ?></p>
                <p>評価: <?php echo number_format($review['rating'], 1); ?> / 5</p>
                <p>コメント: <?php echo $review['comment']; ?></p>
            </div>
        <?php endforeach; ?>
        <a href="main.php">商品ページに戻る</a>
    </div>
</body>

</html>