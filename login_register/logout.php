<?php
function clearCookie(){
    if (isset($_COOKIE['name'])) 
    {
        unset($_COOKIE['name']); 
        setcookie('name', '', time()-1, '/'); 
        echo "ログアウト成功";
        return true;
    } else {
        echo "すでにログアウトされました";

        
        echo "<br><br><br>";
        echo "<div class='main'>";
        echo "<a class='button' href='../login_register/login.html'>ログイン</a>";
        echo "</div>";

        return false;
        
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="../CSS/homepagecss.css">
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
            <li><a href="../login_register/register.html">新規登録</a></li>
            <li><a href="../login_register/login.html">ログイン</a></li>
        </ul>
    </div>
    <br><br><br>
    <div class="title">
        <h4><?php clearCookie();?></h4>
    </div>
    <!-- <a href="../homepage.html">ホームページへ戻る</a> -->
</body>
</html>