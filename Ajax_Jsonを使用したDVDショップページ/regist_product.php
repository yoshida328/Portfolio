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
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // フォームから送信されたデータを取得
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $amount = $_POST['amount'];
    $stock = $_POST['stock'];
    $image_path = $_POST['image_path'];

    // SQL文を準備して実行
    $stmt = $pdo->prepare("INSERT INTO movie (title, genre, amount, stock, image_path) VALUES (:title, :genre, :amount, :stock, :image_path)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':genre', $genre);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':image_path', $image_path);
    $stmt->execute();

    // 登録が成功した旨をクライアントに返す
    echo json_encode(['success' => true, 'message' => '登録しました']);

} catch(PDOException $e) {
    // エラーハンドリング
    echo json_encode(['success' => false, 'message' => 'エラー: ' . $e->getMessage()]);
}
?>