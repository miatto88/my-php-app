<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");

$item = ItemController::detail();

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
            <div class="detail">
                <div>
                    <?php echo "製品名　　　　：　　" . $item["name"]; ?>
                </div>
                <div>
                    <?php echo "価格　　　　　：　　" . $item["price"]; ?>
                </div>
                <div>
                    <?php echo "在庫　　　　　：　　" . $item["stock"]; ?>
                </div>
                <div>
                    <?php echo "登録日　　　　：　　" . $item["created_at"]; ?>
                </div>
                <div>
                    <?php echo "最終更新日　　：　　" . $item["updated_at"]; ?>
                </div>
            </div>
        </section>
        <?php readfile("../layout/sidemenu.php") ?>
    </div>
</body>
</html>