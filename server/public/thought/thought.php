<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | 感想 > ';

session_start();

$id = $_SESSION['id'];
$thought = findThoughtsById(intval($_GET['id']));
$title .= $thought['title'];

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts textPage wrapper">
        <h2 class="subPageH2">みんなの感想</h2>
        <section>
            <div class="thought textContent">
                <div class="textContentHeader">
                    <h3 class=""><?= $thought['title'] ?></h3>
                    <p class="usedData">
                        <span class="userName"><?= h(findUserById($thought['user_id'])['name']) ?></span>
                        (<?= h(date('Y/m/d', strtotime(findReserveById($thought['reserve_id'])['departure_time']))) ?> 利用)
                    </p>
                </div>
                <p class="body"><?= nl2br(h($thought['body'])) ?></p>
            </div>
            <a class="button" href="thoughts.php">一覧へ戻る</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>