<?php
require_once("../../models/auth.php");

Class AuthController {
    public static function get() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }
    }

    public static function auth() {
        $validation = new Authvalidation;
        $validation->setData($_POST);

        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: login.php?last_name=" . $_POST["last_name"] . "&first_name=" . $_POST["first_name"] . "&password=" . $_POST["password"]);
            return;
        }

        $data = $validation->getData();
        $member = Auth::findMember($data["last_name"], $data["first_name"], $data["password"]);
        return $member;
    }

    // セッション切れに関わる処理
    public static function sessionCheck() {
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