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
    'waypoint_2_adress' => $_SESSION['waypoint_2_adress']
];
$page = intval(filter_input(INPUT_GET, 'p'));
?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="selectReserve wrapper">
        <h2 class="subPageH2">予約情報</h2>
        <section>
            <h3 class="subPageH3">以下から予約を登録</h3>
            <div id="jsRsvCdTbl" class="reserveConditionTable jscInnerTableWrap">
                <table class="innerTable nowrap jscInnerTable" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="weekPaging">
                                <a href="selectReserve.php?p=<?= $page - 1 ?>" title="前の一週間" class="arrowPagingWeekR jscCalNavi">
                                    <span class="">前の一週間</span>
                                </a>
                            </th>
                            <th colspan="14" class="monthCell">
                                <?= date('Y年m月', strtotime('+' . ($page * 7) . 'day')) ?>
                            </th>
                            <th rowspan="2" class="weekPaging">
                                <a href="selectReserve.php?p=<?= $page + 1 ?>" title="次の一週間" class="arrowPagingWeekR jscCalNavi">
                                    <span>次の一週間</span>
                                </a>
                        </th>
                    </tr>
                        <tr class="dayCellContainer">
                            <?php for ($i=0; $i < 14; $i++): ?>
                                <th class="dayCell"><?= date('d', strtotime('+' . ($i + $page * 7) . 'day')) ?><br>(<?= $arr_week[date('w', strtotime('+' . $i . 'day'))] ?>)</th>
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
                                                    <?= date('H:i', strtotime(floor(($i / 2) + 6) . ':' . (($i % 2) * 30))) ?>
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
                                                <?php $departure_time = date('Y/m/d/', strtotime('+' . ($i + $page * 7) . 'day ')) . date('H:i', strtotime(floor(($j / 2) + 6) . ':' . (($j % 2) * 30))) ?>
                                                <?php $check = checkReserve($reserve, $departure_time) ?>
                                                <?php if($check): ?>
                                                    <td class="closeCell timeSharpLine isDisabled">
                                                        <a href="insertReserveComplate.php?date=<?= $departure_time ?>"><span class="icnClose">○</span></a>
                                                    </td>
                                                <?php else: ?>
                                                    <td class="closeCell timeSharpLine isDisabled">
                                                        <span class="icnClose">×</span>
                                                    </td>
                                                <?php endif ?>
                                            </tr>
                                            <?php endfor ?>
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
                                                    <?= date('H:i', strtotime(floor(($i / 2) + 6) . ':' . (($i % 2) * 30))) ?>
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