<?php
require_once(dirname(__FILE__) . "/../../models/Customer.php");
require_once(dirname(__FILE__) . "/../../controllers/CustomerController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new CustomerController;

$is_admin = AuthController::isAdmin();

$customer = $controller->detail();
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
            <div class="btns">
                <a href="edit.php?id=<?php echo $customer["id"] ?>" class="<?php if(!$is_admin): ?>not_admin<?php endif; ?>">顧客編集</a>
            </div>
            <hr>
            <div class="detail">
                <div>
                    <?php echo "会社名　　　　　：　　" . $customer["company"]; ?>
                </div>
                <div>
                    <?php echo "電話番号　　　　：　　" . $customer["phone"]; ?>
                </div>
                <div>
                    <?php echo "FAX番号　　　　：　　" . $customer["fax"]; ?>
                </div>
                <div>
                    <?php echo "郵便番号　　　　：　　" . $customer["zip_code"]; ?>
                </div>
                <div>
                    <?php echo "住所　　　　　　：　　" . $customer["state/province"] . $customer["city"] . $customer["address_1"] . $customer["address_2"]; ?>
                </div>
                <div>
                    <?php echo "相手先担当者　　：　　" . $customer["last_name"] . " " . $customer["first_name"]; ?>
                </div>
                <div>
                    <?php echo "登録日　　　　　：　　" . $customer["created_at"]; ?>
                </div>
                <div>
                    <?php echo "最終更新日　　　：　　" . $customer["updated_at"]; ?>
                </div>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php"); ?>
    </div>
</body>
</html>