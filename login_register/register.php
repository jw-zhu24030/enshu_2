<?php
// databaseのログイン情報
$dsn = "mysql:host=localhost;dbname=ticketsite;charset=utf8";
$user = "testuser";
$pass = "testpass";


if (isset($_COOKIE["name"])) {
  
  clearCookie();
}


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
$inputname = $input["name"];
$inputpass = $input["pass"];
$checkpass = $input["pass1"];





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


// ユーザー認証を行う関数
function isUser($dbh, $mail) {
  $sql = "SELECT * FROM user WHERE id = :mail";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':mail', $mail);
  $stmt->execute();
  
  // レコードが見つかった場合はtrueを返す
  return $stmt->fetch() !== false;
}

// 関数（機能）を別々に作っていきます
function register($dbh,$input){
    // stock tableのname, priceの値に入力された商品名と値段を登録
    $sql = <<<_SQL_
            INSERT INTO user (id,name, pwd)VALUES
            (?,?,?);
_SQL_;
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["mail"]);
    $stmt->bindParam(2,$input["name"]);
    $stmt->bindParam(3,$input["pass"]);
    $stmt->execute();
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

function clearCookie(){
  if (isset($_COOKIE['name'])) {
      unset($_COOKIE['name']); 
      setcookie('remember_user', '', -1, '/'); 
      return true;
  } else {
      return false;
  }
}


?>
<html>
  <head>
    <link rel="stylesheet" href="../CSS/homepagecss.css">
  </head>
  <body>
    
    
  <br>
  
  <div class="topnav">
        <!-- Placeholder for greeting -->
        <div id="greeting" class="greeting"></div>
        <ul>
            <li><a href="../homepage.html">ホームページ</a></li>
            <li><a href="../mypage/mypage.php">マイページ</a></li>
            <li><a href="../search/search.php">チケット申し込み</a></li>
            <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
            <li><a href="../login_register/login.html">ログイン</a></li>
        </ul>
    </div>

    <br><br><br>
    <div class="main">
        <?php
            


try {
  // DBに接続します
  $dbh = new PDO($dsn, $user, $pass);
    

  $error_notes = "";
  if($inputname === ""){
    $error_notes.="・名前が未入力です。<br>";
  }
  if($inputpass === "" || $checkpass === "" ){
    $error_notes.="・パスワードが未入力です。<br>";
  }
  if($inputpass != $checkpass){
    $error_notes.="・二回入力されたパスワードは間違いました。<br>";
  }
  if(($inputname!="" && $inputpass!="") && isUser($dbh,$inputmail)){
    $error_notes.="・既存のユーザーメールアドレスです。<br>";
  }
  if (!filter_var($inputmail, FILTER_VALIDATE_EMAIL)) {
    $error_notes.="・不正のメールアドレスです。<br>";
  }
  #エラーが存在する場合
  if($error_notes !== "") {
    error($error_notes);
  }else{
    register($dbh,$input);
    echo "登録成功。<br>こんにちは、{$input['name']}さん。";
}


} catch (PDOException $e) {
  echo "接続失敗．．．";
  echo "エラー内容：" . $e->getMessage();
}


        ?>
    </div>
    <?php
    
    ?>
  <!-- <br><input type="button" value="前画面に戻る" onclick="history.back()"> -->
  </body>
</html>