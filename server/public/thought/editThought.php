<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 感想';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$thought_id = filter_input(INPUT_GET, 'id');
$thought = findThoughtsById($thought_id);
$reserve = findReserveById($thought['reserve_id']);

$thought_title = $thought['title'];
$body = $thought['body'];

if (filter_input(INPUT_GET, 'pp') == 'back') {
    $reserve = findReserveById($_SESSION['reserve_id']);
    $thought_title = $_SESSION['title'];
    $body = $_SESSION['body'];
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $thought_title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');

    $errors = editThoughtValidate($thought, $thought_title, $body);

    if (empty($errors)) {
        $_SESSION['reserve_id'] = $reserve['id'];
        $_SESSION['title'] = $thought_title;
        $_SESSION['body'] = $body;
        header('Location: editThoughtComplate.php');
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
    <div class="formParts insertThought wrapper">
        <h2 class="subPageH2">感想情報</h2>
        <section>
            <h3 class="subPageH3">感想を変更</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="reserveId" class="label1">予約日時</label>
                <select name="reserveId" id="reserveId" class="input1">
                    <option value="<?= h($reserve['id'])?>">
                        <?= h(date('Y年m月d日 H:i', strtotime($reserve['departure_time'])))?>
                    </option> 
                </select>
                <label for="title" class="label2">タイトル</label>
                <input type="text" name="title" id="title" class="input2" value="<?= h($thought_title) ?>">
                <label for="body" class="label3">本文</label>
                <textarea name="body" id="body" class="input3" cols="80" rows="20"><?= h($body) ?></textarea>
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>