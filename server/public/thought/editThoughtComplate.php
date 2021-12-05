<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 感想';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

$reserve = findReserveById($_SESSION['reserve_id']);
$thought_title = $_SESSION['title'];
$body = $_SESSION['body'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    changeThoughts($id, $_SESSION['reserve_id'], $_SESSION['title'], $_SESSION['body']);

    unset($_SESSION['reserve_id']);
    unset($_SESSION['title']);
    unset($_SESSION['body']);

    header('Location: ../mypage/mypage.php?pp=changecomp');
    exit;

}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts thoughtPage wrapper">
        <h2 class="subPageH2">感想情報</h2>
        <section>
            <h3 class="subPageH3">以下の内容に変更します</h3>
            <div class="checkUserData">
                <dl class="">
                    <dt>予約日</dt>
                    <dd>
                        <span>:</span><?= h(date('Y年m月d日 H:i', strtotime($reserve['departure_time'])))?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>タイトル</dt>
                    <dd>
                        <span>:</span><?= h($thought_title) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>本文</dt>
                    <dd>
                        <?= nl2br(h($body)) ?>
                    </dd>
                </dl>
                <form action="" method="post">
                    <input type="submit" value="変更">
                    <a href="editThought.php?pp=back">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>
