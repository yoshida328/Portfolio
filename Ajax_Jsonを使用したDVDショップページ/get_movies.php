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

$genre = $_GET['genre'] ?? ''; // ジャンルが指定されていない場合のデフォルト値を設定
$allowedGenres = ['comedy', 'action', 'fantasy', 'romance', 'horror', 'mystery', 'sports', 'war']; // 許可されたジャンルのリスト
if (!in_array($genre, $allowedGenres)) {
    // 不正なジャンルが指定された場合はエラーメッセージを返す
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid genre']);
    exit;
}

$sql = "SELECT * FROM movie WHERE genre = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$genre]);
$movies = $stmt->fetchAll();

// 画像パスをデータベースから取得したファイル名に基づいて動的に変更する
foreach ($movies as &$movie) {
    $movie['image_path'] = 'http://localhost/ajax-json_teamB/' . $movie['image_path']; // 画像パスを修正
}

echo json_encode($movies); // JSON形式で結果を返す
