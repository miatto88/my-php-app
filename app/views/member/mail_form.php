<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");
require_once("../../validations/Itemvalidation.php");
require_once("../../controllers/AuthController.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    AuthController::sendMail();

    // if (isset($_SESSION["errors"])) {
    //     $errors = $_SESSION["errors"];
    
    //     unset($_SESSION["errors"]);
    // } else {
    //     $errors = [];
    // }
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
        <form class="login-form" action="" method="get">
            <p>メールアドレスを入力してください</p>            
            <input type="text" name="mail_address" size="30" placeholder="xxx@xxxx.xx">
            <div class="form-group">
                <input class="btn btn-outline-primary my-1" type="submit" class="form-control" value="送信">
            </div>
        </form>
    </div>
</body>
</html>