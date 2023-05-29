<?php
// データベースの設定
require("set_database.php");

//コンサート番号と識別idを取得
$passid = $_POST['passid'];
$connum = $_POST['connum'];
$countid = $_POST['count'];

//既に入力しようとしている情報が存在しないかをチェック
    $sqlc = "SELECT * FROM 予約 WHERE 識別id = :passid AND 公演番号 = :connum";
    $stmtc = $dbh->prepare($sqlc);
    $stmtc->bindValue(':passid', $passid);
    $stmtc->bindValue(':connum', $connum);
    $stmtc->execute();
    $member = $stmtc->fetch();

//もし既にチケットを購入していないならば、新たに挿入
if (empty($member)) {
    $sql = "INSERT INTO 予約 VALUES (:passid, :connum, :countid, now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':passid', $passid);
    $stmt->bindValue(':connum', $connum);
    $stmt->bindValue(':countid', $countid);
    $stmt->execute();
    $msg = 'チケットを購入しました。';
    $link = '<a href="index_memberlogin.php">会員ページトップに戻る</a>';
} else {
    //まだチケットを購入していないならば、枚数更新
    $sql = "UPDATE 予約 SET 枚数 = :countid, 購入日時 = now() WHERE 識別id = :passid AND 公演番号 = :connum";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':passid', $passid);
    $stmt->bindValue(':connum', $connum);
    $stmt->bindValue(':countid', $countid);
    $stmt->execute();
    $msg = 'チケット枚数を更新しました。';
    $link = '<a href="index_memberlogin.php">会員ページトップに戻る</a>';
}
?>

<!DOCTYPE html>
    <head>
         <title>予約画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h1>予約が完了しました。</h1>
        <h3><?php echo $msg; ?></h3><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>