<?php
require_once(dirname(__FILE__) . "/BaseModel.php");
require_once(dirname(__FILE__) . "/../util/Function.php");

class StockInHistory Extends BaseModel {
    private $data = [
        "id",
        "item_id",
        "quantity",
        "member_id",
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

    public function setItem_id($item_id) {
        $this->data["item_id"] = $item_id;
    }

    public function getItem_id() {
        return $this->data["item_id"];
    }
    
    public function setQuantity($quantity) {
        $this->data["quantity"] = $quantity;
    }

    public function getQuantity() {
        return $this->data["quantity"];
    }
    
    public function setMember_id($member_id) {
        $this->data["member_id"] = $member_id;
    }
    
    public function getMember_id() {
        return $this->data["member_id"];
    }

    public static function findAll() {
        $dbh = self::dbconnect();

        $items = $dbh->query("SELECT * FROM items");
        $items = $items->fetchAll();

        return $items;
    }

    public static function findById($item_id) {
        $dbh = self::dbconnect();

        $item = $dbh->query("SELECT * FROM items WHERE items.id=$item_id");
        $item = $item->fetch();

        return $item;
    }

    public static function isExistById($item) {
        if ($item["id"] === null || $item["id"] === false) {
            return false;
        }

        return true;
    }

    public function save() {
        try {
            $dbh = self::dbconnect();
    
            $store = $dbh->prepare(
                "INSERT INTO stock_in_histories SET item_id=?, quantity=?, member_id=?, created_at=?, updated_at=?");
            $result = $store->execute([
                $this->getItem_id(),
                $this->getQuantity(),
                $this->getMember_id(),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s")
            ]);

            return $result;
        } catch (PDOException $e) {
            echo h("DB登録エラー: " . $e->getMessage());
        }
    }
}

?>