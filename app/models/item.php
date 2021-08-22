<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    public $dbh;  // 変更 static は削除、動的メソッドに

    // 変更 setDbh()はわかりにくいので削除、findAll()メソッド内に
    // public static function setDbh() {   // 変更 コンストラクタではなくした
    //     // $db = new BaseModel();   // 変更 不要な為削除
    //     $dbh = SELF::dbconnect();
    //     SELF::$dbh = $dbh;
    // }

    public static function findAll() {  // 変更 staticのメソッドに
        $dbh = SELF::dbconnect();

        $items = $dbh->query("SELECT * FROM items");
        $items = $items->fetchAll();

        return $items;
    }
}

?>