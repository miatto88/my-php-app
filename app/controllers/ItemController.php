<?php
require_once("../../models/item.php");
require_once("../../validations/Itemvalidation.php");

class ItemController {
    public static function index() {
        $items = Item::findAll();

        return $items;
    }

    public static function detail() {
        $item_id = $_GET["id"];

        if (!$item_id) {
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

    public static function new() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public static function store() { // 変更 validationの処理を諸々
        $dbh = Item::dbconnect();

        $validation = new ItemValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            header("Location: new.php?name=" . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $store = $dbh->prepare(
            "INSERT INTO items SET name=?, price=?, stock=?, created_at=?, updated_at=?");
        $store->execute([
            $data["name"],
            $data["price"],
            $data["stock"],
            $data["created_at"],
            $data["updated_at"]
        ]);

        
        header("Location: index.php");
        return;
    }

}

?>