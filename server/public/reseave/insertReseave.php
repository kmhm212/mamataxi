<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 予約登録';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

$reseave = [
    'user_id' => 0,
    'departure_area_id' => 1,
    'departure_postal_code' => $_SESSION['departure_postal_code'],
    'departure_adress' => $_SESSION['departure_adress'],
    'destination_area_id' => 2,
    'destination_postal_code' => $_SESSION['destination_postal_code'],
    'destination_adress' => $_SESSION['destination_adress'],
    'waypoint_1_area_id' => $_SESSION['waypoint_1_area_id'],
    'waypoint_1_postal_code' => $_SESSION['waypoint_1_postal_code'],
    'waypoint_1_adress' => $_SESSION['waypoint_1_adress'],
    'waypoint_2_area_id' => $_SESSION['waypoint_2_area_id'],
    'waypoint_2_postal_code' => $_SESSION['waypoint_2_postal_code'],
    'waypoint_2_adress' => $_SESSION['waypoint_2_adress']
    // 'user_id' => $_SESSION['user_id'],
    // 'departure_area_id' => $_SESSION['departure_area_id'],
    // 'departure_postal_code' => $_SESSION['departure_postal_code'],
    // 'departure_adress' => $_SESSION['departure_adress'],
    // 'destination_area_id' => $_SESSION['destination_area_id'],
    // 'destination_postal_code' => $_SESSION['destination_postal_code'],
    // 'destination_adress' => $_SESSION['destination_adress'],
    // 'waypoint_1_area_id' => $_SESSION['waypoint_1_area_id'],
    // 'waypoint_1_postal_code' => $_SESSION['waypoint_1_postal_code'],
    // 'waypoint_1_adress' => $_SESSION['waypoint_1_adress'],
    // 'waypoint_2_area_id' => $_SESSION['waypoint_2_area_id'],
    // 'waypoint_2_postal_code' => $_SESSION['waypoint_2_postal_code'],
    // 'waypoint_2_adress' => $_SESSION['waypoint_2_adress']
];
$arr_week = ['月', '火', '水', '木', '金', '土', '日'];

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="insertReseave wrapper">
        <h2 class="subPageH2">予約情報</h2>
        <section>
            <h3 class="subPageH3">以下から予約を登録</h3>
            <div id="jsRsvCdTbl" class="reserveConditionTable jscInnerTableWrap">
                <table class="innerTable nowrap jscInnerTable" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="weekPaging">
                                <a href="" title="前の一週間" class="arrowPagingWeekR jscCalNavi">
                                    <span class="">前の一週間</span>
                                </a>
                            </th>
                            <th colspan="14" class="monthCell">
                                <?= date('Y年m月') ?>
                            </th>
                            <th rowspan="2" class="weekPaging">
                                <a href="" title="次の一週間" class="arrowPagingWeekR jscCalNavi">
                                    <span>次の一週間</span>
                                </a>
                        </th>
                    </tr>
                        <tr class="dayCellContainer">
                            <?php for ($i=0; $i < 14; $i++): ?>
                                <th class="dayCell"><?= date('d') + $i ?><br>(<?= $arr_week[(date('w') + $i) % 7] ?>)</th>
                            <?php endfor ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                                <table cellpadding="0" cellspacing="0" class="moreInnerTable timeTableLeft">
                                    <tbody>
                                        <?php for ($i=0; $i < 28; $i++): ?>
                                            <tr>
                                                <th class="timeCell ">
                                                    <?= h(floor($i / 2) + 6) ?>：<?= h(($i % 2) * 3) ?>0
                                                </th>
                                            </tr>
                                        <?php endfor ?>
                                    </tbody>
                                </table>
                            </th>
                            <?php for ($i=0; $i < 14 ; $i++) : ?>
                                <th class="innerCol">
                                    <table cellpadding="0" cellspacing="0" class="moreInnerTable">
                                        <tbody>
                                            <?php for ($j=0; $j < 28; $j++): ?>
                                                <tr>
                                                <?php $check = checkReseave($reseave, $i, $j) ?>
                                                <?php if($check): ?>
                                                    <td class="closeCell timeSharpLine isDisabled">
                                                        <a href=""><span class="icnClose">○</span></a>
                                                    </td>
                                                <?php else: ?>
                                                    <td class="closeCell timeSharpLine isDisabled">
                                                        <a href=""><span class="icnClose">×</span></a>
                                                    </td>
                                                <?php endif ?>
                                            </tr>
                                            <?php endfor ?>
                                            <!-- <tr>
                                                <td class="openCell timeSharpLine isDisabled">
                                                    <a href=""><span class="icnOpen">◎</span></a>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </th>
                            <?php endfor ?>
                            <th>
                                <table cellpadding="0" cellspacing="0" class="moreInnerTable timeTableLeft">
                                    <tbody>
                                        <?php for ($i=0; $i < 28; $i++): ?>
                                            <tr>
                                                <th class="timeCell ">
                                                    <?= h(floor($i / 2) + 6) ?>：<?= h(($i % 2) * 3) ?>0
                                                </th>
                                            </tr>
                                        <?php endfor ?>
                                    </tbody>
                                </table>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>