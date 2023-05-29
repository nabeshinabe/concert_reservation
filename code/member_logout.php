<?php
session_start();
$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊
?>

<!DOCTYPE html>
     <head>
         <title>会員ログアウト</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <h1>ログアウトしました。</h1>
            <form action="member.php" method='post'>
                <input type="submit" value="会員ログイン画面に移動">
            </form>
    </body>