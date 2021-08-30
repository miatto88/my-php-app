<?php
require_once("../../models/item.php");

class ItemController {
    public static function index() {
        $items = Item::findAll();

        return $items;
    }

    public static function detail() {
        $item_id = $_GET["id"];
        $item = Item::findById($item_id);
        Item::isExistById($item); // 変更 id存在チェックを追加

        return $item;
    }
}

?>