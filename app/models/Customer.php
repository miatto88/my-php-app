<?php
require_once("BaseModel.php");

class Customer Extends BaseModel {
    private $data = [
        "id",
        "company",
        "phone",
        "fax",
        "address_1",
        "address_2",
        "city",
        "state/province",
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

    // public function out_save() {
    //     try {
    //         $dbh = self::dbconnect();
    
    //         $store = $dbh->prepare(
    //             "INSERT INTO stock_out_histories SET customer_id=?, quantity=?, member_id=?, customer_id=?, created_at=?, updated_at=?");
    //         $result = $store->execute([
    //             $this->getCustomer_id(),
    //             $this->getQuantity(),
    //             $this->getMember_id(),
    //             $this->getCustomer_id(),
    //             date("Y-m-d H:i:s"),
    //             date("Y-m-d H:i:s")
    //         ]);

    //         return $result;
    //     } catch (PDOException $e) {
    //         echo "DB登録エラー: " . $e->getMessage();
    //     }
    // }

    // public function update() {
    //     try {
    //         $dbh = self::dbconnect();
    
    //         $dbh->beginTransaction(); // トランザクション 開始

    //         $store = $dbh->prepare(
    //             "UPDATE customers SET name=?, price=?, stock=?, updated_at=? WHERE id=?");
    //         $result = $store->execute([
    //             $this->getName(),
    //             $this->getPrice(),
    //             $this->getStock(),
    //             date("Y-m-d H:i:s"),
    //             $this->getId()
    //         ]);

    //         if ($result) {
    //             $dbh->commit(); // トランザクション コミット
    //         }

    //         if (!$result) {
    //             $dbh->rollBack(); // トランザクション ロールバック
    //         }

    //         return $result;
    //     } catch (PDOException $e) {
    //         echo "DB更新エラー: " . $e->getMessage(); // トランザクション ロールバック

    //         $dbh->rollBack();
    //     }
    // }

    // public function delete($id) {
    //     try {
    //         $dbh = self::dbconnect();

    //         $dbh->beginTransaction(); // トランザクション 開始
    
    //         $stmt = $dbh->prepare(
    //             "DELETE FROM customers WHERE id=?"
    //         );
    //         $result = $stmt->execute([$id]);

    //         if ($result) {
    //             $dbh->commit(); // トランザクション コミット
    //         }

    //         if(!$result) {
    //             $dbh->rollBack(); // トランザクション ロールバック
    //         }
    
    //         return $result;
    //     } catch (PDOException $e) {
    //         echo "DB削除エラー: " . $e->getMessage(); // トランザクション ロールバック

    //         $dbh->rollBack();
    //     }
    // }
}

?>