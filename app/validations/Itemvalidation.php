<?php
require_once("../../controllers/ItemController.php");

class ItemValidation {
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

        if ($data["name"] == null) {
            $this->setErrorMessages("name", "製品名を入力してください");
        }

        if (!is_numeric($data["price"])) {
            $this->setErrorMessages("price", "価格は数字で入力してください");
        }

        if ($data["price"] == null) {
            $this->setErrorMessages("price", "価格を入力してください");
        }
        
        if (!is_numeric($data["stock"])) {
            $this->setErrorMessages("stock", "在庫数は数字で入力してください");
        }

        if ($data["stock"] == null) {
            $this->setErrorMessages("stock", "在庫数を入力してください");
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}





?>