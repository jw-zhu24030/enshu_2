<?php
if (isset($_COOKIE["name"])) {

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


    



}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}


// update($dbh,$input);

function update($dbh,$input){
    // stock tableのname, priceの値に入力された商品名と値段を登録
    $sql = <<<_SQL_
            UPDATE livelist SET
            name = ?, 
            artist = ?, 
            place = ?, 
            day = ?, 
            daytime = ? 
            WHERE id = ?;
_SQL_;
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["name"]);
    $stmt->bindParam(2,$input["artist"]);
    $stmt->bindParam(3,$input["place"]);
    $stmt->bindParam(4,$input["day"]);
    $stmt->bindParam(5,$input["daytime"]);
    $stmt->bindParam(6,$input["id"]);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認</title>
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
            <div class="title">
    <h3>以下の内容を編集しますか</h3>
    </div>
    <div class="main">
    <form action="manage_live.php" method="post">
        <table>
            <tr>
                <td>公演番号</td>
                <td><?php echo $input['id'];?>
                    <input type="hidden" name="id" value="<?php echo $input['id'];?>"></td>
            </tr>
            <tr>
                <td>公演名</td>
                <td><?php echo $input['name'];?>
                <input type="hidden" name="name" value="<?php echo $input['name'];?>"></td>
            </tr>
            <tr>
                <td>アーティスト</td>
                <td><?php echo $input['artist'];?>
                <input type="hidden" name="artist" value="<?php echo $input['artist'];?>"></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><?php echo $input['prefectures'];?>
                <input type="hidden" name="place" value="<?php echo $input['prefectures'];?>"></td>
            </tr>
            <tr>
                <td>日付</td>
                <td><?php echo $input['day'];?>
                <input type="hidden" name="day" value="<?php echo $input['day'];?>"></td>
            </tr>
            <tr>
                <td>時間</td>
                <td><?php echo $input['daytime'];?>
                <input type="hidden" name="daytime" value="<?php echo $input['daytime'];?>"></td>
            </tr>
            <tr>
                <td><input type="button" value="前画面に戻る" onclick="history.back()"></td>
                <td><input type="submit" value="登録">
                    <input type="hidden"  name="mode" value="update"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>