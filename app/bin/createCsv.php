<?php

const EXPORT_DIR = "/var/tmp/";

$encoded_data = $argv[1];
$decoded_data = json_decode($encoded_data, true);

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
}

fclose($fp);

echo $file_name;

?>