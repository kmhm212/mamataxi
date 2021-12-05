<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 感想';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$reserves = findAfterReserveIdByUserId($id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts thoughtPage wrapper">
        <h2 class="subPageH2">感想情報</h2>
        <section>
            <h3 class="subPageH3">過去の予約と感想を確認</h3>
            <div class="thoughtDatas">
                <?php if(empty($reserves)) : ?>
                    <p>過去の予約はありません。</p>
                <? endif ?>
                <?php foreach($reserves as $reserve): ?>
                    <div class="thoughtData myData">
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
                        <?php $thought = findThoughtByReserveId($reserve['id']) ?>
                        <?php if ($thought): ?>
                            <div class="thoughtEditDelete">
                                <h5 class="grid1"><?= h($thought['title']) ?></h5>
                                <p class="grid2"><?= nl2br(h(LimitStrlen($thought['body'], 300))) ?></p>
                                <div class="buttonArea grid3">
                                    <a href="thought.php?id=<?= h($thought['id']) ?>" class="button">確認</a>
                                    <a href="editThought.php?id=<?= h($thought['id']) ?>" class="button">編集</a>
                                    <a href="deleteThought.php?id=<?= h($thought['id']) ?>" class="button">削除</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="thoughtInsert">
                                <a href="insertThought.php?id=<?= h($reserve['id']) ?>" class="button">感想を書く</a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>