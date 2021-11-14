<?php
require_once("BaseController.php");
require_once("../../models/item.php");
require_once("../../validations/Itemvalidation.php");

class ItemController Extends BaseController {
    public function index() { // 変更 非staticなメソッドに
        $items = Item::findAll();

        return $items;
    }

    public function detail() { // 変更 非staticなメソッドに
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

    public function serchName() {
        $item_name = $_POST["item_name"];

        if ($_POST["item_name"] == null) {
            $items = false;
        } else {
            $items = Item::findByName($item_name);
        }

        if (!$items) {
            session_start();
            $_SESSION["serch"] = "検索条件に一致する製品がありません";
            header("Location: index.php");
            return;
        }

        return $items;
    }

    public function serchStock() {
        $min_stock = $_POST["min_stock"];
        $max_stock = $_POST["max_stock"];

        $items = Item::findByStock($min_stock, $max_stock);
        if (!$items) {
            session_start();
            $_SESSION["serch"] = "検索条件に一致する製品がありません";
            header("Location: index.php");
            return;
        }

        return $items;
    }

    public function new() { // 変更 非staticなメソッドに
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public function store() { // 変更 非staticなメソッドに
        $dbh = Item::dbconnect();

        $validation = new ItemValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: new.php?name=" . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $item = new Item;
        $item->setName($data["name"]);
        $item->setPrice($data["price"]);
        $item->setStock($data["stock"]);

        $save = $item->save();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: new.php");
            return;
        }
        
        header("Location: index.php");
        return;
    }

    public function edit() { // 変更 非staticなメソッドに
        $item_id = $_GET["id"];

        if (!$item_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $item = Item::findById($item_id);
        if (!$item) {
            header("Location: ../error/404.php");
            exit();
        };

        // 入力された値と、マスターにある値を両方渡したい
        $item =[
            "input" => $_GET,
            "master" => $item
        ];

        return $item;
    }

    public function update() { // 変更 非staticなメソッドに
        $dbh = Item::dbconnect();

        $validation = new ItemValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: edit.php?id=" . $_GET["id"] . "&name="  . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $item = new Item;
        $item->setId($_GET["id"]);
        $item->setName($data["name"]);
        $item->setPrice($data["price"]);
        $item->setStock($data["stock"]);

        $update = $item->update();

        if ($update !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ更新に失敗しました";

            header("Location: edit.php?id=" . $_GET["id"]);
            return;
        }
        
        header("Location: index.php");
        return;
    }
}

?>