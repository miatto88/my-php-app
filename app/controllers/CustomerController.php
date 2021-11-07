<?php
require_once("BaseController.php");
require_once("../../models/Customer.php");

class CustomerController Extends BaseController {
    public function index() { // 変更 非staticなメソッドに
        $customers = Customer::findAll();

        return $customers;
    }
}

?>