<?php

$title = " | 会員登録";

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="loginParts signUp2 wrapper">
        <h2 class="subPageH2">会員登録</h2>
        <section>
            <h3 class="subPageH3">会員情報を登録</h3>
            <form action="" method="post">
                <label for="name" class="label1">ユーザー名</label>
                <input type="text" name="name" id="name" class="input1" placeholder="ユーザー名" required value="mamasan@taxi.com">
                <label for="male" class="label2">性別</label>
                <div class="input2">
                    <label>男
                        <input type="radio" name="sex" id="male" value="1" required>
                    </label>
                    <label>女
                        <input type="radio" name="sex" id="female" value="2" required>
                    </label>
                    <label>その他
                        <input type="radio" name="sex" id="other" value="3" required>
                    </label>
                </div>
                <label for="birth" class="label3">生年月日</label>
                <input type="date" name="birth" id="birth" class="input3" placeholder="2021/9/5" required>
                <label for="tel" class="label4">電話番号</label>
                <input type="tel" name="tel" id="tel" class="input4" placeholder="000-0000-0000" required>
                <input type="submit" value="確認">
                <!-- <a href="">戻る</a> -->
            </form>
            <a href="login.php">ログインはこちら</a>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>