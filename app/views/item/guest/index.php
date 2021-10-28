<?php
require_once("../../../models/item.php");
require_once("../../../controllers/ItemController.php");
require_once("../../../controllers/AuthController.php");

$controller = new ItemController;

$items = $controller->index();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../../css/style.css">
    
    <title>在庫管理システム</title>
</head>
<body>
    <header>
        <h1>在庫管理システム</h1>
        <div class="header-info">
            <span>ログイン名： ゲストアカウント</span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div class="btns">
                <a href="new.php" >製品登録</a>
            </div>
            <span class="messages"></span>
            <hr>
            <?php foreach($items as $item): ?>
            <div class="item_data" id=<?php echo "item_id_" . $item["id"] ?>>
                <div class="item_name">
                    <a href="detail.php?id=<?php echo $item["id"] ?>" ><?php echo $item["name"]; ?></a>
                </div>
                <div class="item_property">
                    <span>在庫：<?php echo $item["stock"]; ?></span>
                </div>
                <div class="button">
                    <a href="in_count.php?id=<?php echo $item["id"] ?>">入庫</a>
                    <a href="out_count.php?id=<?php echo $item["id"] ?>">出庫</a>
                    <button data-btn-type="ajax" value="<?php echo $item["id"] ?>">削除</button>
                </div>
                <hr>
            </div>
            <?php endforeach; ?>
            <p>
        </p>
        </section>
        <?php readfile("../../layout/sidemenu.php") ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/api.js"></script>
</body>
</html>