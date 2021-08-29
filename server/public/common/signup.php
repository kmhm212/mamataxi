<?php

$title = " | 会員登録";

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="signUp wrapper">
        <h2 class="subPageH2">会員登録</h2>
        <section>
            <h3 class="subPageH3">メールアドレスで登録</h3>
            <form action="" method="post">
                <label for="email" class="label1">メールアドレス</label>
                <input type="email" name="email" id="email" class="input1" placeholder="例) mamasan@taxi.com" required>
                <label for="password" class="label2">パスワード</label>
                <input type="password" name="password" id="password" class="input2" placeholder="パスワード" required>
                <label for="rePassword" class="label3">パスワード(確認)</label>
                <input type="password" name="rePassword" id="rePassword" class="input3" placeholder="パスワード(確認)" required>
                <input type="submit" value="規約に同意して次へ">
            </form>
            <a href="login.php">ログインはこちら</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>