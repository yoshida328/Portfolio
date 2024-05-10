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

// セッション開始
session_start();

// フォームの送信があった場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力データの取得
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // バリデーション
    $errors = [];

    if (empty($username)) {
        $errors[] = 'ユーザー名は必須です。';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $errors[] = '有効なGmailアドレスを入力してください。';
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors[] = 'パスワードは大文字、小文字、数字、記号を少なくとも1つずつ含む8文字以上である必要があります。';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'パスワードが一致しません。';
    }

    // メールアドレスがすでに存在するか確認
    $stmt_check_email = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt_check_email->execute([$email]);
    $email_exists = $stmt_check_email->fetchColumn();

    if ($email_exists > 0) {
        // 既に存在する場合、エラーメッセージを追加
        $errors[] = 'このメールアドレスは既に登録されています。';
    }

    // エラーがない場合、データベースに登録
    if (empty($errors)) {
        // パスワードのハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // データベースに登録
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $hashedPassword]);

        // 登録成功のメッセージ
        echo 'ユーザー登録が完了しました。';

        // ログイン状態をセッションに保存
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // main.php にリダイレクト
        header('Location: main.php');
        exit;
    } else {
        // エラーメッセージを表示
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
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
    <link rel="stylesheet" href="touroku.css">
</head>

<body>
    <h2>ユーザー登録</h2>


    <form method="post" action="">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">パスワード再入力:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit" value="登録">
    </form>

    <p>登録済みの方はこちらから：<a href="login.php">ログイン</a></p>
</body>

</html>