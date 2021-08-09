<?php
require_once("../../models/item.php");


$sqldata = new Item();
$items = $sqldata->findAll();
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
            <?php $i = 0 ?>
            <?php while ($i < count($items)): ?>
            <div class="item_name">
                <a href="#"><?php echo $items[$i]["name"]; ?></a>
            </div>
            <div class="item_property">
                <span>在庫：<?php echo $items[$i]["stock"]; ?></span>
            </div>
            <div class="button">
                <form method="post">
                    <button type="submit" formaction="in_count.php">入庫</button>
                    <button type="submit" formaction="out_count.php">出庫</button>
                </form>
            </div>
            <hr>
            <?php $i++ ?>
            <?php endwhile; ?>
        </section>
        <section class="side">
            <span class="side_menu active"><a href="index.php">製品一覧</a></span>
            <span class="side_menu"><a href="items.php">製品マスタ</a></span>
            <span class="side_menu"><a href="storing.php">入庫処理</a></span>
            <span class="side_menu"><a href="shipping.php">出庫処理</a></span>
            <span class="side_menu"><a href="customerlist.php">顧客マスタ</a></span>
            <span class="side_menu"><a href="member.php">社員マスタ</a></span>
        </section>
    </div>
</body>
</html>