<?php
// データベースの設定
require("set_database.php");

$sth = $dbh->query(
    "SELECT * FROM 公演一覧 OFFSET 0"
    //直近の10個のコンサートのみを表示
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
     <head>  
         <title>コンサート検索システム @関西 全公演一覧</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <div id="header">
        <h1><a href="index.php">コンサート検索システム＠関西</a></h1>
        <ul>
            <li><a href="member.php">会員ログイン(チケットの予約、照会、取り消しはこちら)</a></li>
            <li><a href="groupmember.php">団体ログイン(コンサートの登録、変更、取り消しはこちら)</a></li>
        </ul>
        </div>