<?php
require_once(dirname(__FILE__) . "/../../models/Member.php");
require_once(dirname(__FILE__) . "/../../controllers/MemberController.php");
require_once(dirname(__FILE__) . "/../../validations/Membervalidation.php");
require_once(dirname(__FILE__) . "/../../controllers/AuthController.php");

$controller = new MemberController;

// POSTが送信された時は update() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->store();
}

// POST以外が送信された時は edit() を呼び出す処理
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $member = $controller->new();
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
            <span><?php echo "ログイン名： " . $_SESSION["member"]["name"]; ?></span>
            <span><a href="../auth/logout.php">ログアウト</a></span>
        </div>
    </header>
    <div class="wrapper">
        <section class="main">
            <div>[社員編集]</div>
            <div>
                <form action="" method="POST">
                    <p>姓　　　　　：　<input type="text" name="last_name" value="<?php echo $member["input"]['last_name'] ?>"></p>
                    <p>名　　　　　：　<input type="text" name="first_name" value="<?php echo $member["input"]['first_name'] ?>"></p>
                    <p>パスワード　：　<input type="text" name="password" value="<?php echo $member["input"]['password'] ?>"></p>
                    <p>管理者権限　：　<input type="radio" name="role" value="<?php echo Member::ROLE_USER; ?>" checked>ユーザー
                        <input type="radio" name="role" value="<?php echo Member::ROLE_ADMIN; ?>">管理者
                    </p>
                    <p><input type="submit" value="登録する"></p>
                </form>
            </div>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach ?>
            </div>
        </section>
        <?php include(dirname(__FILE__) . "/../layout/sidemenu.php") ?>
    </div>
</body>
</html>