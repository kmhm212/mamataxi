<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 予約登録';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

$reserve = [
    'user_id' => $id,
    'departure_time' => filter_input(INPUT_GET, 'date'),
    'departure_area_id' => $_SESSION['departure_area_id'],
    'departure_postal_code' => $_SESSION['departure_postal_code'],
    'departure_adress' => $_SESSION['departure_adress'],
    'destination_area_id' => $_SESSION['destination_area_id'],
    'destination_postal_code' => $_SESSION['destination_postal_code'],
    'destination_adress' => $_SESSION['destination_adress'],
    'waypoint_1_area_id' => $_SESSION['waypoint_1_area_id'],
    'waypoint_1_postal_code' => $_SESSION['waypoint_1_postal_code'],
    'waypoint_1_adress' => $_SESSION['waypoint_1_adress'],
    'waypoint_2_area_id' => $_SESSION['waypoint_2_area_id'],
    'waypoint_2_postal_code' => $_SESSION['waypoint_2_postal_code'],
    'waypoint_2_adress' => $_SESSION['waypoint_2_adress'],
    'child_id' => $_SESSION['child_id']
];

$reserve['destination_time'] = date('Y/m/d/H:i', strtotime($reserve['departure_time'] . '+ '. timeCalculationAtReserve($reserve['departure_area_id'], $reserve['destination_area_id'], $reserve['waypoint_1_area_id'], $reserve['waypoint_2_area_id']) . ' minute'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertReserve($reserve);
    insertReserveChildren($reserve);
    
    unset($_SESSION['departure_area_id']);
    unset($_SESSION['departure_postal_code']);
    unset($_SESSION['departure_adress']);
    unset($_SESSION['destination_area_id']);
    unset($_SESSION['destination_postal_code']);
    unset($_SESSION['destination_adress']);
    unset($_SESSION['waypoint_1_area_id']);
    unset($_SESSION['waypoint_1_postal_code']);
    unset($_SESSION['waypoint_1_adress']);
    unset($_SESSION['waypoint_2_area_id']);
    unset($_SESSION['waypoint_2_postal_code']);
    unset($_SESSION['waypoint_2_adress']);
    unset($_SESSION['child_id']);
    
    header('Location: ../mypage/mypage.php?pp=insertcomp');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="myPageParts insertReserveComp wrapper">
        <h2 class="subPageH2">予約情報</h2>
        <section>
            <h3 class="subPageH3">予約情報を確認</h3>
            <div class="checkUserData">
                <dl class="">
                    <dt>予約日時</dt>
                    <dd>
                        <span>:</span><?= h(date('Y年m月d日', strtotime($reserve['departure_time']))) . "（" . h($arr_week[date('w', strtotime($reserve['departure_time']))]) . "）" . h(date(' H:i', strtotime($reserve['departure_time']))) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>出発地(郵便番号)</dt>
                    <dd>
                        <span>:</span>〒<?= h(substr($reserve['departure_postal_code'], 0, 3) . "-" . substr($reserve['departure_postal_code'], 4)) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>出発地(住所)</dt>
                    <dd>
                        <span>:</span><?= h($reserve['departure_adress']) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>目的地(郵便番号)</dt>
                    <dd>
                        <span>:</span>〒<?= h(substr($reserve['destination_postal_code'], 0, 3) . "-" . substr($reserve['destination_postal_code'], 4)) ?>
                    </dd>
                </dl>
                <dl class="">
                    <dt>目的地(住所)</dt>
                    <dd>
                        <span>:</span><?= h($reserve['destination_adress']) ?>
                    </dd>
                </dl>
                <?php if($reserve['waypoint_1_postal_code']): ?>
                    <dl class="">
                        <dt>経由地①(郵便番号)</dt>
                        <dd>
                            <span>:</span>〒<?= h(substr($reserve['waypoint_1_postal_code'], 0, 3) . "-" . substr($reserve['waypoint_1_postal_code'], 4)) ?>
                        </dd>
                    </dl>
                    <dl class="">
                        <dt>経由地①(住所)</dt>
                        <dd>
                            <span>:</span><?= h($reserve['waypoint_1_adress']) ?>
                        </dd>
                    </dl>
                <?php endif ?>
                <?php if($reserve['waypoint_2_postal_code']): ?>
                    <dl class="">
                        <dt>経由地②(郵便番号)</dt>
                        <dd>
                            <span>:</span>〒<?= h(substr($reserve['waypoint_2_postal_code'], 0, 3) . "-" . substr($reserve['waypoint_2_postal_code'], 4)) ?>
                        </dd>
                    </dl>
                    <dl class="">
                        <dt>経由地②(住所)</dt>
                        <dd>
                            <span>:</span><?= h($reserve['waypoint_2_adress']) ?>
                        </dd>
                    </dl>
                <?php endif ?>
                <?php foreach($reserve['child_id'] as $child_id): ?>
                <dl class="">
                    <dt>ご利用園児</dt>
                    <dd>
                        <span>:</span><?= h(findChildByChildId($child_id)['name']) ?>
                    </dd>
                </dl>
                <?php endforeach ?>
                <form action="" method="post">
                    <input type="submit" value="予約登録">
                    <a href="selectReserve.php">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>