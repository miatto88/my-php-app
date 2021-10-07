<?php
require_once("../../models/item.php");
// require_once("../../validations/Itemvalidation.php");

class ItemController {
    public static function delete($id) {
        // idの存在チェックを追加
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