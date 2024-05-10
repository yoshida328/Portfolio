<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>商品情報検索</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/item_style.css" />
    <link rel="icon" type="image/png" href="images/jisou.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/item_search.js"></script>
</head>
<body>
<h2>（商品管理・在庫管理）</h2>
  <h1>商品検索</h1>
  <form id="item-search-form" action="" method="post">
    <div>
      <label for="item-search-title">商品タイトル／キーワード：</label>
      <input type="text" id="item-search-title" name="item-search-title" required>
      <div class="error" id="item-search-title-error"></div>
    </div>
    <div>
      <label for="item-search-genre">ジャンル：（※任意）</label>
      <select id="item-search-genre" name="item-search-genre" required>
        <option value="">ジャンルを選択してください</option>
        <option value="1">comedy</option>
        <option value="2">action</option>
        <option value="3">fantasy</option>
        <option value="4">romance</option>
        <option value="5">horror</option>
        <option value="6">mystery</option>
        <option value="7">sports</option>
        <option value="8">war</option>
      </select>
    </div>
    <button type="submit" id="item-searcher-btn" class="disabled" disabled>検索</button>
  </form><br><br>
  <div id="item-search-result" class="item-search-result" name="item-search-result">
  </div>
  <div id="itemSearch" class="itemSearch" name="itemSearch">
  </div>
</body>
</html>