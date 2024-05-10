<?php
session_start(); // セッションを開始

// セッションを破棄してログアウト
$_SESSION = array();
session_destroy();

// ログアウト成功を返す
$response = array(
    "status" => "success",
    "message" => "ログアウトしました。"
);

echo json_encode($response); // 応答をJSON形式で送信
