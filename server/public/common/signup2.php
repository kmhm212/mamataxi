<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | 会員登録";

session_start();

if ($_SESSION['id'] || empty($_SESSION['email'])) {
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
    $postal_code1 = filter_input(INPUT_POST, 'postalCode1');
    $postal_code2 = filter_input(INPUT_POST, 'postalCode2');
    $adress = filter_input(INPUT_POST, 'adress');

    $errors = signupValidate2($name, $sex, $birth, $tel, $postal_code1, $postal_code2, $adress);

    if (empty($errors)) {
        $_SESSION['name'] = $name;
        $_SESSION['sex'] = $sex;
        $_SESSION['birth'] = $birth;
        $_SESSION['tel'] = $tel;
        $_SESSION['postal_code'] = $postal_code1 . '-' . $postal_code2;
        $_SESSION['adress'] = $adress;
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
    <div class="formParts signUp2 wrapper">
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
                <input type="tel" name="tel" id="tel" class="input4" placeholder="000-0000-0000" value="<?= h($tel) ?>">
                <label for="postalCode1" class="label5">郵便番号</label>
                <div class="input5">
                    <input type="number" name="postalCode1" id="postalCode1" placeholder="000" value="<?= h($postal_code1) ?>">
                    <span>-</span>
                    <input type="number" name="postalCode2" id="postalCode2" placeholder="0000" value="<?= h($postal_code2) ?>">
                </div>
                <label for="adress" class="label6">自宅住所</label>
                <input type="text" name="adress" id="adress" class="input6" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($adress) ?>">
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