<?php
if (isset($_COOKIE["name"])) {

}else{
    // クッキーがない場合はログインを促すメッセージを表示して終了します
    echo "<p>ログインしてください</p>";
    echo ' <a href="../homepage.html">ホームページへ戻る</a><br>';
    echo ' <a href="../login_register/login.html">ログイン</a>';
    exit();

}

date_default_timezone_set('Asia/Tokyo');
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


if (isset($_COOKIE["name"])) {
    $uid = $_COOKIE["uid"];
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

// var_dump($input);

// DBに接続します
try{
    $dbh = new PDO($dsn, $user, $pass); // PDO: PHP database object, PHP自带函数

    $row = display();
    
    $lid = $row["id"];
    $name = $row["name"];
    $artist = $row["artist"];
    $address = $row["place"];
    $day = $row["day"];
    $daytime = $row["daytime"];
    

}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}

function display(){
    
    global $dbh;
    global $input;
    $sql = "SELECT * FROM livelist WHERE flag = 1 AND id = {$input['lid']}";

    // echo ($sql);
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
    // var_dump($row);


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申し込み確認</title>
</head>
<body>
    <h3>以下の公演を申し込みしますか？</h3>
    <table>
        <tr>
            <td>公演番号</td>
            <td><?php echo"{$lid }";?></td>
        </tr>
        <tr>
            <td>公演名</td>
            <td><?php echo"{$name }";?></td>
        </tr>
        <tr>
            <td>アーティスト</td>
            <td><?php echo"{$artist }";?></td>
        </tr>
        <tr>
            <td>場所</td>
            <td><?php echo"{$address }";?></td>
        </tr>
        <tr>
            <td>日付</td>
            <td><?php echo"{$day }";?></td>
        </tr>
        <tr>
            <td>時間</td>
            <td><?php echo"{$daytime }";?></td>
        </tr>
        <tr>
            <td>
                <input value="前に戻る" onclick="history.back();" type="button">
                
            </td>
            <td>
                
                <form action="submit_apply.php" method="get">
                    <input type="submit"value="申し込み">
                    <input type="hidden" name="lid" value=<?php echo"{$lid}";?>>
                    <input type="hidden" name="uid" value=<?php echo"{$uid}";?>>
                    <input type="hidden" name="applytime" value=<?php echo date("Y-m-d,H:i:s");?>>
                </form>
            </td>
        </tr>
    </table>
    


</body>
</html>