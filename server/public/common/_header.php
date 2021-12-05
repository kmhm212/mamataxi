<?php

require_once __DIR__ . '/../../common/functions.php';

$id = $_SESSION['id'];
$next_reserve = findReserveByUserId($id)[0]['departure_time'];
$arr_week = ['日', '月', '火', '水', '木', '金', '土'];

?>

<header>
    <div class="headerMenu wrapper">
        <div class="title">
            <h1>
                <a href="../index.php" class="logo">
                    ママさんタクシー
                </a>
            </h1>
        </div>
        <nav>
            <div class="navSideL">
                <a href="" class="button">使い方</a>
            </div>
            <!-- マイページorログイン -->
            <div class="navSideC">
                <?php if($_SESSION['id']): ?>
                    <a href="../mypage/mypage.php" class="button">マイページ</a>
                    <a href="/common/logout.php" class="button">ログアウト</a>
                <?php else : ?>
                    <a href="/common/login.php"  class="button">ログイン</a>
                <?php endif ?>
            </div>
            <!-- 次回予約or会員登録 -->
            <div class="navSideR">
                <div class="navReserve">
                    <?php if($_SESSION['id']): ?>
                        <div class="navTopMessage toNRMtext">
                            <span class="nRMtext">次回予約</span>
                        </div>
                        <!-- 予約ありor新規予約 -->
                        <div class="navUnderMessage nextReserve toNRMtext">
                            <?php if ($next_reserve): ?>
                                <a href="../reserve/reservePage.php" class="nRMtext">
                                <?= h(date('Y年m月d日', strtotime($next_reserve))) ?>
                                (<?= h($arr_week[date('w', strtotime($next_reserve))]) ?>) 
                                <?= h(date('H:i~', strtotime($next_reserve))) ?></a>
                            <?php else : ?>
                                <a href="../reserve/insertReserve.php" class="nRMtext">予約はまだありません</a>
                            <?php endif ?>
                        </div>
                    <?php else : ?>
                        <div class="navTopMessage toNRMtext">
                            <span class="nRMtext">初めての方</span>
                        </div>
                        <div class="navUnderMessage toNRMtext">
                            <a href="/common/signup.php" class="nRMtext">会員登録はこちら</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </nav>
    </div>
</header>
<div class="space"></div>