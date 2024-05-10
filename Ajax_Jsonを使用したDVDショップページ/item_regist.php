<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>商品情報登録</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/item_style.css" />
    <link rel="icon" type="image/png" href="images/jisou.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/item_regist.js"></script>
</head>
<body>
  <h2>（商品管理・在庫管理）</h2>
  <h1>商品登録</h1>
  <div class="control-btn" style="text-align: right;">
        <a href="item_manage.php"><button>管理画面へ</button></a>
  </div><br>
  <form id="item-regist-form" action="item_regist_product.php" method="post">
    <div>
      <label for="title">タイトル：</label>
      <input type="text" id="title" name="title" required>
      <div class="error" id="title-error"></div>
    </div><br>
    <div>
      <label for="genre">ジャンル：</label>
      <select id="genre" name="genre" required>
        <option value="">ジャンルを選択してください</option>
        <option value="1">comedy</option>
        <option value="2">action</option>
        <option value="3">fantasy</option>
        <option value="3">romance</option>
        <option value="3">horror</option>
        <option value="3">mystery</option>
        <option value="3">sports</option>
        <option value="3">war</option>
      </select>
    </div><br>
    <div>
      <label for="amount">価格：</label>
      <input type="number" id="amount" name="amount" min="0" step="1" required>
      <div class="error" id="amount-error"></div>
    </div><br>
    <div>
      <label for="stock">在庫数：</label>
      <input type="number" id="stock" name="stock" min="0" step="1" required>
      <div class="error" id="stock-error"></div>
    </div><br>
    <div>
      <label for="image_path">画像ファイル名：</label>
      <input type="text" id="image_path" name="image_path" required>
      <label for="image-file-input" id="select-image-btn">
        <img src="images/folder.png" alt="画像を選択">
      </label>
      <input type="file" id="image-file-input" style="display: none;">
      <div class="error" id="image-path-error"></div>
    </div>
    <button type="submit" id="register-btn" class="disabled" disabled>登録</button>
  </form>
</body>
</html>