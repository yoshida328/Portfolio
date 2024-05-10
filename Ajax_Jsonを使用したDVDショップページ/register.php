<?php
// フォームから送信されたデータを受け取る
$name = $_POST['name'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($name) || empty($address) || empty($email) || empty($password)) {
    echo "すべての項目を入力してください。";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "有効なメールアドレスを入力してください。";
} else {

    // パスワードをハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    // データベースに接続
    $servername = "localhost"; // データベースのホスト名
    $username = "root"; // データベースのユーザー名
    $password = ""; // データベースのパスワード
    $dbname = "cinema"; // データベース名

    // MySQLデータベースに接続
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 接続を確認
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 名前とメールアドレスの重複をチェックするSQLクエリを準備
    $stmt = $conn->prepare("SELECT * FROM member WHERE Name = ? OR mail = ?");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 重複がない場合のみデータを挿入
    if ($result->num_rows === 0) {
        // データベースにデータを挿入するSQLクエリを準備
        $stmt = $conn->prepare("INSERT INTO member (Name, Address, mail, password) VALUES (?, ?, ?, ?)");
        // パラメータをバインド
        $stmt->bind_param("ssss", $name, $address, $email, $hashed_password);

        // SQLクエリを実行し、挿入が成功したかどうかをチェック
        if ($stmt->execute()) {
            echo "新しいレコードが正常に挿入されました";
        } else {
            echo "エラー: " . $stmt->error;
        }
    } else {
        echo "同じ名前またはメールアドレスが既に存在します。";
    }

    // ステートメントとデータベース接続を閉じる
    $stmt->close();
    $conn->close();
}
