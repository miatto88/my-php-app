<?php

const START = 1;
const WIP = 2;
const FINISH = 3;

const EXPORT_DIR = "/var/tmp/";

try {
    $dsn = "mysql:host=my-php-app_mysql_1;dbname=common;charset=utf8";
    $dbh = new PDO($dsn, "root", "miatto");
} catch (PDOException $e) {
    echo "DB接続エラー: " . $e->getMessage();
}

$members = $dbh->query("SELECT * FROM members");
$members = $members->fetchAll();

// ロックファイルの作成
$total = count($members);
$count = 0;
$progress = [START, $total, $count, time()];

$lockFp = fopen(EXPORT_DIR . "lock.csv", "w+");
if (flock($lockFp, LOCK_EX)) {
    fputcsv($lockFp, $progress);

    flock($lockFp, LOCK_UN);
} else {
    echo "ファイルロックに失敗しました";
}

// ダウンロード用CSV作成
$today = date("YmdHi");
$file_name = "members_" . $today . ".csv";

$filepath = EXPORT_DIR . $file_name;

$fp = fopen($filepath, "w");

$head = ["id", "name", "role", "登録日"];
fputcsv($fp, $head);

foreach ($members as $row) {
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
    if (flock($lockFp, LOCK_EX)) {
        rewind($lockFp);
        fputcsv($lockFp, $progress);
        flock($lockFp, LOCK_UN);
    } else {
        echo "ファイルロックに失敗しました";
    }
}

fclose($fp);

// ロックファイルへの書き込み
$progress = [FINISH, $total, $count, time()];
if (flock($lockFp, LOCK_EX)) {
    rewind($lockFp);
    fputcsv($lockFp, $progress);
    flock($lockFp, LOCK_UN);
} else {
    echo "ファイルロックに失敗しました";
}

fclose($lockFp);

echo $file_name;

?>