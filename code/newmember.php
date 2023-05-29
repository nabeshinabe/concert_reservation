<!DOCTYPE html>
     <head>
         <title>新規会員登録</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h2>新規会員登録</h2>
        各種情報を登録してください。パスワード半角は6文字以上32文字以下でお願いします。
            <form action="register_newmember.php" method="post"> 
                名前:<input type="text" name='nameget' required><br>
                住所:<input type="text" name='addressid' required> <br>
                性別:<select name="sex" required>
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                    <br>
                生年月日:<input type="date" name='birthday' required> <br>
                パスワード:<input type="password" name='passwordid' required> <br>
                <br>
                <input type="submit" value="新規会員登録をする" /><br>
            </form>
        <br>
        <br>
        <br>
        <br>
        <a href="member.php", style="text-align:center">
            <button type="button">会員ログインページに戻る</button>
        </a>
     </body>