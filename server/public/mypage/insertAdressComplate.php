<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 住所情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$postal_code = $_SESSION['postal_code'];
$adress = $_SESSION['adress'];
$tel = $_SESSION['tel'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertAdress($id, $name, $tel, $postal_code, $adress);
    
    unset($_SESSION['name']);
    unset($_SESSION['postal_code']);
    unset($_SESSION['adress']);
    unset($_SESSION['tel']);
    
    header('Location: mypage.php?pp=insertcomp');
    exit;
}

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
            <div class="checkUserData">
                <dl class="">
                    <dt>登録名</dt>
                    <dd>
                        <span>:</span><?= h($name) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>郵便番号</dt>
                    <dd>
                        <span>:</span>〒<?= h($postal_code) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>住所</dt>
                    <dd>
                        <span>:</span><?= h($adress) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>電話番号</dt>
                    <dd>
                        <span>:</span><?= h($tel) ?>
                    </dd>
                </dl>
                <form action="" method="post">
                    <input type="submit" value="変更">
                    <a href="insertAdress.php?pp=back">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>