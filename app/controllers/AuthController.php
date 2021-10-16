<?php
require_once("BaseController.php");
require_once("../../models/auth.php");

Class AuthController Extends BaseController {
    public static function index() {
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
        
        // $memberを取得できたらセッションに保存する処理
        if ($member) {
            session_start();
            $_SESSION["member"] = [
                $_SESSION["id"] = $member["id"],
                $_SESSION["name"] = $member["last_name"] . $member["first_name"]
            ];

            header("Location: ../item/index.php");
            return;
        }
        
        return $member;
    }
}


?>