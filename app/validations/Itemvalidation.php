<?php
require_once("../../controllers/ItemController.php");

class ItemValidation {
    private $data;

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

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