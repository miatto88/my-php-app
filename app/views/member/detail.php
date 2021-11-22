<?php
require_once(dirname(__FILE__) . "/../../models/Member.php");
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");
// require_once("../../models/member.php");

$controller = new MemberController;

// if ($_SESSION["member"]["role"] === Member::ROLE_GUEST) { // ゲスト用のロールに定数を使用
//     $hidden_a_tag = 'style="color:grey; pointer-events:none;"';
//     $disable_button = "disabled";
// }

$member = $controller->detail();

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
            <span><?php echo "ログイン名： " . $_SESSION["member"]["name"]; ?></span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div class="btns">
                <a href="edit.php?id=<?php echo $member["id"] ?>" class="<?php if($_SESSION["member"]["role"] === Member::ROLE_GUEST): ?>guest<?php endif; ?>">社員編集</a>
            </div>
            <hr>
            <div class="detail">
                <div>
                    <?php echo "姓　　　　　　：　　" . $member["last_name"]; ?>
                </div>
                <div>
                    <?php echo "姪　　　　　　：　　" . $member["first_name"]; ?>
                </div>
                <div>
                    <?php echo "権限　　　　　：　　" . Member::showRole($member); ?>
                </div>
                <div>
                    <?php echo "登録日　　　　：　　" . $member["created_at"]; ?>
                </div>
                <div>
                    <?php echo "最終更新日　　：　　" . $member["updated_at"]; ?>
                </div>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php"); ?>
    </div>
</body>
</html>