<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/Customer.php");
require_once(dirname(__FILE__) . "/../validations/Customervalidation.php");
require_once(dirname(__FILE__) . "/../util/Role.php");

class CustomerController Extends BaseController {
    public function index() { // 変更 非staticなメソッドに
        $customers = Customer::findAll();
        $is_admin = Role::isAdmin();
        $is_guest = Role::isGuest();

        return compact("customers", "is_admin", "is_guest");
    }

    public function detail() {
        $customer_id = $_GET["id"];

        if (!$customer_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $customer = Customer::findById($customer_id);

        $is_exist = Customer::isExistById($customer);
        if ($is_exist === false) {
            header("Location: ../error/404.php");
            exit();
        };

        return $customer;
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

            header("Location: new.php");
            return;
        }

        $dbh = Customer::dbconnect();

        $validation = new CustomerValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: new.php");
            return;
        }

        $data = $validation->getData();

        $customer = new Customer;
        $customer->setCompany($data["company"]);
        $customer->setPhone($data["phone"]);
        $customer->setFax($data["fax"]);
        $customer->setZipCode($data["zip_code"]);
        $customer->setStateProvince($data["state_province"]);
        $customer->setCity($data["city"]);
        $customer->setAddress1($data["address_1"]);
        $customer->setAddress2($data["address_2"]);
        $customer->setLastName($data["last_name"]);
        $customer->setFirstName($data["first_name"]);

        $save = $customer->save();

        if ($save !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ登録に失敗しました";

            header("Location: new.php");
            return;
        }
        
        header("Location: ../customer/customer.php");
        return;
    }

    public function edit() {
        $customer_id = $_GET["id"];

        if (!$customer_id) {
            header("Location: ../error/404.php");
            exit();
        }
        
        $customer = Customer::findById($customer_id);
        if (!$customer) {
            header("Location: ../error/404.php");
            exit();
        };

        // 入力された値と、マスターにある値を両方渡したい
        $customer =[
            "input" => $_GET,
            "master" => $customer
        ];

        return $customer;
    }

    public function update() {
        $dbh = Customer::dbconnect();

        $validation = new CustomerValidation;
        $validation->setData($_POST);
    
        // validationがNGだった場合にはリダイレクト
        if ($validation->check() === false) {
            session_start();
            $_SESSION["errors"] = $validation->getErrorMessages();

            header("Location: edit.php?id=" . $_GET["id"]);
            return;
        }

        $data = $validation->getData();

        $customer = new Customer;
        $customer->setId($_GET["id"]);
        $customer->setCompany($data["company"]);
        $customer->setPhone($data["phone"]);
        $customer->setFax($data["fax"]);
        $customer->setZipCode($data["zip_code"]);
        $customer->setStateProvince($data["state_province"]);
        $customer->setCity($data["city"]);
        $customer->setAddress1($data["address_1"]);
        $customer->setAddress2($data["address_2"]);
        $customer->setLastName($data["last_name"]);
        $customer->setFirstName($data["first_name"]);

        $update = $customer->update();

        if ($update !== true) {
            session_start();
            $_SESSION["errors"]["database"] = "データ更新に失敗しました";

            header("Location: edit.php?id=" . $_GET["id"]);
            return;
        }
        
        header("Location: ../customer/customer.php");
        return;
    }
}

?>