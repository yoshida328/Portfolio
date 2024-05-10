<?php
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

// ログインフォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力データの取得
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // データベースから該当のユーザーを取得
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが存在し、パスワードが一致するか確認
    if ($user && password_verify($password, $user['password'])) {
        // ログイン成功の処理
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: main.php'); // ログイン成功後のページにリダイレクト
        exit();
    } else {
        // ログイン失敗時のエラーメッセージ
        $error_message = 'メールアドレスまたはパスワードが正しくありません。';
    }
}
?>

<!-- HTMLフォーム -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインページ</title>
    <link rel="stylesheet" href="login.css"> <!-- 必要に応じてCSSファイルを追加 -->
</head>

<body>
    <h2>ログイン</h2>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="ログイン">
    </form>

    <p>新規登録はこちらから：<a href="touroku.php">新規登録</a></p>

</body>

</html>