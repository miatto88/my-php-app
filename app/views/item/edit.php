<?php
require_once(dirname(__FILE__) . "/../../models/Item.php");
require_once(dirname(__FILE__) . "/../../controllers/ItemController.php");
require_once(dirname(__FILE__) . "/../../validations/Itemvalidation.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");
require_once(dirname(__FILE__) . "/../../util/Function.php");

$controller = new ItemController;

// POSTが送信された時は update() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->update();
}

// POST以外が送信された時は edit() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $item = $controller->edit();
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
            <span><?php echo h("ログイン名： " . $_SESSION["member"]["name"]); ?></span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div>[製品編集]</div>
            <div>
                <form action="" method="POST">
                    <p>製品名：　<input type="text" name="name" value="<?php echo h($item["input"]['name']) ?>"></p>
                    <p>価格　：　<input type="number" min="0" name="price" value="<?php echo h($item["input"]['price']) ?>"></p>
                    <p>在庫　：　<input type="number" min="0" name="stock" value="<?php echo h($item["input"]['stock']) ?>"></p>
                    <p><input type="submit" value="更新する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo h($error); ?></p>
                <?php endforeach ?>
            </div>
            <hr>
            <div>
                <div>
                    <p>[製品情報]</p>
                </div>
                <div>
                    <?php echo h("製品名　　　　：　　" . $item["master"]["name"]); ?>
                </div>
                <div>
                    <?php echo h("価格　　　　　：　　" . $item["master"]["price"]); ?>
                </div>
                <div>
                    <?php echo h("在庫　　　　　：　　" . $item["master"]["stock"]); ?>
                </div>
                <div>
                    <?php echo h("登録日　　　　：　　" . $item["master"]["created_at"]); ?>
                </div>
                <div>
                    <?php echo h("最終更新日　　：　　" . $item["master"]["updated_at"]); ?>
                </div>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php") ?>
    </div>
</body>
</html>