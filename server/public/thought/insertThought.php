<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | マイページ > 感想';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];
$reseave_id = filter_input(INPUT_GET, 'id');
if ($reseave_id) {
    $reseaves[0] = findReseaveById($reseave_id);
} else {
$reseaves = findAfterReseaveIdByUserId($id);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $reseaveId = filter_input(INPUT_POST, 'reseaveId');
    $thoughtTitle = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');

    $errors = insertThoughtValidate($reseaveId, $thoughtTitle, $body);

    if (empty($errors)) {
        $_SESSION['reseaveId'] = $reseaveId;
        $_SESSION['title'] = $thoughtTitle;
        $_SESSION['body'] = $body;
        header('Location: insertThoughtComplate.php');
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
            <h3 class="subPageH3">感想を登録</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="reseaveId" class="label1">予約日時</label>
                <select name="reseaveId" id="reseaveId" class="input1">
                    <?php foreach($reseaves as $reseave): ?>
                        <option value="<?= h($reseave['id'])?>"><?= h(date('Y年m月d日 H:i', strtotime($reseave['departure_time'])))?></option> 
                    <?php endforeach ?>
                </select>
                <label for="title" class="label2">タイトル</label>
                <input type="text" name="title" id="title" class="input2" value="<?= h($thoughtTitle) ?>">
                <label for="body" class="label3">本文</label>
                <textarea name="body" id="body" class="input3" cols="80" rows="20" value="<?= nl2br(h($body)) ?>"></textarea>
                <input type="submit" value="確認">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>

</body>
</html>