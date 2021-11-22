<?php
require_once(dirname(__FILE__) . "/../../models/Member.php");
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new MemberController;

$is_guest = AuthController::isGuest();

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     if (isset($_POST["item_name"])) {
//         $items = $controller->serchName();
//     }
    
//     if (isset($_POST["min_stock"]) && isset($_POST["max_stock"])) {
//         $items = $controller->serchStock();
//     }
// }

// if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//     $items = $controller->index();
    
//     $serch = $_SESSION["serch"];
//     unset($_SESSION["serch"]);
// }

$members = $controller->index();
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
                <a href="mail_form.php" class="<?php if($is_guest): ?>guest<?php endif; ?>">社員登録</a>
            </div>
            <span class="messages"></span>
            <hr>
            <?php foreach($members as $member): ?>
            <div class="member_data" id=<?php echo "member_id_" . $member["id"] ?>>
                <div class="member_name">
                    <a href="detail.php?id=<?php echo $member["id"] ?>" ><?php echo $member["last_name"] . " " . $member["first_name"]; ?></a>
                </div>
                <div class="member_role">
                    <span>権限：<?php echo Member::showRole($member); ?></span>
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
    <script type="text/javascript" src="../../js/api.js"></script>
</body>
</html>