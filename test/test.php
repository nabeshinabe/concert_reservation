<!-- Database接続チェック -->

<?php
// 各自の設定に合わせて、pg_connect内を書き直してください
 $dbconn = pg_connect('host= port= dbname= user= password=');

 if(!$dbconn){
     exit('DB connect Failed!');
 }
 ?>

データベースが繋がっていたら、DB connect Succeed!が表示される。
<html>
     <head>
         <title>DB connect Test</title>
     </head>
     <body>
         <strong>DB connect Succeed! </strong>
     </body>
</html>