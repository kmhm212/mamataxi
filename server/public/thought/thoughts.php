<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | 感想一覧';

session_start();

$thoughts = findThoughts();

$p = intval($_GET['page']);
if (empty($p)) { $p = 1; }

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="thoughts wrapper">
        <h2 class="subPageH2">みんなの感想</h2>
        <section>
            <div class="">
                <ul>
                    <?php for ($i=($p - 1) * 10; $i < $p * 10; $i++): ?>
                        <?php if($thoughts[$i]): ?>
                        <li class="thoughtsList">
                            <a href="thought.php?id=<?= $thoughts[$i]['id'] ?>">
                                <p class="usedData">
                                    <?= h(date('Y/m/d', strtotime(findReserveById($thoughts[$i]['reserve_id'])['departure_time']))) ?> 利用
                                    <span class="userName"><?= h(findUserById($thoughts[$i]['user_id'])['name']) ?> さん</span>
                                </p>
                                <h2><?= $thoughts[$i]['title'] ?></h2>
                                <p class="body"><?= nl2br(h(LimitStrlen($thoughts[$i]['body'], 150))) ?></p>
                            </a>
                        </li>
                        <? endif ?>
                    <?php endfor ?>
                </ul>
            </div>
            <div class="prevAndNext">
                <?php if($thoughts[($p - 1) * 10 - 1]): ?>
                    <div class="prevPage button">
                        <a href="thoughts.php?page=<?= $p-1 ?>">
                            ＜ 前のページへ
                        </a>
                    </div>
                <?php endif ?>
                <?php if($thoughts[$p * 10]): ?>
                    <div class="nextPage button">
                        <a href="thoughts.php?page=<?= $p+1 ?>">
                            次のページへ ＞
                        </a>
                    </div>
                <?php endif ?>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>