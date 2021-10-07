<?php
require_once("../../controllers/api/ItemController.php");

header("Content-type: application/json; charset=UTF-8");

$id = $_POST["id"];
$result = [];

try {
    if (empty($id)) {
        throw new Exception("idを受け取れませんでした。");
    }

    $result = ItemController::delete($id);

    if ($result) {
        $response = [
            "result" => "OK",
            "deleted_id" => $id
        ];
    }
    
    if (!$result) {
        $response = [
            "result" => "NG",
            "message" => "Delete_Failed"
        ];
    }
} catch (Exception $e) {
    $response = [
        "result" => "Error",
        "message" => $e->getMessage()
    ];
}

echo json_encode($response);
exit();
?>