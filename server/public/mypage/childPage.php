<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 子ども情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$array_sex = ['', '男', '女', 'その他'];
$children = findChildrenByUserId($id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts childPage wrapper">
        <h2 class="subPageH2">子ども情報</h2>
        <section>
            <h3 class="subPageH3">子ども情報を確認</h3>
            <div class="childDatas">
                <?php foreach($children as $child): ?>
                    <?php $adress = findAdressByAdressId($child['adress_id']) ?>
                    <div class="childData myData">
                        <h4 class=""><?= h($child['name']) ?></h4>
                        <ul class="checkChild">
                            <li><?= h($array_sex[$child['sex']]) ?></li>
                            <li><?= h($child['birth']) ?></li>
                        </ul>
                        <ul class="checkAdress">
                            <li><?= h($adress['name']) ?></li>
                            <li>〒 <?= h($adress['postal_code']) ?></li>
                            <li><?= h($adress['adress']) ?></li>
                            <li>TEL : <?= h($adress['tel']) ?></li>
                        </ul>
                        <div class="changeDelete">
                            <a href="changeChild.php?id=<?= h($child['id']) ?>" class="button">変更</a>
                            <a href="deleteChild.php?id=<?= h($child['id']) ?>" class="button">削除</a>
                        </div>
                    </div>
                <?php endforeach ?>
                <a href="insertChild.php" class="insertBtn  mypageBtn">子ども情報を新規登録</a>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>
