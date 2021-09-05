<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 子ども情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$array_sex = ['', '男', '女', 'その他'];

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$sex = $_SESSION['sex'];
$birth = $_SESSION['birth'];
$adress_id = $_SESSION['adress_id'];

if ($adress_id == 'new') {
$adress_name = $_SESSION['adress_name'];
$postal_code = $_SESSION['postal_code'];
$tel = $_SESSION['tel'];
$nursery_adress = $_SESSION['adress'];
} else {
    $adress = findAdressByAdressId($adress_id);
    $adress_name = $adress['name'];
    $postal_code = $adress['postal_code'];
    $tel = $adress['tel'];
    $nursery_adress = $adress['adress'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($adress_id == 'new') {
        insertAdress($id, $adress_name, $tel, $postal_code, $nursery_adress);
        $adress_id = findInsertAdress($id, $adress_name, $tel, $postal_code, $nursery_adress)['id'];
    }
    insertChild($id, $name, $sex, $birth, $adress_id);
    
    unset($_SESSION['name']);
    unset($_SESSION['sex']);
    unset($_SESSION['birth']);
    unset($_SESSION['adress_id']);
    unset($_SESSION['adres_name']);
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
        <h2 class="subPageH2">子ども情報</h2>
        <section>
            <h3 class="subPageH3">登録情報を確認</h3>
            <div class="checkUserData">
                <dl class="">
                    <dt>登録名</dt>
                    <dd>
                        <span>:</span><?= h($name) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>性別</dt>
                    <dd>
                        <span>:</span><?= h($array_sex[$sex]) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>生年月日</dt>
                    <dd>
                        <span>:</span><?= h($birth) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>保育園名</dt>
                    <dd>
                        <span>:</span><?= h($adress_name) ?>
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
                        <span>:</span><?= h($nursery_adress) ?>
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
                    <a href="insertChild.php?pp=back">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>