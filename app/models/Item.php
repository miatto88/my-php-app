<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    // 変更 itemテーブル要素をもたせる
    private $data = [
        "name",
        "price",
        "stock",
        "created_at",
        "updated_at"
    ];
    
    public $dbh;

    public static function findAll() {
        $dbh = SELF::dbconnect();

        $items = $dbh->query("SELECT * FROM items");
        $items = $items->fetchAll();

        return $items;
    }

    public static function findById($item_id) {
        $dbh = SELF::dbconnect();

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


    // 変更 セッターとゲッターの追加
    public function setName($name) {
        $this->data["name"] = $name;
    }

    public function setPrice($price) {
        $this->data["price"] = $price;
    }

    public function setStock($stock) {
        $this->data["stock"] = $stock;
    }
    public function setCreatedAt($createdAt) {
        $this->data["created_at"] = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->data["updated_at"] = $updatedAt;
    }

    public function getName() {
        return $this->data["name"];
    }
    
    public function getPrice() {
        return $this->data["price"];
    }
    
    public function getStock() {
        return $this->data["stock"];
    }

    public function getCreatedAt() {
        return $this->data["created_at"];
    }

    public function getUpdatedAt() {
        return $this->data["updated_at"];
    }

    // 変更 インサート処理用メソッドの追加
    public function save() {
        $dbh = SELF::dbconnect();
        
        $store = $dbh->prepare(
            "INSERT INTO items SET name=?, price=?, stock=?, created_at=?, updated_at=?");
        $store->execute([
            $this->getName(),
            $this->getPrice(),
            $this->getStock(),
            $this->getCreatedAt(),
            $this->getUpdatedAt()
        ]);
    }
}

?>