<?php

require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connectDb()
{
    try {
        return new PDO(DSN, USER, PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo 'システムエラーが発生しました';
        error_log($e->getMessage());
        exit;
    }
}

// エスケープ処理を行う関数
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// login関連

function signupValidate ($email, $password, $re_password)
{
    $errors = [];
    
    $checkEmail = findUserByEmail($email);
    
    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    } elseif ($checkEmail) {
        $errors[] = MSG_EMAIL_USED;
    }
    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    } elseif (empty($re_password)) {
        $errors[] = MSG_PASSWORD_2_REQUIRED;
    } elseif ($password !== $re_password) {
        $errors[] = MSG_PASSWORD_NOT_MATCH;
    }
    return $errors;
}
function signupValidate2($name, $sex, $birth, $tel)
{
    $errors = [];

    $checkTel = findUserByEmail($tel);

    if (empty($name)) {
        $name = $_SESSION['email'];
    }
    if (empty($sex)) {
        $errors[] = MSG_SEX_REQUIRED;
    }
    if (empty($birth)) {
        $errors[] = MSG_BIRTH_REQUIRED;
    }
    if (empty($tel)) {
        $errors[] = MSG_TEL_REQUIRED;
    } elseif ($checkTel) {
        $errors[] = MSG_USER_TEL_USED;
    }
    return $errors;
}
function insertUser($email, $password, $name, $sex, $birth, $tel)
{
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
}
function loginValidate ($email, $password)
{
    $errors = [];
    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }
    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }
    return $errors;
}
function findUserByEmail($email)
{
    $dbh = connectDB();
    $sql = <<<EOM
        SELECT
            *
        FROM
            users
        WHERE
            email = :email;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserByTel($tel)
{
    $dbh = connectDB();
    $sql = <<<EOM
        SELECT
            *
        FROM
            users
        WHERE
            tel = :tel;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}