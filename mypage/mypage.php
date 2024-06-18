<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
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
        <li><a href="../search/search.php">チケット申し込み</a></li>
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

    <section>
        <div class="title">
        <h4>個人情報管理</h4></div>
        <div class="main">
        <a href="myinfo.php" class="link">個人情報編集</a>
        </div>
    </section>
    <section>
        <div class="title">
        <h4>抽選履歴</h4></div>
        <div class="main">
        <a href="history.php" class="link">詳しいはこちら</a></div>
    </section>

    
</body>
</html>