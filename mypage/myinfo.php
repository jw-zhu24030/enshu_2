<?php

if(isset($_COOKIE['uid'])){
    $uid = $_COOKIE['uid'];

    
// var_dump($_COOKIE);

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
$input = [];
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


if(isset($input["mode"]) && $input["mode"] == "edit"){
$error_notes = "";
if($input['id'] === ""){
$error_notes.="・メールアドレスが未入力です。<br>";
}
if($input['name'] === ""){
$error_notes.="・名前が未入力です。<br>";
}
if($input['pwd'] === "" || $input['pwd1'] === "" ){
$error_notes.="・パスワードが未入力です。<br>";
}
if($input['pwd'] != $input['pwd1']){
$error_notes.="・二回入力されたパスワードは間違いました。<br>";
}
if(($input['name']!="" && $input['pwd']!="") && isUser($dbh,$input['id'],$uid)){
$error_notes.="・既存のユーザーメールアドレスです。<br>";
}
#エラーが存在する場合
if($error_notes !== "") {
error($error_notes);
}else{

edit();
}
}

$result =  display();
$mail = $result['id'];
$name = $result['name'];
$pwd = $result['pwd'];
// $pwdstars = str_repeat("*", strlen($pwd));
$pwdstars = "*******";


}catch(PDOException $e){
echo "接続失敗．．．";
echo "エラー内容：".$e->getMessage();
}

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


// ユーザー認証を行う関数
function isUser($dbh, $mail, $uid) {
  $sql = "SELECT * FROM user WHERE id = :mail AND uid != '{$uid}'";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':mail', $mail);
  $stmt->execute();
  
  // レコードが見つかった場合はtrueを返す
  return $stmt->fetch() !== false;
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
function edit(){
    global $input;
    global $dbh;
    // stock tableのname, priceの値に入力された商品名と値段を登録
    $sql = <<<_SQL_
            UPDATE user SET
            id = ?, 
            name = ?, 
            pwd = ?
            WHERE uid = ?;
_SQL_;
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["id"]);
    $stmt->bindParam(2,$input["name"]);
    $stmt->bindParam(3,$input["pwd"]);
    $stmt->bindParam(4,$input["uid"]);
    $stmt->execute();
    setcookie("mail", $input["id"], time()+600, "/");
    setcookie("name", $input["name"], time()+600, "/");
    setcookie("uid", $input["uid"], time()+600, "/");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人情報</title>
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
    <div class="main">
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

    <div class="main">
    </div>
    <div class="title">
    <h3>個人情報確認</h3>
    </div>
    <div class="main">
    <form action="myinfo_edit.php" method="post">
        <table>
            <tr>
                <td>
                    ID/メールアドレス
                </td>
                <td>
                    <?php echo "{$mail}";?>
                </td>
            </tr>
            <tr>
                <td>
                    ニックネーム
                </td>
                <td>
                    <?php echo "{$name}";?>

                </td>
            </tr>
            <tr>
                <td>
                    パスワード
                </td>
                <td>
                    <?php echo "{$pwdstars}";?>

                </td>
            </tr>
            <tr>
                <td><input type="button" value="マイページに戻る" onclick="location.href='mypage.php'"></td>
                <td><input type="submit" value="編集"></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>