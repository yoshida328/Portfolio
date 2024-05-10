<!-- ミニカートに非同期で金額 -->

<?php

session_start();

// カートの中身がセッションに保存されているかチェック
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $total = 0;

    // カート内の商品の合計金額を計算
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // JSON形式で合計金額を返す
    echo json_encode(array("total" => $total));
} else {

    echo json_encode(array("total" => 0));
}
?>