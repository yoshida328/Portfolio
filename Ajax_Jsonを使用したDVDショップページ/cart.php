<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>カート</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="cart.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="cart">
        <h1>カート</h1>
        <div id="cart-items">
            <?php
            // カートが空でない場合のみ処理を行う
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    echo '<div class="cart-item">';
                    echo '<img src="' . $item['imageUrl'] . '" alt="' . $item['title'] . '">';
                    echo '<h3 class="h3">' . $item['title'] . '</h3>';
                    echo '<p class="pri">価格: ' . $item['price'] . '</p>';
                    echo '<p class="qua">数量: ' . $item['quantity'] . '</p>';
                    echo '<button class="remove-from-cart" data-id="' . $item['id'] . '">削除</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>カートに商品がありません。</p>';
            }
            ?>
        </div>
        <p class="gouke">合計金額: <span id="total-price"></span></p>
        <a href="order_process.php" id="purchase-button">ご注文手続きへ進む</a>
    </div>

    <script>
        $(document).ready(function() {
            // カート内の商品数を確認し、0の場合は自動的にホームページにリダイレクトする
            function checkCartAndRedirect() {
                if ($("#cart-items").children().length === 0) {
                    window.location.href = "index.php"; // ホームページにリダイレクト
                }
            }

            // カートから商品を削除する処理
            $(document).on('click', '.remove-from-cart', function() {
                var id = $(this).data("id");
                $.ajax({
                    url: "remove_from_cart.php",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("商品をカートから削除しました。"); // ログ出力
                        alert(response.message);

                        $('#cart-message').text('商品をカートから削除しました。');
                        // ページをリロードしてカートの内容を更新する

                        location.reload();
                        checkCartAndRedirect();
                    },
                    error: function() {
                        alert("エラーが発生しました。");
                    }
                });
            });

            // 商品の数量を変更した際にセッションを更新する処理
            $(document).on('change', '.quantity', function() {
                var id = $(this).data("id");
                var quantity = $(this).val();
                $.ajax({
                    url: "update_cart.php",
                    type: "POST",
                    data: {
                        id: id,
                        quantity: quantity
                    },
                    dataType: "json",
                    success: function(response) {

                        $('#cart-message').text('カートの数量を更新しました。');
                        // ページをリロードしてカートの内容を更新する
                        location.reload();
                        checkCartAndRedirect();
                    },
                    error: function() {
                        alert("エラーが発生しました。");
                    }
                });
            });

            // カートの商品を取得して表示する関数
            function displayCartItems(cartItems) {
                $("#cart-items").empty(); // カート内の商品表示領域をクリア

                var total = 0; // 合計金額を初期化

                $.each(cartItems, function(i, item) {
                    console.log("Image URL: " + item.imageUrl);

                    // 各商品の情報を表示するHTMLを生成
                    var itemHtml =
                        '<div class="cart-item">' +
                        '<img src="' + item.imageUrl + '" alt="' + item.title + '">' +
                        '<div class="item-details">' +
                        '<h3 class="h3">' + item.title + '</h3>' +
                        '<p class="pri">価格: ' + item.price + '円</p>' +
                        '<p class="qua">数量: <input type="number" class="quantity" value="' + item.quantity + '" data-id="' + item.id + '"></p>' +
                        '</div>' +
                        '<button class="remove-from-cart" data-id="' + item.id + '">削除</button>' +
                        '</div>';

                    // カート内の商品表示領域に商品情報を追加
                    $("#cart-items").append(itemHtml);


                    total += item.price * item.quantity;
                });
                $("#total-price").text(total + '円');
            }

            // 購入ボタンがクリックされたときの処理
            $("#purchase-button").click(function() {
                // カート内の商品情報をサーバーに送信し、購入処理を実行する
                $.ajax({
                    url: "order_process.php",
                    type: "POST",
                    data: {
                        items: sessionCartItems // カート内の商品情報をサーバーに送信
                    },
                    success: function(response) {
                        // 成功したときの処理
                        console.log("Purchase successful.");
                        // 他の処理を実行（例：購入手続きの完了など）
                    },
                    error: function() {
                        // エラーが発生したときの処理
                        alert("購入処理に失敗しました。");
                    }
                });
            });
            // セッションからカートの商品データを取得して表示する
            var sessionCartItems = <?php echo json_encode($_SESSION["cart"] ?? []) ?>;
            displayCartItems(sessionCartItems);
            checkCartAndRedirect();
        });
    </script>
</body>

</html>