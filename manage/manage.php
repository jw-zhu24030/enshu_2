<?php

if (isset($_COOKIE)) 
{
    echo "こんにちは、{$_COOKIE["name"]}";
} 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理</title>
</head>
<body>
    <table>
        <tr>
            <td><a href="manage_live.php">公演管理</a></td>
        </tr>
        <tr>
            <td>アーティスト管理</td>
        </tr>
        <tr>
            <td>
                場所管理
            </td>
        </tr>
    </table>
</body>
</html>