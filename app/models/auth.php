<?php
require_once(dirname(__FILE__) . "/BaseModel.php");

class Auth Extends BaseModel {
    private $data = [
        "id",
        "last_name",
        "first_name",
        "role"
    ];
    
    public $dbh;

    public static function findMember($last_name, $first_name, $password) {
        $dbh = SELF::dbconnect();

        $member = $dbh->prepare("SELECT * From members WHERE last_name=? AND first_name=? AND password=?");
        $member->execute([$last_name, $first_name, $password]);
        $member = $member->fetch();

        return $member;
    }
}

?>