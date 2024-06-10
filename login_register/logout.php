<?php
clearCookie();

function clearCookie(){
    if (isset($_COOKIE['name'])) 
    {
        unset($_COOKIE['name']); 
        setcookie('name', '', time()-1, '/'); 
        echo "ログアウト成功";
        return true;
    } else {
        echo "すでにログアウトされました";
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
</head>
<body>
    <br>
    <a href="../homepage.html">ホームページへ戻る</a>
</body>
</html>