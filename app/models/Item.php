<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    private $data = [
        "id",
        "name",
        "price",
        "stock",
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
        try {
            $dbh = SELF::dbconnect();
    
            $store = $dbh->prepare(
                "INSERT INTO items SET name=?, price=?, stock=?, created_at=?, updated_at=?");
            $result = $store->execute([
                $this->getName(),
                $this->getPrice(),
                $this->getStock(),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s")
            ]);

            return $result;
        } catch (PDOException $e) {
            echo "DB登録エラー: " . $e->getMessage();
        }
    }

    public function update() {
        try {
            $dbh = SELF::dbconnect();
    
            $dbh->beginTransaction(); // トランザクション 開始

            $store = $dbh->prepare(
                "UPDATE items SET name=?, price=?, stock=?, updated_at=? WHERE id=?");
            $result = $store->execute([
                $this->getName(),
                $this->getPrice(),
                $this->getStock(),
                date("Y-m-d H:i:s"),
                $this->getId()
            ]);

            if ($result) {
                $dbh->commit(); // トランザクション コミット
            }

            if (!$result) {
                $dbh->rollBack(); // 変更 トランザクション ロールバック
            }

            return $result;
        } catch (PDOException $e) {
            echo "DB更新エラー: " . $e->getMessage(); // トランザクション ロールバック

            $dbh->rollBack();
        }
    }

    public function delete($id) {
        $dbh = SELF::dbconnect();

        $stmt = $dbh->prepare(
            "DELETE FROM items WHERE id=?"
        );
        $result = $stmt->execute([$id]);

        return $result;
    }
}

?>