<?php

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

$inputmail = $input["mail"];
$inputpass = $input["pass"];

$inputmail = wordProcess($inputmail);
$inputpass = wordProcess($inputpass);
// setcookie("mail", $inputmail, time()+600);



try {
  // DBに接続します
  $dbh = new PDO($dsn, $user, $pass);
    

  $error_notes = "";
  if($inputmail === ""){
    $error_notes.="・名前が未入力です。<br>";
  }
  if($inputpass === ""){
    $error_notes.="・パスワードが未入力です。<br>";
  }
  if(($inputmail!="" && $inputpass!="") && !isUser($dbh,$inputmail,$inputpass) && !isManager($dbh,$inputmail,$inputpass)){
    $error_notes.="・メールアドレスまたはパスワードが間違えました。<br>";
  }
  #エラーが存在する場合
  if($error_notes !== "") {
      error($error_notes);
  }elseif(isManager($dbh,$inputmail,$inputpass)){
    header("Location:../manage/manage.php");
    $name = getUserInfo($dbh,$inputmail)["name"];
    setcookie("name", $name, time()+600, "/");
    exit();
  }else{
  
  // echo "こんにちは、{$inputmail}さん。";

  $name = getUserInfo($dbh,$inputmail)["name"];
  $uid = getUserInfo($dbh,$inputmail)["uid"];
  setcookie("mail", $inputmail, time()+600, "/");
  setcookie("name", $name, time()+600, "/");
  setcookie("uid", $uid, time()+600, "/");
  
  
  }


} catch (PDOException $e) {
  echo "接続失敗．．．";
  echo "エラー内容：" . $e->getMessage();
}




function error($err){
    global $tmpl_dir;
  
    # テンプレート読み込み
    $conf = fopen("../error.tmpl","r") or die;
    $size = filesize("../error.tmpl");
    $tmpl = fread($conf,$size);
    fclose($conf);
  
    # 文字置き換え
    $tmpl = str_replace("!message!",$err,$tmpl);
    # 表示
    echo $tmpl;
    exit;
  }

function getUserInfo($dbh, $id){

  $sql = "SELECT * FROM user WHERE id = :id" ;
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row;
}


// ユーザー認証を行う関数
function isUser($dbh, $name, $pass) {
  $sql = "SELECT * FROM user WHERE id = :name AND pwd = :pass AND flag = 1" ;
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':pass', $pass);
  $stmt->execute();
  
  // レコードが見つかった場合はtrueを返す
  return $stmt->fetch() !== false;
}


function isManager( $dbh,$name, $pass) {
  $sql = "SELECT * FROM user WHERE id = :name AND pwd = :pass AND flag = 0" ;
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':pass', $pass);
  $stmt->execute();
  
  // レコードが見つかった場合はtrueを返す
  return $stmt->fetch() !== false;
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
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    
    <section>
        <li><a href="../homepage.html">ホームページ</a></li>
        <li><a href="../mypage/mypage.php">マイページ</a></li>
        <li><a href="../login_register/logout.php">ログアウト</a></li>
        <li><a href="../search/search.php">チケット申し込み</a></li>
        <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
    </section>
    <?php
      if (isset($_COOKIE['name'])){
      echo "こんにちは、{$_COOKIE['name']}さん。";
      }
    ?>



</body>
</html>