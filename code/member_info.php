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
    "SELECT * FROM 購入チケット NATURAL JOIN 公演 NATURAL JOIN 主催 INNER JOIN コンサート ON 公演.公演番号=コンサート.公演番号 WHERE 識別id = '$pass' AND 名前 = '$username' ORDER BY 開演日 ASC"
);

$rows = $sth->fetchAll(PDO::FETCH_ASSOC);

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
        //公演番号で繋げる。
        "SELECT * FROM 公演一覧 NATURAL JOIN 公演 INNER JOIN コンサート ON 公演.公演番号=コンサート.公演番号 WHERE " . $keywordCondition . ""
    ); //SQL文を実行して、結果を$stmtに代入する。
}else{
    $stmt = "";
}
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
            <li><a href="index_memberlogin.php">会員ページトップに戻る</a></li>
            <li><a href="member_logout.php">ログアウト</a></li>
        </ul>
        </div>
        <h1><?php echo (htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . "さん予約変更ページ") ?></h1><br>
        <h2>新規購入</h2>
        <h3>コンサート検索</h3>
            検索に用いたい情報を用いて検索してください。</br>
            文字列の一部のみが合致するあいまい検索も可能です。
            <form action="member_info.php" method="post">
                日付:<input type="date" name="date" value=""> <br>
                アーティスト:<input type="text" name="artist" value=""><br>
                会場名:<input type='text' name='place' value=""> </br>
                <br>
                <input type='submit' name='search' value='検索' />
            </form>
                </br>

            <?php if (isset($_POST["search"])): ?>
                <b><font color="yellow">＜検索結果＞</font>
                <?php if (empty($stmt)): ?>
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
                                <th scope="col">価格
                                <th scope="col">予約ボタン
                        <tbody>
                        <?php   foreach ($stmt as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['開演日']); ?>
                                <td><?php echo htmlspecialchars($s['開演時刻']); ?>
                                <td><?php echo htmlspecialchars($s['コンサート名']); ?>
                                <td><?php echo htmlspecialchars($s['出演者']); ?>
                                <td><?php echo htmlspecialchars($s['会場名']); ?>
                                <td><?php echo htmlspecialchars($s['ホール名']); ?>
                                <td><?php echo htmlspecialchars($s['チケット代']); ?>
                                <td><form action="member_info_add.php" method="post">
                                    枚数:<select name="count" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <input type='hidden' name='connum' value= <?php echo htmlspecialchars($s['公演番号']); ?>>
                                        <input type='hidden' name='passid' value= <?php echo $pass; ?>>
                                        <!-- 既に買っていたら更新、まだ買っていなければ予約をボタンにする。 -->
                                        <?php
                                            $sqlc = "SELECT * FROM 予約 WHERE 公演番号 = :connum AND 識別id = :passid";
                                            $stmtc = $dbh->prepare($sqlc);
                                            $stmtc->bindValue(':passid', $pass);
                                            $stmtc->bindValue(':connum', $s['公演番号']);
                                            $stmtc->execute();
                                            $member = $stmtc->fetch();
                                        ?>
                                        <?php if (empty($member)): ?>
                                            <input type='submit' name='search' value='予約'>
                                        <?php else:?>
                                            <input type='submit' name='update' value='更新'>
                                        <?php endif; ?>
                                    </form>
                        <?php   endforeach; ?>
                <?php endif; ?>
            </table>
            <?php endif; ?>
            <h3>チケット購入、枚数更新</h3>
                検索したコンサートから購入したいチケットの枚数(最大４枚)を決めてから、予約ボタンを押してください。<br>
                なお、既に購入しているチケットの場合は購入枚数が更新されます。<br>
                

        <h2>購入チケット取消</h2>
            <?php if (empty($rows)): ?>
                <div>現在購入しているチケットはありません。</div>
            <?php else: ?>
                <div>次のようなチケットを現在購入しております。</div>
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
                        <th scope="col">予約取消
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
                        <td><form action="member_info_delete.php" method="post">
                                    <input type='hidden' name='connum' value= <?php echo htmlspecialchars($r['公演番号']); ?>>
                                    <input type='hidden' name='passid' value= <?php echo $pass; ?>>
                                    <input type='submit' name='search' value='取消'>
                                </form>
                <?php   endforeach; ?>
            </table>
            <?php endif; ?>
            <?php if (!empty($rows)): ?>
                上記のうち取り消したいコンサートの取消ボタンを選んでください。そのコンサート全てのチケットの予約が取り消されます。
            <?php endif; ?>
    </body>
