<?php
// データベースの設定
require("set_database.php");

$nameget = $_POST['nameget'];
$addressid = $_POST['addressid'];
$sex = $_POST['sex'];
$birthday = $_POST['birthday'];
$passwordid = $_POST['passwordid'];

$err_msg = array();

if (!empty($_POST)) {
    // パスワードバリデーションチェック
    // 空白チェック
    if ($passwordid === '') {
      $err_msg['passwordid'] = '入力してください';
    }
    // 文字数チェック
    if (strlen($passwordid) > 32 || strlen($passwordid) < 6) {
      $err_msg['passwordid'] = '6文字以上32文字以内で入力してください';
    }
    // 形式チェック
    if (!preg_match("/^[a-zA-Z0-9]+$/", $passwordid)) {
      $err_msg['passwordid'] = '半角英数字で入力してください';
    }
}

//フォームに入力されたパスワードの組み合わせが無いかをチェック。
$sql = "SELECT * FROM 観客 WHERE 識別ID = :passwordid";
$stmt = $dbh->prepare($sql);
//SQL injection対策でbindvalue関数を使用。
$stmt->bindValue(':passwordid', $passwordid);
$stmt->execute();
$member = $stmt->fetch();

if (!empty($member) && $member['識別id'] === $passwordid) {
    //同じパスワードがあれば却下。
    $msg = 'このパスワードには何らかの問題があります。';
    $link = '<a href="newmember.php">登録画面に戻る</a>';
}elseif (!empty($err_msg)){
    //パスワードの形式が条件を満たしていなければ却下
    $msg = $err_msg['passwordid'];
    $link = '<a href="newmember.php">登録画面に戻る</a>';
}else {
    //登録されていなければinsert 
    $sql = "INSERT INTO 観客 VALUES (:passwordid, :nameget, :addressid, :sex, :birthday)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':nameget', $nameget);
    $stmt->bindValue(':addressid', $addressid);
    $stmt->bindValue(':sex', $sex);
    $stmt->bindValue(':birthday', $birthday);
    $stmt->bindValue(':passwordid', $passwordid);
    $stmt->execute();
    $msg = '新規会員登録が完了しました';
    $link = '<a href="member.php">会員ログインページに戻る</a>';
}
?>
<head>
         <title></title>
         <link rel="stylesheet" type="text/css" href="db_final.css">
     </head>
     <body>
     <h2>新規会員登録</h2>
        <h3><?php echo $msg; ?></h1><!--メッセージの出力-->
        <?php echo $link; ?>
    </body>

