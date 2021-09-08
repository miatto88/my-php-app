<?php

class ItemValidation {
    public static $errors = [];

    public static function check() {
        if ($_POST["name"] == null) {
            return false;
        }

        if (strlen($_POST["name"]) >= 15) {
            return false;
        }

        if (!is_numric($_POST["price"])) {
            return false;
        }
        
        if (!is_numric($_POST["stock"])) {
            return false;
        }

        return true;
    }
}





?>