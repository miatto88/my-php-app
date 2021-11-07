<?php
// require_once("../../controllers/StockInHistoryController.php");

class StockInHistoryValidation {
    private $data;
    private $errors = [];

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function setErrorMessages($errorType, $errorMessage) {
        $this->errors[$errorType] = $errorMessage;
    }

    public function getErrorMessages() {
        return $this->errors;
    }

    public function check() {
        $data = $this->getData();
        // $controller = new StockOutHistoryController;
        // $item = $controller->detail();

        // if ($data["quantity"] > $item["stock"]) {
        //     $this->setErrorMessages("stock", "在庫が不足しています");
        // }

        if ($data["quantity"] == null) {
            $this->setErrorMessages("quantity", "入庫数を入力してください");
        }

        // if ($data["customer_id"] == null) {
        //     $this->setErrorMessages("customer_id", "出荷先を入力してください");
        // }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}

?>