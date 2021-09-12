<?php
require_once("../../controllers/ItemController.php");

class ItemValidation {
    private $data;

    // 変更 セッター追加
    public function setData($data) {
        $this->data = $data;
    }

    // 変更 ゲッター追加
    public function getData() {
        return $this->data;
    }

    // 変更 checkメソッドを動的メソッドに
    public function check() {
        $data = $this->getData();

        if ($data["name"] == null) {
            return false;
        }

        if (!is_numeric($data["price"])) {
            return false;
        }
        
        if (!is_numeric($data["stock"])) {
            return false;
        }

        return true;
    }
}





?>