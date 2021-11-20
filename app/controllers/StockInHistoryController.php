<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/StockInHistory.php");
require_once(dirname(__FILE__) . "/../validations/StockInHistoryvalidation.php");

class StockInHistoryController Extends BaseController {
    public function index() {
        $items = StockInHistory::findAll();

        return $items;
    }

    public function detail() {
        $item_id = $_GET["id"];

        if (!$item_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $item = StockInHistory::findById($item_id);

        $is_exist = StockInHistory::isExistById($item);
        if ($is_exist === false) {
            header("Location: ../error/404.php");
            exit();
        };

        return $item;
    }

    public function new() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public function store() {
        $dbh = StockInHistory::dbconnect();

        $validation = new StockInHistoryValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: in_count.php?id=" . $_POST["item_id"] . "&quantity=" . $_POST["quantity"]);
            return;
        }

        $data = $validation->getData();

        $stock_in_history = new StockInHistory;
        $stock_in_history->setItem_id($data["item_id"]);
        $stock_in_history->setQuantity($data["quantity"]);
        $stock_in_history->setMember_id($data["member_id"]);

        $save = $stock_in_history->save();

        $item = new Item;
        $item->setId($data["item_id"]);
        $stock = $item->stockIn($item->getId());
        $item->stockUpdate($stock);

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: in_count.php");
            return;
        }
        
        header("Location: index.php");
        return;
    }

    // public function edit() { // 変更 非staticなメソッドに
    //     $item_id = $_GET["id"];

    //     if (!$item_id) {
    //         header("Location: ../error/404.php");
    //         exit();
    //     }
        
    //     $item = StockInHistory::findById($item_id);
    //     if (!$item) {
    //         header("Location: ../error/404.php");
    //         exit();
    //     };

    //     // 入力された値と、マスターにある値を両方渡したい
    //     $item =[
    //         "input" => $_GET,
    //         "master" => $item
    //     ];

    //     return $item;
    // }

    // public function update() { // 変更 非staticなメソッドに
    //     $dbh = StockInHistory::dbconnect();

    //     $validation = new StockHistoryValidation;
    //     $validation->setData($_POST);
    
    //     // validationがNGだった場合にはリダイレクト
    //     if ($validation->check() === false) {
    //         session_start();
    //         $_SESSION["errors"] = $validation->getErrorMessages();

    //         header("Location: edit.php?id=" . $_GET["id"] . "&name="  . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
    //         return;
    //     }

    //     $data = $validation->getData();

    //     $item = new StockInHistory;
    //     $item->setId($_GET["id"]);
    //     $item->setName($data["name"]);
    //     $item->setPrice($data["price"]);
    //     $item->setStock($data["stock"]);

    //     $update = $item->update();

    //     if ($update !== true) {
    //         session_start();
    //         $_SESSION["errors"]["database"] = "データ更新に失敗しました";

    //         header("Location: edit.php?id=" . $_GET["id"]);
    //         return;
    //     }
        
    //     header("Location: index.php");
    //     return;
    // }
}

?>