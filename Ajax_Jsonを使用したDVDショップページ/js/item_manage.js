$(document).ready(function() {  // ページ安定 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// 管理／削除（ページ表示安定） ////////////////////////////////////////////////////////////
// item_manage.php //
//////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////
// 初期表示時に商品リストを読み込む
loadProductList();

// 商品選択＝＞商品id取得＝＞編集
// 商品選択ボタンがクリックされたときの処理
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('edit-btn')) {
        var productId = event.target.getAttribute('data-product-id'); // 選択された商品のIDを取得
        console.log(productId);
        
        // 商品IDを含むURLにリダイレクト
        window.location.href = 'item_edit.php?id=' + productId;
    }
});

///////////////////////////////////////////////////////////////////////////////////////////
//  削除  /////////////////////////////////////////////////////////////////////////////////
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
                    url: "item_delete_product.php",
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

///////////////////////////////////////////////////////////////////////////////////////////////
// ジャンル選択　～ドロップダウンリスト～  ///////////////////////////////////////////////////////////////
$('#genre-select').change(function() {
    // 選択されたジャンルを取得
    var selectedGenre = $(this).val();

    // Ajaxリクエストを送信して商品リストを取得
    $.ajax({
        url: 'item_drop_filter_databases.php',
        type: 'POST',
        data: { selected_genre: selectedGenre },
        dataType: 'json',
        success: function(response) {
            // 商品リストを表示
            displayProducts(response.data);
        },
        error: function(xhr, status, error) {
            // エラーハンドリング
            console.error(xhr.responseText);
        }
    });
});

// 商品リストを表示する関数
function displayProducts(products) {
    var productListHTML = '';
    // 商品リストの生成
    $.each(products, function(index, product) {
        productListHTML += '<tr>';
        productListHTML += '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" class="deleteCheckbox" name="deleteCheckbox" value="' + product.id + '"></td>';
        productListHTML += '<td>' + product.id + '</td>';
        productListHTML += '<td><img src="' + product.image_path + '" alt="Thumbnail" style="width: 50px; height: auto;"></td>';
        productListHTML += '<td>' + product.title + '</td>';
        productListHTML += '<td>' + product.genre + '</td>';
        productListHTML += '<td>' + parseInt(product.amount).toLocaleString() + '円</td>';
        productListHTML += '<td>' + product.stock + '</td>';
        productListHTML += '<td><button class="edit-btn" data-product-id="' + product.id + '">編集</button></td>'; // 編集ボタンを追加
        productListHTML += '</tr>';
    });
    // 既存の商品リストを削除してから新しい商品リストを挿入する
    $('#products-display-area').html(productListHTML);
}
//  ドロップダウンおわり  //////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////
// ソート（商品ID，タイトル，価格，在庫数）  /////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
    // ソートボタンのクリックイベントを設定
    $('.sort-button').on('click', function() {
        var column = $(this).data('column'); // ボタンが関連付けられた列名を取得
        var sortOrder = $(this).data('sort-order') || 'asc'; // ボタンが関連付けられた列の現在のソート順を取得
        var newSortOrder = sortOrder === 'asc' ? 'desc' : 'asc'; // 新しいソート順を決定（昇順→降順、降順→昇順）

        // ソート状態を更新
        $('.sort-button').data('sort-order', null); // すべてのソートボタンのソート状態をリセット
        $(this).data('sort-order', newSortOrder); // クリックされたボタンのソート状態を更新

        // ソート要求を送信
        sortProducts(column, newSortOrder);
    });
});

// 商品をソートする関数
function sortProducts(column, sortOrder) {
    $.ajax({
        url: 'item_sort_products.php',
        type: 'POST',
        data: { column: column, sortOrder: sortOrder },
        dataType: 'json',
        success: function(response) {
            // 商品リストを更新
            displayProducts(response.data);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// 商品リストを表示する関数（displayProducts関数の内容は先ほどのものを流用）
function displayProducts(products) {
    var productListHTML = '';
    // 商品リストの生成
    $.each(products, function(index, product) {
        productListHTML += '<tr>';
        productListHTML += '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" class="deleteCheckbox" name="deleteCheckbox" value="' + product.id + '"></td>';
        productListHTML += '<td>' + product.id + '</td>';
        productListHTML += '<td><img src="' + product.image_path + '" alt="Thumbnail" style="width: 50px; height: auto;"></td>';
        productListHTML += '<td>' + product.title + '</td>';
        productListHTML += '<td>' + product.genre + '</td>';
        productListHTML += '<td>' + parseInt(product.amount).toLocaleString() + '円</td>';
        productListHTML += '<td>' + product.stock + '</td>';
        productListHTML += '<td><button class="edit-btn" data-product-id="' + product.id + '">編集</button></td>'; // 編集ボタンを追加
        productListHTML += '</tr>';
    });
    // 既存の商品リストを削除してから新しい商品リストを挿入する
    $('#products-display-area').empty().append(productListHTML);
}

///////////////////////////////////////////////////////////////////////////////////////////////
// 商品ID検索　リアルタイム検索  ///////////////////////////////////////////////////////////////
// 商品ID検索用のinput要素
const idSearchInput = document.getElementById('id-search');

// 商品ID検索用のinput要素にkeyupイベントリスナーを追加
idSearchInput.addEventListener('keyup', function () {
    const id = this.value.trim(); // 入力されたIDを取得
    if (id === '') {
        loadProductList(); // IDが空の場合は全レコードを表示
        return;
    }

    // Ajaxリクエストを作成
    const xhr = new XMLHttpRequest();
    const url = 'id_search_database.php';
    const params = 'id=' + encodeURIComponent(id); // IDをエンコード
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // レスポンスを受け取った時の処理
    xhr.onload = function () {
        if (xhr.status === 200) {
            // レスポンスのデータを取得
            const responseData = JSON.parse(xhr.responseText);
            if (responseData.success) {
                // 成功した場合は商品リストを更新
                updateProductList(responseData.data);
            } else {
                // レコードが見つからなかった場合は全レコードを表示
                loadProductList();
            }
        } else {
            console.error('Error:', xhr.statusText);
        }
    };

    // エラーが発生した時の処理
    xhr.onerror = function () {
        console.error('Error: Network Error');
    };

    // リクエストを送信
    xhr.send(params);
});



//////////////////////////////////////////////////////////////////////////////////////
});  // $(document).ready(function()  ページ表示安定の終端 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////
// 管理／削除（通常） /////////////////////////////////////////////////////////////////
// item_manage.php //
// item_manage.php //
//////////////////////////////////////////////////////////////////////////////////////

//  リスト表示  /////////////////////////////////////////////////////////////////////////////
function loadProductList() {
    $.ajax({
        url: 'item_get_products.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var productListHTML = '';
            // td要素のセレクタを指定して幅を設定
            $('td').css('width', '90%');
            // 商品リストの生成
            $.each(response.data, function(index, product) {
                productListHTML += '<tr>';
                productListHTML += '<td style="text-align: center; vertical-align: middle;">' + '<input type="checkbox" class="deleteCheckbox" name="deleteCheckbox" value="' + product.id + '"></td>';
                productListHTML += '<td>' + product.id + '</td>';
                productListHTML += '<td><img src="' + product.image_path + '" alt="Thumbnail" style="width: 50px; height: auto;"></td>';
                productListHTML += '<td>' + product.title + '</td>';
                productListHTML += '<td>' + product.genre + '</td>';
                productListHTML += '<td>' + parseInt(product.amount).toLocaleString() + '円</td>';
                productListHTML += '<td>' + product.stock + '</td>';
                productListHTML += '<td><button class="edit-btn" data-product-id="' + product.id + '">編集</button></td>'; // 編集ボタンを追加
                productListHTML += '</tr>';
            });
            // 既存の商品リストを削除してから新しい商品リストを挿入する
            $('#products-display-area').empty();
            $('#products-display-area').append('<table class="product-table">' + productListHTML + '</table>');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////
// タイトル検索　リアルタイム検索  ///////////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    const titleSearchInput = document.getElementById('title-search');

    // 商品タイトルの入力欄で入力があった場合の処理
    titleSearchInput.addEventListener('keyup', function () {
        const keyword = this.value.trim(); // 入力されたキーワードを取得
        if (keyword === '') {
            loadProductList();
            return; // キーワードが空の場合は全レコードを表示
        }

        // Ajaxリクエストを作成
        const xhr = new XMLHttpRequest();
        const url = 'item_title_search_databases.php';
        const params = 'keyword=' + encodeURIComponent(keyword); // キーワードをエンコード
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // レスポンスを受け取った時の処理
        xhr.onload = function () {
            if (xhr.status === 200) {
                // レスポンスのデータを取得
                const responseData = JSON.parse(xhr.responseText);
                if (responseData.success) {
                    // 成功した場合は商品リストを更新
                    updateProductList(responseData.data);
                } else {
                    // 失敗した場合はエラーメッセージを表示
                    console.error('Error:', responseData.message);
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        // エラーが発生した時の処理
        xhr.onerror = function () {
            console.error('Error: Network Error');
        };

        // リクエストを送信
        xhr.send(params);
    });
});

// 商品リストを読み込む関数
function loadProductList() {
    // Ajaxリクエストを作成
    const xhr = new XMLHttpRequest();
    const url = 'item_get_products.php';
    xhr.open('GET', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    // レスポンスを受け取った時の処理
    xhr.onload = function () {
        if (xhr.status === 200) {
            // レスポンスのデータを取得
            const responseData = JSON.parse(xhr.responseText);
            if (responseData.success) {
                // 成功した場合は商品リストを更新
                updateProductList(responseData.data);
            } else {
                // 失敗した場合はエラーメッセージを表示
                console.error('Error:', responseData.message);
            }
        } else {
            console.error('Error:', xhr.statusText);
        }
    };

    // エラーが発生した時の処理
    xhr.onerror = function () {
        console.error('Error: Network Error');
    };

    // リクエストを送信
    xhr.send();
}

// 商品リストを更新する関数
function updateProductList(products) {
    const productsDisplayArea = document.getElementById('products-display-area');
    // 商品リストをクリア
    productsDisplayArea.innerHTML = '';

    // 商品リストを再構築
    products.forEach(product => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="text-align: center; vertical-align: middle;"><input type="checkbox" class="deleteCheckbox" name="deleteCheckbox" value="${product.id}"></td>
            <td>${product.id}</td>
            <td><img src="${product.image_path}" alt="${product.title}" width="50"></td>
            <td>${product.title}</td>
            <td>${product.genre}</td>
            <td>${parseInt(product.amount).toLocaleString()} 円</td> <!-- 金額を整数に変換して、通貨形式で表示 -->
            <td>${product.stock}</td>
            <td><button class="edit-btn" data-product-id="${product.id}">編集</button></td>
        `;
        productsDisplayArea.appendChild(tr);
    });
}

