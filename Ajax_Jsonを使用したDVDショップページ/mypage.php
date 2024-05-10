<?php
session_start();

// セッションにユーザー名が設定されていることを確認
if (!isset($_SESSION['username'])) {
    // セッションにユーザー情報がない場合はログインページにリダイレクト
    header("Location: login.php");
    exit; // リダイレクトしたらスクリプトの実行を終了する
}

// セッションにメールアドレスが設定されていない場合は、データベースから取得してセットする
if (!isset($_SESSION['mail'])) {
    // データベース接続の情報
    $host = 'localhost';
    $db   = 'cinema';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // データベースに接続
        $pdo = new PDO($dsn, $user, $pass, $options);

        // ユーザーのメールアドレスを取得するクエリを実行
        $stmt = $pdo->prepare("SELECT mail FROM member WHERE Name = :username");
        $stmt->execute(['username' => $_SESSION['username']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // メールアドレスが取得できた場合はセッションに設定する
        if ($result) {
            $_SESSION['mail'] = $result['mail'];
        } else {
            // メールアドレスが取得できなかった場合はエラーを表示して終了
            echo "メールアドレスの取得に失敗しました。";
            exit;
        }
    } catch (\PDOException $e) {
        // エラーが発生した場合はエラーメッセージを表示して処理を終了
        echo "データベースエラー: " . $e->getMessage();
        exit;
    }
}

// データベース接続の情報
$host = 'localhost';
$db   = 'cinema';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// ユーザーの注文履歴を取得する処理
try {
    // データベースに接続
    $pdo = new PDO($dsn, $user, $pass, $options);

    // ユーザーの注文履歴を取得するクエリを実行
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE mail = :mail");
    $stmt->execute(['mail' => $_SESSION['mail']]);
    $orders = $stmt->fetchAll();
} catch (\PDOException $e) {
    // エラーが発生した場合はエラーメッセージを表示して処理を終了
    echo "データベースエラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="reset.css" />
    <link rel="stylesheet" href="mypage.css" />
    <title>マイページ</title>
</head>

<body>
    <h1>マイページ</h1>

    <div>
        <h2>ユーザー情報</h2>
        <p>ユーザー名: <?= htmlspecialchars($_SESSION['username']); ?></p>
        <p>メールアドレス: <?= htmlspecialchars($_SESSION['mail']); ?></p>
    </div>

    <div>
        <h2>購入履歴</h2>
        <table>
            <thead>
                <tr>
                    <th>注文番号</th>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>価格</th>
                    <th>合計金額</th>
                    <th>注文日時</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']); ?></td>
                        <td><?= htmlspecialchars($order['Title']); ?></td>
                        <td><?= htmlspecialchars($order['quantity']); ?></td>
                        <td><?= htmlspecialchars($order['Amount']); ?></td>
                        <td><?= htmlspecialchars($order['total_price']); ?></td>
                        <td><?= htmlspecialchars($order['time']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>