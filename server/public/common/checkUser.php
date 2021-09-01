<?php

require_once __DIR__ . '/../../common/functions.php';

$title = " | 会員情報確認";

session_start();

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$name = $_SESSION['name'];
$sex = $_SESSION['sex'];
$birth = $_SESSION['birth'];
$tel = $_SESSION['tel'];

$array_sex = ['男', '女', 'その他'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dbh = connectDb();
    $sql = <<<EOM
    INSERT INTO
        users
        (email, password, name, sex, birth, tel)
        VALUES
        (:email, :password, :name, :sex, :birth, :tel);
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':sex', $sex, PDO::PARAM_INT);
    $stmt->bindParam(':birth', $birth, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../index.php');
    exit;
}

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
                        <span>:</span><?= h($email) ?>
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
                        <span>:</span><?= h($name) ?>
                    </dd>
                </dl>
                <dl class="check4">
                    <dt>性別</dt>
                    <dd>
                        <span>:</span><?= h($array_sex[$sex]) ?>
                    </dd>
                </dl>
                <dl class="check5">
                    <dt>生年月日</dt>
                    <dd>
                        <span>:</span><?= h($birth) ?>
                    </dd>
                </dl>
                <dl class="check6">
                    <dt>電話番号</dt>
                    <dd>
                        <span>:</span><?= h($tel) ?>
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