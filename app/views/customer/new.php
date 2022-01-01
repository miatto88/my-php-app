<?php
require_once(dirname(__FILE__) . "/../../models/Customer.php");
require_once(dirname(__FILE__) . "/../../controllers/CustomerController.php");
// require_once(dirname(__FILE__) . "/../../validations/Customervalidation.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new CustomerController;

// POST以外が送信された時は new() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $get = $controller->new();
    $errors = [];

    // validationがNGでリダイレクトされた時のメッセージ(仮)
    if (!empty($get)) {
        $errors[] = "入力に不正があった為、登録に失敗しました。";
    }

    session_start();
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    
        unset($_SESSION["errors"]);
    }
}

// POSTが送信された時は store() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->store();
}

// GETが空の時のvalue値を空白に設定する
if (empty($get["company"])) {
    $get["company"] = "";
}
if (empty($get["phone"])) {
    $get["phone"] = "";
}
if (empty($get["fax"])) {
    $get["fax"] = "";
}
if (empty($get["zip_code"])) {
    $get["zip_code"] = "";
}
if (empty($get["state/province"])) {
    $get["state/province"] = "";
}
if (empty($get["city"])) {
    $get["city"] = "";
}
if (empty($get["address_1"])) {
    $get["address_1"] = "";
}
if (empty($get["address_2"])) {
    $get["address_2"] = "";
}
if (empty($get["first_name"])) {
    $get["first_name"] = "";
}
if (empty($get["last_name"])) {
    $get["last_name"] = "";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../css/style.css">
    
    <title>在庫管理システム</title>
</head>
<body>
    <header>
        <h1>在庫管理システム</h1>
        <div class="header-info">
            <span><?php echo "ログイン名： " . $_SESSION["member"]["name"]; ?></span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div>[顧客登録]</div>
            <div>
                <form action="" method="POST">
                    <p>会社名　　　：　<input type="text" name="company" value="<?php echo $get['company'] ?>"></p>
                    <p>電話番号　　：　<input type="text" name="phone" value="<?php echo $get['phone'] ?>"></p>
                    <p>FAX番号　　：　<input type="text" name="fax" value="<?php echo $get['fax'] ?>"></p>
                    <p>郵便番号　　：　<input type="text" name="zip_code" value="<?php echo $get['zip_code'] ?>"></p>
                    <p>都道府県　　：　<input type="text" name="state_province" value="<?php echo $get['state_province'] ?>"></p>
                    <p>市区　　　　：　<input type="text" name="city" value="<?php echo $get['city'] ?>"></p>
                    <p>町・番地　　：　<input type="text" name="address_1" value="<?php echo $get['address_1'] ?>"></p>
                    <p>建物名　　　：　<input type="text" name="address_2" value="<?php echo $get['address_2'] ?>"></p>
                    <p>担当者（姓）：　<input type="text" name="last_name" value="<?php echo $get['last_name'] ?>"></p>
                    <p>担当者（名）：　<input type="text" name="first_name" value="<?php echo $get['first_name'] ?>"></p>
                    <p><input type="hidden" name="created_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="hidden" name="updated_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="submit" value="登録する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach ?>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php") ?>
    </div>
</body>
</html>