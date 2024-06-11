<?php
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


$name = wordProcess($input["name"]);
$mail = wordProcess($input["email"]);
$liveno = wordProcess($input["liveno"]);
$message = wordProcess($input["message"]);
$localtime = str_replace(","," ",wordProcess($input["localtime"]));

try {
    // DBに接続します
    $dbh = new PDO($dsn, $user, $pass);

    $sql = <<<_SQL_
        INSERT INTO  inquiry (name, email, lid, text, time)
            VALUES ("{$name}","{$mail}","{$liveno}","{$message}","{$localtime}");
_SQL_;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
} catch (PDOException $e) {
  echo "接続失敗．．．";
  echo "エラー内容：" . $e->getMessage();
}




function wordProcess($input){
# 文字コードをUTF-8 に統一
    $enc = mb_detect_encoding($input);
    $input = mb_convert_encoding($input, "UTF-8", $enc);

    # クロスサイトスクリプティング対策
    $input = htmlentities($input, ENT_QUOTES, "UTF-8");

    # 改行コード処理
    $input = str_replace("\r\n", "_kaigyou_", $input);
    $input = str_replace("\n", "_kaigyou_", $input);
    $input = str_replace("\r", "_kaigyou_", $input);
    return $input;
}

?>

<html>
    ありがとうございました。<br>
    <a href="../homepage.html">ホームページに戻る</a>
    <!-- <input type="button" value="ホームページに戻る" onclick="homepage.html"> -->
</html>