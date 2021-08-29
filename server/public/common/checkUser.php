<?php

$title = " | 会員情報確認";

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.php' ?>

<body>

<?php include_once __DIR__ . '/_header.php' ?>

<article>
    <div class="checkUser wrapper">
        <h2 class="subPageH2">会員情報確認</h2>
        <section>
            <h3 class="subPageH3">以下の情報で登録</h3>
            <div class="checkUserData">
                <dl class="check1">
                    <dt>PCメールアドレス</dt>
                    <dd>
                        <span>:</span>asasda@asasdad.com
                    </dd>
                </dl>
                <dl class="check2">
                    <dt>パスワード</dt>
                    <dd>
                        <span>:</span>*********
                    </dd>
                </dl>
                <dl class="check3">
                    <dt>ユーザー名</dt>
                    <dd>
                        <span>:</span>木村ママ
                    </dd>
                </dl>
                <dl class="check4">
                    <dt>性別</dt>
                    <dd>
                        <span>:</span>女
                    </dd>
                </dl>
                <dl class="check5">
                    <dt>生年月日</dt>
                    <dd>
                        <span>:</span>1990年1月1日
                    </dd>
                </dl>
                <dl class="check6">
                    <dt>電話番号</dt>
                    <dd>
                        <span>:</span>09012345678
                    </dd>
                </dl>
                <form action="" method="post">
                    <input type="submit" value="登録">
                    <a href="">戻る</a>
                </form>
            </div>
        </section>
    </div>
</article>

<?php include_once __DIR__ . '/_footer.html' ?>

</body>
</html>