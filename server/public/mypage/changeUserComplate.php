<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | マイページ > 会員情報";

session_start();

$id = $_SESSION['id'];

$name = $_SESSION['name'];
$sex = $_SESSION['sex'];
$birth = $_SESSION['birth'];
$tel = $_SESSION['tel'];

$array_sex = ['', '男', '女', 'その他'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUser($id, $name, $sex, $birth, $tel);
    
    unset($_SESSION['name']);
    unset($_SESSION['sex']);
    unset($_SESSION['birth']);
    unset($_SESSION['tel']);
    header('Location: mypage.php?pp=changecomp');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="checkUser wrapper">
        <h2 class="subPageH2">会員情報確認</h2>
        <section>
            <h3 class="subPageH3">以下の情報で再登録</h3>
            <div class="checkUserData">
                <dl class="check1">
                    <dt>ユーザー名</dt>
                    <dd>
                        <span>:</span><?= h($name) ?>
                    </dd>
                </dl>
                <dl class="check2">
                    <dt>性別</dt>
                    <dd>
                        <span>:</span><?= h($array_sex[$sex]) ?>
                    </dd>
                </dl>
                <dl class="check3">
                    <dt>生年月日</dt>
                    <dd>
                        <span>:</span><?= h($birth) ?>
                    </dd>
                </dl>
                <dl class="check4">
                    <dt>電話番号</dt>
                    <dd>
                        <span>:</span><?= h($tel) ?>
                    </dd>
                </dl>
                <form action="" method="post">
                    <input type="submit" value="登録">
                    <a href="changeUser.php">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>