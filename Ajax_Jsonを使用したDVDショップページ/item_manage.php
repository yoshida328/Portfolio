
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
        <a href="item_regist.php"><button>登録画面へ</button></a>
    </div><br>

    <div id="product-list" class="product-list">
        <div style="max-height: 750px; overflow-y: scroll;"> <!-- コンテナに縦方向のスクロールバーを設定 -->
            <table class="header-table" style="position: sticky; top: 0; background-color: #ffffff;"> <!-- 項目行を固定 -->
                <thead>
                    <tr>
                        <th><button id="index-delete-btn" class="index-delete-btn">Ｘ</button></th>
                        <th>
                            <input type="text" id="id-search" placeholder="番号：">
                            商品ID<br><br><br><br>
                            <button class="sort-button" data-column="id">▲▼</button>
                        </th>
                        <th>商品画像</th>
                        <th>
                            <input type="text" id="title-search" placeholder="商品タイトル検索：">
                            タイトル<br><br><br><br>
                            <button class="sort-button" data-column="title">▲▼</button>
                        </th>
                        <th><br><br><br>ジャンル
                            <div id="genre-dropdown" class="dropdown">
                                <select id="genre-select" style="font-size: 11px;">
                                    <option value="all">全てのジャンル</option>
                                    <option value="comedy">コメディ</option>
                                    <option value="action">アクション</option>
                                    <option value="fantasy">ファンタジー</option>
                                    <option value="romance">ロマンス</option>
                                    <option value="horror">ホラー</option>
                                    <option value="mystery">ミステリー</option>
                                    <option value="sports">スポーツ</option>
                                    <option value="war">戦争</option>
                                </select>
                            </div>
                        </th>
                        <th>価格<button id="amount-sort" class="sort-button" data-column="amount">▲▼</button></th>
                        <th>在庫数<button id="stock-sort" class="sort-button" data-column="stock">▲▼</button></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            <table class="data-table">
                <tbody id="products-display-area">
                    <!-- ここに商品リストがAjaxで挿入される -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>