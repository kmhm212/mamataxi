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
$adresses = findAdressByUserId($id);

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

    $select_departure = filter_input(INPUT_POST, 'select_departure');
    if ($select_departure != 'new') {
        $select_adress = findAdressByAdressId($select_departure);
        $departure_postal_code_1 = substr($select_adress['postal_code'], 0, 3);
        $departure_postal_code_2 = substr($select_adress['postal_code'], 4);
        $departure_adress = $select_adress['adress'];
    }
    $select_destination = filter_input(INPUT_POST, 'select_destination');
    if ($select_destination != 'new') {
        $select_adress = findAdressByAdressId($select_destination);
        $destination_postal_code_1 = substr($select_adress['postal_code'], 0, 3);
        $destination_postal_code_2 = substr($select_adress['postal_code'], 4);
        $destination_adress = $select_adress['adress'];
    }
    $select_waypoint_1 = filter_input(INPUT_POST, 'select_waypoint_1');
    if ($select_waypoint_1 != 'new') {
        $select_adress = findAdressByAdressId($select_waypoint_1);
        $waypoint_1_postal_code_1 = substr($select_adress['postal_code'], 0, 3);
        $waypoint_1_postal_code_2 = substr($select_adress['postal_code'], 4);
        $waypoint_1_adress = $select_adress['adress'];
    }
    $select_waypoint_2 = filter_input(INPUT_POST, 'select_waypoint_2');
    if ($select_waypoint_2 != 'new') {
        $select_adress = findAdressByAdressId($select_waypoint_2);
        $waypoint_2_postal_code_1 = substr($select_adress['postal_code'], 0, 3);
        $waypoint_2_postal_code_2 = substr($select_adress['postal_code'], 4);
        $waypoint_2_adress = $select_adress['adress'];
    }

    $errors = insertReserveValidate($departure_postal_code_1, $departure_postal_code_2, $departure_adress, $destination_postal_code_1, $destination_postal_code_2, $destination_adress, $waypoint_1_postal_code_1, $waypoint_1_postal_code_2, $waypoint_1_adress, $waypoint_2_postal_code_1, $waypoint_2_postal_code_2, $waypoint_2_adress, $child_id);

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

        header('Location: selectReserve.php');
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
    <div class="formParts insertReserve wrapper">
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

                <div class="reserveAdress adress1">
                    <h4>出発地</h4>
                    <label for="select_departure label1">登録済み住所から選ぶ</label>
                    <select name="select_departure" id="select_departure" class="input1">
                        <option value="new" selected>-</option>
                        <?php foreach($adresses as $adress): ?>
                            <option value="<?= h($adress['id'])?>"><?= h($adress['name'])?></option> 
                        <?php endforeach ?>
                    </select>
                    <label for="departure_postal_code_1" class="label2">郵便番号</label>
                    <div class="input2">
                        <input type="number" name="departure_postal_code_1" id="departure_postal_code_1" placeholder="000" value="<?= h($departure_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="departure_postal_code_2" id="departure_postal_code_2" placeholder="0000" value="<?= h($departure_postal_code_2) ?>">
                    </div>
                    <label for="departure_adress" class="label3">住所</label>
                    <input type="text" name="departure_adress" id="departure_adress" class="input3" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($departure_adress) ?>">
                </div>
                
                <div class="reserveAdress adress2">
                    <h4>目的地</h4>
                    <label for="select_destination label1">登録済み住所から選ぶ</label>
                    <select name="select_destination" id="select_destination" class="input1">
                        <option value="new" selected>-</option>
                        <?php foreach($adresses as $adress): ?>
                            <option value="<?= h($adress['id'])?>"><?= h($adress['name'])?></option> 
                        <?php endforeach ?>
                    </select>
                    <label for="destination_postal_code_1" class="label2">郵便番号</label>
                    <div class="input2">
                        <input type="number" name="destination_postal_code_1" id="destination_postal_code_1" placeholder="000" value="<?= h($destination_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="destination_postal_code_2" id="destination_postal_code_2" placeholder="0000" value="<?= h($destination_postal_code_2) ?>">
                    </div>
                    <label for="destination_adress" class="label3">住所</label>
                    <input type="text" name="destination_adress" id="destination_adress" class="input3" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($destination_adress) ?>">
                </div>

                <div class="reserveAdress adress3">
                    <h4>経由地①</h4>
                    <label for="select_waypoint_1 label1">登録済み住所から選ぶ</label>
                    <select name="select_waypoint_1" id="select_waypoint_1" class="input1">
                        <option value="new" selected>-</option>
                        <?php foreach($adresses as $adress): ?>
                            <option value="<?= h($adress['id'])?>"><?= h($adress['name'])?></option> 
                        <?php endforeach ?>
                    </select>
                    <label for="waypoint_1_postal_code_1" class="label2">郵便番号</label>
                    <div class="input2">
                        <input type="number" name="waypoint_1_postal_code_1" id="waypoint_1_postal_code_1" placeholder="000" value="<?= h($waypoint_1_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="waypoint_1_postal_code_2" id="waypoint_1_postal_code_2" placeholder="0000" value="<?= h($waypoint_1_postal_code_2) ?>">
                    </div>
                    <label for="waypoint_1_adress" class="label3">住所</label>
                    <input type="text" name="waypoint_1_adress" id="waypoint_1_adress" class="input3" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($waypoint_1_adress) ?>">
                </div>

                <div class="reserveAdress adress4">
                    <h4>経由地②</h4>
                    <label for="select_waypoint_2 label1">登録済み住所から選ぶ</label>
                    <select name="select_waypoint_2" id="select_waypoint_2" class="input1">
                        <option value="new" selected>-</option>
                        <?php foreach($adresses as $adress): ?>
                            <option value="<?= h($adress['id'])?>"><?= h($adress['name'])?></option> 
                        <?php endforeach ?>
                    </select>
                    <label for="waypoint_2_postal_code_1" class="label2">郵便番号</label>
                    <div class="input2">
                        <input type="number" name="waypoint_2_postal_code_1" id="waypoint_2_postal_code_1" placeholder="000" value="<?= h($waypoint_2_postal_code_1) ?>">
                        <span>-</span>
                        <input type="number" name="waypoint_2_postal_code_2" id="waypoint_2_postal_code_2" placeholder="0000" value="<?= h($waypoint_2_postal_code_2) ?>">
                    </div>
                    <label for="waypoint_2_adress" class="label3">住所</label>
                    <input type="text" name="waypoint_2_adress" id="waypoint_2_adress" class="input3" placeholder="〇〇県〇〇市〇〇町1−2−3 〇〇マンション101号室" value="<?= h($waypoint_2_adress) ?>">
                </div>
                <div class="reserveChildren">
                    <h4>ご利用のお子様</h4>
                    <?php foreach($children as $child): ?>
                        <input type="checkbox" name="child_id[]" value="<?= h($child['id']) ?>" id="child<?= h($child['id']) ?>">
                        <label for="child<?= h($child['id']) ?>">
                            <?= h($child['name']) ?>
                        </label>
                    <?php endforeach ?>
                </div>
                <input type="submit" value="日時を選択する">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>