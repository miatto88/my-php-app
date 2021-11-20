<?php
require_once(dirname(__FILE__) . "/../controllers/AuthController.php");

class AuthValidation {
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

        if ($data["last_name"] == null || $data["first_name"] == null) {
            $this->setErrorMessages("name", "名前を入力してください");
        }

        if ($data["password"] == null) {
            $this->setErrorMessages("password", "パスワードを入力してください");
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}





?>