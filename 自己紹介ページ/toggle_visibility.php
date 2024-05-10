<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'sukinakoto';
$username = 'root';
$password = '';

// PDOインスタンスの作成
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// GETパラメータからidを取得
$id = $_GET['id'] ?? null;

if ($id) {
    // データベースのstatusを切り替える
    $query = "UPDATE contact_form SET status = NOT status WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        // 成功したらcontact_manage.phpにリダイレクト
        header("Location: contact_manage.php");
        exit();
    } catch (PDOException $e) {
        die("Error updating status: " . $e->getMessage());
    }
} else {
    die("Invalid ID");
}
?>
