<?php
// セッションを開始
session_start();

// カートをセッションに保存する処理
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// 商品情報の受け取り
if (isset($_POST['id'], $_POST['title'], $_POST['quantity'], $_POST['price'], $_POST['imageUrl'])) {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $imageUrl = $_POST['imageUrl'];

    // 商品がすでにカートにあるかチェック
    $isFound = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] += $quantity;
            $isFound = true;
            break;
        }
    }
    if (!$isFound) {
        // カートに新しい商品を追加
        $_SESSION['cart'][] = array('id' => $id, 'title' => $title, 'quantity' => $quantity, 'price' => $price, 'imageUrl' => $imageUrl);
    }

    // 正常な処理が行われた場合、成功メッセージを返す
    echo json_encode(array("message" => "カートに商品を追加しました。"));
} else {
    // 必要な情報がPOSTに含まれていない場合、エラーメッセージを返す
    echo json_encode(array("error" => "必要な情報がPOSTに含まれていません。"));
}
