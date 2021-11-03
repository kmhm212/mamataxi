<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 予約確認';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$reseaves = findBeforReseaveIdByUserId($id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts reseavePage wrapper">
        <h2 class="subPageH2">予約情報</h2>
        <section>
            <h3 class="subPageH3">予約を確認</h3>
            <div class="reseaveDatas">
                <?php foreach($reseaves as $reseave): ?>
                    <div class="reseaveData myData">
                        <h4 class=""><?= h(date('m月d日 H:i', strtotime($reseave['departure_time']))) ?></h4>
                        <dl class="checkAdress">
                            <dt>出発地</dt>
                            <dd>
                                〒 <?= h($reseave['departure_postal_code']) ."  " . h($reseave['departure_adress']) ?>
                            </dd>
                            <dt>目的地</dt>
                            <dd>
                                〒 <?= h($reseave['destination_postal_code']) ."  " . h($reseave['destination_adress']) ?>
                            </dd>
                            <?php if ($reseave['waypoint_1_postal_code']): ?>
                                <dt class="waypoint">経由地①</dt>
                                <dd class="waypoint">
                                    〒 <?= h($reseave['waypoint_1_postal_code']) ."  " . h($reseave['waypoint_1_adress']) ?>
                                </dd>
                            <?php endif ?>
                            <?php if ($reseave['waypoint_2_postal_code']): ?>
                                <dt class="waypoint">経由地②</dt>
                                <dd class="waypoint">
                                    〒 <?= h($reseave['waypoint_2_postal_code']) ."  " . h($reseave['waypoint_2_adress']) ?>
                                </dd>
                            <?php endif ?>
                        </dl>
                        <div class="reseaveDelete">
                            <a href="deleteReseave.php?id=<?= h($reseave['id']) ?>" class="button">削除</a>
                        </div>
                    </div>
                <?php endforeach ?>
                <a href="insertReseave.php" class="mypageBtn">予約を新規登録</a>
                <a href="../thought/thoughtPage.php" class="mypageBtn">過去の予約を確認</a>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>