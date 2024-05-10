$(document).ready(function() {  // ページ安定 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
// 登録（ページ安定） //////////////////////////////////////////////////////////////////
// item_regist.php , item_regist_product.php //
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

//////////////////////////////////////////////////////////////////////////////////////////////
// ファイル選択ボタンがクリックされたときの処理
$('#select-image-btn').on('click', function(event) {
    event.preventDefault(); // デフォルトの動作をキャンセル

    // ファイル選択ダイアログを開く
    $('#image-file-input').click();
});

// ファイルが選択されたときの処理
document.getElementById('image-file-input').addEventListener('change', function() {
// 選択されたファイルのファイル名を取得して、入力欄に表示
var filename = this.value.split('\\').pop(); // ファイルパスからファイル名を抽出

document.getElementById('image_path').value = "movies_cinema/" + filename;

// ファイルが選択されたらフォームの入力値をチェックして登録ボタンの状態を更新
validateForm();
});

/////////////////////////////////////////////////////////////////////////////////////////
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
    url: 'item_regist_product.php',
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
});  // $(document).ready(function()  の終端 /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////