<!DOCTYPE html>
     <head>
         <title>コンサート検索システム @関西 団体ログイン</title>
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

        <h2>団体ログイン</h2>
            コンサートの登録、変更、削除を行いたい方は以下のボックスからログインをしてください。
            <form action="group_login.php" method='post'>
                団体名:<input type='text' name="groupname" required><br>
                ジャンル:<select name="genre" required>
                        <option value="アンサンブル">アンサンブル</option>
                        <option value="オーケストラ">オーケストラ</option>
                        <option value="吹奏楽">吹奏楽</option>
                        <option value="吹奏楽">弾き語り</option>
                        <option value="JPOP">J-POP</option>
                        <option value="KPOP">K-POP</option>
                        <option value="演歌">演歌</option>
                        <option value="クラシック">クラシック</option>    
                        <option value="ジャズ">ジャズ</option>
                        <option value="テクノ">テクノ</option>         
                        <option value="フュージョン">フュージョン</option>
                        <option value="ファンク">ファンク</option>
                        <option value="レゲエ">レゲエ</option>
                        <option value="メタル">メタル</option>
                        <option value="ロック">ロック</option>
                        <option value="バイオリン">バイオリン</option>
                        <option value="その他">--その他--</option>
                    </select>
                    <br><br>
                <input type="submit" value="団体ログイン" style="text-align:center; margin-left:1%; width:40%; font-size:15px; background-color:greenyellow">
                </form>
            <br>
            新しく団体として登録したい方は、
            <a href="newgroupmember.php", style="text-align:center; text-decoration: none;">
                <button type="button" style="width:5%; color:red">こちら</button>
            </a>
            から新規団体登録をしてください。
            <br>
            <br>
            <br>
            <br>
            <a href="index.php", style="text-align:center;text-decoration: none;">
                <button type="button" style="width:10%;font-size:10px;" text-align="right">トップページに戻る</button>
            </a>
     </body>