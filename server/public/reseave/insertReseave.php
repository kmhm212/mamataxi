<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 予約登録';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$children = findChildrenByUserId($id);


if (filter_input(INPUT_GET, 'pp') == 'fromHome') {
    $departure_postal_code_1 = $_SESSION['departure_postal_code_1'];
    $departure_postal_code_2 = $_SESSION['departure_postal_code_2'];
    $destination_postal_code_1 = $_SESSION['destination_postal_code_1'];
    $destination_postal_code_2 = $_SESSION['destination_postal_code_2'];
    $waypoint_1_postal_code_1 = $_SESSION['waypoint_1_postal_code_1'];
    $waypoint_1_postal_code_2 = $_SESSION['waypoint_1_postal_code_2'];
    $waypoint_2_postal_code_1 = $_SESSION['waypoint_2_postal_code_1'];
    $waypoint_2_postal_code_2 = $_SESSION['waypoint_2_postal_code_2'];
    
    unset($_SESSION['departure_postal_code_1']);
    unset($_SESSION['departure_postal_code_2']);
    unset($_SESSION['destination_postal_code_1']);
    unset($_SESSION['destination_postal_code_2']);
    unset($_SESSION['waypoint_1_postal_code_1']);
    unset($_SESSION['waypoint_1_postal_code_2']);
    unset($_SESSION['waypoint_2_postal_code_1']);
    unset($_SESSION['waypoint_2_postal_code_2']);
}

if (filter_input(INPUT_GET, 'pp') == 'back') {
    $departure_postal_code_1 = substr($_SESSION['departure_postal_code'], 0, 3);
    $departure_postal_code_2 = substr($_SESSION['departure_postal_code'], 4);
    $departure_adress = $_SESSION['departure_adress'];
    $destination_postal_code_1 = substr($_SESSION['destination_postal_code'], 0, 3);
    $destination_postal_code_2 = substr($_SESSION['destination_postal_code'], 4);
    $destination_adress = $_SESSION['destination_adress'];
    
    unset($_SESSION['waypoint_1_area_id']);
    unset($waypoint_1_area_id);
    $waypoint_1_postal_code_1 = substr($_SESSION['waypoint_1_postal_code'], 0, 3);
    $waypoint_1_postal_code_2 = substr($_SESSION['waypoint_1_postal_code'], 4);
    unset($waypoint_1_postal_code);
    unset($_SESSION['waypoint_1_postal_code']);
    $waypoint_1_adress = $_SESSION['waypoint_1_adress'];
    unset($_SESSION['waypoint_1_adress']);

    unset($_SESSION['waypoint_2_area_id']);
    unset($waypoint_2_area_id);
    $waypoint_2_postal_code_1 = substr($_SESSION['waypoint_2_postal_code'], 0, 3);
    $waypoint_2_postal_code_2 = substr($_SESSION['waypoint_2_postal_code'], 4);
    unset($waypoint_2_postal_code);
    unset($_SESSION['waypoint_2_postal_code']);
    $waypoint_2_adress = $_SESSION['waypoint_2_adress'];
    unset($_SESSION['waypoint_2_adress']);
}

$errors = [];
$child_id = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $departure_postal_code_1 = filter_input(INPUT_POST, 'departure_postal_code_1');
    $departure_postal_code_2 = filter_input(INPUT_POST, 'departure_postal_code_2');
    $departure_adress = filter_input(INPUT_POST, 'departure_adress');
    $destination_postal_code_1 = filter_input(INPUT_POST, 'destination_postal_code_1');
    $destination_postal_code_2 = filter_input(INPUT_POST, 'destination_postal_code_2');
    $destination_adress = filter_input(INPUT_POST, 'destination_adress');
    $waypoint_1_postal_code_1 = filter_input(INPUT_POST, 'waypoint_1_postal_code_1');
    $waypoint_1_postal_code_2 = filter_input(INPUT_POST, 'waypoint_1_postal_code_2');
    $waypoint_1_adress = filter_input(INPUT_POST, 'waypoint_1_adress');
    $waypoint_2_postal_code_1 = filter_input(INPUT_POST, 'waypoint_2_postal_code_1');
    $waypoint_2_postal_code_2 = filter_input(INPUT_POST, 'waypoint_2_postal_code_2');
    $waypoint_2_adress = filter_input(INPUT_POST, 'waypoint_2_adress');
    $child_id = filter_input(INPUT_POST, 'child_id', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);

    $errors = insertReseaveValidate($departure_postal_code_1, $departure_postal_code_2, $departure_adress, $destination_postal_code_1, $destination_postal_code_2, $destination_adress, $waypoint_1_postal_code_1, $waypoint_1_postal_code_2, $waypoint_1_adress, $waypoint_2_postal_code_1, $waypoint_2_postal_code_2, $waypoint_2_adress, $child_id);

    if (empty($errors)) {
        $departure_postal_code = $departure_postal_code_1 . "-" . $departure_postal_code_2;
        $destination_postal_code = $destination_postal_code_1 . "-" . $destination_postal_code_2;
        $departure_area_id = findAreaId($departure_postal_code);
        $destination_area_id = findAreaId($destination_postal_code);

        if ($waypoint_1_postal_code_1) {
            $waypoint_1_postal_code = $waypoint_1_postal_code_1 . "-" . $waypoint_1_postal_code_2;
            $waypoint_1_area_id = findAreaId($waypoint_1_postal_code);
        }
        if ($waypoint_2_postal_code_1) {
            $waypoint_2_postal_code = $waypoint_2_postal_code_1 . "-" . $waypoint_2_postal_code_2;
            $waypoint_2_area_id = findAreaId($waypoint_2_postal_code);
        }

        $_SESSION['departure_area_id'] = $departure_area_id;
        $_SESSION['departure_postal_code'] = $departure_postal_code;
        $_SESSION['departure_adress'] = $departure_adress;
        $_SESSION['destination_area_id'] = $destination_area_id;
        $_SESSION['destination_postal_code'] = $destination_postal_code;
        $_SESSION['destination_adress'] = $destination_adress;
        $_SESSION['waypoint_1_area_id'] = $waypoint_1_area_id;
        $_SESSION['waypoint_1_postal_code'] = $waypoint_1_postal_code;
        $_SESSION['waypoint_1_adress'] = $waypoint_1_adress;
        $_SESSION['waypoint_2_area_id'] = $waypoint_2_area_id;
        $_SESSION['waypoint_2_postal_code'] = $waypoint_2_postal_code;
        $_SESSION['waypoint_2_adress'] = $waypoint_2_adress;
        $_SESSION['child_id'] = $child_id;

        header('Location: selectReseave.php');
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
        <h2 class="subPageH2">予約登録</h2>
        <section>
            <h3 class="subPageH3">予約情報を登録</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

            <form action="" method="post">

                <div class="reseaveAdress adress1">
                    <h4>出発地</h4>
                    <label for="departure_postal_code_1" class="label1">郵便番号</label>
                    <div class="input1">
                        <input type="number" name="departure_postal_code_1" id="departure_postal_code_1" placeholder="000" value="<?= h($departure_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="departure_postal_code_2" id="departure_postal_code_2" placeholder="0000" value="<?= h($departure_postal_code_2) ?>">
                    </div>
                    <label for="departure_adress" class="label2">住所</label>
                    <input type="text" name="departure_adress" id="departure_adress" class="input2" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($departure_adress) ?>">
                </div>
                
                <div class="reseaveAdress adress2">
                    <h4>目的地</h4>
                    <label for="destination_postal_code_1" class="label1">郵便番号</label>
                    <div class="input1">
                        <input type="number" name="destination_postal_code_1" id="destination_postal_code_1" placeholder="000" value="<?= h($destination_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="destination_postal_code_2" id="destination_postal_code_2" placeholder="0000" value="<?= h($destination_postal_code_2) ?>">
                    </div>
                    <label for="destination_adress" class="label2">住所</label>
                    <input type="text" name="destination_adress" id="destination_adress" class="input2" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($destination_adress) ?>">
                </div>

                <div class="reseaveAdress adress3">
                    <h4>経由地①</h4>
                    <label for="waypoint_1_postal_code_1" class="label1">郵便番号</label>
                    <div class="input1">
                        <input type="number" name="waypoint_1_postal_code_1" id="waypoint_1_postal_code_1" placeholder="000" value="<?= h($waypoint_1_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="waypoint_1_postal_code_2" id="waypoint_1_postal_code_2" placeholder="0000" value="<?= h($waypoint_1_postal_code_2) ?>">
                    </div>
                    <label for="waypoint_1_adress" class="label2">住所</label>
                    <input type="text" name="waypoint_1_adress" id="waypoint_1_adress" class="input2" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($waypoint_1_adress) ?>">
                </div>

                <div class="reseaveAdress adress4">
                    <h4>経由地②</h4>
                    <label for="waypoint_2_postal_code_1" class="label1">郵便番号</label>
                    <div class="input1">
                        <input type="number" name="waypoint_2_postal_code_1" id="waypoint_2_postal_code_1" placeholder="000" value="<?= h($waypoint_2_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="waypoint_2_postal_code_2" id="waypoint_2_postal_code_2" placeholder="0000" value="<?= h($waypoint_2_postal_code_2) ?>">
                    </div>
                    <label for="waypoint_2_adress" class="label2">住所</label>
                    <input type="text" name="waypoint_2_adress" id="waypoint_2_adress" class="input2" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($waypoint_2_adress) ?>">
                </div>
                <div class="reseaveChildren">
                    <h4>ご利用のお子様</h4>
                    <?php foreach($children as $child): ?>
                        <input type="checkbox" name="child_id[]" value="<?= h($child['id']) ?>" id="child<?= h($child['id']) ?>">
                        <label for="child<?= h($child['id']) ?>">
                            <?= h($child['name']) ?>
                        </label>
                    <?php endforeach ?>
                </div>
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>