<!DOCTYPE html>
     <head>
         <title></title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h2>新規団体登録</h2>
        各種情報を登録してください。ジャンルは近そうなものを選んでいただければ構いません。
            <form action="register_newgroupmember.php" method="post"> 
                団体名:<input type="text" name='groupname' required><br>
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
                    <br>
                    <br>
                <input type="submit" value="新規団体登録をする" /><br>
            </form>
        <br>
        <br>
        <br>
        <br>
        <a href="groupmember.php", style="text-align:center">
            <button type="button">団体ログインページに戻る</button>
        </a>
     </body>