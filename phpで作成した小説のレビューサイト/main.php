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

// ログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// ユーザー情報取得
$username = $_SESSION['username'];

// 商品情報取得
$stmt_products = $pdo->query('SELECT * FROM products');
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

// 商品ごとのレビュー情報取得
$average_reviews = [];
foreach ($products as $product) {
    $stmt_reviews = $pdo->prepare('SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?');
    $stmt_reviews->execute([$product['id']]);
    $average_rating = $stmt_reviews->fetchColumn();
    $average_reviews[$product['id']] = $average_rating;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <h2>ログイン中、<?php echo $username; ?>殿</h2>

    <div class="product-container">
        <?php foreach ($products as $product) : ?>
            <div class="product">
                <!-- 画像のパスを相対パスで指定 -->
                <img src="image/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>レビューの平均: <?php echo number_format($average_reviews[$product['id']], 1); ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>">詳細を見る</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>