<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    public $dbh;

    public static function findAll() {
        $dbh = SELF::dbconnect();

        $items = $dbh->query("SELECT * FROM items");
        $items = $items->fetchAll();

        return $items;
    }

    public static function findById($item_id) {
        $dbh = SELF::dbconnect();

        $item = $dbh->query("SELECT * FROM items WHERE items.id=$item_id");
        $item = $item->fetch();

        return $item;
    }

    public static function isExistById($item) {
        if ($item["id"] === null || $item["id"] === false) {
            return false;
        }

        return true;
    }
}

?>