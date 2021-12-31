<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/Customer.php");
// require_once(dirname(__FILE__) . "/../validations/Customervalidation.php");
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

}

?>