<?php
session_start();
$username = $_SESSION['groupname'];

// データベースの設定
require("set_database.php");

$sth = $dbh->query(
    "SELECT * FROM 団体 NATURAL JOIN 主催 NATURAL JOIN 概要詳細 NATURAL JOIN 公演 WHERE 団体名 = '$username' ORDER BY 開演日 ASC"
);

$placelist = $dbh->query(
    "SELECT * FROM ホール NATURAL JOIN 会場"
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
$rowslist = $placelist->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
     <head>
         <title> <?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さんのページ") ?> </title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <div id="header">
        <h1><a href="index_grouplogin.php">コンサート検索システム @関西</a></h1>
        <ul>
            <li><a href="index_grouplogin.php">団体ページトップに戻る</a></li>
            <li><a href="group_logout.php">ログアウト</a></li>
        </ul>
        </div>
        <h1><?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さん登録変更ページ") ?></h1><br>
        <h2>新規追加</h2>
        <h3>施設一覧</h3>
        <?php if (!$rowslist): ?>
                <div>現在、使用可能な施設が存在しません。</div>
            <?php else: ?>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">会場名
                        <th scope="col">ホール名
                        <th scope="col">営業開始時刻
                        <th scope="col">営業終了時刻
                        <th scope="col">収容人数
                        <th scope="col">使用料
                        <th scope="col">住所
                <tbody>
                <?php   foreach ($rowslist as $rl): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rl['会場名']); ?>
                        <td><?php echo htmlspecialchars($rl['ホール名']); ?>
                        <td><?php echo htmlspecialchars($rl['営業開始時刻']); ?>
                        <td><?php echo htmlspecialchars($rl['営業終了時刻']); ?>
                        <td><?php echo htmlspecialchars($rl['収容人数']); ?>
                        <td><?php echo htmlspecialchars($rl['使用料']); ?>
                        <td><?php echo htmlspecialchars($rl['住所']); ?>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
                </br>
        <h3>コンサートの追加</h3>
        新たにコンサートを追加する場合には、こちらに入力してください。なお、施設は上記からお選びください。
            <form action="group_info_add.php" method="post">
                ＜必須＞公演番号(半角英数字8文字以内)<input type='text' name='numberid' value="" required> </br>
                ＜必須＞開演日:<input type="date" name="dateid" value="" required> <br>
                開場時刻:<input type="time" name="opent" value=""><br>
                ＜必須＞開演時刻:<input type="time" name="startt" value="" required><br>
                終演時刻:<input type="time" name="endt" value=""><br>
                ＜必須＞会場名:<input type='text' name='place' value="" required> </br>
                ＜必須＞ホール名:<input type='text' name='placehall' value="" required> </br>
                ＜必須＞コンサート名:<input type='text' name='conname' value="" required> </br>
                ＜必須＞チケット代(半角数字のみ):<input type='text' name='tprice' value="" required> </br>
                ＜必須＞観客予定数(半角数字のみ):<input type='text' name='howmany' value="" required> </br>
                <input type='hidden' name='groupname' value= <?php echo $username; ?>>
                <br>
                <input type='submit' name='search' value='登録' />
            </form>
        <!-- 
        <h2>変更</h2>
            <?php //if (!$rows): ?>
                <div>現在登録しているコンサートはありません。</div>
            <?php //else: ?>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">開演日
                        <th scope="col">開場時刻
                        <th scope="col">開演時刻
                        <th scope="col">終演時刻
                        <th scope="col">コンサート
                        <th scope="col">会場名
                        <th scope="col">ホール名
                        <th scope="col">変更
                <tbody>
                <?php   //foreach ($rows as $r): ?>
                    <tr>
                        <td><?php //echo htmlspecialchars($r['開演日']); ?>
                        <td><?php //echo htmlspecialchars($r['開場時刻']); ?>
                        <td><?php //echo htmlspecialchars($r['開演時刻']); ?>
                        <td><?php //echo htmlspecialchars($r['終演時刻']); ?>
                        <td><?php //echo htmlspecialchars($r['コンサート名']); ?>
                        <td><?php //echo htmlspecialchars($r['会場名']); ?>
                        <td><?php //echo htmlspecialchars($r['ホール名']); ?>
                        <td><form action="member_info_delete.php" method="post">
                                    <input type='hidden' name='connum' value= <?php //echo htmlspecialchars($r['公演番号']); ?>>
                                    <input type='submit' name='search' value='変更'>
                            </form>
                <?php   //endforeach; ?>
            </table>
            <?php //endif; ?>
        -->
        
        <h2>コンサート削除</h2>
            <?php if (!$rows): ?>
                <div>現在登録しているコンサートはありません。</div>
            <?php else: ?>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">開演日
                        <th scope="col">開場時刻
                        <th scope="col">開演時刻
                        <th scope="col">終演時刻
                        <th scope="col">コンサート
                        <th scope="col">会場名
                        <th scope="col">ホール名
                        <th scope="col">変更
                <tbody>
                <?php   foreach ($rows as $r): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['開演日']); ?>
                        <td><?php echo htmlspecialchars($r['開場時刻']); ?>
                        <td><?php echo htmlspecialchars($r['開演時刻']); ?>
                        <td><?php echo htmlspecialchars($r['終演時刻']); ?>
                        <td><?php echo htmlspecialchars($r['コンサート名']); ?>
                        <td><?php echo htmlspecialchars($r['会場名']); ?>
                        <td><?php echo htmlspecialchars($r['ホール名']); ?>
                        <td><form action="group_info_delete.php" method="post">
                                    <input type='hidden' name='connum' value= <?php echo htmlspecialchars($r['公演番号']); ?>>
                                    <input type='hidden' name='dateid' value= <?php echo htmlspecialchars($r['開演日']); ?>>
                                    <input type='hidden' name='startt' value= <?php echo htmlspecialchars($r['開演時刻']); ?>>
                                    <input type='hidden' name='place' value= <?php echo htmlspecialchars($r['会場名']); ?>>
                                    <input type='hidden' name='placehall' value= <?php echo htmlspecialchars($r['ホール名']); ?>>
                                    <input type='hidden' name='conname' value= <?php echo htmlspecialchars($r['コンサート名']); ?>>
                                    <input type='submit' name='search' value='削除'>
                            </form>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
    </body>