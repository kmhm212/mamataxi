<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 予約確認';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$reserves = findBeforReserveIdByUserId($id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts reservePage wrapper">
        <h2 class="subPageH2">予約情報</h2>
        <section>
            <h3 class="subPageH3">予約を確認</h3>
            <div class="reserveDatas">
                <?php foreach($reserves as $reserve): ?>
                    <div class="reserveData myData">
                        <h4 class=""><?= h(date('m月d日 H:i', strtotime($reserve['departure_time']))) ?></h4>
                        <dl class="checkAdress">
                            <dt>出発地</dt>
                            <dd>
                                〒 <?= h($reserve['departure_postal_code']) ."  " . h($reserve['departure_adress']) ?>
                            </dd>
                            <dt>目的地</dt>
                            <dd>
                                〒 <?= h($reserve['destination_postal_code']) ."  " . h($reserve['destination_adress']) ?>
                            </dd>
                            <?php if ($reserve['waypoint_1_postal_code']): ?>
                                <dt class="waypoint">経由地①</dt>
                                <dd class="waypoint">
                                    〒 <?= h($reserve['waypoint_1_postal_code']) ."  " . h($reserve['waypoint_1_adress']) ?>
                                </dd>
                            <?php endif ?>
                            <?php if ($reserve['waypoint_2_postal_code']): ?>
                                <dt class="waypoint">経由地②</dt>
                                <dd class="waypoint">
                                    〒 <?= h($reserve['waypoint_2_postal_code']) ."  " . h($reserve['waypoint_2_adress']) ?>
                                </dd>
                            <?php endif ?>
                        </dl>
                        <div class="reserveDelete">
                            <a href="deleteReserve.php?id=<?= h($reserve['id']) ?>" class="button">削除</a>
                        </div>
                    </div>
                <?php endforeach ?>
                <a href="insertReserve.php" class="mypageBtn">予約を新規登録</a>
                <a href="../thought/thoughtPage.php" class="mypageBtn">過去の予約を確認</a>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>