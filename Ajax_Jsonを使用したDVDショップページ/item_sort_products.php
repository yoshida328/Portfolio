<?php
// データベース接続情報
$host = '127.0.0.1';
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

    // クエリを構築
    $column = $_POST['column']; // ソートする列名
    $sortOrder = $_POST['sortOrder']; // ソート順（'asc'または'desc'）

    // ソート順をSQL文に組み込む
    $orderBy = $column . ' ' . $sortOrder;

    // クエリを準備して実行
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie ORDER BY $orderBy, id ASC"; // idが同位の場合はidで昇順に並べる
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // 結果を取得
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $products]);

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>