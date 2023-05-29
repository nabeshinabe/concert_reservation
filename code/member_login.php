<?php
// データベースの設定
require("set_database.php");

session_start();
$nameid = $_POST['nameid'];
$passwordid= $_POST['passwordid'];

$sql = "SELECT * FROM 観客 WHERE 識別id = :passwordid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':passwordid', $passwordid);
$stmt->execute();
$member = $stmt->fetch();

//名前と識別idが合っているかチェック。
if (!empty($member) and $member['名前'] === $nameid and $member['識別id'] === $passwordid) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['nameid'] = $member['名前'];
    $_SESSION['passwordid'] = $member['識別id'];
    $msg = 'ログインしました。';
    $link = '<a href="index_memberlogin.php">会員ページに移動</a>';
} else {
    $msg = '名前もしくはパスワードが間違っています。';
    $link = '<a href="member.php">戻る</a>';
}
?>
<!DOCTYPE html>
    <head>
         <title>会員ログイン画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h1>会員ログイン</h1>
        <h3><?php echo $msg; ?></h1><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>