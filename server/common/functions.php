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
function signupValidate2($name, $sex, $birth, $tel, $postal_code1, $postal_code2, $adress)
{
    $errors = [];

    $checkTel = findUserByTel($tel);

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
        $errors[] = MSG_TEL_USED;
    }
    if (empty($postal_code1 || $postal_code2)) {
        $errors[] = MSG_POSTAL_CODE_REQUIRED;
    }
    if (empty($adress)) {
        $errors[] = MSG_ADRESS_REQUIRED;
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
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->execute();
}
function insertAdress($user, $name, $tel, $postal_code, $adress)
{
    $area_id = findAreaId($postal_code);

    $dbh = connectDb();
    $sql = <<<EOM
    INSERT INTO
        adresses
        (user_id, name, tel, postal_code, area_id, adress)
        VALUES
        (:user_id, :name, :tel, :postal_code, :area_id, :adress);
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
    $stmt->bindParam(':area_id', $area_id['id'], PDO::PARAM_INT);
    $stmt->bindParam(':adress', $adress, PDO::PARAM_STR);
    $stmt->execute();
}
function findAreaId($postal_code)
{
    $area_code = intval(str_replace('-', '', $postal_code)) % 5;
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            id
        FROM
            areas
        WHERE
            area_code = :area_code;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':area_code', $area_code, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

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
    $dbh = connectDb();
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
    $dbh = connectDb();
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

// 子どもいるか判断

function haveChild($user_id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            children
        WHERE
            user_id = :user_id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// mypage

function findById($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            users
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function changeUserValidate($user, $name, $sex, $birth, $tel)
{
    $errors = [];

    $checkTel = findUserByTel($tel);

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
    } elseif ($tel != $user['tel'] && $checkTel) {
        $errors[] = MSG_TEL_USED;
    }
    if ($name == $user['name']
    && $sex == $user['sex']
    && $birth == $user['birth']
    && $tel == $user['tel']) {
        $errors[] = MSG_NO_CHANGE;
    }
    return $errors;
}
function updateUser($id, $name, $sex, $birth, $tel)
{
    $dbh = connectDb();
    $sql = <<<EOM
        UPDATE
            users
        SET
            name = :name,
            sex = :sex,
            birth = :birth,
            tel = :tel
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':sex', $sex, PDO::PARAM_INT);
    $stmt->bindParam(':birth', $birth, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->execute();
}
function changePassValidate($password, $new_password, $re_new_password)
{
    $errors = [];
    
    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }
    if (empty($new_password)) {
        $errors[] = MSG_NEW_PASSWORD_REQUIRED;
    } elseif ($new_password !== $re_new_password) {
        $errors[] = MSG_NEW_PASSWORD_NOT_MATCH;
    }
    if (empty($re_new_password)) {
        $errors[] = MSG_NEW_PASSWORD_2_REQUIRED;
    }
    return $errors;
}
function updatePassword($id, $new_password)
{
    $dbh = connectDb();
    $sql = <<<EOM
        UPDATE
            users
        SET
            password = :password
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
    $stmt->execute();
}

// 住所