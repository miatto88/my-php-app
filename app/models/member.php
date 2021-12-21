<?php
require_once(dirname(__FILE__) . "/BaseModel.php");

class Member Extends BaseModel {
    const ROLE_USER = "0";
    const ROLE_ADMIN = "1";
    const ROLE_GUEST = "2";

    const EXPORT_DIR = "/var/tmp/";
    
    public static function showRole($member) {
        if ($member["role"] === self::ROLE_USER) {
            return "ユーザー";
        }
        
        if ($member["role"] === self::ROLE_ADMIN) {
            return "管理者";
        }
        
        if ($member["role"] === self::ROLE_GUEST) {
            return "ゲスト";
        }
        
        return "不明";
    }

    private $data = [
        "id",
        "last_name",
        "first_name",
        "password",
        "role",
        "token"
    ];

    public $dbh;

    public function setId($id) {
        $this->data["id"] = $id;
    }

    public function getId() {
        return $this->data["id"];
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
    
    public function setPassword($password) {
        $this->data["password"] = $password;
    }
    
    public function getPassword() {
        return $this->data["password"];
    }

    public function setRole($role) {
        $this->data["role"] = $role;
    }
    
    public function getRole() {
        return $this->data["role"];
    }
    
    public function setToken($token) {
        $this->data["token"] = $token;
    }
    
    public function getToken() {
        return $this->data["token"];
    }

    public static function findAll() {
        $dbh = self::dbconnect();

        $members = $dbh->query("SELECT * FROM members limit 0, 15");
        $members = $members->fetchAll();

        return $members;
    }

    public static function findById($member_id) {
        $dbh = self::dbconnect();

        $member = $dbh->query("SELECT * FROM members WHERE members.id=$member_id");
        $member = $member->fetch();

        return $member;
    }

    public static function findByToken($token) {
        $dbh = self::dbconnect();

        $member = $dbh->query("SELECT * FROM members WHERE members.token='" . $token . "'");
        $member = $member->fetch();

        return $member;
    }

    public static function isExistById($member) {
        if ($member["id"] === null || $member["id"] === false) {
            return false;
        }

        return true;
    }

    public function createToken() {
        $token = rand(0, 100) . uniqid();
        return $token;
    }

    public function saveToken() {
        try {
            $dbh = self::dbconnect();
    
            $store = $dbh->prepare(
                "INSERT INTO members SET first_name=?, last_name=?, password=?, role=?, token=?, created_at=?, updated_at=?");
            $result = $store->execute([
                "pre_member",
                "pre_member",
                $this->getToken(),
                "0",
                $this->getToken(),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s")
            ]);

            return $result;
        } catch (PDOException $e) {
            echo "DB登録エラー: " . $e->getMessage();
        }
    }

    public function save() {
        try {
            $dbh = self::dbconnect();

            $dbh->beginTransaction(); // トランザクション 開始
    
            $store = $dbh->prepare(
                "INSERT INTO members SET first_name=?, last_name=?, password=?, role=?, token=?, created_at=?, updated_at=?");
            $result = $store->execute([
                $this->getFirstName(),
                $this->getLastName(),
                $this->getPassword(),
                $this->getRole(),
                "0",
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
            echo "DB登録エラー: " . $e->getMessage();

            $dbh->rollBack();
        }
    }

    public function update() {
        try {
            $dbh = self::dbconnect();
    
            $dbh->beginTransaction(); // トランザクション 開始

            $store = $dbh->prepare(
                "UPDATE members SET last_name=?, first_name=?, password=?, role=?, updated_at=? WHERE id=?");
            $result = $store->execute([
                $this->getLastName(),
                $this->getFirstName(),
                $this->getPassword(),
                $this->getRole(),
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
            echo "DB更新エラー: " . $e->getMessage(); // トランザクション ロールバック

            $dbh->rollBack();
        }
    }

    // public function delete($id) {
    //     try {
    //         $dbh = SELF::dbconnect();

    //         $dbh->beginTransaction(); // トランザクション 開始
    
    //         $stmt = $dbh->prepare(
    //             "DELETE FROM members WHERE id=?"
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