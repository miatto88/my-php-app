<?php
require_once(dirname(__FILE__) . "/../../models/item.php");
require_once(dirname(__FILE__) . "/../../controllers/ItemController.php");
require_once(dirname(__FILE__) . "/../../validations/Itemvalidation.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new ItemController;

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
if (empty($get["name"])) {
    $get["name"] = "";
}
if (empty($get["price"])) {
    $get["price"] = "";
}
if (empty($get["stock"])) {
    $get["stock"] = "";
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
            <div>[製品登録]</div>
            <div>
                <form action="" method="POST">
                    <p>製品名：　<input type="text" name="name" value="<?php echo $get['name'] ?>"></p>
                    <p>価格　：　<input type="number" min="0" name="price" value="<?php echo $get['price'] ?>"></p>
                    <p>在庫　：　<input type="number" min="0" name="stock" value="<?php echo $get['stock'] ?>"></p>
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