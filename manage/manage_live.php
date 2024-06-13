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
    if(isset($input["mode"] ) && $input["mode"]=="register"){
        register($dbh,$input);
    }
    if(isset($input["mode"]) && $input["mode"]=="delete"){
        delete();
    }
    if(isset($input["mode"]) && $input["mode"]=="update"){
        update($dbh,$input);
    }
    if(isset($input["mode"]) && $input["mode"]=="result"){
        getLiveResult($dbh,$input);
    }

    display();
    

}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}


// 関数（機能）を別々に作っていきます
function register($dbh,$input){
    // stock tableのname, priceの値に入力された商品名と値段を登録
    $sql = <<<_SQL_
            INSERT INTO livelist (name, artist, place, day, daytime)VALUES
            (?,?,?,?,?);
_SQL_;
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["name"]);
    $stmt->bindParam(2,$input["artist"]);
    $stmt->bindParam(3,$input["prefectures"]);
    $stmt->bindParam(4,$input["day"]);
    $stmt->bindParam(5,$input["daytime"]);
    $stmt->execute();
}

function display(){
    global $dbh;
    global $input;
    $sql = <<<_SQL_

SELECT livelist.id, livelist.name, livelist.artist, livelist.place, livelist.day, livelist.daytime, livelist.status, COUNT(history.lid) AS count
FROM livelist
LEFT JOIN history ON livelist.id = history.lid
WHERE livelist.flag = 1
GROUP BY livelist.id, livelist.name, livelist.artist, livelist.place, livelist.day, livelist.daytime, livelist.status;

_SQL_;

    // echo ($dbh->query($sql));
    // prepare() methodを使って、sqlの実行結果を$stmt objectに保留、
    // fetchを使って配列を取得
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    // $blockを初期化
    $block = "";

    // tmplファイルの読み込み
    $fh = fopen("manage_live.tmpl", "r+");
    $fs = filesize("manage_live.tmpl"); // file sizeを調べる（のちのfread関数で使用）
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
        $count = $row["count"];
        $hit = "";
        if($row["status"]==0){
            $status = "未抽選";
        }else{
            $status = "抽選済み";
        }
    
        // tmplファイルの文字置き換え
        $insert = str_replace("!id!",$id, $insert);
        $insert = str_replace("!name!",$name, $insert);
        $insert = str_replace("!artist!",$artist, $insert);
        $insert = str_replace("!address!",$address, $insert);
        $insert = str_replace("!day!",$day, $insert);
        $insert = str_replace("!daytime!",$daytime, $insert);
        $insert = str_replace("!count!",$count, $insert);
        $insert = str_replace("!status!",$status, $insert);
     
        // stock.htmlに差し込む変数に格納する
        $block .= $insert; // loopするために、insert_tmplの値を追加する
    
        
    }
    

    // stock.htmlの!bolck!に、$blockを差し込む
    $fh_stock = fopen("manage_live.html","r+");
    $fs_stock = filesize("manage_live.html");
    $top = fread($fh_stock, $fs_stock);
    fclose($fh_stock);

    // $top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);
    
    // 全てを差し替えたデータをブラウザに表示
    echo ($top);
}

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
function delete(){
    global $dbh;
    global $input;
    $sql = <<<_SQL_
        UPDATE livelist SET flag = 0 WHERE id = ?;
_SQL_;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["id"]);
    $stmt->execute();

}
function getLiveResult($dbh,$input){
    // stock tableのname, priceの値に入力された商品名と値段を登録
    $sql = <<<_SQL_
            UPDATE livelist SET status = 1 WHERE id = ?;
_SQL_;
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["id"]);
    $stmt->execute();

    $class = randomChoose();
    $sql1 = "";
    switch($class){
        case -1:
            $sql1 = "UPDATE history SET hit = -1 WHERE lid = ?;";
            break;
        case 1:
            $sql1 = "UPDATE history SET hit = 1 WHERE lid = ?;";
            break;
    }
    // prepare() method を使って、sqlの実行結果を$stmt objectに保留
    $stmt1 = $dbh->prepare($sql1);
    $stmt1->bindParam(1,$input["id"]);
    $stmt1->execute();

}
function randomChoose(){
    
    // 生成一个0到99的随机数
    $random = rand(0, 99);

    // 20%的概率为成功（0到19），80%的概率为失败（20到99）
    if ($random < 20) {
        $class = -1;
    } else {
        $class = 1;
    }
    return $class;
}
?>