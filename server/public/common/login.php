<?php

$title = " | ログイン";

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
            <form action="" method="post">
                <label for="email" class="label1">メールアドレス</label>
                <input type="email" name="email" id="email" class="input1" placeholder="mamasan@taxi.com" required>
                <label for="password" class="label2">パスワード</label>
                <input type="password" name="password" id="password" class="input2" placeholder="パスワード" required>
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