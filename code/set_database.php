<?php
// Databaseの接続
//例: $dsn = 'pgsql:host=localhost port=5432 dbname=concertrsvutf'; 
$dsn = 'pgsql:host=localhost port=5432 dbname=concertrsvutf';
// usernameを書く
$user = 'postgres';
// データベースのpasswordを書く
$password = ' ';

try{
    $dbh = new PDO(
        $dsn,
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
       );
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
?>