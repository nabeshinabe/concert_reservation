# コンサート予約システム／Concert Reservation

## 目的／Objective
異なる会場におけるコンサートを、一つの予約システムで一括管理するためのアプリケーションの案

## 実行方法／Execution Method
データベースはPostgreSQL14を使用
### 準備
- ./database/test.sql を準備したPostgreSQLで実行させ、テーブルを作成する
- ./code/set_database.php内の以下の部分を、必要に応じて書き換える。特にパスワードは自ら設定したパスワードにする
``` php
$dsn = 'pgsql:host=localhost port=5432 dbname=concertrsvutf';
// usernameを書く
$user = 'postgres';
// データベースのpasswordを書く
$password = ' ';
```

### 実行
start.shを実行
- データベースのパス等が違う場合は、start.shを編集してください

``` sh
sh start.sh
```

### 終了
stop.shを実行
- データベースのパス等が違う場合は、stop.shを編集してください

``` sh
sh stop.sh
```

## 困った時／When you are in trouble
./test/ にはチェック用のコードが入っている。
### phpinfo.php
phpの情報を出力する。

### test.php
各自の設定に合わせてpg_connectの引数を書き直して、このページに遷移することで、データベースが接続されているかをチェック可能。

```php
# MacOSVerで開く
open <http://localhost:8080/test/{}.php>

# phpを実行
php -S localhost:8080
```
上記の{}をphpinfo か testで埋めて、これを実行することで確認可能。