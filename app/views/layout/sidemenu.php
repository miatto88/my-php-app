<?php if ($_SESSION["member"]["role"] === Member::ROLE_GUEST): ?>
    <section class="side">
        <span class="side_menu active"><a href="index.php">製品一覧</a></span>
        <span class="side_menu"><a href="items.php" style="color:grey; pointer-events:none;">製品マスタ</a></span>
        <span class="side_menu"><a href="in_count.php" style="color:grey; pointer-events:none;">入庫処理</a></span>
        <span class="side_menu"><a href="out_count.php" style="color:grey; pointer-events:none;">出庫処理</a></span>
        <span class="side_menu"><a href="customerlist.php" style="color:grey; pointer-events:none;">顧客マスタ</a></span>
        <span class="side_menu"><a href="member.php" style="color:grey; pointer-events:none;">社員マスタ</a></span>
    </section>

<?php else: ?>
    <section class="side">
        <span class="side_menu active"><a href="index.php">製品一覧</a></span>
        <span class="side_menu"><a href="items.php">製品マスタ</a></span>
        <span class="side_menu"><a href="in_count.php">入庫処理</a></span>
        <span class="side_menu"><a href="out_count.php">出庫処理</a></span>
        <span class="side_menu"><a href="customerlist.php">顧客マスタ</a></span>
        <span class="side_menu"><a href="member.php">社員マスタ</a></span>
    </section>

<?php endif;?>
