<?php
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");

$controller = new MemberController;

$data = $controller->index();

$controller->downloadCsv($data);

?>