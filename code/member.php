<!DOCTYPE html>
     <head>
         <title>コンサート検索システム @関西 会員ログイン</title>
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

        <h2>会員ログイン</h2>
            コンサートの予約、変更、取消を行いたい方は以下のボックスからログインをしてください。
            <form action="member_login.php" method='post'>
                名前:<input type='text' name="nameid" required><br>
                パスワード:<input type='password' name="passwordid" required><br>
                    <br>
                <input type="submit" value="会員ログイン" style="text-align:center; margin-left:1%; width:40%; font-size:15px; background-color:yellow;">
                </form>
            <br>
            新規の方は
            <a href="newmember.php", style="text-align:center; text-decoration: none;">
                <button type="button" style="width:5%; color:blue">こちら</button>
            </a>
            からアクセスして会員登録してください。
        <br>
        <br>
        <br>
        <br>
        <a href="index.php", style="text-align:center">
            <button type="button" style="width:10%;font-size:10px;" text-align="right">トップページに戻る</button>
        </a>
     </body>

        