<?php
// データベースの設定
require("set_database.php");

//コンサート番号と識別idを取得
$passid = $_POST['passid'];
$connum = $_POST['connum'];

//既に入力しようとしている情報が存在しているかをチェック
    $sqlc = "SELECT * FROM 予約 WHERE 識別id = :passid AND 公演番号 = :connum";
    $stmtc = $dbh->prepare($sqlc);
    $stmtc->bindValue(':passid', $passid);
    $stmtc->bindValue(':connum', $connum);
    $stmtc->execute();
    $member = $stmtc->fetch();

//もし既にチケットを購入しているならば削除
if (!empty($member)) {
    $sql = "DELETE FROM 予約 WHERE 識別id = :passid AND 公演番号 = :connum";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':passid', $passid);
    $stmt->bindValue(':connum', $connum);
    $stmt->execute();
    $msg = '正常にチケット予約を取り消しました。';
    $link = '<a href="index_memberlogin.php">会員ページトップに戻る</a>';
} else {
    $msg = '何らかのエラーによりチケット取消に失敗しました。';
    $link = '<a href="index_memberlogin.php">会員ページトップに戻る</a>';
}
?>

<!DOCTYPE html>
    <head>
         <title>予約取消画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h1>予約取消</h1>
        <h3><?php echo $msg; ?></h3><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>