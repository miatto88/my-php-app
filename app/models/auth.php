<?php
require_once("BaseModel.php");

class Auth Extends BaseModel {
    private $data = [
        "id",
        "last_name",
        "first_name",
    ];
    
    public $dbh;

    // public function setId($id) {
    //     $this->data["id"] = $id;
    // }

    // public function getId() {
    //     return $this->data["id"];
    // }

    // public function setLastName($last_name) {
    //     $this->data["last_name"] = $last_name;
    // }

    // public function getLastName() {
    //     return $this->data["last_name"];
    // }

    // public function setFirstName($first_name) {
    //     $this->data["first_name"] = $first_name;
    // }

    // public function getFirstName() {
    //     return $this->data["first_name"];
    // }


    // public static function findAll() {
    //     $dbh = SELF::dbconnect();

    //     $members = $dbh->query("SELECT * From members");
    //     $members = $members->fetchAll();

    //     return $members;
    // }

    public static function findMember($last_name, $first_name, $password) {
        $dbh = SELF::dbconnect();

        $member = $dbh->prepare("SELECT * From members WHERE last_name=? AND first_name=? AND password=?");
        $member->execute([$last_name, $first_name, $password]);
        $member = $member->fetch();

        return $member;
    }
}

?>