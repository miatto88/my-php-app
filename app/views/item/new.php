<?php
require_once("../../models/item.php");
require_once("../../controllers/ItemController.php");

ItemController::request();

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
                    <p>製品名：　<input type="text" name="name"></p>
                    <p>価格　：　<input type="number" name="price"></p>
                    <p>在庫　：　<input type="number" name="stock"></p>
                    <p><input type="hidden" name="created_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="hidden" name="updated_at" value="<?php echo date("Y-m-d H:i:s") ?>"></p>
                    <p><input type="submit" value="登録する"></p>
                </form>
            </div>
        </section>
        <?php readfile("../layout/sidemenu.php") ?>
    </div>
</body>
</html>