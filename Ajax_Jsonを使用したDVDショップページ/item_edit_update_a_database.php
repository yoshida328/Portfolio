<?php
// edit_update_a_database.php

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

    // 更新処理を行う
    if(isset($_POST['edited-id'])) {
        // フォームからのデータを取得
        $id = $_POST['edited-id'];
        $title = $_POST['edited-title'];
        $genre = $_POST['edited-genre'];
        $amount = $_POST['edited-amount'];
        $stock = $_POST['edited-stock'];
        $imagePath = $_POST['edited-image_path'];

        // データベースの更新処理を行う（適切なSQL文をここに記述）
        $query = "UPDATE movie SET title = :title, genre = :genre, amount = :amount, stock = :stock, image_path = :image_path WHERE id = :id";

        // プリペアドステートメントを準備
        $stmt = $pdo->prepare($query);

        // パラメータをバインド
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':image_path', $imagePath);

        // クエリを実行
        $stmt->execute();

        // 更新成功した場合
        echo $id;
    } else {
        // 更新されていない場合
        echo "0";
    }
} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit(); // エラーが発生したらスクリプトの実行を終了する
}
?>