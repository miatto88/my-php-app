<?php
require_once("../../models/item.php");

class ItemController {
    public static function index() {
        $items = Item::findAll();
        
        return $items;
    }
}

?>