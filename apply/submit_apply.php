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
// try{
//     $dbh = new PDO($dsn, $user, $pass); // PDO: PHP database object, PHP自带函数

//     $lid = $input["lid"];
//     $uid = $input["uid"];
//     $applytime = str_replace(","," ", $input["applytime"]);
//     if (!isApplied($lid, $uid)){
//         $row = apply($lid, $uid, $applytime);
//         echo "申し込み完了<br>";
//         echo "結果が出るまでしばらくお待ちください。<br>";
//     }else{
//         echo "すでに申し込み済みの公演です。<br>";
//     }
    
    

// }catch(PDOException $e){
//     echo "接続失敗．．．";
//     echo "エラー内容：".$e->getMessage();
// }
function isApplied($lid, $uid){
    
    global $dbh;
    global $input;
    $sql = <<<_SQL_
    SELECT * FROM history WHERE lid = {$lid} and uid = {$uid};
_SQL_;
    // echo ($sql);
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // レコードが見つかった場合はtrueを返す
    return $stmt->fetch() !== false;


}
function apply($lid, $uid, $applytime){
    
    global $dbh;
    global $input;
    $sql = <<<_SQL_
    INSERT INTO history (lid, uid, apply_time)
        VALUES({$lid},{$uid},'{$applytime}');
_SQL_;
    // echo ($sql);
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // レコードが見つかった場合はtrueを返す
    return $stmt->fetch() !== false;


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申し込み完了</title>
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
            <br><br><br>
            <div class="title">
                <h3>申し込み完了</h3>
            </div>
            <div class="main">
                <?php
                
                try{
                    $dbh = new PDO($dsn, $user, $pass); // PDO: PHP database object, PHP自带函数

                    $lid = $input["lid"];
                    $uid = $input["uid"];
                    $applytime = str_replace(","," ", $input["applytime"]);
                    if (!isApplied($lid, $uid)){
                        $row = apply($lid, $uid, $applytime);
                        echo "申し込み完了<br>";
                        echo "結果が出るまでしばらくお待ちください。<br>";
                    }else{
                        echo "すでに申し込み済みの公演です。<br>";
                    }
                    
                    

                }catch(PDOException $e){
                    echo "接続失敗．．．";
                    echo "エラー内容：".$e->getMessage();
                }
                ?>
            </div>
</body>
</html>