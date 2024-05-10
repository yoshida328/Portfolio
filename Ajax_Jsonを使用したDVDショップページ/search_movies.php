<?php
header("Access-Control-Allow-Origin: *");

$host = 'localhost';
$db   = 'cinema';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// パラメータからキーワードを取得
$keyword = $_GET['keyword'] ?? '';

// キーワードを含む映画をデータベースから検索するクエリを作成
$sql = "SELECT * FROM movie WHERE title LIKE ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$keyword%"]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($movies as &$movie) {
    $movie['image_path'] = 'http://localhost/ajax-json_teamB/' . $movie['image_path']; // 画像パスを修正
}

// 検索結果をJSON形式で出力
echo json_encode($movies);
