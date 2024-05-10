<!DOCTYPE html>
<?php
// item_edit.php

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

    // 商品IDを取得
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

    // 商品データを取得するクエリ
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie WHERE id = :id";

    // プリペアドステートメントを準備
    $stmt = $pdo->prepare($query);

    // パラメータをバインド
    $stmt->bindParam(':id', $productId);

    // クエリを実行
    $stmt->execute();

    // データを取得
    $product = $stmt->fetch();

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit(); // エラーが発生したらスクリプトの実行を終了する
}
?>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品編集ページ</title>
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/item_style.css" />
  <link rel="icon" type="image/png" href="images/jisou.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/item_edit.js"></script>
</head>
<body>
<div class="body_black">  
    <div class="edit-container">
        <h2>（商品管理・在庫管理）</h2>
        <h1>商品情報編集ページ</h1>        
        <div class="edit-control-btn" style="text-align: right;">
                <a href="item_manage.php"><button>管理画面へ</button></a>
        </div>
        <div class="edit-wrapper">
            <!-- 左側（レコード情報） -->
            <div class="edit-left">
                <h2>レコード情報</h2>
                <div class="edit-left-spacer">
                </div>
                <div class="item-info">
                    <div class="item-label"><b>商品ID：</b></div>
                    <div id="id-info" class="item-value">　<?php echo $product['id']; ?></div>
                </div>
                <div class="item-info">
                    <div class="item-label"><b>タイトル：</b></div>
                    <div id="title-info" class="item-value">　<?php echo $product['title']; ?></div>
                </div>
                <div class="item-info">
                    <div class="item-label"><b>ジャンル：</b></div>
                    <div id="genre-info" class="item-value">　<?php echo $product['genre']; ?></div>
                </div>
                <div class="item-info">
                    <div class="item-label"><b>価格（円）：</b></div>
                    <div id="amount-info" class="item-value">　<?php echo (int)$product['amount']; ?></div>
                </div>
                <div class="item-info">
                    <div class="item-label"><b>在庫数：</b></div>
                    <div id="stock-info" class="item-value">　<?php echo $product['stock']; ?></div>
                </div>
                <div class="item-info">
                    <div class="item-label"><b>画像パス：</b></div>
                    <div id="image_path-info" class="item-value">　<?php echo $product['image_path']; ?></div>
                </div>
                <div class="origin-item-info">
                    <div class="origin-item-label"><b>商品画像：</b></div>
                    <div class="origin-item-value">
                        <?php 
                        // 画像ファイルのパス
                        $imagePath = "http://localhost/groupB_shohin_kanri_segi/" . $product['image_path'];

                        // 画像を表示
                        echo '　<img src="' . $imagePath . '" alt="商品画像">';
                        ?>
                    </div>
                </div>
            </div>
            <!-- 右側（内容編集） -->
            <div class="edit-right">
                <br>
                <h2>内容編集</h2><br><br>
                <form id="edit-form">
                    <label for="edit-id">商品ID：</label>
                    <input type="number" id="edit-id" name="edited-id" value="<?php echo $product['id']; ?>"font-size="14px;" style="width: 400px;" readonly><br>
                    <label for="edit-title">タイトル：</label>
                    <input type="text" id="edit-title" name="edited-title" value="<?php echo $product['title']; ?>"font-size="14px;"  style="width: 400px;"><br>
                    <label for="edit-genre">ジャンル：</label>
                    <select id="edit-genre" name="edited-genre" font-size="14px;"  style="width: 400px;">
                        <option value="comedy" <?php echo ($product['genre'] === 'comedy') ? 'selected' : ''; ?>>comedy</option>
                        <option value="action" <?php echo ($product['genre'] === 'action') ? 'selected' : ''; ?>>action</option>
                        <option value="fantasy" <?php echo ($product['genre'] === 'fantasy') ? 'selected' : ''; ?>>fantasy</option>
                        <option value="romance" <?php echo ($product['genre'] === 'romance') ? 'selected' : ''; ?>>romance</option>
                        <option value="horror" <?php echo ($product['genre'] === 'horror') ? 'selected' : ''; ?>>horror</option>
                        <option value="mystery" <?php echo ($product['genre'] === 'mystery') ? 'selected' : ''; ?>>mystery</option>
                        <option value="sports" <?php echo ($product['genre'] === 'sports') ? 'selected' : ''; ?>>sports</option>
                        <option value="war" <?php echo ($product['genre'] === 'war') ? 'selected' : ''; ?>>war</option>
                    </select><br>
                    <label for="edit-amount">価格（円）：</label>
                    <input type="number" id="edit-amount" name="edited-amount" value="<?php echo (int)$product['amount']; ?>" font-size="14px;" style="width: 400px;" step="1" min="0"><br>
                    <label for="edit-stock">在庫数：</label>
                    <input type="number" id="edit-stock" name="edited-stock" value="<?php echo $product['stock']; ?>" font-size="14px;" style="width: 400px;" min="0"><br>
                    <div class="edit-item-info">
                        <label for="edit-image_path" style="display: inline-block;">画像パス：</label>
                        <!-- 画像変更ボタン -->
                        <label for="edit-file-select-input" id="edit-file-select-btn" style="display: inline-block;">画像を変更する</label>
                        <input type="file" id="edit-file-select-input" name="edited-image_path" style="display: none;">
                        <br>
                        <input type="text" id="edit-image_path" name="edited-image_path" value="<?php echo $product['image_path']; ?>" font-size="14px;" style="width: 400px;">
                        <br>
                        <div class="edit-item-label"><b>商品画像：</b></div>
                        <div class="edit-item-value">
                            <?php 
                            // 画像ファイルのパス
                            $imagePath = "http://localhost/groupB_shohin_kanri_segi/" . $product['image_path'];
                            // 画像を表示
                            echo '<img src="' . $imagePath . '" alt="商品画像">';
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <div class="edit-btn-area">
        <button id="edit-update-btn" disabled>内容更新</button>
    </div>
</div>
</body>
</html>