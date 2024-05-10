$(document).ready(function() {
    // 入力欄の内容が変更されたときの処理
    $('#edit-form input, #edit-form select').on('input', function() {
        validateFields();
    });

    // 〇ファイル選択ボタンがクリックされたときの処理
    $('#edit-file-select-btn').on('click', function(event) {
        event.preventDefault(); // デフォルトの動作をキャンセル
        // ファイル選択ダイアログを開く
        $('#edit-file-select-input').click();
    });

    // 〇ファイルが選択されたときの処理
    $('#edit-file-select-input').on('change', function() {
        var file = this.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            // ファイルが読み込まれた後にプレビューを表示
            $('#edit-image_path').val("movies_cinema/" + file.name);
            $('.edit-item-value img').attr('src', e.target.result);
        };

        // ファイルの内容を読み込む
        reader.readAsDataURL(file);

        // ファイルが選択されたらフォームの入力値をチェックして登録ボタンの状態を更新
        validateForm();
    });

    // 画像パス入力欄の変更を監視し、リアルタイムで画像を表示
    $('#edit-image_path').on('input', function() {
        var imagePath = $(this).val();
        var imageElement = $('.edit-item-value img');
        
        if (imagePath) {
            // 入力された画像パスがある場合は画像を表示
            imageElement.attr('src', imagePath);
        } else {
            // 入力された画像パスがない場合は代替の画像を表示
            imageElement.attr('src', '代替の画像パス');
        }
    });

    // 内容更新ボタンがクリックされたときの処理
    $('#edit-update-btn').on('click', function() {
        var confirmed = confirm("データベースの内容を更新します。よろしいですか？");
        if (confirmed) {
            // データベースの更新処理を実行
            updateDatabase();
            // 画面を切り替える
            window.location.href = 'item_manage.php';
        }
    });

/////////////////////////////////////////////////////////////////////////////////////////////////////
});//  HTML表示完了待ち　～おわり～
/////////////////////////////////////////////////////////////////////////////////////////////////////

function updateDatabase() {
    $.ajax({
        url: 'item_edit_update_a_database.php', // データベースの更新処理を行うPHPファイルのパスを指定する
        method: 'POST',
        data: $('#edit-form').serialize(), // フォームデータをシリアライズして送信
        success: function(response) {
            if (response !== "0") {
                // 更新が成功した場合
                var updatedProductId = response;
                var updatedProductName = $('#id').val(); // 更新された商品のIDを取得
                alert("商品ID：" + updatedProductName + " を更新しました。"); // アラートを表示
                // 1秒後にページを切り替える
                setTimeout(function() {
                    window.location.href = 'item_manage.php';
                }, 1000);
            } else {
                alert("更新に失敗しました。"); // 更新が失敗した場合のアラート
            }
        },
        error: function() {
            alert("エラーが発生しました。"); // エラーが発生した場合のアラート
        }
    });
}

function validateFields() {
    var allFieldsFilled = true; // 全ての入力欄が空でないことを示すフラグを初期化
    $('#edit-form input, #edit-form select').each(function() {
        var fieldName = $(this).attr('name');
        var fieldValue = $(this).val()
        if (fieldName !== 'edited-id') { // 商品IDを除外
            if (!fieldValue) { // フィールドが空白または空白のみであるか確認
                $(this).css('border', '2px solid red'); // 空欄もしくは空白のみの入力欄を赤枠に
                allFieldsFilled = false; // 入力欄が空であることを示すフラグを更新
            } else {
                $(this).css('border', '2px solid #90ee90'); // 有効な入力欄を緑枠に
            }
        }
    });
    // 入力欄が空でない場合は内容更新ボタンをアクティブにする
    if (allFieldsFilled) {
        $('#edit-update-btn').prop('disabled', false);
        $('#edit-update-btn').css('background-color', '#80ccff'); // ボタンを青色に
    } else {
        $('#edit-update-btn').prop('disabled', true);
        $('#edit-update-btn').css('background-color', '#A9A9A9'); // ボタンをグレーアウトに
    }
}
