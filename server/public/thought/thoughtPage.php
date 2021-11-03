<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 感想';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$reseaves = findAfterReseaveIdByUserId($id);

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
            <h3 class="subPageH3">感想を確認</h3>
            <div class="thoughtDatas">
                <?php foreach($reseaves as $reseave): ?>
                    <div class="thoughtData myData">
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
                        <?php $thought = findThoughtByReseaveId($reseave['id']) ?>
                        <?php if ($thought): ?>
                            <div class="thoughtEditDelete">
                                <h5 class="label1"><?= h($thought['title']) ?></h5>
                                <p class="label1"><?= h($thought['body']) ?></p>
                                <a href="thought.php?id=<?= h($thought['id']) ?>" class="button label3">確認</a>
                                <a href="editThought.php?id=<?= h($thought['id']) ?>" class="button label4">編集</a>
                                <a href="deleteThought.php?id=<?= h($thought['id']) ?>" class="button label5">削除</a>
                            </div>
                        <?php else: ?>
                            <div class="thoughtInsert">
                                <a href="insertThought.php?id=<?= h($reseave['id']) ?>" class="button">感想を書く</a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>