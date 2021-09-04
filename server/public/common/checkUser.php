<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | 会員情報確認";

session_start();

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$name = $_SESSION['name'];
$sex = $_SESSION['sex'];
$birth = $_SESSION['birth'];
$tel = $_SESSION['tel'];
$postal_code = $_SESSION['postal_code'];
$adress = $_SESSION['adress'];

$adress_name = '自宅';
$array_sex = ['', '男', '女', 'その他'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertUser($email, $password, $name, $sex, $birth, $tel);
    $user = findUserByEmail($email);

    insertAdress($user, $adress_name, $tel, $postal_code, $adress);
    
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    unset($_SESSION['name']);
    unset($_SESSION['sex']);
    unset($_SESSION['birth']);
    unset($_SESSION['tel']);
    unset($_SESSION['postal_code']);
    unset($_SESSION['adress']);
    header('Location: login.php?pp=sigupcomp');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="checkUser wrapper">
        <h2 class="subPageH2">会員情報確認</h2>
        <section>
            <h3 class="subPageH3">以下の情報で登録</h3>
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
                <dl class="check7">
                    <dt>郵便番号</dt>
                    <dd>
                        <span>:</span><?= h($postal_code) ?>
                    </dd>
                </dl>
                <dl class="check8">
                    <dt>住所</dt>
                    <dd>
                        <span>:</span><?= h($adress) ?>
                    </dd>
                </dl>
                <form action="" method="post">
                    <input type="submit" value="登録">
                    <a href="signup2.php">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>