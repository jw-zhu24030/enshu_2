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
// var_dump($input);
// DBに接続します
try{
    $dbh = new PDO($dsn, $user, $pass); // PDO: PHP database object, PHP自带函数

    if(isset($input["mode"]) && $input["mode"]=="check"){
        
        check($dbh,$input);

    }

    display();
    

}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}


function display(){
    global $dbh;
    global $input;
    $sql = <<<_SQL_
            SELECT * FROM inquiry ORDER BY status, no;
_SQL_;

    // echo ($dbh->query($sql));
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // $blockを初期化
    $block = "";

    // tmplファイルの読み込み
    $fh = fopen("manage_inquiry.tmpl", "r+");
    $fs = filesize("manage_inquiry.tmpl"); // file sizeを調べる（のちのfread関数で使用）
    $insert_tmpl = fread($fh, $fs); // fileの読み込みを行う
    fclose($fh); // 不必要

    // recordを一行ずつ繰り返し$blockに詰め込む
    while ($row = $stmt->fetch()){
        // var_dump($row); // 输出查询结果以供调试

        // 差し込む用tmplを初期化
        $insert = $insert_tmpl;

        // DBの値を、PHPで使用する値として変数に入れ直す
        $id = $row["no"];
        $name = $row["name"];
        $email = $row["email"];
        $text = $row["text"];
        $lid = $row["lid"];
        $time = $row["time"];
        $status = $row["status"];
    
        // tmplファイルの文字置き換え
        $insert = str_replace("!id!",$id, $insert);
        $insert = str_replace("!name!",$name, $insert);
        $insert = str_replace("!email!",$email, $insert);
        $insert = str_replace("!text!",str_replace("_kaigyou_","<br>",$text), $insert);
        $insert = str_replace("!lid!",$lid, $insert);
        $insert = str_replace("!time!",$time, $insert);
        if ($status == "0"){
             $insert = str_replace("!status!","<td bgcolor='yellow'>***<b>未対応</b>***</td>", $insert);
        }else if ($status == "1"){
             $insert = str_replace("!status!","<td bgcolor='lightgreen'>***<b>対応済み</b>***</td>", $insert);
        }
     
        // stock.htmlに差し込む変数に格納する
        $block .= $insert; // loopするために、insert_tmplの値を追加する
    
        
    }
    

    // stock.htmlの!bolck!に、$blockを差し込む
    $fh_stock = fopen("manage_inquiry.html","r+");
    $fs_stock = filesize("manage_inquiry.html");
    $top = fread($fh_stock, $fs_stock);
    fclose($fh_stock);

    // $top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);
    
    // 全てを差し替えたデータをブラウザに表示
    echo ($top);
}

function check(){
    global $dbh;
    global $input;
    $sql = <<<_SQL_
        UPDATE inquiry SET status = ? WHERE no = ?;
_SQL_;
    $stmt = $dbh->prepare($sql);
    $check = -1;
    // if($input["status"] == "未対応"){
    if(preg_match("[未対応]",$input["status"]) == 1){
        $check = 1;
    // }else if($input["status"] == "対応済み"){
    }else if(preg_match("[対応済み]",$input["status"]) == 1){
        $check = 0;
    }
    $stmt->bindParam(1,$check);
    $stmt->bindParam(2,$input["id"]);
    $stmt->execute();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ管理</title>
</head>
<body>
    
</body>
</html>