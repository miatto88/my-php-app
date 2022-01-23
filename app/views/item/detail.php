<?php
require_once(dirname(__FILE__) . "/../../models/Item.php");
require_once(dirname(__FILE__) . "/../../controllers/ItemController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");
// require_once("../../models/member.php");
require_once(dirname(__FILE__) . "/../../util/Function.php");

$controller = new ItemController;

// if ($_SESSION["member"]["role"] === Member::ROLE_GUEST) { // ゲスト用のロールに定数を使用
//     $hidden_a_tag = 'style="color:grey; pointer-events:none;"';
//     $disable_button = "disabled";
// }

$item = $controller->detail();

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
            <div class="btns">
                <a href="edit.php?id=<?php echo h($item["id"]) ?>" class="<?php if($_SESSION["member"]["role"] === Member::ROLE_GUEST): ?>guest<?php endif; ?>">製品編集</a>
            </div>
            <hr>
            <div class="detail">
                <div>
                    <?php echo h("製品名　　　　：　　" . $item["name"]); ?>
                </div>
                <div>
                    <?php echo h("価格　　　　　：　　" . $item["price"]); ?>
                </div>
                <div>
                    <?php echo h("在庫　　　　　：　　" . $item["stock"]); ?>
                </div>
                <div>
                    <?php echo h("登録日　　　　：　　" . $item["created_at"]); ?>
                </div>
                <div>
                    <?php echo h("最終更新日　　：　　" . $item["updated_at"]); ?>
                </div>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php"); ?>
    </div>
</body>
</html>