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
    }    
}

?>