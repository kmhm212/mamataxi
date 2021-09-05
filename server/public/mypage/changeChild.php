<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 子ども情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$child_id = filter_input(INPUT_GET, 'id');
$child = findChildByChildId($child_id);

if (filter_input(INPUT_GET, 'pp') == 'back') {
    $name = $_SESSION['name'];
    $sex = $_SESSION['sex'];
    $birth = $_SESSION['birth'];
    $adress_id = $_SESSION['adress_id'];
    $adress_name = $_SESSION['adress_name'];
    $postal_code1 = substr($_SESSION['postal_code'], 0, 3);
    $postal_code2 = substr($_SESSION['postal_code'], 4);
    $tel = $_SESSION['tel'];
    $nursery_adress = $_SESSION['adress'];
} else {
    $name = $child['name'];
    $birth = $child['birth'];
}

$id = $_SESSION['id'];
$adresses = findAdressByUserId($id);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = filter_input(INPUT_POST, 'name');
    $sex = filter_input(INPUT_POST, 'sex');
    $birth = filter_input(INPUT_POST, 'birth');
    $adress_id = filter_input(INPUT_POST, 'adressId');
    if ($adress_id == 'new') {
        $adress_name = filter_input(INPUT_POST, 'adressName');
        $postal_code1 = filter_input(INPUT_POST, 'postalCode1');
        $postal_code2 = filter_input(INPUT_POST, 'postalCode2');
        $nursery_adress = filter_input(INPUT_POST, 'adress');
        $tel = str_replace('-', '', filter_input(INPUT_POST, 'tel'));
    }

    $errors = updataChildValidate($child_id, $name, $sex, $birth, $adress_id, $adress_name, $tel, $postal_code1, $postal_code2, $nursery_adress);

    if (empty($errors)) {
        $_SESSION['child_id'] = $child_id;
        $_SESSION['name'] = $name;
        $_SESSION['sex'] = $sex;
        $_SESSION['birth'] = $birth;
        $_SESSION['adress_id'] = $adress_id;
        if ($adress_id == 'new') {
            $_SESSION['adress_name'] = $adress_name;
            $_SESSION['postal_code'] = $postal_code1 . '-' . $postal_code2;
            $_SESSION['adress'] = $nursery_adress;
            $_SESSION['tel'] = $tel;
        }
        header('Location: changeChildComplate.php');
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
    <div class="formParts insertChild wrapper">
        <h2 class="subPageH2">子ども情報</h2>
        <section>
            <h3 class="subPageH3">子ども情報を変更</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="name" class="label1">登録名</label>
                <input type="text" name="name" id="name" class="input1" placeholder="タロウ" value="<?= h($name) ?>">
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
                <label for="adressId" class="label4">保育園住所</label>
                <select name="adressId" id="adressId" class="input4">
                    <option value="" selected>-</option>
                    <?php foreach($adresses as $adress): ?>
                        <option value="<?= h($adress['id'])?>"><?= h($adress['name'])?></option> 
                    <?php endforeach ?>
                    <option value="new">新規登録</option>
                </select>
                <label for="adressName" class="label5">登録名</label>
                <input type="text" name="adressName" id="adressName" class="input5" placeholder="〇〇保育園" value="<?= h($adress_name) ?>">
                <label for="postalCode1" class="label6">郵便番号</label>
                <div class="input6">
                    <input type="number" name="postalCode1" id="postalCode1" placeholder="000" value="<?= h($postal_code1) ?>">
                    <span>-</span>
                    <input type="number" name="postalCode2" id="postalCode2" placeholder="0000" value="<?= h($postal_code2) ?>">
                </div>
                <label for="adress" class="label7">住所</label>
                <input type="text" name="adress" id="adress" class="input7" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($nursery_adress) ?>">
                <label for="tel" class="label8">電話番号</label>
                <input type="tel" name="tel" id="tel" class="input8" placeholder="000-0000-0000" value="<?= h($tel) ?>">
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>