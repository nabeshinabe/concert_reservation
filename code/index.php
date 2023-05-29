<?php
// データベースの設定
require("set_database.php");

//公演一覧はビュー
$sth = $dbh->query(
    "SELECT * FROM 公演一覧 WHERE (開演日 > now()) OFFSET 0 LIMIT 5"
    //直近の10個のコンサートのみを表示
);

//検索された時のみ使用
if(@$_POST["date"] != "" OR @$_POST["artist"] != "" OR @$_POST["place"] != ""){
    $keywordCondition = [];

    //検索で使われた文字のみ使用
    if(@$_POST["date"] != ""){
        $keywordCondition[] = "開演日= '" . $_POST["date"] ."'";
    }
    if(@$_POST["artist"] != ""){
        $keywordCondition[] = "出演者 LIKE '%" . $_POST["artist"] . "%'";
    }
    if(@$_POST["place"] != ""){
        $keywordCondition[] = "会場名 LIKE '%" . $_POST["place"] . "%'";
    }

    //ANDで繋げて文字列
    $keywordCondition = implode(' AND ', $keywordCondition);


    $stmt = $dbh->query(
        "SELECT * FROM 公演一覧 WHERE " . $keywordCondition . ""
    ); //SQL文を実行して、結果を$stmtに代入する。
}else{
    $stmt = "";
}

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
     <head>
         <title>コンサート検索システム @関西</title>
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
        <h1>ようこそ！</h1>
            <h4 style="text-align:center">チケットの予約等は上のメニューバーから「会員ログイン」を選択してください。新規の方もそちらから新規会員登録をしてください。</h4>
        <h2>公演一覧</h2>
            現在以下のようなコンサートが直近に予定されています。
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
            さらに先のコンサートの予定を確認したい方は
            <a href="schedule.php", style="text-align:center; text-decoration: none;">
                <button type="button" style="width:5%;">こちら</button>
            </a>から。
            
        <h2>クイック検索</h2>
            検索に用いたい情報を用いて検索してください。</br>
            文字列の一部のみが合致するあいまい検索も可能です。
            <form action="index.php" method="post">
                日付:<input type="date" name="date" value=""> <br>
                アーティスト:<input type="text" name="artist" value=""><br>
                会場名:<input type='text' name='place' value=""> </br>
                <br>
                <input type='submit' name='search' value='検索' />
            </form>
                </br>
            <?php if (!$rows): ?>
                <div>直近のコンサートはありません。</div>
            <?php elseif (isset($_POST["search"])): ?>
                <b><font color="yellow">＜検索結果＞</font>
                <?php if (!$stmt): ?>
                    <div>条件に該当するコンサートが見つかりませんでした。</div>
                <?php else: ?>
                    <?php if(@$_POST["date"] != ""): ?>
                        <div>日付: <?php echo htmlspecialchars($_POST["date"]) ?></div>
                        <?php endif; ?>
                    <?php if(@$_POST["artist"] != ""): ?>
                        <div>アーティスト名: <?php echo htmlspecialchars($_POST["artist"]) ?></div>
                        <?php endif; ?>
                    <?php if(@$_POST["place"] != ""): ?>
                        <div>会場名: <?php echo htmlspecialchars($_POST["place"]) ?></div>
                        <?php endif; ?>
                    以上の条件で検索しました。</b>
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
                        <?php   foreach ($stmt as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['開演日']); ?>
                                <td><?php echo htmlspecialchars($s['開演時刻']); ?>
                                <td><?php echo htmlspecialchars($s['コンサート名']); ?>
                                <td><?php echo htmlspecialchars($s['出演者']); ?>
                                <td><?php echo htmlspecialchars($s['会場名']); ?>
                                <td><?php echo htmlspecialchars($s['ホール名']); ?>
                        <?php   endforeach; ?>
                <?php endif; ?>
            </table>
            <?php endif; ?>
     </body>  
</html>