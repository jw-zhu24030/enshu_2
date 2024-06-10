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
    <title>マイページ</title>
</head>
<body>
    
    <section>
        <li><a href="../homepage.html">ホームページ</a></li>
        <li><a href="../login_register/logout.php">ログアウト</a></li>
        <li><a href="../search/search.php">チケット申し込み</a></li>
        <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
    </section>
    <!-- <?php
        echo"こんにちは、{$_COOKIE["name"]}さん。";
    ?> -->
    <section>
        <h4>個人情報管理</h4>
        <a href="myinfo.php">個人情報編集</a>
    </section>
    <section>
        <h4>抽選履歴</h4>
        <a href="history.php">詳しいはこちら</a>
    </section>

    
</body>
</html>