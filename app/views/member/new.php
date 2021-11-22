<?php
require_once(dirname(__FILE__) . "/../../models/Member.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $member = AuthController::store();
}

if ($_SERVER["REQUEST_METHOD"]  !== "POST") {
    $get = AuthController::index();

    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    
        unset($_SESSION["errors"]);
    } else {
        $errors = [];
    }
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
                姓：<input type="text" name="last_name" value="<?php echo $get["last_name"] ?>">
            </div>
            <div>
                名：<input type="text" name="first_name" value="<?php echo $get["first_name"] ?>">
            </div>
            <div>
                パスワード：<input type="password" name="password" size="10" value="<?php echo $get["password"] ?>">
            </div>
            <div class="form-group">
                <input class="btn btn-outline-primary my-1" type="submit" class="form-control" value="登録">
            </div>
            <p>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </p>
        </form>
    </div>
</body>
</html>