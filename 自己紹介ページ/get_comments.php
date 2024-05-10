<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'sukinakoto';
$username = 'root';
$password = '';

try {
    // PDOオブジェクトの作成
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースからVisibleのデータを取得
    $query = "SELECT name, message FROM contact_form WHERE status = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $visibleContacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // データベース接続を切断
    $pdo = null;

    // 取得したデータをJSON形式で出力
    echo json_encode($visibleContacts);
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージをJSON形式で出力
    echo json_encode(array('error' => 'データベースエラー: ' . $e->getMessage()));
}
