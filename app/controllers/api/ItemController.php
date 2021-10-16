<?php
require_once("../../models/item.php");

class ItemController {
    public static function delete($id) {
        // idの存在チェック
        $item_id = Item::findById($id);

        $is_exist = Item::isExistById($item_id);
        if ($is_exist === false) {
            return false;
        };

        $item = new Item;
        $item->setId($id);
        $id = $item->getId();

        $item->delete($id);

        return true;
    }
}

?>