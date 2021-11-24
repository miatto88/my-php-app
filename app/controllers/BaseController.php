<?php
Class BaseController {
    public function __construct() {
        session_start();

        if (empty($_SESSION["member"])) {
            $_SESSION = [];
            session_destroy();

            header("Location: ../auth/login.php");
            return;
        }

        if ($_SESSION["member"]["role"] === Member::ROLE_GUEST) {
            $member = "guest";
            return $member;
        }

        if ($_SESSION["member"]["role"] === Member::ROLE_ADMIN) {
            $member = "admin";
            return $member;
        }
    }    
}

?>