<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'sukinakoto';
$username = 'root';
$password = '';

// PDOインスタンスの作成
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// データベースからお問い合わせ情報を取得
$query = "SELECT * FROM contact_form";
$stmt = $pdo->prepare($query);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 管理者パスワードを設定
$adminPassword = '11'; // 簡易な例として '11' に変更

// POSTリクエストがある場合、パスワードを検証
$passwordCorrect = false; // パスワードが正しいかどうかのフラグを初期化

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredPassword = $_POST['password']; // フォームから送信されたパスワード

    // パスワードが一致した場合はお問い合わせ情報を表示
    if ($enteredPassword === $adminPassword) {
        $passwordCorrect = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理ページ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #0066cc;
            cursor: pointer;
        }

        a:hover {
            text-decoration: underline;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-button {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background-color: #0066cc;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #004080;
        }
    </style>
</head>
<body>

<?php if ($passwordCorrect): ?>

<h2>管理ページ</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>お問い合わせ内容</th>
        <th>時間</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach ($contacts as $contact): ?>
        <tr>
            <td><?= $contact['id'] ?></td>
            <td><?= $contact['name'] ?></td>
            <td><?= $contact['email'] ?></td>
            <td><?= $contact['message'] ?></td>
            <td><?= $contact['created_at'] ?></td>
            <td><?= $contact['status'] == 1 ? '表示' : '非表示' ?></td>
            <td>
                <a href="toggle_visibility.php?id=<?= $contact['id'] ?>">変更
            </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>
<a href="index.php" class="back-button">戻る</a>

<?php else: ?>
    <div class="password-form">
        <form method="post">
            <label for="password">パスワード：</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">入力</button>
        </form>
    </div>
<?php endif; ?>
</body>
</html>

