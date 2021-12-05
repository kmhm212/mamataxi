<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | NEWS';

session_start();

$news = findNews();

$p = intval($_GET['page']);
if (empty($p)) { $p = 1; }

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="newsPage wrapper">
        <h2 class="subPageH2">おしらせ</h2>
        <section>
            <div class="">
                <ul>
                    <?php for ($i=($p - 1) * 25; $i < $p * 25; $i++): ?>
                        <?php if($news[$i]): ?>
                        <li class="newsList">
                            <a href="news.php?id=<?= $news[$i]['id'] ?>">
                                <p class="data">
                                    <span class="newsCategory category<?= findCategoryById($news[$i]['category_id'])['id'] ?>">
                                        <?= h(findCategoryById($news[$i]['category_id'])['name']) ?>
                                    </span>
                                    <?= h(date('Y/m/d', strtotime(findNewsById($news[$i]['id'])['created_at']))) ?> 
                                </p>
                                <h3><?= $news[$i]['title'] ?></h2>
                            </a>
                        </li>
                        <? endif ?>
                    <?php endfor ?>
                </ul>
            </div>
            <div class="prevAndNext">
                <?php if($news[($p - 1) * 25 - 1]): ?>
                    <div class="prevPage button">
                        <a href="newsPage.php?page=<?= $p-1 ?>">
                            ＜ 前のページへ
                        </a>
                    </div>
                <?php endif ?>
                <?php if($news[$p * 25]): ?>
                    <div class="nextPage button">
                        <a href="newsPage.php?page=<?= $p+1 ?>">
                            次のページへ ＞
                        </a>
                    </div>
                <?php endif ?>
            </div>
        </section>
    </div>
</article>


<?php include_once __DIR__ . '/../common/_footer.html' ?>