<?php
session_start();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // カートから指定された商品IDの商品を削除
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
            // カート内のインデックスを再インデックスする
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            // 削除成功メッセージを返す
            echo json_encode(array("message" => "商品をカートから削除しました。"));
            exit();
        }
    }
    // 指定されたIDの商品がカート内に見つからない場合
    echo json_encode(array("error" => "指定された商品がカート内に見つかりません。"));
} else {
    // POST データが送信されていない場合
    echo json_encode(array("error" => "商品IDが指定されていません。"));
}
