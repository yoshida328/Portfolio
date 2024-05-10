// スマホ用メニュー　クラス追加
const ham = document.querySelector("#js-hamburger");
const nav = document.querySelector("#js-globalnav");
const Main = document.querySelector("#js-main");

ham.addEventListener("click", function () {
 ham.classList.toggle("_active");
 nav.classList.toggle("_active");
 Main.classList.toggle("_darker");
});

// 子メニュー表示
const parentMenu = document.querySelectorAll("._has-child > a");
for (let i = 0; i < parentMenu.length; i++) {
 parentMenu[i].addEventListener("click", function(e){
  e.preventDefault();
  this.nextElementSibling.classList.toggle("active");
 })
}

// ページUP
let PageUpBtn = document.getElementById('js-pageup');

if (PageUpBtn) { // 要素が存在する場合のみ処理を実行
    window.addEventListener("scroll", function () {
        const scroll = window.pageYOffset;
        if (scroll > 700) {
            PageUpBtn.style.opacity = 1;
        } else {
            PageUpBtn.style.opacity = 0;
        }
    });

    PageUpBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// キャラクター紹介タブ
// ボタン
const nameList = document.querySelectorAll(".charanamelist__item");
// コンテンツ
const charaContent = document.querySelectorAll(".charalist__item");

document.addEventListener("DOMContentLoaded", function () {
  for (let i = 0; i < nameList.length; i++) {
    nameList[i].addEventListener("click", charaSwitch);
  }
  function charaSwitch() {
    document.querySelectorAll(".active")[0]?.classList.remove("active");
    this?.classList.add("active");
    document.querySelectorAll(".show")[0].classList.remove("show");
    const aryList = Array.prototype.slice.call(nameList);
    const index = aryList.indexOf(this);
    charaContent[index].classList.add("show");
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const loadCommentsBtn = document.getElementById('loadCommentsBtn');
  const commentsTableContainer = document.getElementById('commentsTableContainer');

  loadCommentsBtn.addEventListener('click', function() {
      // 既存のコメントをクリア
      commentsTableContainer.innerHTML = '';

      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_comments.php', true);
      xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 400) {
              var commentsData = JSON.parse(xhr.responseText);
              var commentsSection = document.createElement('section');
              commentsSection.classList.add('bg-white');
              var tableHTML = '<table><thead><tr><th>名前</th><th>メッセージ</th></tr></thead><tbody>';
              commentsData.forEach(function(comment) {
                  tableHTML += '<tr><td>' + comment.name + '</td><td>' + comment.message + '</td></tr>';
              });
              tableHTML += '</tbody></table>';
              commentsSection.innerHTML = tableHTML;
              commentsTableContainer.appendChild(commentsSection);
          } else {
              console.error('リクエストエラー');
          }
      };
      xhr.onerror = function() {
          console.error('通信エラー');
      };
      xhr.send();
  });
});
