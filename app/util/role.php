<?php

Class Role {
    public static function isAdmin() {
        if ($_SESSION["member"]["role"] === Member::ROLE_ADMIN) {
            return true;
        }
        return false;
    }

    public static function isGuest() {
        if ($_SESSION["member"]["role"] === Member::ROLE_GUEST) { // ゲスト用のロールに定数を使用
            return true;
        }
        return false;
    }
}

?>