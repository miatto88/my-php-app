<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    private $data = [
        "id", // 変更 idを追加
        "name",
        "price",
        "stock",
        "created_at",
        "updated_at"
    ];
    
    public $dbh;

    // 変更 idのセッターとゲッターを追加
    public function setId($id) {
        $this->data["id"] = $id;
    }

    public function getId() {
        return $this->data["id"];
    }

    // 変更 セッターとゲッターの並び順、createdとupdated削除
    public function setName($name) {
        $this->data["name"] = $name;
    }

    public function getName() {
        return $this->data["name"];
    }
    
    public function setPrice($price) {
        $this->data["price"] = $price;
    }

    public function getPrice() {
        return $this->data["price"];
    }
    
    public function setStock($stock) {
        $this->data["stock"] = $stock;
    }
    
    public function getStock() {
        return $this->data["stock"];
    }

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

    public function save() {
        $dbh = SELF::dbconnect();

        $store = $dbh->prepare(
            "INSERT INTO items SET name=?, price=?, stock=?, created_at=?, updated_at=?");
        $store->execute([
            $this->getName(),
            $this->getPrice(),
            $this->getStock(),
            date("Y-m-d H:i:s"), // 変更 createdはここで取得
            date("Y-m-d H:i:s") // 変更 updatedはここで取得
        ]);
    }

    public function update() {
        $dbh = SELF::dbconnect();

        $store = $dbh->prepare(
            "UPDATE items SET name=?, price=?, stock=?, updated_at=? WHERE id=?");
        $store->execute([
            $this->getName(),
            $this->getPrice(),
            $this->getStock(),
            date("Y-m-d H:i:s"),
            $this->getId()
        ]);
    }
}

?>