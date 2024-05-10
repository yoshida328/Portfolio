<?php
session_start();

if (isset($_POST['id'], $_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // カート内の商品数量を更新
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $quantity;
                // 更新成功メッセージを返す
                echo json_encode(array("message" => "カート内の商品数量を更新しました。"));
                exit();
            }
        }
    }
    // 指定されたIDの商品がカート内に見つからない場合
    echo json_encode(array("error" => "指定された商品がカート内に見つかりません。"));
} else {
    // POST データが送信されていない場合
    echo json_encode(array("error" => "商品IDまたは数量が指定されていません。"));
}
