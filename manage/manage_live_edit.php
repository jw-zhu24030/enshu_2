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
    

    
    if(isset($input["mode"] ) && $input["mode"]=="edit"){
        $result =  display();
        $name = $result['name'];
        $artist = $result['artist'];
        $place = $result['place'];
        $day = $result['day'];
        $daytime = $result['daytime'];
        

    }


}catch(PDOException $e){
    echo "接続失敗．．．";
    echo "エラー内容：".$e->getMessage();
}

function display(){
    global $dbh;
    global $input;
    $sql = <<<_SQL_
        SELECT * FROM livelist WHERE id = ?;
_SQL_;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1,$input["id"]);
    $stmt->execute();
    $result = $stmt -> fetch();
    return $result;
}


?>

<!doctype html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>公演一覧</title>
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
                    <li><a href="../manage/manage.php">ホームページ</a></li>
                    <li><a href="../login_register/logout.php">ログアウト</a></li>
                </ul>
            </div>
            <br><br><br>
            <section>
                <h3>公演内容を更新</h3>
                <form action="manage_live_edit_confirm.php" method="post">
                    <table>
                        <tr>
                            <td>公演番号</td>
                            <td><input type="hidden" name="id" value="<?php echo $result['id'];?>"><?php echo $result['id'];?></td>
                        </tr>
                        <tr>
                            <td>公演名</td>
                            <td><input type="text" name="name" value="<?php echo $result['name'];?>"></td>
                        </tr>
                        <tr>
                            <td>アーティスト</td>
                            <td><input type="text" name="artist" value="<?php echo $result['artist'];?>"></td>
                        </tr>
                        <tr>
                            <td>場所</td>
                            <td>
                                <select name="prefectures" id ="prefectures">
                                    <option value="<?php echo $result['place'];?>" selected><?php echo $result['place'];?></option>
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
                            </td>
                        </tr>
                        <tr>
                            <td>日付</td>
                            <td><input type="date" name="day" value="<?php echo $result['day'];?>"></td>
                        </tr>
                        <tr>
                            <td>時間</td>
                            <td><input type="time" name="daytime" value="<?php echo $result['daytime'];?>"></td>
                        </tr>
                        <tr>
                    <td><input type="button" value="前画面に戻る" onclick="history.back()"></td>
                    <td><input type="submit" value="登録"></td></tr>
                    </table>
                </form>
            </section>
            
        </body>
    </html>
