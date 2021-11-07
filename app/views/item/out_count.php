<?php
require_once("../../models/StockOutHistory.php");
require_once("../../controllers/StockOutHistoryController.php");
require_once("../../controllers/ItemController.php");
require_once("../../controllers/CustomerController.php");
require_once("../../controllers/AuthController.php");

$stock_out_controller = new StockOutHistoryController;

$item_controller = new ItemController;
$items = $item_controller->index();

$customer_controller = new CustomerController;
$customers = $customer_controller->index();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $get = $stock_out_controller->new();
    $errors = [];

    session_start();
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    
        unset($_SESSION["errors"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POSTが送信された時は store() を呼び出す処理

    $stock_out_controller->store();
}

if (!empty($_GET["id"])) {
    $item = $item_controller->detail();
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
            <div>[出庫処理]</div>
            <p>
                <span>製品名　：　</span>
                <select onChange="top.location.href=value" name="name" id="">
                    <option value=""><?php echo $item["name"]; ?></option>
                    <?php foreach ($items as $item): ?>
                    <option value="out_count.php?id=<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div>
                <form action="" method="post">
                    <p>出庫数　：　 <input type="number" name="quantity" value="<?php echo $get["quantity"] ?>"></p>
                    <p>出庫先　：　
                        <select name="customer_id">
                            <option value=""><?php echo $customer["company"]; ?></option>
                            <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer["id"]; ?>"><?php echo $customer["company"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p><input type="hidden" name="item_id" value="<?php echo $_GET["id"] ?>"></p>
                    <p><input type="hidden" min="0" name="member_id" value="<?php echo $_SESSION["member"]["id"] ?>"></p>
                    <p><input type="hidden" name="created_at"></p>
                    <p><input type="hidden" name="updated_at"></p>
                    <p><input type="submit" value="出庫する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach ?>
            </div>
        </section>
        <?php include("../layout/sidemenu.php") ?>
    </div>
</body>
</html>