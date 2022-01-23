<?php
require_once(dirname(__FILE__) . "/BaseModel.php");
require_once(dirname(__FILE__) . "/../util/Function.php");

class Customer Extends BaseModel {
    private $data = [
        "id",
        "company",
        "phone",
        "fax",
        "address_1",
        "address_2",
        "city",
        "state_province",
        "zip_code",
        "first_name",
        "last_name",
        "created_at",
        "updated_at"
    ];
    
    public $dbh;

    public function setId($id) {
        $this->data["id"] = $id;
    }

    public function getId() {
        return $this->data["id"];
    }

    public function setCompany($company) {
        $this->data["company"] = $company;
    }

    public function getCompany() {
        return $this->data["company"];
    }

    public function setPhone($phone) {
        $this->data["phone"] = $phone;
    }

    public function getPhone() {
        return $this->data["phone"];
    }

    public function setFax($fax) {
        $this->data["fax"] = $fax;
    }

    public function getFax() {
        return $this->data["fax"];
    }

    public function setAddress1($address_1) {
        $this->data["address_1"] = $address_1;
    }

    public function getAddress1() {
        return $this->data["address_1"];
    }

    public function setAddress2($address2) {
        $this->data["address_2"] = $address2;
    }

    public function getAddress2() {
        return $this->data["address_2"];
    }

    public function setCity($city) {
        $this->data["city"] = $city;
    }

    public function getCity() {
        return $this->data["city"];
    }

    public function setStateProvince($state_province) {
        $this->data["state_province"] = $state_province;
    }

    public function getStateProvince() {
        return $this->data["state_province"];
    }

    public function setZipCode($zip_code) {
        $this->data["zip_code"] = $zip_code;
    }

    public function getZipCode() {
        return $this->data["zip_code"];
    }

    public function setLastName($last_name) {
        $this->data["last_name"] = $last_name;
    }

    public function getLastName() {
        return $this->data["last_name"];
    }

    public function setFirstName($first_name) {
        $this->data["first_name"] = $first_name;
    }

    public function getFirstName() {
        return $this->data["first_name"];
    }

    public static function findAll() {
        $dbh = self::dbconnect();

        $customers = $dbh->query("SELECT * FROM customers");
        $customers = $customers->fetchAll();

        return $customers;
    }

    public static function findById($customer_id) {
        $dbh = self::dbconnect();

        $customer = $dbh->query("SELECT * FROM customers WHERE customers.id=$customer_id");
        $customer = $customer->fetch();

        return $customer;
    }

    public static function isExistById($customer) {
        if ($customer["id"] === null || $customer["id"] === false) {
            return false;
        }

        return true;
    }

    public function save() {
        try {
            $dbh = self::dbconnect();

            $dbh->beginTransaction(); // トランザクション 開始
    
            $store = $dbh->prepare(
                "INSERT INTO customers SET company=?, phone=?, fax=?, zip_code=?, state_province=?, city=?, address_1=?, address_2=?, last_name=?, first_name=?, created_at=?, updated_at=?");
            $result = $store->execute([
                $this->getCompany(),
                $this->getPhone(),
                $this->getFax(),
                $this->getZipCode(),
                $this->getStateProvince(),
                $this->getCity(),
                $this->getAddress1(),
                $this->getAddress2(),
                $this->getLastName(),
                $this->getFirstName(),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s")
            ]);

            if ($result) {
                $dbh->commit(); // トランザクション コミット
            }

            if (!$result) {
                $dbh->rollBack(); // トランザクション ロールバック
            }

            return $result;
        } catch (PDOException $e) {
            echo h("DB登録エラー: " . $e->getMessage());

            $dbh->rollBack();
        }
    }

    public function update() {
        try {
            $dbh = self::dbconnect();
    
            $dbh->beginTransaction(); // トランザクション 開始

            $store = $dbh->prepare(
                "UPDATE customers SET company=?, phone=?, fax=?, zip_code=?, state_province=?, city=?, address_1=?, address_2=?, last_name=?, first_name=?, updated_at=? WHERE id=?");
            $result = $store->execute([
                $this->getCompany(),
                $this->getPhone(),
                $this->getFax(),
                $this->getZipCode(),
                $this->getStateProvince(),
                $this->getCity(),
                $this->getAddress1(),
                $this->getAddress2(),
                $this->getLastName(),
                $this->getFirstName(),
                date("Y-m-d H:i:s"),
                $this->getId()
            ]);

            if ($result) {
                $dbh->commit(); // トランザクション コミット
            }

            if (!$result) {
                $dbh->rollBack(); // トランザクション ロールバック
            }

            return $result;
        } catch (PDOException $e) {
            echo h("DB更新エラー: " . $e->getMessage()); // トランザクション ロールバック

            $dbh->rollBack();
        }
    }
}

?>