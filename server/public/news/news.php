<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | おしらせ > ';

session_start();

$id = $_SESSION['id'];
$news = findNewsById(intval($_GET['id']));
$title .= $news['title'];

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts textPage wrapper">
        <h2 class="subPageH2">おしらせ</h2>
        <section>
            <div class="news textContent">
                <div class="textContentHeader">
                    <h3 class=""><?= $news['title'] ?></h3>
                    <p class="data">
                        <?= h(date('Y/m/d', strtotime($news['created_at']))) ?>
                    </p>
                </div>
                <p class="body"><?= nl2br(h($news['body'])) ?></p>
            </div>
            <a class="button" href="newsPage.php">一覧へ戻る</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>