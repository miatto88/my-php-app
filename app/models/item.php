<?php
require_once("BaseModel.php");

class Item Extends BaseModel {
    public function __construct() {
        $db = new BaseModel();
        $this->dbh = $db->dbconnect();
    }

    public function findAll() {
        $items = $this->dbh->query("SELECT * FROM items");
        $items = $items->fetchall();

        return $items;
    }
}

?>