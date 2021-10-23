<?php
require_once("BaseController.php");
require_once("../../models/auth.php");
require_once("../../models/member.php");
require_once("../../validations/Mailvalidation.php");
require_once("../../validations/Authvalidation.php");

Class AuthController Extends BaseController {
    public static function index() {
        session_start();

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

    public function sendMail($token) {
        $validation = new MailValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: mail_form.php?mail_address=" . $_POST["mail_address"]);
            return;
        }

        $data = $validation->getData();

        $sendResult = mb_send_mail(
            $data["mail_address"],
            "【在庫確認システム】ユーザー登録確認メール",
            "※ユーザー登録はまだ完了していません" . PHP_EOL .
            "下記のURLをクリックし、ユーザー情報の入力を続けてください" . PHP_EOL .
            "このURLの有効期限は30分です" . PHP_EOL .
            "http://127.0.0.1:8000/views/member/new.php?token=" . $token
        );

        if ($sendResult !== true) {
            session_start();
            $_SESSION["errors"]["mail"] = "メール送信に失敗しました";

            header("Location: mail_form.php?mail_failed");
            return;
        }
        
        header("Location: success.php");
        return;

    }

    public function createToken() {
        $token = rand(0, 100) . uniqid();
        
        $dbh = Member::dbconnect();
        
        $pre_member = new Member;
        $pre_member->setToken($token);

        $save = $pre_member->saveToken();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: mail_form.php");
            return;
        }
        
        return $token;

    }

    public function store() {
        $dbh = Member::dbconnect();

        $validation = new AuthValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: new.php?token=" . $_GET["token"] . "&last_name=" . $_POST["last_name"] . "&first_name=" . $_POST["first_name"] . "&password=" . $_POST["password"]);
            return;
        }

        $data = $validation->getData();

        // DBからトークンを取得する処理。存在しない場合はfalseが返る
        $pre_member = Member::findByToken($_GET["token"]);

        // トークンが不正、あるいは有効期限切れの処理
        if ($pre_member === false || $pre_member["created_at"] < date("Y-m-d H:i:s", strtotime("-30 minute"))) {
            session_start();
            $_SESSION["errors"]["token"] = "トークンが有効ではありません" . "</br>" . "初めからやり直してください";

            header("Location: new.php?token=" . $_GET["token"]);
            return;
        }

        $member = new Member;
        $member->setId($pre_member["id"]);
        $member->setLastName($data["last_name"]);
        $member->setFirstName($data["first_name"]);
        $member->setPassword($data["password"]);

        $save = $member->update();

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