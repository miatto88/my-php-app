<?php
require_once("../../models/member.php");
require_once("../../controllers/AuthController.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $member = AuthController::store();

}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    
    <title>在庫管理システム</title>
</head>
<body>
    <!-- <header> -->
        <h1 class="login-title">在庫管理システム</h1>
    <!-- </header> -->
    <div class="login-wrapper">
        <form class="login-form" action="" method="post">
            <div>
            姓：<input type="text" name="last_name">
            </div>
            <div>
            名：<input type="text" name="first_name">
            </div>
            <div>
            パスワード：<input type="password" name="password" size="10">
            </div>
            <div class="form-group">
                <input class="btn btn-outline-primary my-1" type="submit" class="form-control" value="登録">
            </div>
        </form>
    </div>
</body>
</html>