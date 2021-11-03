<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | マイページ";

session_start();
if(empty($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}
$id = $_SESSION['id'];
$child_check = haveChild($id);

$pp = filter_input(INPUT_GET, 'pp');
if ($pp == 'insertcomp') {
    $msg = '登録が完了しました。';
} elseif ($pp == 'changecomp') {
    $msg = '変更が完了しました。';
} elseif ($pp == 'delcomp') {
    $msg = '削除が完了しました。';
}
?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="mypage wrapper">
        <section>
            <h2 class="subPageH2">マイページ</h2>
            <?php if(empty($child_check)): ?>
                <div class="childCheck">
                    <p><a href="insertChild.php">※お子様の情報登録を行ってください</a></p>
                </div>
            <?php endif ?>
            <?php if($msg): ?>
                <p class="checkMSG">
                    <?= $msg ?><br>
                </p>
            <?php endif ?>
            <div class="mypageContents">
                <div class="mypageContent">
                    <h3 class="subPageH3">会員情報</h3>
                    <ul>
                        <li><a href="userPage.php">会員情報の確認</a></li>
                        <li><a href="changePassword.php">パスワードの変更</a></li>
                    </ul>
                </div>
                <div class="mypageContent">
                    <h3 class="subPageH3">お子様の情報</h3>
                    <ul>
                        <li><a href="childPage.php">子ども情報の確認</a></li>
                        <li><a href="insertChild.php">子ども情報の登録</a></li>
                    </ul>
                </div>
                <div class="mypageContent">
                    <h3 class="subPageH3">予約情報</h3>
                    <ul>
                        <li><a href="../reseave/reseavePage.php">予約の確認</a></li>
                        <li><a href="../reseave/insertReseave.php">予約の登録</a></li>
                    </ul>
                </div>
                <div class="mypageContent">
                    <h3 class="subPageH3">住所情報</h3>
                    <ul>
                        <li><a href="adressPage.php">住所の確認</a></li>
                        <li><a href="insertAdress.php">住所の登録</a></li>
                    </ul>
                </div>
                <div class="mypageContent">
                    <h3 class="subPageH3">ご感想はこちらから</h3>
                    <ul>
                        <li><a href="../thought/thoughtPage.php">感想の確認</a></li>
                        <li><a href="../thought/insertThought.php">感想の登録</a></li>
                        <li><a href="../thought/otherThoughtPage.php">他の人の感想を見てみる</a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>