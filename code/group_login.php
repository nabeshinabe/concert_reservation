<?php
// データベースの設定
require("set_database.php");

session_start();
$groupname = $_POST['groupname'];
$genre= $_POST['genre'];

$sql = "SELECT * FROM 団体 WHERE 団体名 = :groupname AND ジャンル = :genre";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':groupname', $groupname);
$stmt->bindValue(':genre', $genre);
$stmt->execute();
$member = $stmt->fetch();
//団体名とジャンルが合っているかチェック。
if (!empty($member) and $member['団体名'] === $groupname and $member['ジャンル'] === $genre) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['groupname'] = $member['団体名'];
    $msg = 'ログインしました。';
    $link = '<a href="index_grouplogin.php">団体ページに移動</a>';
} else {
    $msg = '団体名もしくはジャンルが間違っています。';
    $link = '<a href="groupmember.php">戻る</a>';
}
?>
<!DOCTYPE html>
    <head>
         <title>団体ログイン画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h1>団体ログイン</h1>
        <h3><?php echo $msg; ?></h1><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>