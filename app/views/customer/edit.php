<?php
require_once(dirname(__FILE__) . "/../../models/Customer.php");
require_once(dirname(__FILE__) . "/../../controllers/CustomerController.php");
// require_once(dirname(__FILE__) . "/../../validations/Customervalidation.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new CustomerController;

// POSTが送信された時は update() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->update();
}

// POST以外が送信された時は edit() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $customer = $controller->edit();
    $errors = [];

    // バリデーションエラー時にセッションを取得する処理を追加
    session_start();
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    
        unset($_SESSION["errors"]);
    }
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
            <div>[顧客編集]</div>
            <div>
                <form action="" method="POST">
                    <p>会社名　　　：　<input type="text" name="company" value="<?php echo $customer["input"]['company'] ?>"></p>
                    <p>電話番号　　：　<input type="number" min="0" name="phone" value="<?php echo $customer["input"]['phone'] ?>"></p>
                    <p>FAX番号　　：　<input type="number" min="0" name="fax" value="<?php echo $customer["input"]['fax'] ?>"></p>
                    <p>郵便番号　　：　<input type="number" min="0" name="zip_code" value="<?php echo $customer["input"]['zip_code'] ?>"></p>
                    <p>都道府県　　：　<input type="text" name="state/province" value="<?php echo $customer["input"]['state/province'] ?>"></p>
                    <p>市区　　　　：　<input type="text" name="city" value="<?php echo $customer["input"]['city'] ?>"></p>
                    <p>町・番地　　：　<input type="text" name="address_1" value="<?php echo $customer["input"]['address_1'] ?>"></p>
                    <p>建物名　　　：　<input type="text" name="address_2" value="<?php echo $customer["input"]['address_2'] ?>"></p>
                    <p>担当者（姓）：　<input type="text" name="last_name" value="<?php echo $customer["input"]['last_name'] ?>"></p>
                    <p>担当者（名）：　<input type="text" name="first_name" value="<?php echo $customer["input"]['first_name'] ?>"></p>
                    <p><input type="submit" value="更新する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach ?>
            </div>
            <hr>
            <div>
                <div>
                    <p>[顧客情報]</p>
                </div>
                <div>
                    <?php echo "会社名　　　　　：　　" . $customer["master"]["company"]; ?>
                </div>
                <div>
                    <?php echo "電話番号　　　　：　　" . $customer["master"]["phone"]; ?>
                </div>
                <div>
                    <?php echo "FAX番号　　　　：　　" . $customer["master"]["fax"]; ?>
                </div>
                <div>
                    <?php echo "郵便番号　　　　：　　" . $customer["master"]["zip_code"]; ?>
                </div>
                <div>
                    <?php echo "住所　　　　　　：　　" . $customer["master"]["state/province"] . $customer["master"]["city"] . $customer["master"]["address_1"] . $customer["master"]["address_2"]; ?>
                </div>
                <div>
                    <?php echo "相手先担当者　　：　　" . $customer["master"]["last_name"] . " " . $customer["master"]["first_name"]; ?>
                </div>
                <div>
                    <?php echo "登録日　　　　　：　　" . $customer["master"]["created_at"]; ?>
                </div>
                <div>
                    <?php echo "最終更新日　　　：　　" . $customer["master"]["updated_at"]; ?>
                </div>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php") ?>
    </div>
</body>
</html>