<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");
require_once("../../validations/Itemvalidation.php");


// 変更 POST以外が送信された時は new() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $get = ItemController::new();

    // validationがNGでリダイレクトされた時のメッセージ
    if (!empty($get)) {
        $error = "入力に不正があった為、登録に失敗しました。";
    } else {
        $error = "";
    }
}

// 変更 POSTが送信された時は store() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $check = ItemValidation::check();
    
    // validationがNGだった場合にはリダイレクト
    if ($check === false) {
        header("Location: new.php?name=" . $get["name"] . "&price=" . $get["price"] . "&stock=" . $get["stock"]);
        return;
    }

    ItemController::store();
}

// 変更 GETが空の時のvalue値を空白に設定する
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
            <span><?php echo "ログイン名： "; ?></span>
            <span><a href="#">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div>
                <form action="" method="POST">
                    <p>製品名：　<input type="text" name="name" value="<?php echo $get['name'] ?>"></p>
                    <p>価格　：　<input type="number" name="price" value="<?php echo $get['price'] ?>"></p>
                    <p>在庫　：　<input type="number" name="stock" value="<?php echo $get['stock'] ?>"></p>
                    <p><input type="hidden" name="created_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="hidden" name="updated_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="submit" value="登録する"></p>
                </form>
            </div>
            <div><p><?php echo $error ?></p></div>
        </section>
        <?php readfile("../layout/sidemenu.php") ?>
    </div>
</body>
</html>