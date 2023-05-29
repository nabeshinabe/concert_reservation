<?php
// データベースの設定
require("set_database.php");

$sth = $dbh->query(
    "SELECT * FROM 公演一覧"
    //これからのコンサートを表示
);

$sth2 = $dbh->query(
    "SELECT * FROM 概要詳細 NATURAL JOIN 企画 WHERE 開演日 < now() ORDER BY 開演日 DESC"
    //過去のコンサートを表示
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
$rows2 = $sth2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
     <head>  
         <title>コンサート検索システム @関西 全公演一覧</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <div id="header">
        <h1><a href="index.php">コンサート検索システム＠関西</a></h1>
        <ul>
            <li><a href="member.php">会員ログイン(チケットの予約、照会、取り消しはこちら)</a></li>
            <li><a href="groupmember.php">団体ログイン(コンサートの登録、変更、取り消しはこちら)</a></li>
        </ul>
        </div>
        <h2>これからの公演一覧</h2>
            現在以下のようなコンサートが予定されています。
            <?php if (!$rows): ?>
                <div>直近のコンサートはありません。</div>
            <?php else: ?>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">開演日
                        <th scope="col">開演時刻
                        <th scope="col">コンサート
                        <th scope="col">アーティスト
                        <th scope="col">会場名
                        <th scope="col">ホール名
                <tbody>
                <?php   foreach ($rows as $r): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['開演日']); ?>
                        <td><?php echo htmlspecialchars($r['開演時刻']); ?>
                        <td><?php echo htmlspecialchars($r['コンサート名']); ?>
                        <td><?php echo htmlspecialchars($r['出演者']); ?>
                        <td><?php echo htmlspecialchars($r['会場名']); ?>
                        <td><?php echo htmlspecialchars($r['ホール名']); ?>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
        <a href="index.php", style="text-align:center">
            <button type="button">トップページに戻る</button>
        </a>

        <h2>過去の公演一覧</h2>
            過去にはこのようなコンサートが実施されました。
            <?php if (!$rows2): ?>
                <div>過去のコンサートはありません。</div>
            <?php else: ?>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">開演日
                        <th scope="col">開演時刻
                        <th scope="col">コンサート
                        <th scope="col">アーティスト
                        <th scope="col">会場名
                        <th scope="col">ホール名
                <tbody>
                <?php   foreach ($rows2 as $r2): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r2['開演日']); ?>
                        <td><?php echo htmlspecialchars($r2['開演時刻']); ?>
                        <td><?php echo htmlspecialchars($r2['コンサート名']); ?>
                        <td><?php echo htmlspecialchars($r2['出演者']); ?>
                        <td><?php echo htmlspecialchars($r2['会場名']); ?>
                        <td><?php echo htmlspecialchars($r2['ホール名']); ?>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
        <a href="index.php", style="text-align:center">
            <button type="button">トップページに戻る</button>
        </a>
     </body>