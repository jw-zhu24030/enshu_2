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
</head>
<body>
    <table>
        <tr>
            <td><a href="manage_live.php">公演管理</a></td>
        </tr>
        <tr>
            <td>アーティスト管理</td>
        </tr>
        <tr>
            <td>
                場所管理
            </td>
        </tr>
        <tr>
            <td>
                <a href="manage_inquiry.php">問い合わせ管理</a>
            </td>
        </tr>
    </table>
</body>
</html>