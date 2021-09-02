<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | 会員登録";

session_start();

if ($_SESSION['id']) {
    header('Location: ../index.php');
    exit;
}

$name = $_SESSION['email'];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = filter_input(INPUT_POST, 'name');
    $sex = filter_input(INPUT_POST, 'sex');
    $birth = filter_input(INPUT_POST, 'birth');
    $tel = str_replace('-', '', filter_input(INPUT_POST, 'tel'));

    $errors = signupValidate2($name, $sex, $birth, $tel);

    if (empty($errors)) {
        $_SESSION['name'] = $name;
        $_SESSION['sex'] = $sex;
        $_SESSION['birth'] = $birth;
        $_SESSION['tel'] = $tel;
        header('Location: checkUser.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>
<article>
    <div class="loginParts signUp2 wrapper">
        <h2 class="subPageH2">会員登録</h2>
        <section>
            <h3 class="subPageH3">会員情報を登録</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="name" class="label1">ユーザー名</label>
                <input type="text" name="name" id="name" class="input1" placeholder="ユーザー名" value="<?= h($name) ?>">
                <label for="male" class="label2">性別</label>
                <div class="input2">
                    <label>男
                        <input type="radio" name="sex" id="male" value=1>
                    </label>
                    <label>女
                        <input type="radio" name="sex" id="female" value=2>
                    </label>
                    <label>その他
                        <input type="radio" name="sex" id="other" value=>
                    </label>
                </div>
                <label for="birth" class="label3">生年月日</label>
                <input type="date" name="birth" id="birth" class="input3" placeholder="2021/9/5" value="<?= h($birth) ?>">
                <label for="tel" class="label4">電話番号</label>
                <input type="tel" name="tel" id="tel" class="input4" placeholder="000-0000-0000"  value="<?= h($tel) ?>">
                <input type="submit" value="確認">
                <!-- <a href="">戻る</a> -->
            </form>
            <a href="login.php">ログインはこちら</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>