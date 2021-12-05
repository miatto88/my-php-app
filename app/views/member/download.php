<?php
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");

$controller = new MemberController;

$file_name = $_SESSION["ajax"]["file_name"];

$controller->downloadCsv($file_name);

return;
?>