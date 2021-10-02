<?php
require_once("../../controllers/ItemController.php");

header("Content-type: application/json; charset=UTF-8");

$id = $_POST["id"];
$result = [];

try {
    if (empty($id)) {
        throw new Exception("idを受け取れませんでした。");
    }

    ItemController::delete($id);
    header("Location: ../item/index.php");
        return;

    $result = [
        "result" => "OK",
        "deleted_id" => "$id"
    ];
} catch (Exception $e) {
    $result = [
        "result" => "NG",
        "message" => $e->getMessage()
    ];
}

return json_encode($result);
?>