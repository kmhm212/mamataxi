<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 会員情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$array_sex = ['', '男', '女', 'その他'];

$id = $_SESSION['id'];

$user = findById($id);
$email = $user['email'];
$name = $user['name'];
$sex = $user['sex'];
$birth = $user['birth'];
$tel = $user['tel'];

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="userPage wrapper">
        <h2 class="subPageH2">会員情報</h2>
        <section>
            <h3 class="subPageH3">会員情報を確認</h3>
            <div class="checkUserData">
                <dl class="check1">
                    <dt>PCメールアドレス</dt>
                    <dd>
                        <span>:</span><?= h($email) ?>
                    </dd>
                </dl>
                <dl class="check2">
                    <dt>パスワード</dt>
                    <dd>
                        <span>:</span>*********
                    </dd>
                </dl>
                <dl class="check3">
                    <dt>ユーザー名</dt>
                    <dd>
                        <span>:</span><?= h($name) ?>
                    </dd>
                </dl>
                <dl class="check4">
                    <dt>性別</dt>
                    <dd>
                        <span>:</span><?= h($array_sex[$sex]) ?>
                    </dd>
                </dl>
                <dl class="check5">
                    <dt>生年月日</dt>
                    <dd>
                        <span>:</span><?= h($birth) ?>
                    </dd>
                </dl>
                <dl class="check6">
                    <dt>電話番号</dt>
                    <dd>
                        <span>:</span><?= h($tel) ?>
                    </dd>
                </dl>
                <a href="changeUser.php" class="button">会員情報変更</a>
                <a href="changePassword.php" class="button">パスワード変更</a>
                <a href="adressPage.php" class="button">住所変更</a>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>
