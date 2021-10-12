<?php
Class BaseController {
    public function __construct() {
        session_start();

        // タイムアウトの処理は不要
        // if ($_SESSION["time"] + 3600 < time()) {
        //     $_SESSION = [];
        //     session_destroy();

        //     header("Location: ../auth/login.php");
        //     return;
        // }

        // $_SESSION["time"] = time();

        if (empty($_SESSION["member"])) {
            $_SESSION = [];
            session_destroy();

            header("Location: ../auth/login.php");
            return;
        }
    }    
}

?>