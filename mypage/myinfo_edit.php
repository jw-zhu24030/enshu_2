<?php

if (isset($_COOKIE['uid'])){
    $uid = $_COOKIE['uid'];
    // var_dump($_COOKIE);
    
}else{
    // クッキーがない場合はログインを促すメッセージを表示して終了します
    echo "<p>ログインしてください</p>";
    echo ' <a href="../homepage.html">ホームページへ戻る</a><br>';
    echo ' <a href="../login_register/login.html">ログイン</a>';
    exit();

} 

// databaseのログイン情報
$dsn = "mysql:host=localhost;dbname=ticketsite;charset=utf8";
$user = "testuser";
$pass = "testpass";

// 受け取りデータを処理する
$origin = []; // ここに処理前のデータが入る
if(isset($_GET)||isset($_POST)){
    $origin += $_GET;
    $origin += $_POST;
} 

// 文字コードとhtmlエンティティズの処理を繰り返し行う
foreach($origin as $key=>$value){
    // 文字コード処理
    $mb_code = mb_detect_encoding($value);
    $value = mb_convert_encoding($value, "UTF-8", $mb_code);

    // htmlエンティティズ処理
    $value = htmlentities($value,ENT_QUOTES);

    // 処理が終わったデータを$inputに入れなおします
    $input[$key] = $value;
}
// DBに接続します
try{
    $dbh = new PDO($dsn, $user, $pass); // PDO: PHP database object, PHP自带函数
    
  $result =  display();
        $mail = $result['id'];
        $name = $result['name'];
        $pwd = $result['pwd'];
    



}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}

function display(){
    global $dbh;
    global $uid;
    $sql = <<<_SQL_
        SELECT * FROM user WHERE uid = ?;
_SQL_;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$uid);
    $stmt->execute();
    $result = $stmt -> fetch();
    return $result;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人情報</title>
</head>
<body>
    <h3>個人情報確認</h3>
    <form action="myinfo.php" method="post">
        <table>
            <tr>
                <td>
                    ID/メールアドレス
                </td>
                <td>
                    <input type="text" name="id" value="<?php echo $result['id'];?>"></td>    
                </td>
            </tr>
            <tr>
                <td>
                    ニックネーム
                </td>
                <td>
                <input type="text" name="name" value="<?php echo $result['name'];?>"></td>  

                </td>
            </tr>
            <tr>
                <td>
                    パスワード
                </td>
                <td>
                <input type="password" name="pwd" value="<?php echo $result['pwd'];?>"></td>  

                </td>
            </tr>
            <tr>
                <td>
                    パスワード確認
                </td>
                <td>
                <input type="password" name="pwd1" value="<?php echo $result['pwd'];?>"></td>  

                </td>
            </tr>
            <tr>
                <td><input type="button" value="前画面に戻る" onclick="history.back()"></td>
                <td><input type="submit" value="確認"></td>
            </tr>
        </table>
        <input type="hidden" name="mode" value="edit">
        <input type="hidden" name="uid" value="<?php echo $result['uid'];?>">
    </form>
</body>
</html>

