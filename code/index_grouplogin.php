<?php
session_start();
$username = $_SESSION['groupname'];
if (isset($_SESSION['groupname'])) {//ログインしているとき
    $msg = htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さんのページです。';
}

// データベースの設定
require("set_database.php");

$sth = $dbh->query(
    "SELECT * FROM 団体 NATURAL JOIN 主催 NATURAL JOIN 概要詳細 NATURAL JOIN 公演 NATURAL JOIN コンサート WHERE 団体名 = '$username' ORDER BY 開演日 ASC"
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
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
            <li><a href="group_info.php">登録、変更、削除</a></li>
            <li><a href="group_logout.php">ログアウト</a></li>
        </ul>
        </div>
        <h1><?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さん専用ページ(団体)") ?></h1><br>
        <?php echo $msg; ?><br>

        <h2>予定コンサート一覧</h2>
            現在、以下のコンサートを予定しています。</br>
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
                        <th scope="col">価格
                        <th scope="col">収容予定人数
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
                        <td><?php echo htmlspecialchars($r['チケット代']); ?>
                        <td><?php echo htmlspecialchars($r['観客予定数']); ?>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
    </body>
