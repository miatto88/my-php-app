<?php
require_once("../../models/item.php");

class ItemController {
    public static function index() {
        $items = Item::findAll();

        return $items;
    }

    public static function detail() {
        $item_id = $_GET["id"];

        if ($item_id === null) { // 変更 $item_id が取得できない場合の処理
            header("Location: ../error/404.php");
            exit();
        }
        
        $item = Item::findById($item_id);

        $is_exist = Item::isExistById($item);
        if ($is_exist === false) { // 変更 リダイレクト処理
            header("Location: ../error/404.php");
            exit();
        };

        return $item;
    }
}

?>