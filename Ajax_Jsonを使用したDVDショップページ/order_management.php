<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>注文管理ページ</title>
    <style>
        /* ページスタイルを設定します */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
            /* 薄い青 */
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #4d94ff;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            padding: 10px;
            background-color: #80ccff;
            color: #003366;
            border: 1px solid #007acc;
            text-align: left;
        }

        td {
            padding: 10px;
            border: 1px solid #007acc;
            background-color: #e6f7ff;
            color: #003366;
        }

        tr:hover {
            background-color: #b3d9ff;
        }

        tr:nth-child(even) {
            background-color: #cceeff;
        }

        /* 削除ボタンのスタイル */
        button.delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        button.delete-btn:hover {
            background-color: #ff1a1a;
        }

        /* 一括削除ボタンのスタイル */
        button.delete-btn.bulk {
            /* ボタンを右上に配置 */
            text-align: right;
            margin-bottom: 10px;
            /* 右側に余白を追加 */
            margin-right: 200px;
        }
    </style>
    <!-- JavaScript関数を追加 -->
    <script>
        function confirmDelete() {
            // ユーザーに確認メッセージを表示
            return confirm('一度削除すると戻せません。本当に削除しますか？');
        }
    </script>
</head>

<body>
    <h1>注文ページ</h1>

    <?php
    // データベース接続情報
    $host = 'localhost';
    $db_name = 'cinema';
    $username = 'root';
    $password = 'root';

    try {
        // データベースに接続
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 一括削除処理
        if (isset($_POST['delete_bulk'])) {
            if (isset($_POST['order_ids'])) {
                $orderIds = $_POST['order_ids'];
                // クエリプレースホルダーの作成
                $placeholders = implode(', ', array_fill(0, count($orderIds), '?'));
                $deleteSql = "DELETE FROM `order` WHERE `order id` IN ($placeholders)";
                $stmt = $conn->prepare($deleteSql);
                // 注文IDをバインドして実行
                $stmt->execute($orderIds);
            }
        }

        // 検索条件の取得
        $search_conditions = [];
        $search_sql = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 注文番号の検索条件を取得
            if (!empty($_POST['order_id'])) {
                // `order id` はデータベース内の列名であることを確認
                $search_conditions[] = "`order id` = :order_id";
            }

            // その他の検索条件の取得（例：名前、住所など）
            foreach (['name', 'address', 'mail', 'title'] as $column) {
                if (!empty($_POST[$column])) {
                    $search_conditions[] = "$column LIKE :$column";
                }
            }

            // 検索条件を結合
            if (!empty($search_conditions)) {
                $search_sql = "WHERE " . implode(" AND ", $search_conditions);
            }
        }

        // 検索条件を考慮したSQLクエリの作成
        $sql = "SELECT `order id`, `name`, `address`, `mail`, `title`, `amount`, `quantity`, `total prise`, `time`
        FROM `order` $search_sql";

        $stmt = $conn->prepare($sql);

        // 検索条件がある場合、バインドする
        if (!empty($search_conditions)) {
            if (!empty($_POST['order_id'])) {
                $stmt->bindValue(":order_id", $_POST['order_id'], PDO::PARAM_INT); // 注文番号が整数の場合
            }

            foreach (['name', 'address', 'mail', 'title'] as $column) {
                if (!empty($_POST[$column])) {
                    $stmt->bindValue(":$column", '%' . $_POST[$column] . '%', PDO::PARAM_STR);
                }
            }
        }

        $stmt->execute();

        // 検索フォームの表示
        echo "<form method='POST' style='text-align: center;'>";
        echo "<input type='text' name='order id' placeholder='注文番号'>";
        echo "<input type='text' name='name' placeholder='顧客名'>";
        echo "<input type='text' name='address' placeholder='住所'>";
        echo "<input type='text' name='mail' placeholder='メール'>";
        echo "<input type='text' name='title' placeholder='商品タイトル'>";
        echo "<button type='submit'>検索</button>";
        echo "</form>";

        // 注文情報を表示するフォーム
        echo "<form method='POST' onsubmit='return confirmDelete();'>";
        // 一括削除ボタンの配置
        echo "<div style='text-align: right; margin-bottom: 20px;'>";
        echo "<button type='submit' name='delete_bulk' class='delete-btn bulk'>削除</button>";
        echo "</div>";
        echo "<table>
                <tr>
                    <th>選択</th>
                    <th>注文番号</th>
                    <th>顧客名</th>
                    <th>住所</th>
                    <th>メール</th>
                    <th>商品タイトル</th>
                    <th>価格</th>
                    <th>数量</th>
                    <th>合計価格</th>
                    <th>注文日時</th>
                </tr>";

        // 各行にチェックボックスを追加
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='order_ids[]' value='{$row['order id']}'></td>";
            echo "<td>{$row['order id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['mail']}</td>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['amount']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['total prise']}</td>";
            echo "<td>{$row['time']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</form>";
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }

    // データベース接続を閉じる
    $conn = null;
    ?>
</body>

</html>