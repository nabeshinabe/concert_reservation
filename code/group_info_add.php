<?php
// データベースの設定
require("set_database.php");

//コンサート番号と識別idを取得
$groupname = $_POST['groupname'];
$numberid = $_POST['numberid'];
$dateid = $_POST['dateid'];
$opent = $_POST['opent'];
$startt = $_POST['startt'];
$endt = $_POST['endt'];
$place = $_POST['place'];
$placehall = $_POST['placehall'];
$conname = $_POST['conname'];
$tprice = $_POST['tprice'];
$howmany = $_POST['howmany'];

if(empty($opent)){
    $opent = NULL;
}
if(empty($endt)){
    $endt = NULL;
}


//エラーチェック
$err_msg = array();
//会場名とホールが存在するかを確認
$sqlh = "SELECT * FROM ホール WHERE 会場名 = :place AND ホール名 = :placehall";
$stmth = $dbh->prepare($sqlh);
$stmth->bindValue(':place', $place);
$stmth->bindValue(':placehall', $placehall);
$stmth->execute();
$memberh = $stmth->fetch();

if (empty($memberh)) {
    $err_msg['place'] = '存在しない場所です。';
}

//不正な文字列では無いかのチェック
if (!empty($_POST)) {
    // 公演番号バリデーションチェック
    // 空白チェック
    if ($numberid === '') {
      $err_msg['numberid'] = '公演番号は入力してください';
    }
    // 文字数チェック
    if (strlen($numberid) > 8 || strlen($numberid) < 1) {
      $err_msg['numberid'] = '公演番号は1文字以上8文字以下で入力してください';
    }
    // 形式チェック
    if (!preg_match("/^[a-zA-Z0-9]+$/", $numberid)) {
      $err_msg['numberid'] = '公演番号は半角英数字で入力してください';
    }

    // 時間順序チェック
    if (!empty($opent) and $opent > $startt) {
        $err_msg['opent'] = '開場時刻<=開演時刻の順番にする必要があります。';
    }
    if (!empty($endt) and $startt > $endt) {
        $err_msg['endt'] = '開演時刻<=終演時刻の順番にする必要があります。';
    }

    // チケット代は半角数字
    // 形式チェック
    if (!preg_match("/^[0-9]+$/", $tprice)) {
        $err_msg['tprice'] = 'チケット代は半角数字で入力してください';
    }

    // 観客予定数は半角数字
    // 形式チェック
    if (!preg_match("/^[0-9]+$/", $howmany)) {
        $err_msg['howmany'] = '観客予定数は半角数字で入力してください';
    }
}

//既に入力しようとしている情報が存在しないかをチェック
    $sqlc = "SELECT * FROM 公演 WHERE 公演番号 = :numberid";
    $stmtc = $dbh->prepare($sqlc);
    $stmtc->bindValue(':numberid', $numberid);
    $stmtc->execute();
    $member = $stmtc->fetch();

//もし既にチケットを購入していないならば、新たに挿入
if (!empty($member)) {
    $msg = '既に公演番号が使われています。';
    $link = '<a href="group_info.php">登録画面に戻る</a>';
} elseif (!empty($err_msg)){
    //パスワードの形式が条件を満たしていなければ却下
    //メッセージは直接出力
    $link = '<a href="group_info.php">登録画面に戻る</a>';
} else {
    //問題なければ、新たなコンサート挿入 
    //企画に挿入
    try{
        //トランザクション開始
        $dbh->beginTransaction();

        $sqlc = "SELECT * FROM 企画 WHERE コンサート名 = :conname AND 出演者 = :groupname";
        $stmtc = $dbh->prepare($sqlc);
        $stmtc->bindValue(':conname', $conname);
        $stmtc->bindValue(':groupname', $groupname);
        $stmtc->execute();
        $member11 = $stmtc->fetch();

        if(empty($member11)){
            $sql1 = "INSERT INTO 企画 VALUES(:conname, :groupname)";
            $stmt1 = $dbh->prepare($sql1);
            $stmt1->bindValue(':conname', $conname);
            $stmt1->bindValue(':groupname', $groupname);
            $stmt1->execute();
        }

        //主催に挿入       
        $sqld = "SELECT * FROM 主催 WHERE コンサート名 = :conname AND 団体名 = :groupname";
        $stmtd = $dbh->prepare($sqld);
        $stmtd->bindValue(':conname', $conname);
        $stmtd->bindValue(':groupname', $groupname);
        $stmtd->execute();
        $member12 = $stmtd->fetch();

        if(empty($member12)){
            $sql2 = "INSERT INTO 主催 VALUES(:groupname, :conname)";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bindValue(':conname', $conname);
            $stmt2->bindValue(':groupname', $groupname);
            $stmt2->execute();
        }

        //コンサートに挿入
        $sql3 = "INSERT INTO コンサート VALUES(:numberid, :howmany, :tprice)";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bindValue(':numberid', $numberid);
        $stmt3->bindValue(':howmany', $howmany);
        $stmt3->bindValue(':tprice', $tprice);
        $stmt3->execute();

        //公演に挿入
        $sql4 = "INSERT INTO 公演 VALUES(:numberid, :place, :placehall, :dateid, :startt)";
        $stmt4 = $dbh->prepare($sql4);
        $stmt4->bindValue(':numberid', $numberid);
        $stmt4->bindValue(':place', $place);
        $stmt4->bindValue(':placehall', $placehall);
        $stmt4->bindValue(':dateid', $dateid);
        $stmt4->bindValue(':startt', $startt);
        $stmt4->execute();

        //公演に挿入
        $sql5 = "INSERT INTO 概要詳細 VALUES(:place, :placehall, :dateid, :opent, :startt, :endt, :conname)";
        $stmt5 = $dbh->prepare($sql5);
        $stmt5->bindValue(':place', $place);
        $stmt5->bindValue(':placehall', $placehall);
        $stmt5->bindValue(':dateid', $dateid);
        $stmt5->bindValue(':opent', $opent);
        $stmt5->bindValue(':startt', $startt);
        $stmt5->bindValue(':endt', $endt);
        $stmt5->bindValue(':conname', $conname);
        $stmt5->execute();

        //全て正常に動作したらコミット
        $dbh->commit();
        $msg = '正常にコンサートを追加しました。';
        $link = '<a href="index_grouplogin.php">会員ページトップに戻る</a>';
    }catch(PDOException $e){
        //不正があればロールバック
        echo $e -> getMessage();
        $dbh->rollBack();
        $msg = '登録に対して、何らかのエラーが発生しました。';
        $link = '<a href="index_grouplogin.php">会員ページトップに戻る</a>';
    }finally{
        $dbh = null;
    }
}
?>

<!DOCTYPE html>
    <head>
         <title>予約画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h1>新規コンサート挿入の結果です。</h1>
        <h3><?php if (!$err_msg): ?>
                <div><?php echo $msg; ?></div>
            <?php else: ?>
                <?php   foreach ($err_msg as $err): ?>
                    <?php echo $err ?><br>
                <?php   endforeach; ?>
            <?php endif; ?></h3><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>