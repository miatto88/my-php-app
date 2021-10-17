<?php
require_once("BaseController.php");
require_once("../../models/auth.php");
require_once("../../models/member.php");

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

    public static function logout() {
        session_start();

        $_SESSION = [];
        session_destroy();

        header("Location: ../auth/login.php");
        return;
    }

    public static function sendMail() {
        mb_send_mail(
            $_GET["mail_address"],
            "【在庫確認システム】ユーザー登録確認メール",
            "※ユーザー登録はまだ完了していません" . PHP_EOL .
            "下記のURLをクリックし、ユーザー情報の入力を続けてください" . PHP_EOL .
            "http://127.0.0.1:8000/views/member/new.php"
        );
    }

    public function store() { // 変更 非staticなメソッドに
        $dbh = Member::dbconnect();

        // $validation = new MemberValidation;
        // $validation->setData($_POST);
    
        // // validationがNGだった場合にはリダイレクト
        // if ($validation->check() === false) {
        //     session_start();
        //     $_SESSION["errors"] = $validation->getErrorMessages();

        //     header("Location: new.php?name=" . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
        //     return;
        // }

        // $data = $_POST;

        $member = new Member;
        $member->setLastName($_POST["last_name"]);
        $member->setFirstName($_POST["first_name"]);
        $member->setPassword($_POST["password"]);

        $save = $member->save();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: new.php");
            return;
        }
        
        header("Location: ../auth/login.php");
        return;
    }


}


?>