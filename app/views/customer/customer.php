<?php
require_once(dirname(__FILE__) . "/../../models/Customer.php");
require_once(dirname(__FILE__) . "/../../controllers/CustomerController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new CustomerController;

// $is_guest = AuthController::isGuest();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $controller->index();
    // if (isset($_POST["item_name"])) {
    //     $items = $controller->serchName();
    // }
    
    // if (isset($_POST["min_stock"]) && isset($_POST["max_stock"])) {
    //     $items = $controller->serchStock();
    // }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $data = $controller->index();
    
    // $serch = $_SESSION["serch"];
    // unset($_SESSION["serch"]);
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
            <div class="btns">
                <a href="new.php" class="<?php if($is_guest): ?>guest<?php endif; ?>">顧客登録</a>
            </div>
            <span class="messages"></span>
            <hr>
            <div class="serch_form">
                <label for="acd_menu">検索 ▽　</label>
                <?php echo $serch ?>
                <input type="checkbox" id="acd_menu" class="acd_menu">
                <div class="acd_content">
                    <form class="serch_form" action="" method="post">
                        <div class="serch_name">
                            製品名　　　　　<input type="text" name="item_name">
                            <input type="submit" value="製品名で検索">
                        </div>
                    </form>
                    <form class="serch_form" action="" method="post">
                        <div>
                            在庫数（範囲）　<input type="number" class="serch_stock" name="min_stock"> 〜 <input type="number" class="serch_stock" name="max_stock">
                            <input type="submit" value="在庫数で検索">
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <?php foreach($data["customers"] as $customer): ?>
            <div class="customer_data" id=<?php echo "customer_id_" . $customer["id"] ?>>
                <div class="customer_name">
                    <a href="detail.php?id=<?php echo $customer["id"] ?>" ><?php echo $customer["company"]; ?></a>
                </div>
                <div class="customer_contacts">
                    <span>TEL：<?php echo $customer["phone"]; ?></span>
                    <span>　FAX：<?php echo $customer["fax"]; ?></span>
                </div>
                <hr>
            </div>
            <?php endforeach; ?>
            <p>
        </p>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php"); ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/api.js"></script>
</body>
</html>