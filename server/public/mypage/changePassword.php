<?php

require_once __DIR__ . '/../../common/functions.php';

$title = ' | パスワード変更';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

$user = findById($id);
$password = $user['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $password = filter_input(INPUT_POST, 'password');
    $new_password = filter_input(INPUT_POST, 'newPassword');
    $re_new_password = filter_input(INPUT_POST, 'reNewPassword');
    
    $errors = changePassValidate($password, $new_password, $re_new_password);

    if (empty($errors)) {
        if (password_verify($password, $user['password'])) {
            updatePassword($id, password_hash($new_password, PASSWORD_DEFAULT));
            unset($_SESSION['id']);
            header('Location: ../common/login.php?pp=changepasscomp');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/../common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/../common/_header.php' ?>

<article>
    <div class="formParts changePassword wrapper">
        <h2 class="subPageH2">会員情報</h2>
        <section>
            <h3 class="subPageH3">パスワードを変更</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="password">現在のパスワードを入力</label>
                <input type="password" name="password" id="password">
                <label for="newPassword">新しいパスワードを入力</label>
                <input type="password" name="newPassword" id="newPassword">
                <label for="reNewPassword">新しいパスワードを入力(確認)</label>
                <input type="password" name="reNewPassword" id="reNewPassword">
            <input type="submit" value="変更">
            </form>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/../common/_footer.html' ?>
