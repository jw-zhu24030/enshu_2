<?php

if (isset($_COOKIE["name"])) {

}else{
    // クッキーがない場合はログインを促すメッセージを表示して終了します
    echo "<p>ログインしてください</p>";
    echo ' <a href="../homepage.html">ホームページへ戻る</a><br>';
    echo ' <a href="../login_register/login.html">ログイン</a>';
    exit();

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理</title>
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
                <li><a href="../manage/manage.php">ホームページ</a></li>
                <li><a href="../login_register/logout.php">ログアウト</a></li>
            </ul>
        </div>
        <br><br><br>
        <br><br><br>
        <div class="main">
            <table>
                <tr>
                    <td><b><a href="manage_live.php">公演管理</a></b></td>
                </tr>
                <!-- <tr>
                    <td>アーティスト管理</td>
                </tr>
                <tr>
                    <td>
                        場所管理
                    </td>
                </tr> -->
                <br><br><br><br><br><br>
                <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
                <tr>
                    <td>
                        <a href="manage_inquiry.php"><b>問い合わせ管理</b></a>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>