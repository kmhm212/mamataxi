<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | 会員登録";

session_start();

unset($_SESSION['email']);
unset($_SESSION['password']);

if ($_SESSION['id']) {
    header('Location: ../index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $re_password = filter_input(INPUT_POST, 'rePassword');

    $errors = signupValidate($email, $password, $re_password);

    if (empty($errors)) {
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('Location: signup2.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="loginParts signUp wrapper">
        <h2 class="subPageH2">会員登録</h2>
        <section>
            <h3 class="subPageH3">メールアドレスで登録</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="email" class="label1">メールアドレス</label>
                <input type="email" name="email" id="email" class="input1" placeholder="mamasan@taxi.com" value="<?= h($email)?>">
                <label for="password" class="label2">パスワード</label>
                <input type="password" name="password" id="password" class="input2" placeholder="パスワード">
                <label for="rePassword" class="label3">パスワード(確認)</label>
                <input type="password" name="rePassword" id="rePassword" class="input3" placeholder="パスワード(確認)">
                <input type="submit" value="次へ">
            </form>
            <a href="login.php">ログインはこちら</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>