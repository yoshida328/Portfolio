Chat history
ChatGPT
New chat

Today
商品リストをソート


表のスタイル変更
Yesterday
商品検索フォーム改善
リモート変更の競合
商品検索モーダル作成
検索結果をモーダルに表示
商品情報検索モーダル
Previous 7 Days
商品情報の表示更新
商品情報編集要求
商品情報編集要求
商品情報登録ページを作成
Formulario centrado y ajustado
Gitブランチ作成指示
商品画像表示コード
商品管理ページ構築
MySQLデータベースのリスト表示
商品管理ページ機能要件
商品管理ページ作成
商品登録の確認
商品登録画面のAjax
Previous 30 Days
Ajax JSON 商品登録
JSONの利点
テーブルレコードのスクロール
表の固定ヘッダー
CSS Style Not Working
表スクロール修正
PHP Post Variable Explanation
Java学習コード解説
Upgrade plan
Get GPT-4, DALL·E, and more

User
瀬木和憲
Close sidebar
ChatGPT 3.5

User
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>商品管理ページ</title>
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/item_style.css" />
  <link rel="icon" type="image/png" href="images/jisou.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/item_manage.js"></script>
</head>
<body>
    <h2>（商品管理・在庫管理）</h2>
    <h1>商品管理ページ</h1>
    <div class="control-btn" style="text-align: right;">
        <button id="search-edit-btn">検索／編集</button>&nbsp&nbsp<button id="regist-btn">登録</button>
    </div><br>
    <div id="product-list" class="product-list">
        <table>
            <tr>
                <th>削除</th>
                <th><button id="sort-by-id">商品id</button></th>
                <th>サムネイル</th>
                <th>タイトル</th>
                <th>
                    <select id="genre-filter">
                        <option value="">ジャンルを選択してください</option>
                        <option value="comedy">comedy</option>
                        <option value="action">action</option>
                        <option value="fantasy">fantasy</option>
                        <option value="romance">romance</option>
                        <option value="horror">horror</option>
                        <option value="mystery">mystery</option>
                        <option value="sports">sports</option>
                        <option value="war">war</option>
                    </select>
                </th>
                <th>価格</th>
                <th>在庫数</th>
            </tr>
            <!-- ここに商品リストがAjaxで挿入されます -->
        </table>
    </div>
</body>

</html>

$(document).ready(function() {  // ページ安定 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////
// 管理／削除（ページ安定） ////////////////////////////////////////////////////////////
// item_manage.php //
//////////////////////////////////////////////////////////////////////////////////////
// 初期表示時に商品リストを読み込む
loadProductList();

// 削除ボタンの背景色の切り替え
$(document).on('change', '.deleteCheckbox', function() {
    var checked = $('.deleteCheckbox:checked').length > 0;
    $('#index-delete-btn').toggleClass('delete-btn-active', checked);
});

// 削除ボタンがクリックされたときの処理
$(document).on('click', '#index-delete-btn', function() {
    var checkedItems = $('.deleteCheckbox:checked');
    if (checkedItems.length > 0) {
        // 選択したレコードを削除する処理
        if (confirm("選択したレコードを削除してよろしいですか？")) {
            checkedItems.each(function() {
                var id = $(this).val(); // チェックされたチェックボックスの値（商品ID）
                // データベースからレコードを削除するためのAjaxリクエスト
                $.ajax({
                    type: "POST",
                    url: "delete_product.php",
                    data: { product_id: id },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message); // 成功時のメッセージをコンソールに出力
                        } else {
                            console.error(response.message); // 失敗時のメッセージをコンソールに出力
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // エラーメッセージをコンソールに出力
                    }
                });
                // 表示上のレコードを削除
                $(this).closest('tr').remove();
            });
            alert("削除しました。"); // 削除完了のアラート
        }
    } else {
        alert("削除するレコードを選択してください。"); // 選択されているレコードがない場合のアラート
    }
});

// 商品idの昇順・降順機能
$('#sort-by-id').click(function() {
    // 昇順と降順のフラグを切り替える
    var ascending = $(this).data('ascending');
    $(this).data('ascending', !ascending);
    
    // 商品idを昇順・降順にソートする処理をここに記述
    sortProductsById(ascending);
});

// 商品をidでソートする関数
function sortProductsById(ascending) {
    // 商品リストの各行を取得
    var rows = $('.product-list table tbody tr').get();
    
    // ソートする
    rows.sort(function(rowA, rowB) {
        var idA = parseInt($(rowA).find('td:eq(1)').text()); // 商品idを取得
        var idB = parseInt($(rowB).find('td:eq(1)').text());
        if (ascending) {
            return idA - idB; // 昇順
        } else {
            return idB - idA; // 降順
        }
    });

    // ソートした行を商品リストに再追加
    $.each(rows, function(index, row) {
        $('.product-list table').append(row);
    });
}


//////////////////////////////////////////////////////////////////////////////////////
});  // $(document).ready(function()  の終端 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// 管理／削除（通常） ////////////////////////////////////////////////////////////
// item_manage.php //
// item_manage.php //
//////////////////////////////////////////////////////////////////////////////////////
function loadProductList() {
    $.ajax({
        url: 'get_products.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var productListHTML = '<table class="product-table">';
            productListHTML += '<tr><th><button id="index-delete-btn" class="index-delete-btn">削除</button></th><th>商品id</th><th>商品画像</th><th>タイトル</th><th>ジャンル</th><th>価格</th><th>在庫数</th></tr>';
            $.each(response.data, function(index, product) {
                productListHTML += '<tr>';
                productListHTML += '<td style="text-align: center; vertical-align: middle;">' + '<input type="checkbox" class="deleteCheckbox" name="deleteCheckbox" value="' + product.id + '"></td>';
                productListHTML += '<td>' + product.id + '</td>';
                productListHTML += '<td><img src="' + product.image_path + '" alt="Thumbnail"></td>';
                productListHTML += '<td>' + product.title + '</td>';
                productListHTML += '<td>' + product.genre + '</td>';
                productListHTML += '<td>' + parseInt(product.amount).toLocaleString() + '円</td>';
                productListHTML += '<td>' + product.stock + '</td>';
                productListHTML += '</tr>';
            });
            productListHTML += '</table>';

            $('#product-list').html(productListHTML);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}

<?php
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

    // 商品データを取得するクエリ
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie";

    // クエリを実行して結果を取得
    $stmt = $pdo->query($query);

    // データを配列に格納
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $products]);

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

・商品id、タイトル、価格、在庫数項目に、▲、▼ボタンをつくって、それぞれ昇順、降順ボタンとしたい
・別のソート用のphpファイルを作って、並べ替えたレコードを読み込んでリスト表示させることはできるか？
ChatGPT
商品リスト内の各項目に昇順・降順ボタンを追加し、それぞれのボタンがクリックされたときに、別のPHPファイルでソートを行い、結果をリスト表示させることは可能です。以下に手順を示します。

HTML内の各項目に昇順・降順ボタンを追加します。
各ボタンのクリックイベントを処理するJavaScriptを記述します。
JavaScript内で、クリックされたボタンに応じて、Ajaxリクエストを送信し、別のPHPファイルでソート処理を行います。
ソート処理が完了したら、その結果を取得して、商品リストを更新します。
具体的な手順を以下に示します。

HTMLの変更
各項目のヘッダーに昇順・降順ボタンを追加します。

html
Copy code
<th><button class="sort-button" data-column="id">▲</button> 商品id <button class="sort-button" data-column="id">▼</button></th>
<th>...</th>
<th>...</th>
JavaScriptの変更
昇順・降順ボタンがクリックされたときの処理を記述します。

javascript
Copy code
// 商品リストをソートする関数
function sortProducts(column, ascending) {
    $.ajax({
        url: 'sort_products.php',
        type: 'POST',
        data: { column: column, ascending: ascending },
        dataType: 'json',
        success: function(response) {
            // ソートした商品リストを表示
            var productListHTML = '<table class="product-table">';
            // 表示処理...
            $('#product-list').html(productListHTML);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// 昇順・降順ボタンがクリックされたときの処理
$(document).on('click', '.sort-button', function() {
    var column = $(this).data('column');
    var ascending = $(this).text() === '▲'; // ボタンのテキストで昇順・降順を判定
    sortProducts(column, ascending);
});
PHPの変更
sort_products.phpというファイルを作成し、ソート処理を記述します。このファイルは、Ajaxリクエストを受け取り、データベースからソートされた結果を取得してJSON形式で返します。

php
Copy code
// sort_products.php

// データベース接続などの準備...

// クライアントから送られてきた列名と昇順・降順の情報を取得
$column = $_POST['column'];
$ascending = $_POST['ascending'];

// ソート処理（例えばORDER BYを使ってデータベースから取得）

// ソート結果をJSON形式で返す
header('Content-Type: application/json');
echo json_encode(['success' => true, 'data' => $sortedProducts]);
これで、商品リストの各項目に昇順・降順ボタンを追加し、クリックされたときにAjaxリクエストを送信してソート処理を行うことができます。

User
sort_products.php
<?php
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

    // 商品データを取得するクエリ
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie";

    // クエリを実行して結果を取得
    $stmt = $pdo->query($query);

    // データを配列に格納
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $products]);

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
修正して全文欲しい
ChatGPT
修正したsort_products.phpの全文を以下に示します。

php
Copy code
<?php
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

    // クライアントから送られてきた列名と昇順・降順の情報を取得
    $column = $_POST['column'];
    $ascending = $_POST['ascending'] === 'true' ? true : false; // 文字列から真偽値に変換

    // ソート対象の列を指定するSQL
    $column_sql = '';
    switch ($column) {
        case 'id':
        case 'title':
        case 'genre':
        case 'amount':
        case 'stock':
            $column_sql = $column;
            break;
        default:
            // 不正な列名が送られてきた場合はデフォルトで'id'列を指定
            $column_sql = 'id';
    }

    // ORDER BY句を構築
    $order_by = $column_sql . ($ascending ? ' ASC' : ' DESC');

    // 商品データを取得するクエリ（ソートあり）
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie ORDER BY $order_by";

    // クエリを実行して結果を取得
    $stmt = $pdo->query($query);

    // データを配列に格納
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $products]);

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
この修正では、$_POST['ascending']が文字列として送信されるため、それを真偽値に変換しています。また、不正な列名が送られてきた場合に備えて、デフォルトで'id'列を指定するようにしました。また、セキュリティ上の理由から、外部からの入力値に直接SQLクエリを組み立てるのではなく、安全な方法でSQLを実行するようにしています。

User
genreはドロップダウンメニューでHTML側で制御する
ChatGPT
理解しました。genreをドロップダウンメニューでHTML側で制御するために、以下の手順を実行します。

HTML内でgenreのドロップダウンメニューを追加します。
JavaScriptを使用して、ドロップダウンメニューの選択状態を取得し、それに応じて商品リストをフィルタリングします。
HTMLの変更
genreのドロップダウンメニューを追加します。

html
Copy code
<th>
    <select id="genre-filter">
        <option value="">ジャンルを選択してください</option>
        <option value="comedy">comedy</option>
        <option value="action">action</option>
        <option value="fantasy">fantasy</option>
        <!-- 他のジャンルのオプションも追加 -->
    </select>
</th>
JavaScriptの変更
ドロップダウンメニューの選択状態を監視し、選択されたジ

User
違う。genre以外の項目のソートの修正コードを頂きたい
<?php
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

    // クライアントから送られてきた列名と昇順・降順の情報を取得
    $column = $_POST['column'];
    $ascending = $_POST['ascending'] === 'true' ? true : false; // 文字列から真偽値に変換

    // ソート対象の列を指定するSQL
    $column_sql = '';
    switch ($column) {
        case 'id':
        case 'title':
        case 'amount':
        case 'stock':
            $column_sql = $column;
            break;
        default:
            // 不正な列名が送られてきた場合はデフォルトで'id'列を指定
            $column_sql = 'id';
    }

    // ORDER BY句を構築
    $order_by = $column_sql . ($ascending ? ' ASC' : ' DESC');

    // 商品データを取得するクエリ（ソートあり）
    $query = "SELECT id, title, genre, amount, stock, image_path FROM movie ORDER BY $order_by";

    // クエリを実行して結果を取得
    $stmt = $pdo->query($query);

    // 取得したデータをHTMLに変換
    $html = '<table>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<tr>';
        // データをテーブルに追加する処理を行う
        // 例：$html .= '<td>' . $row['id'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // HTMLを返す
    echo $html;

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
