<?php

class BaseModel {
    public static function dbconnect() {
        try {
            $dsn = "mysql:host=my-php-app_mysql_1;dbname=common;charset=utf8";
            $dbh = new PDO($dsn, "root", "miatto");

            // $dbh = new PDO("mysql:dbname=common;host=127.0.0.1;charset=utf8", "root", "");
            // return $dbh;
            
            return $dbh;
        } catch (PDOException $e) {
            echo "DB接続エラー: " . $e->getMessage();
        }
    }
}

?>
