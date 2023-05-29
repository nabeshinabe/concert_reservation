<?php
    session_start();
    $_SESSION = array();//セッションの中身をすべて削除
    session_destroy();//セッションを破壊
?>

<!DOCTYPE html>
     <head>
         <title>団体ログアウト</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <h1>ログアウトしました。</h1>
            <form action="groupmember.php" method='post'>
                <input type="submit" value="団体ログイン画面に移動">
            </form>
    </body>