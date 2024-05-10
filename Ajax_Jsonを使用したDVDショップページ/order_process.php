<?php
session_start();

// カート情報を取得
$cart = $_SESSION['cart'] ?? [];

// ログインしているかどうかを確認
if (isset($_SESSION['username'])) {
    // ログインしている場合はユーザー情報を取得
    $user_id = $_SESSION['username'];

    // ここでデータベースからユーザーの情報を取得
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";

    // データベースに接続
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 接続をチェック
    if ($conn->connect_error) {
        die("データベース接続エラー: " . $conn->connect_error);
    }

    // ユーザー情報を取得するSQLクエリを準備
    $sql = "SELECT * FROM member WHERE Name = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 取得したユーザー情報を取得
        $row = $result->fetch_assoc();
        $name = $row["Name"];
        $address = $row["Address"];
        $mail = $row["mail"];
    } else {
        echo "ユーザー情報が見つかりませんでした。";
    }
}

$order_id = uniqid();
// データベースへの登録処理
if (isset($_POST['checkout'])) {
    // 入力されたユーザー情報を取得
    $name = $_POST['name'];
    $address = $_POST['address'];
    $mail = $_POST['mail'];

    // データベースに接続
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";

    // データベースに接続
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 接続をチェック
    if ($conn->connect_error) {
        die("データベース接続エラー: " . $conn->connect_error);
    }

    // 注文情報をordersテーブルに挿入するSQLクエリを準備
    foreach ($cart as $item) {
        $title = $item['title'];
        $amount = $item['price'];
        $quantity = $item['quantity'];
        $total_price = $amount * $quantity;
        $time = date('Y-m-d H:i:s'); // 現在の日時を取得

        $sql = "INSERT INTO orders (order_id, Address, mail, Title, Amount, quantity, total_price, time) VALUES ('$order_id','$address', '$mail', '$title', '$amount', '$quantity', '$total_price', '$time')";

        if ($conn->query($sql) !== TRUE) {
            echo "エラー: " . $sql . "<br>" . $conn->error;
        }
        // 購入された商品の在庫を減らす
        $sql = "UPDATE movie SET stock = stock - $quantity WHERE Title = '$title'";
        if ($conn->query($sql) !== TRUE) {
            echo "エラー: " . $sql . "<br>" . $conn->error;
        }
    }

    echo '<div class="center-text">感谢您的购买。</div>'; //ご購入ありがとうございます。

    // データベース接続を閉じる
    $conn->close();

    // 2秒後にindex.phpにリダイレクトする
    header("refresh:2;url=index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="order_process.css">
    <title>ご注文手続き</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="cart">
                    <h1>ご注文手続き</h1>
                    <div id="cart-items">
                        <?php
                        // カートが空でない場合のみ処理を行う
                        if (!empty($cart)) {
                            foreach ($cart as $item) {
                                echo '<div class="cart-item">';
                                echo '<p>商品名: ' . $item['title'] . '</p>';
                                echo '<p>価格: ' . $item['price'] . '</p>';
                                echo '<p>数量: ' . $item['quantity'] . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>有您的购物车中没有商品。</p>'; //カートに商品がありません。
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="register-form">
                    <h4>登録フォーム</h4>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">住所</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">メールアドレス</label>
                            <input type="email" class="form-control" id="mail" name="mail" value="<?php echo isset($mail) ? $mail : ''; ?>" required>

                        </div>
                        <button type="submit" class="btn btn-primary" name="checkout">ご購入</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>