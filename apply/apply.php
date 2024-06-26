<?php



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


if (isset($_COOKIE["name"])) {
    $tmplurl = "apply.tmpl";
}else{
    $tmplurl = "apply_unlogin.tmpl";
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

    dispaly();
    

}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
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


function dispaly(){
    global $dbh;
    global $input;

    $error_notes = "";

    if(!isset($input)){
        $sql = <<<_SQL_
            SELECT * FROM livelist WHERE flag = 1;
_SQL_;
    }
    elseif(isset($input["radiosearch"]) && $input["inputsearch"] && $input["radiosearch"]){
        $keyword = $input["inputsearch"];
        $type = $input["radiosearch"];
        $sql = <<<_SQL_
            SELECT * FROM livelist WHERE flag = 1 and {$type} LIKE '%{$keyword}%';
_SQL_;
    }elseif($input["date"] && $input["prefectures"]){
        $day = $input["date"];
        $prefectures = $input["prefectures"];
        $sql = <<<_SQL_
            SELECT * FROM livelist WHERE flag = 1 and (day='{$day}')and (place='$prefectures');
_SQL_;
    }elseif($input["date"]){
        $day = $input["date"];
        $sql = <<<_SQL_
            SELECT * FROM livelist WHERE flag = 1 and (day='{$day}');
_SQL_;
    }elseif($input["prefectures"]){
        $prefectures = $input["prefectures"];
        $sql = <<<_SQL_
            SELECT * FROM livelist WHERE flag = 1 and (place='$prefectures');
_SQL_;
    }
    else{
        $error_notes.= "検索条件を入力してください。<br>";;
    }
    
    #エラーが存在する場合
    if($error_notes !== "") {
        error($error_notes);
    }
    
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // $blockを初期化
    $block = "";

    // tmplファイルの読み込み
    global $tmplurl;
    $fh = fopen($tmplurl, "r+");
    $fs = filesize($tmplurl); // file sizeを調べる（のちのfread関数で使用）
    // $fh = fopen("apply.tmpl", "r+");
    // $fs = filesize("apply.tmpl"); // file sizeを調べる（のちのfread関数で使用）
    $insert_tmpl = fread($fh, $fs); // fileの読み込みを行う
    fclose($fh); // 不必要

    // recordを一行ずつ繰り返し$blockに詰め込む
    while ($row = $stmt->fetch()){
        // var_dump($row); // 输出查询结果以供调试

        // 差し込む用tmplを初期化
        $insert = $insert_tmpl;

        // DBの値を、PHPで使用する値として変数に入れ直す
        $lid = $row["id"];
        $name = $row["name"];
        $artist = $row["artist"];
        $address = $row["place"];
        $day = $row["day"];
        $daytime = $row["daytime"];
        if (isset($_COOKIE["uid"])) {
            $uid = $_COOKIE["uid"];
        }else{
            $uid = "";
        }
        // tmplファイルの文字置き換え
        $insert = str_replace("!lid!",$lid, $insert);
        $insert = str_replace("!name!",$name, $insert);
        $insert = str_replace("!artist!",$artist, $insert);
        $insert = str_replace("!address!",$address, $insert);
        $insert = str_replace("!day!",$day, $insert);
        $insert = str_replace("!daytime!",$daytime, $insert);
        $insert = str_replace("!uid!",$uid, $insert);
    
        // stock.htmlに差し込む変数に格納する
        $block .= $insert; // loopするために、insert_tmplの値を追加する
    
        
    }
    

    // stock.htmlの!bolck!に、$blockを差し込む
    $fh_stock = fopen("apply.html","r+");
    $fs_stock = filesize("apply.html");
    $top = fread($fh_stock, $fs_stock);
    fclose($fh_stock);

    // $top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);
    
    // 全てを差し替えたデータをブラウザに表示
    echo ($top);
}
?>



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
                    <li><a href="../search/search.php">チケット申し込み</a></li>
                    <li><a href="../inquiry/inquiry.html">問い合わせ</a></li>
                    <li><a href="../login_register/register.html">新規登録</a></li>
                    <li><a href="../login_register/login.html">ログイン</a></li>
                    <li><a href="../login_register/logout.php">ログアウト</a></li>
                </ul>
            </div>
            <br><br><br>
    <div class="main">
    </div>
</body>
</html>