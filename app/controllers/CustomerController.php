<?php
require_once(dirname(__FILE__) . "/BaseController.php");
require_once(dirname(__FILE__) . "/../models/Customer.php");

class CustomerController Extends BaseController {
    public function index() { // 変更 非staticなメソッドに
        $customers = Customer::findAll();

        return $customers;
    }
}

?>