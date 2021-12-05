<?php
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");

header("Content-type: application/json; charset=UTF-8");

$controller = new MemberController;

$data = $controller->export();

$file_name = $controller->createCsv($data);

$_SESSION["ajax"]["file_name"] = $file_name;

echo json_encode($file_name);
exit();

?>