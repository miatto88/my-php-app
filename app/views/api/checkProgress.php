<?php
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");

header("Content-type: application/json; charset=UTF-8");

$controller = new MemberController;

$progress = $controller->checkProgress();

echo json_encode($progress);
exit();

?>