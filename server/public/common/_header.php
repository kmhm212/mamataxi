<?php

require_once __DIR__ . '/../../common/functions.php';
$next_reseave = findReseaveByUserId($_SESSION['id'])[0]['departure_time'];
$arr_week = ['月', '火', '水', '木', '金', '土', '日'];

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
                            <?php if ($reseaves): ?>
                                <a href="../mypage/mypage.php" class="nRMtext">
                                <?= h(date($next_reseaves, 'Y年M月D日')) ?>
                                (<?= h($arr_week[date($next_reseaves, 'W')]) ?>) 
                                <?= h(date($next_reseaves, 'H:I')) ?>~</a>
                            <?php else : ?>
                                <a href="../reseave/reseavePage.php" class="nRMtext">予約はまだありません</a>
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