<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/Member.php");
require_once(dirname(__FILE__) . "/../validations/Membervalidation.php");
require_once(dirname(__FILE__) . "/../util/Role.php");

class MemberController Extends BaseController {
    const EXPORT_DIR = "/var/tmp/";

    public function index() {
        $members = Member::findAll();
        $is_admin = Role::isAdmin();
        $is_guest = Role::isGuest();

        return compact("members", "is_admin", "is_guest");
    }

    public function detail() {
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

    public function new() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $_GET;
        }

        return true;
    }

    public function store() {
        if (Role::isAdmin() === false) {
            session_start();
            $_SESSION["errors"]["database"] = "管理者のみ実行できる機能です";

            header("Location: store.php");
            return;
        }

        $dbh = Member::dbconnect();

        $validation = new MemberValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: store.php?last_name=" . $_POST["last_name"] . "&first_name=" . $_POST["first_name"]);
            return;
        }

        $data = $validation->getData();

        $member = new Member;
        $member->setLastName($data["last_name"]);
        $member->setFirstName($data["first_name"]);
        $member->setPassword($data["password"]);
        $member->setRole($data["role"]);

        $save = $member->save();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: store.php");
            return;
        }
        
        header("Location: ../member/member.php");
        return;
    }

    public function edit() {
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

    public function update() {
        $dbh = Member::dbconnect();

        $validation = new MemberValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: edit.php?id=" . $_GET["id"] . "&last_name="  . $_POST["last_name"] . "&first_name=" . $_POST["first_name"]);
            return;
        }

        $data = $validation->getData();

        $member = new Member;
        $member->setId($_GET["id"]);
        $member->setLastName($data["last_name"]);
        $member->setFirstName($data["first_name"]);
        $member->setPassword($data["password"]);
        $member->setRole($data["role"]);

        $update = $member->update();

        if ($update !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ更新に失敗しました";

            header("Location: edit.php?id=" . $_GET["id"]);
            return;
        }
        
        header("Location: ../member/member.php");
        return;
    }

    public function export() {
        $members = Member::findAll();

        return $members;
    }

    public function createCsv($file_name) {
        $filepath = dirname(__FILE__)  . "/../bin/createCsv.php";
        $cmd = "/usr/local/bin/php $filepath $file_name > /dev/null &";

        exec($cmd);
        return;
    }

    public function downloadCsv($file_name) {
        $filepath = self::EXPORT_DIR . $file_name;

        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename={$file_name}");
        header("Content-Transfer-Encoding: binary");

        readfile($filepath);
        return;
    }

    public function checkProgress() {
        $fp = fopen(self::EXPORT_DIR . "lock.csv", "r");
        $progress = fgetcsv($fp);
        fclose($fp);
        
        return $progress;
    }
}

?>