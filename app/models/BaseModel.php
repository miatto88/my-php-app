<?php

class BaseModel {
    public function dbconnect() {
        try {
            $dbh = new PDO("host=my-php-app_mysql_1;mysql:dbname=common;charset=utf8", "root", "miatto");
            return $dbh;
            // $dbh = new PDO("mysql:dbname=common;host=127.0.0.1;charset=utf8", "root", "");
            // return $dbh;
        } catch (PDOException $e) {
            echo "DB接続エラー: " . $e->getMessage();
        }
    }
}

?>
