<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");
require_once("../../validations/Itemvalidation.php");

// POST以外が送信された時は edit() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $item = ItemController::edit();

    // validationがNGでリダイレクトされた時のメッセージ
    if ($_GET["error"] === "1") {
        $error = "入力に不正があった為、登録に失敗しました。";
    } else {
        $error = "";
    }
}

// POSTが送信された時は update() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    ItemController::update();
}

// GETが空の時のvalue値を空白に設定する
// if (empty($$item["name"])) {
//     $$item["name"] = "";
// }
// if (empty($$item["price"])) {
//     $$item["price"] = "";
// }
// if (empty($$item["stock"])) {
//     $$item["stock"] = "";
// }

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
            <div>[製品編集]</div>
            <div>
                <form action="" method="POST">
                    <p>製品名：　<input type="text" name="name" value="<?php echo $item['name'] ?>"></p>
                    <p>価格　：　<input type="number" name="price" value="<?php echo $item['price'] ?>"></p>
                    <p>在庫　：　<input type="number" name="stock" value="<?php echo $item['stock'] ?>"></p>
                    <p><input type="submit" value="更新する"></p>
                </form>
            </div>
            <div><p><?php echo $error ?></p></div>
        </section>
        <?php readfile("../layout/sidemenu.php") ?>
    </div>
</body>
</html>