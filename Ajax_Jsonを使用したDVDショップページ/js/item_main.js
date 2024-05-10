$(document).ready(function() {  // ページ安定 /////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    
    //////////////////////////////////////////////////////////////////////////////////////
    // 管理／削除（ページ安定） ////////////////////////////////////////////////////////////
    // item_manage.php //
    //////////////////////////////////////////////////////////////////////////////////////
        // 更新ボタンがクリックされた時に商品リストを更新する関数
        $('#refresh-btn').click(function() {
            loadProductList(); // main.js内の関数を呼び出し
        });
    
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
    
    
    //////////////////////////////////////////////////////////////////////////////////////
    // 登録（ページ安定） //////////////////////////////////////////////////////////////////
    // item_regist.php , regist_product.php //
    //////////////////////////////////////////////////////////////////////////////////////
    // フォームの各入力欄の値が変更されたときの処理
    $('#item-regist-form input[type="text"], #item-regist-form input[type="number"], #item-regist-form select').on('change keyup', function() {
    // フォームの入力値をチェックして、アクティブな状態にするかどうかを判断
    validateForm();
    });
    
    // フォーカスが外れたときに入力値をチェックする
    $('#amount, #stock').on('blur', function() {
    var inputId = $(this).attr('id');
    var inputValue = $(this).val().trim();
    
    // 負の数が入力された場合はエラーメッセージを表示
    if (inputValue < 0) {
        $('#' + inputId + '-error').text('0以上の数を入力してください。');
    } else {
        $('#' + inputId + '-error').text('');
    }
    });
    
    // フォームの送信ボタンがクリックされたときの処理
    $('#item-regist-form').submit(function(e) {
    e.preventDefault(); // フォームのデフォルトの送信をキャンセル
    
    // フォームの入力値を取得
    var title = $('#title').val().trim();
    var genre = $('#genre').val().trim();
    var amount = $('#amount').val().trim();
    var stock = $('#stock').val().trim();
    var image_path = $('#image_path').val().trim();
    
    // データをオブジェクトに格納
    var data = {
        title: title,
        genre: genre,
        amount: amount,
        stock: stock,
        image_path: image_path
    };
    
    // Ajaxリクエストを送信してサーバーにデータを送信する
    $.ajax({
        type: 'POST',
        url: 'regist_product.php',
        data: data,
        success: function(response) {
        // 登録が成功したら、アラートを表示してフォームをリセット
        alert('登録しました。');
        $('#item-regist-form')[0].reset();
        // 登録後、フォームの入力値を再度チェックして非アクティブ状態にする
        validateForm();
        },
        error: function(xhr, status, error) {
        // エラーが発生した場合は、エラーメッセージを表示
        alert('エラー: ' + error);
        }
    });
    });
    
    // フォームの入力値をチェックして、登録ボタンの状態を切り替える関数
    function validateForm() {
    var title = $('#title').val().trim();
    var genre = $('#genre').val().trim();
    var amount = $('#amount').val().trim();
    var stock = $('#stock').val().trim();
    var image_path = $('#image_path').val().trim();
    
    // 価格と在庫が0以上の整数値であることを確認
    var isPriceValid = /^\d+$/.test(amount) && amount >= 0;
    var isStockValid = /^\d+$/.test(stock) && stock >= 0;
    
    // 全ての入力値が空でなく、価格と在庫が0以上の整数値であれば、登録ボタンをアクティブにする
    if (title && genre && isPriceValid && isStockValid && image_path) {
        $('#register-btn').removeClass('disabled').addClass('active').prop('disabled', false);
    } else {
        $('#register-btn').addClass('disabled').removeClass('active').prop('disabled', true);
    }
    }
    
    
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
                // 商品データをコンテナ表示用のHTMLに追加
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
    
    
    //////////////////////////////////////////////////////////////////////////////////////
    // 管理／削除（通常） ////////////////////////////////////////////////////////////
    // item_manage.php  ////
    // get_products.php ////
    // delete_product.php //
    //////////////////////////////////////////////////////////////////////////////////////
    function loadProductList() {
        $.ajax({
            url: 'get_products.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var productListHTML = '<table>';
                productListHTML += '<tr><th>ID</th><th>Title</th><th>Genre</th><th>Amount</th><th>Stock</th></tr>';
                $.each(response.data, function(index, product) {
                    productListHTML += '<tr>';
                    productListHTML += '<td>' + product.id + '</td>';
                    productListHTML += '<td>' + product.title + '</td>';
                    productListHTML += '<td>' + product.genre + '</td>';
                    productListHTML += '<td>' + product.amount + '</td>';
                    productListHTML += '<td>' + product.stock + '</td>';
                    productListHTML += '<td><img src="' + product.image_path + '" alt="Thumbnail"></td>';
                    productListHTML += '</tr>';
                });
                productListHTML += '</table>';
    
                $('#product-list').html(productListHTML);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    
    //////////////////////////////////////////////////////////////////////////////////////
    // 検索（通常） ////////////////////////////////////////////////////////////
    // item_search.php //
    //////////////////////////////////////////////////////////////////////////////////////
    // モーダルウィンドウを開くための処理
    $(document).on('click', '.itemSearch', function() {
        var item = $(this).data('item'); // クリックされた商品の情報を取得
        // モーダル内の要素に商品情報を設定
        $('#modal-image').attr('src', item.image_path);
        $('#modal-image-path').text(item.image_path);
        $('#modal-id').text(item.id);
        $('#modal-title').text(item.title);
        $('#modal-genre').text(item.genre);
        $('#modal-amount').text(item.amount);
        $('#modal-stock').text(item.stock);
        $('#modal-edited-image').attr('src', item.image_path);
        $('#modal-edited-image-path').val(item.image_path);
        $('#modal-edited-id').text(item.id);
        $('#modal-edited-title').val(item.title);
        $('#modal-edited-genre').val(item.genre);
        $('#modal-edited-amount').val(item.amount);
        $('#modal-edited-stock').val(item.stock);
        // モーダルを表示
        $('#modal').css('display', 'block');
    });
    
    // モーダルウィンドウを閉じるための処理
    $('.close').click(function() {
        $('#modal').css('display', 'none');
    });
    
    // モーダルウィンドウ外のクリックで閉じる処理
    $(window).click(function(event) {
        if (event.target == $('#modal')[0]) {
            $('#modal').css('display', 'none');
        }
    });
    
    // 入力値の変更を検知して登録ボタンの状態を切り替える
    $('#modal-edited-image-path, #modal-edited-title, #modal-edited-genre, #modal-edited-amount, #modal-edited-stock').on('input', function() {
        var editedTitle = $('#modal-edited-title').val().trim();
        var editedGenre = $('#modal-edited-genre').val().trim();
        var editedAmount = $('#modal-edited-amount').val().trim();
        var editedStock = $('#modal-edited-stock').val().trim();
        var editedImagePath = $('#modal-edited-image-path').val().trim();
    
        var isEditedTitleValid = editedTitle.length > 0;
        var isEditedGenreValid = editedGenre.length > 0;
        var isEditedAmountValid = /^\d+$/.test(editedAmount) && editedAmount >= 0;
        var isEditedStockValid = /^\d+$/.test(editedStock) && editedStock >= 0;
        var isEditedImagePathValid = editedImagePath.length > 0;
    
        if (isEditedTitleValid && isEditedGenreValid && isEditedAmountValid && isEditedStockValid && isEditedImagePathValid) {
            $('#update-btn').removeClass('disabled').addClass('active').prop('disabled', false);
        } else {
            $('#update-btn').addClass('disabled').removeClass('active').prop('disabled', true);
        }
    });
    
    // 変更登録ボタンがクリックされたときの処理
    $('#update-btn').click(function() {
        // 変更内容を取得
        var editedItem = {
            id: $('#modal-edited-id').text(),
            title: $('#modal-edited-title').val().trim(),
            genre: $('#modal-edited-genre').val().trim(),
            amount: $('#modal-edited-amount').val().trim(),
            stock: $('#modal-edited-stock').val().trim(),
            image_path: $('#modal-edited-image-path').val().trim()
        };
        // Ajaxリクエストを送信してデータベースを更新する
        $.ajax({
            type: 'POST',
            url: 'update_product.php',
            data: JSON.stringify(editedItem),
            contentType: 'application/json',
            success: function(response) {
                alert('データベースを更新しました。');
                $('#modal').css('display', 'none'); // モーダルを閉じる
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('エラーが発生しました。');
            }
        });
    });
}
