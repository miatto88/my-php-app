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

    public static function store() {
        $dbh = Item::dbconnect();

        $validation = new ItemValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            header("Location: new.php?name=" . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $item = new Item;
        $item->setName($data["name"]);
        $item->setPrice($data["price"]);
        $item->setStock($data["stock"]);

        $item->save();
        
        header("Location: index.php");
        return;
    }

    // 変更 editメソッドを追加
    public static function edit() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
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

        return true;
    }

    // 変更 updateメソッドを追加
    public static function update() {
        $dbh = Item::dbconnect();

        $validation = new ItemValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            header("Location: edit.php?id=" . $_GET["id"] . "&error=1");
            return;
        }

        $data = $validation->getData();

        $item = new Item;
        $item->setId($_GET["id"]);
        $item->setName($data["name"]);
        $item->setPrice($data["price"]);
        $item->setStock($data["stock"]);

        $item->update();
        
        header("Location: index.php");
        return;
    }
}

?>