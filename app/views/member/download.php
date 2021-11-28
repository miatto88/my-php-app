<?php
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");

// ログインチェック
$controller = new MemberController;


$today = date("YmdHi");
$filename = "members_" . $today . ".csv";
$filedata = $controller->index();

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename={$filename}");
header("Content-Transfer-Encoding: binary");

$fp = fopen("php://output", "w");

$head = ["id", "姓", "名", "権限", "登録日", "最終更新日"];
fputcsv($fp, $head);

foreach ($filedata["members"] as $row) {
    fputcsv($fp, $row);
}

fclose($fp);

return;

?>