<?php
require_once("../../controllers/AuthController.php");
require_once("../../validations/Authvalidation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $member = AuthController::auth();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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
            <div class="form-group">
                <input type="text" name="last_name" maxlength="50" placeholder="姓" class="form-control col-sm-5" value="<?php echo $get["last_name"] ?>">
                <input type="text" name="first_name" maxlength="50" placeholder="名" class="form-control col-sm-5" value="<?php echo $get["first_name"] ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" maxlength="100" placeholder="パスワード" class="form-control form-control" value="<?php echo $get["password"] ?>">
            </div>
            <div class="form-group">
                <input class="btn btn-outline-primary my-1" type="submit" class="form-control" value="ログイン">
                <a class="btn btn-outline-secondary my-1" class="form-control" href="../member/mail_form.php" value="新規登録">新規登録</a>
            </div>
        </form>
        </br>
        <form class="login-form" action="../item/guest/index.php" method="post">
            <p class="form-group">
                <input class="btn btn-outline-success my-1" type="submit" class="form-control" value="ゲストログイン">
            </p>
        </form>
        <p>
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </p>
    </div>
</body>
</html>