<?php
require_once("BaseController.php");
require_once("../../models/StockOutHistory.php");
require_once("../../validations/StockOutHistoryvalidation.php");

class StockOutHistoryController Extends BaseController {
    public function index() {
        $items = StockOutHistory::findAll();

        return $items;
    }

    public function detail() {
        $item_id = $_GET["id"];

        if (!$item_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $item = StockOutHistory::findById($item_id);

        $is_exist = StockOutHistory::isExistById($item);
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
        $dbh = StockOutHistory::dbconnect();

        $validation = new StockOutHistoryValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: out_count.php?id=" . $_POST["item_id"] . "&quantity=" . $_POST["quantity"] . "&customer_id=" . $_POST["customer_id"]);
            return;
        }

        $data = $validation->getData();

        $stock_out_history = new StockOutHistory;
        $stock_out_history->setItem_id($data["item_id"]);
        $stock_out_history->setQuantity($data["quantity"]);
        $stock_out_history->setMember_id($data["member_id"]);
        $stock_out_history->setCustomer_id($data["customer_id"]);

        $save = $stock_out_history->save();

        $item = new Item;
        $item->setId($data["item_id"]);
        $stock = $item->stockOut($item->getId());
        $item->stockUpdate($stock);

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: out_count.php");
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
        
    //     $item = StockOutHistory::findById($item_id);
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
    //     $dbh = StockOutHistory::dbconnect();

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

    //     $item = new StockOutHistory;
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