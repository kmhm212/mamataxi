<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 住所情報';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id');

$user_adress = findAdressByAdressId($id);

if (filter_input(INPUT_POST, 'pp') == 'back') {
    $name = $_SESSION['name'];
    $postal_code1 = substr($_SESSION['postal_code'], 0, 3);
    $postal_code2 = substr($_SESSION['postal_code'], 4);
    $adress = $_SESSION['adress'];
    $tel = $_SESSION['tel'];
} else {
    $name = $user_adress['name'];
    $postal_code1 = substr($user_adress['postal_code'], 0, 3);
    $postal_code2 = substr($user_adress['postal_code'], 4);
    $adress = $user_adress['adress'];
    $tel = $user_adress['tel'];
    }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = filter_input(INPUT_POST, 'name');
    $postal_code1 = filter_input(INPUT_POST, 'postalCode1');
    $postal_code2 = filter_input(INPUT_POST, 'postalCode2');
    $adress = filter_input(INPUT_POST, 'adress');
    $tel = str_replace('-', '', filter_input(INPUT_POST, 'tel'));

    $errors = changeAdressValidate($id, $name, $tel, $postal_code1, $postal_code2, $adress);

    if (empty($errors)) {
        $_SESSION['adress_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['postal_code'] = $postal_code1 . '-' . $postal_code2;
        $_SESSION['adress'] = $adress;
        $_SESSION['tel'] = $tel;
        header('Location: changeAdressComplate.php');
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
    <div class="formParts changeAdress wrapper">
        <h2 class="subPageH2">住所情報</h2>
        <section>
            <h3 class="subPageH3">登録住所を変更</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="name" class="label1">登録名</label>
                <input type="text" name="name" id="name" class="input1" placeholder="〇〇保育園" value="<?= h($name) ?>">
                <label for="postalCode1" class="label2">郵便番号</label>
                <div class="input2">
                    <input type="number" name="postalCode1" id="postalCode1" placeholder="000" value="<?= h($postal_code1) ?>">
                    <span>-</span>
                    <input type="number" name="postalCode2" id="postalCode2" placeholder="0000" value="<?= h($postal_code2) ?>">
                </div>
                <label for="adress" class="label3">自宅住所</label>
                <input type="text" name="adress" id="adress" class="input3" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($adress) ?>">
                <label for="tel" class="label4">電話番号</label>
                <input type="tel" name="tel" id="tel" class="input4" placeholder="000-0000-0000" value="<?= h($tel) ?>">
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>