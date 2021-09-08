<?php
require_once("../../models/item.php");

class ItemController {
    public static function index() {
        $items = Item::findAll();

        return $items;
    }

    public static function detail() {
        $item_id = $_GET["id"];

        if (!$item_id) { // 変更 条件式を変更
            header("Location: ../error/404.php");
            exit();
        }
        
        $item = Item::findById($item_id);

        $is_exist = Item::isExistById($item);
        if ($is_exist === false) {
            header("Location: ../error/404.php");
            exit();
        };

        return $item;
    }

    public static function new() { // 変更 メソッド追加
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public static function store() { // 変更 メソッド追加
        $dbh = Item::dbconnect();

        $store = $dbh->prepare(
            "INSERT INTO items SET name=?, price=?, stock=?, created_at=?, updated_at=?");
        $store->execute([
            $_POST["name"],
            $_POST["price"],
            $_POST["stock"],
            $_POST["created_at"],
            $_POST["updated_at"]
        ]);

        header("Location: index.php");
        return;
    }

}

?>