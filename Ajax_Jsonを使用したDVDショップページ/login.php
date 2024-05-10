<?php
session_start(); // セッションを開始

// データベースの接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema";
// フォームから送信されたユーザーネームとパスワード
$user = isset($_POST['username']) ? $_POST['username'] : null;
$pass = isset($_POST['password']) ? $_POST['password'] : null;


try {
    // PDOインスタンスの作成
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // PDOエラーモードを例外に設定
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文を準備
    // パスワードはハッシュ化して保存されていることを前提としています。
    $stmt = $conn->prepare("SELECT password FROM member WHERE Name = :username");
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが見つかった場合、パスワードの検証を行う
    if ($result !== false && password_verify($pass, $result['password'])) {
        // ログイン成功
        $_SESSION['username'] = $user; // ユーザーネームをセッション変数に保存

        $stmt = $conn->prepare("SELECT mail FROM member WHERE Name = :username");
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->execute();
        $emailResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['email'] = $emailResult['mail']; // メールアドレスをセッション変数に保存


        $response = array(
            "status" => "success",
            "message" => "ログインに成功しました。",
            "username" => $user
        );
    } else {
        // ログイン失敗
        $response = array(
            "status" => "error",
            "message" => "ユーザーネームまたはパスワードが間違っています。",
            "username" => "ゲスト様" // ゲスト名を含める
        );
    }

    echo json_encode($response); // 応答をJSON形式で送信
} catch (PDOException $e) {
    $response = array(
        "status" => "error",
        "message" => "接続失敗: " . $e->getMessage()
    );
    echo json_encode($response); // エラーメッセージをJSON形式で送信
}

$conn = null; // 接続を閉じる
