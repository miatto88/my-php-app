<?php

const START = 1;
const WIP = 2;
const FINISH = 3;

const EXPORT_DIR = "/var/tmp/";

$encoded_data = $argv[1];
$decoded_data = json_decode($encoded_data, true);

// if (!file_exists(EXPORT_DIR . "lock.csv")) {
//     touch(EXPORT_DIR . "lock.csv");
// }

// if (file_exists(EXPORT_DIR . "lock.csv")) {
//     unlink(EXPORT_DIR . "lock.csv");
// }

// ロックファイルの作成
$total = count($decoded_data);
$count = 0;
$progress = [START, $total, $count, time()];

$lockFp = fopen(EXPORT_DIR . "lock.csv", "w+");
fputcsv($lockFp, $progress);

// ダウンロード用CSV作成
$today = date("YmdHi");
$file_name = "members_" . $today . ".csv";

$filepath = EXPORT_DIR . $file_name;

$fp = fopen($filepath, "w");

$head = ["id", "name", "role", "登録日"];
fputcsv($fp, $head);

foreach ($decoded_data as $row) {
    $data = [
        $row["id"],
        $row["last_name"] . " " . $row["first_name"],
        $row["role"],
        $row["created_at"]
    ];

    fputcsv($fp, $data);
    
    // ロックファイルへの経過書き込み
    $count++; 
    $progress = [WIP, $total, $count, time()];
    rewind($lockFp);
    fputcsv($lockFp, $progress);
}

fclose($fp);

// ロックファイルへの書き込み
$progress = [FINISH, $total, $count, time()];
rewind($lockFp);
fputcsv($lockFp, $progress);

fclose($lockFp);

echo $file_name;

?>