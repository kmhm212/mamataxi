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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = filter_input(INPUT_POST, 'name');
    $sex = filter_input(INPUT_POST, 'sex');
    $birth = filter_input(INPUT_POST, 'birth');
    $tel = str_replace('-', '', filter_input(INPUT_POST, 'tel'));

    $errors = changeUserValidate($user, $name, $sex, $birth, $tel);

    if (empty($errors)) {
        $_SESSION['name'] = $name;
        $_SESSION['sex'] = $sex;
        $_SESSION['birth'] = $birth;
        $_SESSION['tel'] = $tel;
        header('Location: changeUserComplate.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="formParts changeUser wrapper">
        <h2 class="subPageH2">会員情報</h2>
        <section>
            <h3 class="subPageH3">会員情報を変更</h3>
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
                <input type="tel" name="tel" id="tel" class="input4" placeholder="000-0000-0000" value="<?= h($tel) ?>">
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>
