$(document).ready(function() {  // ページ安定 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// 検索（ページ安定） //////////////////////////////////////////////////////////////////
// item_search.php ///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

var itemSearchDataArray1 = []; // 商品データの配列１（初期状態）
var itemSearchDataArray2 = []; // 商品データの配列２（ジャンル指定時）

// 初期状態で全ての商品データを取得（配列１に格納）
$.ajax({
    type: 'GET',
    url: 'get_products.php',
    success: function(response) {
        // レスポンスから商品データを取得
        var products = response.data;

        // 商品データを配列１に格納
        itemSearchDataArray1 = products;

        // 検索ボタンをアクティブにする
        checkSearchButton(); // 初期表示時にもチェック
    },
    error: function(xhr, status, error) {
        // エラーが発生した場合の処理
        alert('エラー: ' + error);
    }
});

// キーワード入力時の処理（onKeyUp）
$('#item-search-title').on('input', function() {
    // 検索ボタンの状態をチェックして設定
    checkSearchButton();

    var keyword = $(this).val().trim().toLowerCase(); // 入力されたキーワードを取得

    // キーワードが空の場合はリスト表示を空にする
    if (!keyword) {
        clearSearchResults();
        return;
    }

    // 検索結果表示用のHTMLを初期化
    $('#item-search-result').html('<p>＜＜検索結果＞＞</p>');

    // 商品データからキーワードに一致する商品を検索
    var found = false;
    itemSearchDataArray1.forEach(function(item) {
        // 商品名にキーワードが含まれるかどうかを判定
        if (item.title.toLowerCase().includes(keyword)) {
            found = true;
            // 商品データを表示用のHTMLに追加
            var itemHtml = '<div class="itemSearch">';
            itemHtml += '<div class="itemImage" style="margin-left: 30px; margin-right: 50px;">';
            itemHtml += '<img src="' + item.image_path + '" alt="' + item.title + '">';
            itemHtml += '</div>'; // .itemImage を閉じる
            itemHtml += '<div class="itemInfo">';
            itemHtml += '<p class="title">タイトル名: <strong><span class="large">' + item.title + '</span></strong></p>';
            itemHtml += '<p>商品ID: ' + item.id + '</p>';
            itemHtml += '<p>ジャンル: ' + item.genre + '</p>';
            itemHtml += '<p>価格: ' + parseInt(item.amount, 10) + '</p>';
            itemHtml += '<p>在庫数: ' + item.stock + '</p>';
            itemHtml += '</div>'; // .itemInfo を閉じる
            itemHtml += '</div>'; // .itemSearch を閉じる
            $('#item-search-result').append(itemHtml); // 検索結果を表示
        }
    });

    // キーワードに一致する商品が見つからない場合
    if (!found) {
        $('#item-search-result').html('<p>該当する商品はありません。</p>');
    }

    // キーワードに一致する商品がない場合、検索結果のコンテナを非表示にする
    $('#item-search-result-container').toggle(found);
});

// 検索結果をクリアする関数
function clearSearchResults() {
    $('#item-search-result').html(''); // 検索結果を空にする
    $('#item-search-result-container').hide(); // 検索結果のコンテナを非表示にする
}

// 検索ボタンの状態をチェックして設定
checkSearchButton(); // 初期表示時にもチェック


function checkSearchButton() {
    // ジャンルの選択状態を取得
    var selectedGenre = $('#item-search-genre').val();
    
    // キーワード欄の入力内容を取得し、小文字に変換してトリム
    var keyword = $('#item-search-title').val().trim().toLowerCase();

    // ジャンルが選択されているかどうかをチェック
    if (selectedGenre !== '') {
        // ジャンルが選択されている場合
        // 検索ボタンをアクティブに設定（青色）
        $('#item-searcher-btn').removeClass('disabled').removeAttr('disabled').addClass('active');
        // キーワード欄が空欄または空白の場合、検索ボタンを押すと選択したジャンルのレコードをリスト表示
        if (!keyword) {
            $('#item-searcher-btn').click(function(e) {
                e.preventDefault();
                displayRecords(selectedGenre); // 選択したジャンルのレコードをリスト表示する関数を呼び出し
            });
        } else {
            // キーワード欄に入力がある場合、検索ボタンを押すと検索結果をリスト表示
            $('#item-searcher-btn').click(function(e) {
                e.preventDefault();
                searchRecords(selectedGenre, keyword); // 検索結果をリスト表示する関数を呼び出し
            });
        }
    } else {
        // ジャンルが未選択の場合
        // キーワード欄が空欄または空白の場合、検索ボタンを非アクティブに設定（グレーアウト）
        if (!keyword) {
            $('#item-searcher-btn').addClass('disabled').attr('disabled', 'disabled').removeClass('active');
        } else {
            // キーワード欄に入力がある場合、検索ボタンをアクティブに設定（青色）
            $('#item-searcher-btn').removeClass('disabled').removeAttr('disabled').addClass('active');
            // 検索ボタンを押すと検索結果をリスト表示
            $('#item-searcher-btn').click(function(e) {
                e.preventDefault();
                searchRecords(selectedGenre, keyword); // 検索結果をリスト表示する関数を呼び出し
            });
        }
    }
}

// 選択したジャンルのレコードをリスト表示する関数
function displayRecords(genre) {
    // ここに選択したジャンルのレコードをリスト表示する処理を記述
}

// 検索結果をリスト表示する関数
function searchRecords(genre, keyword) {
    // ここに検索結果をリスト表示する処理を記述
}



//////////////////////////////////////////////////////////////////////////////////////
});  // $(document).ready(function()  の終端 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////