<?php
// データベースの設定
require("set_database.php");

//コンサート番号と識別idを取得
$connum = $_POST['connum'];
$dateid = $_POST['dateid'];
$startt = $_POST['startt'];
$place = $_POST['place'];
$placehall = $_POST['placehall'];
$conname = $_POST['conname'];


//既に入力しようとしている情報が存在しているかをチェック
    $sqlc = "SELECT * FROM 公演 NATURAL JOIN 概要詳細 NATURAL JOIN コンサート NATURAL JOIN 主催 NATURAL JOIN 企画 WHERE 公演番号 = :connum";
    $stmtc = $dbh->prepare($sqlc);
    $stmtc->bindValue(':connum', $connum);
    $stmtc->execute();
    $member = $stmtc->fetch();

//もし存在していたら削除
if (!empty($member)) {
    try{
        //トランザクション開始
        $dbh->beginTransaction();

        //概要詳細から削除
        $sql1 = "DELETE FROM 概要詳細 WHERE 会場名 = :place AND ホール名 = :placehall AND 開演日 = :dateid AND 開演時刻 = :startt";
        $stmt1 = $dbh->prepare($sql1);
        $stmt1->bindValue(':place', $place);
        $stmt1->bindValue(':placehall', $placehall);
        $stmt1->bindValue(':dateid', $dateid);
        $stmt1->bindValue(':startt', $startt);
        $stmt1->execute();

        //公演から削除
        $sql2 = "DELETE FROM 公演 WHERE 公演番号 = :connum";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->bindValue(':connum', $connum);
        $stmt2->execute();

        //その公演番号の予約を削除
        $sql3 = "DELETE FROM 予約 WHERE 公演番号 = :connum";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bindValue(':connum', $connum);
        $stmt3->execute();

        //コンサートから削除
        $sql4 = "DELETE FROM コンサート WHERE 公演番号 = :connum";
        $stmt4 = $dbh->prepare($sql4);
        $stmt4->bindValue(':connum', $connum);
        $stmt4->execute();

        //全て正常に動作したらコミット
        $dbh->commit();
        $msg = '正常にコンサートを削除しました。';
        $link = '<a href="index_grouplogin.php">会員ページトップに戻る</a>';
    }catch(PDOException $e){
        //不正があればロールバック
        echo $e -> getMessage();
        $dbh->rollBack();
        $msg = '削除に対して、何らかのエラーが発生しました。';
        $link = '<a href="index_grouplogin.php">会員ページトップに戻る</a>';
    }finally{
        $dbh = null;
    }
} else {
    $msg = '何らかのエラーによりコンサート取消に失敗しました。';
    $link = '<a href="index_grouplogin.php">会員ページトップに戻る</a>';
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