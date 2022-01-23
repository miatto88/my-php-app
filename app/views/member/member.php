<?php
require_once(dirname(__FILE__) . "/../../models/Member.php");
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");
require_once(dirname(__FILE__) . "/../../util/Function.php");

$controller = new MemberController;

$data = $controller->index();

$is_admin = $data["is_admin"];
$is_guest = $data["is_guest"];

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
                <a href="store.php" class="<?php if(!$is_admin): ?>not_admin<?php endif; ?>">社員登録</a>
            </div>
            <hr>
            <div>
                <button data-btn-type="ajax" <?php if($is_guest): ?>disabled<?php endif; ?>>CSV出力</button>
                <div class="progress">
                    <button class="download" onclick="location.href='download.php'" disabled>出力待機</button>
                </div>
                <div class="file_name"></div>
            </div>
            <span class="messages"></span>
            <hr>
            <?php foreach($data["members"] as $data): ?>
            <div class="member_data" id=<?php echo h("member_id_" . $data["id"]) ?>>
                <div class="member_name">
                    <a href="detail.php?id=<?php echo h($data["id"]) ?>" ><?php echo h($data["last_name"] . " " . $data["first_name"]); ?></a>
                </div>
                <div class="member_role">
                    <span>権限：<?php echo h(Member::showRole($data)); ?></span>
                </div>
                <hr>
            </div>
            <?php endforeach; ?>
            <p>
        </p>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php"); ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/createCsv.js"></script>
</body>
</html>