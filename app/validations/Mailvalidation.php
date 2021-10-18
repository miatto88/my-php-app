<?php
require_once("../../controllers/AuthController.php");

class MailValidation {
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

        if ($data["mail_address"] == null) {
            $this->setErrorMessages("mail_address", "メールアドレスを入力してください");
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
}

?>