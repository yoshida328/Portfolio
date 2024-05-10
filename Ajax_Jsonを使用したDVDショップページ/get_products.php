<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'cinema';
$username = 'root';
$password = '';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // PDOインスタンスを作成
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);

    // 商品データを取得するクエリ
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie";

    // クエリを実行して結果を取得
    $stmt = $pdo->query($query);

    // データを配列に格納
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $products]);
} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
