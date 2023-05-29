<?php
session_start();
$username = $_SESSION['nameid'];
$pass = $_SESSION['passwordid'];
if (isset($_SESSION['nameid'])) {//ログインしているとき
    $msg = htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さんのページです。';
}

// データベースの設定
require("set_database.php");

$sth = $dbh->query(
    //購入チケットはビュー
    "SELECT * FROM 主催 NATURAL JOIN 購入チケット WHERE 識別id = '$pass' AND 名前 = '$username' ORDER BY 開演日 ASC"
);

$sthsum = $dbh->query(
    //購入したチケットの合計金額を求める。
    "SELECT SUM(合計金額) as s FROM 購入チケット WHERE 識別id = '$pass' AND 名前 = '$username'"
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
$pricesum = $sthsum->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
     <head>
         <title> <?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さんのページ") ?> </title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
        <div id="header">
        <h1><a href="index_memberlogin.php">コンサート検索システム @関西</a></h1>
        <ul>
            <li><a href="member_info.php">予約、変更、取消</a></li>
            <li><a href="member_logout.php">ログアウト</a></li>
        </ul>
        </div>
        <h1><?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さん専用ページ(会員)") ?></h1><br>
        <?php echo $msg; ?><br>

        <h2>購入チケット一覧</h2>
            <?php if (!$rows): ?>
                <div>現在購入しているチケットはありません。</div>
            <?php else: ?>
                <div>現在以下のコンサートチケットを購入しています。(開演日順)</div>
            <table border="2">
                <thead>
                    <tr>
                        <th scope="col">開演日
                        <th scope="col">開演時刻
                        <th scope="col">コンサート
                        <th scope="col">アーティスト
                        <th scope="col">会場名
                        <th scope="col">ホール名
                        <th scope="col">枚数
                        <th scope="col">合計金額
                <tbody>
                <?php   foreach ($rows as $r): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['開演日']); ?>
                        <td><?php echo htmlspecialchars($r['開演時刻']); ?>
                        <td><?php echo htmlspecialchars($r['コンサート名']); ?>
                        <td><?php echo htmlspecialchars($r['団体名']); ?>
                        <td><?php echo htmlspecialchars($r['会場名']); ?>
                        <td><?php echo htmlspecialchars($r['ホール名']); ?>
                        <td><?php echo htmlspecialchars($r['枚数']); ?>
                        <td><?php echo htmlspecialchars($r['合計金額']); ?>
                <?php   endforeach; ?>
            </table>
            合計金額は、
            <?php   foreach ($pricesum as $p): ?>
                <?php echo htmlspecialchars($p['s']); ?>
            <?php   endforeach; ?>
            円です。
            <?php endif; ?>
    </body>
