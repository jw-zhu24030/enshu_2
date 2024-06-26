
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ライブを探す</title>    
    <link rel="stylesheet" href="../CSS/homepagecss.css">
    <script>
        // Function to get a cookie by name
        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

        // Function to display the cookie value
        function displayCookie() {
            let userName = getCookie("name");
            if (userName) {
                document.getElementById("greeting").innerText = `こんにちは、${userName}さん。`;
            }
        }

        // Call the function on page load
        window.onload = displayCookie;
    </script>
</head>
<body>


    <div class="topnav">
        <!-- Placeholder for greeting -->
        <div id="greeting" class="greeting"></div>
        <ul>
            <li><a href="../homepage.html">ホームページ</a></li>
            <li><a href="../mypage/mypage.php">マイページ</a></li>
            <li><a href="search.php">チケット申し込み</a></li>
            <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
            <li><a href="../login_register/logout.php">ログアウト</a></li>
        </ul>
    </div>

    <br><br><br><br>

    <div class="title">
        <?php
            if (!isset($_COOKIE["name"])) 
            {
                echo "<b><p>ログインしてください</p></b>";
                echo "</div>";
                echo "<div class='main'>";
                
                echo "<a class='button' href='../login_register/login.html'>ログイン</a>";
                exit();
            }

        ?>
    </div>
    <div class="searchContainer">
        <form action="../apply/apply.php" method="get"> 
        <div class="searchbyall">
            
            <h4>公演一覧より確認する</h4>
            <a href="../apply/apply.php" class="searchall">確認</a>
        </div> 
            <div class="searchbykeywords">
                <h4>番号またはキーワードより探す</h4>
                <input type="text" name="inputsearch" placeholder="番号またはキーワードより探す"value="">
                <div class="search-group">
                <label class="typesearch"><input type="radio" value="id" name="radiosearch">番号</label>
                <label class="typesearch"><input type="radio" value="name" name="radiosearch">公演名</label>
                <label class="typesearch"><input type="radio" value="artist" name="radiosearch">アーティスト名</label></div>
                <input type="submit" class="searchButton" value="検索" >
                </div><br>
            <div class="searchbyfilter">
            <br>
                <h4>フィルターより探す</h4>
                日付<input type="date" name="date" id="date" value=""><br>
                場所<select name="prefectures" id ="prefectures">
                <option value="" selected>都道府県を選択</option>
                <option value="北海道">北海道</option>
                <option value="青森県">青森県</option>
                <option value="岩手県">岩手県</option>
                <option value="宮城県">宮城県</option>
                <option value="秋田県">秋田県</option>
                <option value="山形県">山形県</option>
                <option value="福島県">福島県</option>
                <option value="茨城県">茨城県</option>
                <option value="栃木県">栃木県</option>
                <option value="群馬県">群馬県</option>
                <option value="埼玉県">埼玉県</option>
                <option value="千葉県">千葉県</option>
                <option value="東京都">東京都</option>
                <option value="神奈川県">神奈川県</option>
                <option value="新潟県">新潟県</option>
                <option value="富山県">富山県</option>
                <option value="石川県">石川県</option>
                <option value="福井県">福井県</option>
                <option value="山梨県">山梨県</option>
                <option value="長野県">長野県</option>
                <option value="岐阜県">岐阜県</option>
                <option value="静岡県">静岡県</option>
                <option value="愛知県">愛知県</option>
                <option value="三重県">三重県</option>
                <option value="滋賀県">滋賀県</option>
                <option value="京都府">京都府</option>
                <option value="大阪府">大阪府</option>
                <option value="兵庫県">兵庫県</option>
                <option value="奈良県">奈良県</option>
                <option value="和歌山県">和歌山県</option>
                <option value="鳥取県">鳥取県</option>
                <option value="島根県">島根県</option>
                <option value="岡山県">岡山県</option>
                <option value="広島県">広島県</option>
                <option value="山口県">山口県</option>
                <option value="徳島県">徳島県</option>
                <option value="香川県">香川県</option>
                <option value="愛媛県">愛媛県</option>
                <option value="高知県">高知県</option>
                <option value="福岡県">福岡県</option>
                <option value="佐賀県">佐賀県</option>
                <option value="長崎県">長崎県</option>
                <option value="熊本県">熊本県</option>
                <option value="大分県">大分県</option>
                <option value="宮崎県">宮崎県</option>
                <option value="鹿児島県">鹿児島県</option>
                <option value="沖縄県">沖縄県</option>
                </select>
                <br>
                <input type="submit" class="searchButton" value="検索" >
            </div>
        </form>
    <!-- <input type="button" value="前画面に戻る" onclick="history.back()"> -->
    <!-- <a href="../homepage.html">ホームページへ戻る</a> -->
    </div>
</body>


</html>

