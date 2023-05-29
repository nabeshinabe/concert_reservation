<?php
// データベースの設定
require("set_database.php");

$groupname = $_POST['groupname'];
$genre= $_POST['genre'];

$err_msg = array();

if (!empty($_POST)) {
    // 団体名を描くときのチェック
    // 空白チェック
    if ($groupname === '') {
      $err_msg['groupname'] = '入力してください';
    }
    // 文字数チェック
    if (strlen($groupname) > 100) {
      $err_msg['groupname'] = '100文字以内で入力してください';
    }
}

//フォームに入力された団体名の組み合わせが無いかをチェック。
$sql = "SELECT * FROM 団体 WHERE 団体名 = :groupname";
$stmt = $dbh->prepare($sql);
//SQL injection対策でbindvalue関数を使用。
$stmt->bindValue(':groupname', $groupname);
$stmt->execute();
$member = $stmt->fetch();

if (!empty($member) && $member['団体名'] === $groupname) {
    //同じ団体があれば却下。
    $msg = '既に団体は登録されています。';
    $link = '<a href="newgroupmember.php">登録画面に戻る</a>';
}elseif (!empty($err_msg)){
    //団体の形式が条件を満たしていなければ却下
    $msg = $err_msg['groupname'];
    $link = '<a href="newgroupmember.php">登録画面に戻る</a>';
}else {
    //登録されていなければinsert 
    $sql = "INSERT INTO 団体 VALUES (:groupname, :genre)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':groupname', $groupname);
    $stmt->bindValue(':genre', $genre);
    $stmt->execute();
    $msg = '新規団体登録が完了しました';
    $link = '<a href="groupmember.php">団体ログインページに戻る</a>';
}
?>
<!DOCTYPE html>
    <head>
         <title>団体登録画面</title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h2>新規団体登録</h2>
        <h3><?php echo $msg; ?></h1><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>

