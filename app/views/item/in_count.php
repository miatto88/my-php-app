<?php
require_once(dirname(__FILE__) . "/../../models/StockInHistory.php");
require_once(dirname(__FILE__) . "/../../controllers/StockInHistoryController.php");
require_once(dirname(__FILE__) . "/../../controllers/ItemController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");
require_once(dirname(__FILE__) . "/../../util/Function.php");

$stock_in_controller = new StockInHistoryController;

$item_controller = new ItemController;
$data = $item_controller->index();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $get = $stock_in_controller->new();
    $errors = [];

    session_start();
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    
        unset($_SESSION["errors"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POSTが送信された時は store() を呼び出す処理
    $stock_in_controller->store();
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
            <span><?php echo h("ログイン名： " . $_SESSION["member"]["name"]); ?></span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div>[入庫処理]</div>
            <p>
                <span>製品名　：　</span>
                <select onChange="top.location.href=value" name="name" id="">
                    <option value=""><?php echo h($item["name"]); ?></option>
                    <?php foreach ($data["items"] as $item): ?>
                    <option value="in_count.php?id=<?php echo h($item["id"]); ?>"><?php echo h($item["name"]); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div>
                <form action="" method="post">
                    <p>入庫数　：　 <input type="number" name="quantity" value="<?php echo h($get["quantity"]) ?>"></p>
                    <p><input type="hidden" name="item_id" value="<?php echo h($_GET["id"]) ?>"></p>
                    <p><input type="hidden" min="0" name="member_id" value="<?php echo h($_SESSION["member"]["id"]) ?>"></p>
                    <p><input type="hidden" name="created_at"></p>
                    <p><input type="hidden" name="updated_at"></p>
                    <p><input type="submit" value="入庫する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo h($error); ?></p>
                <?php endforeach ?>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php") ?>
    </div>
</body>
</html>