<?php

$title = " | ログイン";

require_once __DIR__ . '/../../common/functions.php';

session_start();

if($_SESSION['id']) {
    header('Location: ../index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    
    $errors = loginValidate($email, $password);

    if (empty($errors)) {
        $user = findUserByEmail($email);
        if (password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            header('Location: ../index.php');
            exit;
        } else {
            $errors[] = MSG_EMAIL_PASSWORD_NOT_MATCH;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="loginParts login wrapper">
        <h2 class="subPageH2">ログイン</h2>
        <section>
            <h3 class="subPageH3">メールアドレスでログイン</h3>
            <?php if($errors): ?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post">
                <label for="email" class="label1">メールアドレス</label>
                <input type="email" name="email" id="email" class="input1" placeholder="mamasan@taxi.com">
                <label for="password" class="label2">パスワード</label>
                <input type="password" name="password" id="password" class="input2" placeholder="パスワード">
                <input type="submit" value="ログイン">
            </form>
            <a href="signup.php">会員登録はこちら</a><br>
            <a href="">パスワードを忘れたりなんかしない</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>