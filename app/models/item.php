<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    public static $dbh;

    public static function setDbh() {   // 変更 コンストラクタではなくした
        // $db = new BaseModel();   // 変更 不要な為削除
        $dbh = SELF::dbconnect();
        SELF::$dbh = $dbh;
    }

    public static function findAll() {  // 変更 staticのメソッドに
        $items = SELF::$dbh->query("SELECT * FROM items");
        $items = $items->fetchall();

        return $items;
    }
}

?>