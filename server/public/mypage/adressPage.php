<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 住所情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

$adresses = findAdressByUserId($id);

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts adressPage wrapper">
        <h2 class="subPageH2">住所情報</h2>
        <section>
            <h3 class="subPageH3">登録住所を確認</h3>
            <div class="adressDatas">
                <?php foreach($adresses as $adress): ?>
                    <div class="adressData myData">
                        <h4 class=""><?= h($adress['name']) ?></h4>
                        <ul class="checkAdress">
                            <li>〒 <?= h($adress['postal_code']) ?></li>
                            <li><?= h($adress['adress']) ?></li>
                            <li>TEL : <?= h($adress['tel']) ?></li>
                        </ul>
                        <div class="changeDelete">
                            <a href="changeAdress.php?id=<?= h($adress['id']) ?>" class="button">変更</a>
                            <a href="deleteAdress.php?id=<?= h($adress['id']) ?>" class="button">削除</a>
                        </div>
                    </div>
                <?php endforeach ?>
                <a href="insertAdress.php" class="insertAdressBtn">住所を新規登録</a>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>
