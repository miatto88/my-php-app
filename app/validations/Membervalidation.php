<?php
require_once(dirname(__FILE__) . "/../controllers/MemberController.php");

class MemberValidation {
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

        if ($data["last_name"] == null) {
            $this->setErrorMessages("last_name", "名前(姓)を入力してください");
        }

        if ($data["first_name"] == null) {
            $this->setErrorMessages("first_name", "名前(名)を入力してください");
        }

        if ($data["password"] == null) {
            $this->setErrorMessages("password", "パスワードを入力してください");
        }

        if (strlen($data["password"]) < 4) {
            $this->setErrorMessages("password_length", "パスワードは4文字以上を入力してください");
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $data["password"])) {
            $this->setErrorMessages("password_preg_match", "パスワードは半角英数で入力してください");
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}





?>