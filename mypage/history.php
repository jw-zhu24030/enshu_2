<?php

if (isset($_COOKIE['uid'])){
    $uid = $_COOKIE['uid'];
}
// else{
//     // クッキーがない場合はログインを促すメッセージを表示して終了します
//     echo "<p>ログインしてください</p>";
//     echo ' <a href="../homepage.html">ホームページへ戻る</a><br>';
//     echo ' <a href="../login_register/login.html">ログイン</a>';
//     exit();
// 
// } 
// databaseのログイン情報
$dsn = "mysql:host=localhost;dbname=ticketsite;charset=utf8";
$user = "testuser";
$pass = "testpass";

// 受け取りデータを処理する
$origin = []; // ここに処理前のデータが入る
$tmplurl = "";
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

    if(isset($input) && $input['mode']=='cancle'){
        cancle();
    }
    dispaly();
    
    

}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}


function cancle(){
    global $dbh;
    global $input;
    global $uid;
    
    $sql = <<<_SQL_
        UPDATE history SET flag = 0 WHERE lid = ? AND uid = ?;
_SQL_;    
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["id"]);
    $stmt->bindParam(2,$uid);
    $stmt->execute();

}
function dispaly(){
    global $dbh;
    global $input;
    global $uid;
    $sql = <<<_SQL_
            SELECT livelist.id, livelist.name, livelist.artist, livelist.place, livelist.day, livelist.daytime, history.hit as status
             FROM livelist LEFT JOIN history ON livelist.id = history.lid
             WHERE history.uid = {$uid} AND history.flag = 1
             ORDER BY livelist.day, livelist.daytime;
_SQL_;
    
    // echo ($sql);
    // echo ($dbh->query($sql));
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // var_dump($stmt->fetch());
    // $blockを初期化
    $block = "";

    // tmplファイルの読み込み
    $fh = fopen("history.tmpl", "r+");
    $fs = filesize("history.tmpl"); // file sizeを調べる（のちのfread関数で使用）
    $insert_tmpl = fread($fh, $fs); // fileの読み込みを行う
    fclose($fh); // 不必要

    // recordを一行ずつ繰り返し$blockに詰め込む
    while ($row = $stmt->fetch()){
        // var_dump($row); // 输出查询结果以供调试

        // 差し込む用tmplを初期化
        $insert = $insert_tmpl;

        // DBの値を、PHPで使用する値として変数に入れ直す
        $id = $row["id"];
        $name = $row["name"];
        $artist = $row["artist"];
        $address = $row["place"];
        $day = $row["day"];
        $daytime = $row["daytime"];
        $status = "";
        switch($row["status"]){
            case -1:
                $status = "落選";
                break;
            case 0:
                $status = "抽選待ち";
                break;
            case 1:
                $status = "当選";
                break;
        }
        // tmplファイルの文字置き換え
        $insert = str_replace("!id!",$id, $insert);
        $insert = str_replace("!name!",$name, $insert);
        $insert = str_replace("!artist!",$artist, $insert);
        $insert = str_replace("!address!",$address, $insert);
        $insert = str_replace("!day!",$day, $insert);
        $insert = str_replace("!daytime!",$daytime, $insert);
        $insert = str_replace("!status!",$status, $insert);
    
        // stock.htmlに差し込む変数に格納する
        $block .= $insert; // loopするために、insert_tmplの値を追加する
    
        
    }
    

    // stock.htmlの!bolck!に、$blockを差し込む
    $fh_stock = fopen("history.html","r+");
    $fs_stock = filesize("history.html");
    $top = fread($fh_stock, $fs_stock);
    fclose($fh_stock);

    // $top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);
    
    // 全てを差し替えたデータをブラウザに表示
    echo ($top);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申し込み履歴</title>
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

    
</body>
</html>