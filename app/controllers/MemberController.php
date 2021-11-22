<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/Member.php");
require_once(dirname(__FILE__) . "/../validations/Membervalidation.php");

class MemberController Extends BaseController {
    public function index() { // 変更 非staticなメソッドに
        $members = Member::findAll();

        return $members;
    }

    public function detail() { // 変更 非staticなメソッドに
        $member_id = $_GET["id"];

        if (!$member_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $member = Member::findById($member_id);

        $is_exist = Member::isExistById($member);
        if ($is_exist === false) {
            header("Location: ../error/404.php");
            exit();
        };

        return $member;
    }

    public function serchName() {
        $member_name = $_POST["member_name"];

        if ($_POST["member_name"] == null) {
            $members = false;
        } else {
            $members = Member::findByName($member_name);
        }

        if (!$members) {
            session_start();
            $_SESSION["serch"] = "検索条件に一致する製品がありません";
            header("Location: index.php");
            return;
        }

        return $members;
    }

    public function serchStock() {
        $min_stock = $_POST["min_stock"];
        $max_stock = $_POST["max_stock"];

        $members = Member::findByStock($min_stock, $max_stock);
        if (!$members) {
            session_start();
            $_SESSION["serch"] = "検索条件に一致する製品がありません";
            header("Location: index.php");
            return;
        }

        return $members;
    }

    public function new() { // 変更 非staticなメソッドに
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public function store() { // 変更 非staticなメソッドに
        $dbh = Member::dbconnect();

        $validation = new MemberValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: new.php?name=" . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $member = new Member;
        $member->setName($data["name"]);
        $member->setPrice($data["price"]);
        $member->setStock($data["stock"]);

        $save = $member->save();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: new.php");
            return;
        }
        
        header("Location: index.php");
        return;
    }

    public function edit() { // 変更 非staticなメソッドに
        $member_id = $_GET["id"];

        if (!$member_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $member = Member::findById($member_id);
        if (!$member) {
            header("Location: ../error/404.php");
            exit();
        };

        // 入力された値と、マスターにある値を両方渡したい
        $member =[
            "input" => $_GET,
            "master" => $member
        ];

        return $member;
    }

    public function update() { // 変更 非staticなメソッドに
        $dbh = Member::dbconnect();

        $validation = new MemberValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: edit.php?id=" . $_GET["id"] . "&name="  . $_POST["name"] . "&price=" . $_POST["price"] . "&stock=" . $_POST["stock"]);
            return;
        }

        $data = $validation->getData();

        $member = new Member;
        $member->setId($_GET["id"]);
        $member->setName($data["name"]);
        $member->setPrice($data["price"]);
        $member->setStock($data["stock"]);

        $update = $member->update();

        if ($update !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ更新に失敗しました";

            header("Location: edit.php?id=" . $_GET["id"]);
            return;
        }
        
        header("Location: index.php");
        return;
    }
}

?>