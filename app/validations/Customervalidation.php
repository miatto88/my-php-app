<?php
require_once(dirname(__FILE__) . "/../controllers/CustomerController.php");

class CustomerValidation {
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

        if ($data["company"] == null) {
            $this->setErrorMessages("company", "会社名を入力してください");
        }

        if ($data["phone"] == null) {
            $this->setErrorMessages("phone", "電話番号を入力してください");
        }

        if ($data["fax"] == null) {
            $this->setErrorMessages("fax", "FAX番号を入力してください");
        }

        if ($data["zip_code"] == null) {
            $this->setErrorMessages("zip_code", "郵便番号を入力してください");
        }

        if ($data["state_province"] == null) {
            $this->setErrorMessages("state_province", "都道府県を入力してください");
        }

        if ($data["city"] == null) {
            $this->setErrorMessages("city", "市区を入力してください");
        }

        if ($data["address_1"] == null) {
            $this->setErrorMessages("address_1", "町・番地を入力してください");
        }
        
        if ($data["last_name"] == null) {
            $this->setErrorMessages("last_name", "相手先担当者の名前(姓)を入力してください");
        }

        if ($data["first_name"] == null) {
            $this->setErrorMessages("first_name", "相手先担当者の名前(名)を入力してください");
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}





?>