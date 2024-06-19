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
// echo"<br><br><br><br><br><br><br><br>";
// var_dump($input);
$inputmail = $input["mail"];
// $inputpass = $input["pass"];
$inputpass = $input['hashedPassword'];

$inputmail = wordProcess($inputmail);
// $inputpass = wordProcess($inputpass);
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

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
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
            <li><a href="../mypage/mypage.php">マイページ</a></li>
            <li><a href="../search/search.php">チケット申し込み</a></li>
            <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </div>
    <br><br><br><br>
    <div class="searchContainer">
    <form action="../apply/apply.php" method="get" class="searchbykeywords">
        
    <div class="searchbykeywords">
        <h4>番号またはキーワードより探す</h4>
        <input type="text" name="inputsearch" placeholder="番号またはキーワードより探す"value="">
        <div class="search-group">
        <label class="typesearch"><input type="radio" value="id" name="radiosearch">番号</label>
        <label class="typesearch"><input type="radio" value="name" name="radiosearch">公演名</label>
        <label class="typesearch"><input type="radio" value="artist" name="radiosearch">アーティスト名</label></div>
        <input type="submit" class="searchButton" value="検索" >
    
    </div><br>
    <div class="searchbyfilter">
        <br>
        <h4>フィルターより探す</h4>
        日付<input type="date" name="date" id="date" value=""><br>
        場所<select name="prefectures" id ="prefectures">
                <option value="" selected>都道府県を選択</option>
                <option value="北海道">北海道</option>
                <option value="青森県">青森県</option>
                <option value="岩手県">岩手県</option>
                <option value="宮城県">宮城県</option>
                <option value="秋田県">秋田県</option>
                <option value="山形県">山形県</option>
                <option value="福島県">福島県</option>
                <option value="茨城県">茨城県</option>
                <option value="栃木県">栃木県</option>
                <option value="群馬県">群馬県</option>
                <option value="埼玉県">埼玉県</option>
                <option value="千葉県">千葉県</option>
                <option value="東京都">東京都</option>
                <option value="神奈川県">神奈川県</option>
                <option value="新潟県">新潟県</option>
                <option value="富山県">富山県</option>
                <option value="石川県">石川県</option>
                <option value="福井県">福井県</option>
                <option value="山梨県">山梨県</option>
                <option value="長野県">長野県</option>
                <option value="岐阜県">岐阜県</option>
                <option value="静岡県">静岡県</option>
                <option value="愛知県">愛知県</option>
                <option value="三重県">三重県</option>
                <option value="滋賀県">滋賀県</option>
                <option value="京都府">京都府</option>
                <option value="大阪府">大阪府</option>
                <option value="兵庫県">兵庫県</option>
                <option value="奈良県">奈良県</option>
                <option value="和歌山県">和歌山県</option>
                <option value="鳥取県">鳥取県</option>
                <option value="島根県">島根県</option>
                <option value="岡山県">岡山県</option>
                <option value="広島県">広島県</option>
                <option value="山口県">山口県</option>
                <option value="徳島県">徳島県</option>
                <option value="香川県">香川県</option>
                <option value="愛媛県">愛媛県</option>
                <option value="高知県">高知県</option>
                <option value="福岡県">福岡県</option>
                <option value="佐賀県">佐賀県</option>
                <option value="長崎県">長崎県</option>
                <option value="熊本県">熊本県</option>
                <option value="大分県">大分県</option>
                <option value="宮崎県">宮崎県</option>
                <option value="鹿児島県">鹿児島県</option>
                <option value="沖縄県">沖縄県</option>
            </select>
            <br>
            <input type="submit" class="searchButton" value="検索" >
            </div>
        </form>
    </div>
    
</body>
</html>