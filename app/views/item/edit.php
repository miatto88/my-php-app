<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");
require_once("../../validations/Itemvalidation.php");

// POSTが送信された時は update() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    ItemController::update();
}

// POST以外が送信された時は edit() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $item = ItemController::edit();

    // 変更 バリデーションエラー時にセッションを取得する処理を追加
    session_start();
    if (isset($_SESSION["error"])) {
        $error = $_SESSION["error"];
    
        unset($_SESSION["error"]);
        session_destroy();
    }
}

// 編集しようとしている製品の現在の情報を呼び出すする処理
// $item = ItemController::detail();

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
                    <p>製品名：　<input type="text" name="name" value="<?php echo $item["input"]['name'] ?>"></p>
                    <p>価格　：　<input type="number" name="price" value="<?php echo $item["input"]['price'] ?>"></p>
                    <p>在庫　：　<input type="number" name="stock" value="<?php echo $item["input"]['stock'] ?>"></p>
                    <p><input type="submit" value="更新する"></p>
                </form>
            </div>
            <div>
                <p><?php echo $error ?></p>
            </div>
            <hr>
            <div>
                <div>
                    <p>[製品情報]</p>
                </div>
                <div>
                    <?php echo "製品名　　　　：　　" . $item["master"]["name"]; ?>
                </div>
                <div>
                    <?php echo "価格　　　　　：　　" . $item["master"]["price"]; ?>
                </div>
                <div>
                    <?php echo "在庫　　　　　：　　" . $item["master"]["stock"]; ?>
                </div>
                <div>
                    <?php echo "登録日　　　　：　　" . $item["master"]["created_at"]; ?>
                </div>
                <div>
                    <?php echo "最終更新日　　：　　" . $item["master"]["updated_at"]; ?>
                </div>
            </div>
        </section>
        <?php readfile("../layout/sidemenu.php") ?>
    </div>
</body>
</html>