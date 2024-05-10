<?php
// データベース接続情報
$host = '127.0.0.1';
$dbname = 'cinema';
$username = 'root';
$password = '';

// POSTリクエストから商品IDを取得
$product_id = $_POST['product_id'];

// データベースに接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文を準備
    $stmt = $pdo->prepare("DELETE FROM movie WHERE id = :id");

    // パラメータをバインドしてクエリを実行
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();

    // レスポンスを返す
    echo json_encode(['success' => true, 'message' => 'レコードを削除しました']);

} catch(PDOException $e) {
    // エラーハンドリング
    echo json_encode(['success' => false, 'message' => 'エラー: ' . $e->getMessage()]);
}
?>