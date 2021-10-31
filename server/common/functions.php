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
    } elseif (strlen($tel) > 11 || strlen($tel) < 10) {
        $errors[] = MSG_TEL_LIMIT;
    } elseif ($checkTel) {
        $errors[] = MSG_TEL_USED;
    }
    if (empty($postal_code1 || $postal_code2)) {
        $errors[] = MSG_POSTAL_CODE_REQUIRED;
    } elseif (strlen($postal_code1) != 3 ||strlen($postal_code2) != 4) {
        $errors[] = MSG_POSTAL_CODE_LIMIT;
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
function findUserById($id)
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
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
    } elseif (strlen($tel) > 11 || strlen($tel) < 10) {
        $errors[] = MSG_TEL_LIMIT;
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

function findAdressByUserId($user_id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            adresses
        WHERE
            user_id = :user_id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}
function findAdressByAdressId($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            adresses
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function insertAdress($user_id, $name, $tel, $postal_code, $adress)
{
    $area = findAreaId($postal_code);

    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            adresses
            (user_id, name, tel, postal_code, area_id, adress)
        VALUES
            (:user_id, :name, :tel, :postal_code, :area_id, :adress);
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
    $stmt->bindParam(':area_id', $area['id'], PDO::PARAM_INT);
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
function changeAdressValidate($id, $name, $tel, $postal_code1, $postal_code2, $adress)
{
    $errors = [];
    $user_adress = findAdressByAdressId($id);

    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if (empty($postal_code1 || $postal_code2)) {
        $errors[] = MSG_POSTAL_CODE_REQUIRED;
    } elseif (strlen($postal_code1) != 3 ||strlen($postal_code2) != 4) {
        $errors[] = MSG_POSTAL_CODE_LIMIT;
    }
    if (empty($adress)) {
        $errors[] = MSG_ADRESS_REQUIRED;
    }
    if (empty($tel)) {

    } elseif (strlen($tel) > 11 || strlen($tel) < 10) {
        $errors[] = MSG_TEL_LIMIT;
    }
    if ($user_adress['name'] == $name
    && $user_adress['tel'] == $tel
    && $user_adress['postal_code'] == $postal_code1 . '-' . $postal_code2
    && $user_adress['adress'] == $adress) {
        $errors = MSG_NO_CHANGE;
    }
    return $errors;
}
function updateAdress($id, $name, $tel, $postal_code, $adress)
{
    $area = findAreaId($postal_code);

    $dbh = connectDb();
    $sql = <<<EOM
        UPDATE
            adresses
        SET
            name = :name,
            postal_code = :postal_code,
            adress = :adress,
            area_id = :area_id,
            tel = :tel
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
    $stmt->bindParam(':area_id', $area['id'], PDO::PARAM_INT);
    $stmt->bindParam(':adress', $adress, PDO::PARAM_STR);
    $stmt->execute();
}
function deleteAdress($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        DELETE FROM
            adresses
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
function insertAdressValidate($name, $tel, $postal_code1, $postal_code2, $adress)
{
    $errors = [];

    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if (empty($postal_code1 || $postal_code2)) {
        $errors[] = MSG_POSTAL_CODE_REQUIRED;
    } elseif (strlen($postal_code1) != 3 ||strlen($postal_code2) != 4) {
        $errors[] = MSG_POSTAL_CODE_LIMIT;
    }
    if (empty($adress)) {
        $errors[] = MSG_ADRESS_REQUIRED;
    }
    if (empty($tel)) {

    } elseif (strlen($tel) > 11 || strlen($tel) < 10) {
        $errors[] = MSG_TEL_LIMIT;
    }
    return $errors;
}
function findInsertAdress($user_id, $name, $tel, $postal_code, $adress)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            id
        FROM
            adresses
        WHERE
            user_id = :user_id
        AND
            name = :name
        AND
            tel = :tel
        AND
            postal_code = :postal_code
        AND
            adress = :adress;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
    $stmt->bindParam(':adress', $adress, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function findAreaCode($id) {
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            areas
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['area_code'];
}

// 子ども

function findChildrenByUserId($user_id)
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
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}
function findChildByChildId($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            children
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function insertChild($user_id, $name, $sex, $birth, $adress_id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            children
            (user_id, name, sex, birth, adress_id)
        VALUES
            (:user_id, :name, :sex, :birth, :adress_id);
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':sex', $sex, PDO::PARAM_INT);
    $stmt->bindParam(':birth', $birth, PDO::PARAM_STR);
    $stmt->bindParam(':adress_id', $adress_id, PDO::PARAM_INT);
    $stmt->execute();
}
function updataChildValidate($id, $name, $sex, $birth, $adress_id, $adress_name, $tel, $postal_code1, $postal_code2, $nursery_adress)
{
    $errors = [];
    if ($adress_id == 'new') {
        $errors = insertAdressValidate($adress_name, $tel, $postal_code1, $postal_code2, $nursery_adress);
    }
    $child = findChildByChildId($id);

    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if (empty($sex)) {
        $errors[] = MSG_SEX_REQUIRED;
    }
    if (empty($birth)) {
        $errors[] = MSG_BIRTH_REQUIRED;
    }
    if (empty($adress_id)) {
        $errors[] = MSG_ADRESS_REQUIRED;
    }
    if ($child['name'] == $name
    && $child['sex'] == $sex
    && $child['birth'] == $birth
    && $child['adress_id'] == $adress_id) {
        $errors[] = MSG_NO_CHANGE;
    }
    return $errors;
}
function updateChild($id, $name, $sex, $birth, $adress_id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        UPDATE
            children
        SET
            name = :name,
            sex = :sex,
            birth = :birth,
            adress_id = :adress_id
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':sex', $sex, PDO::PARAM_INT);
    $stmt->bindParam(':birth', $birth, PDO::PARAM_STR);
    $stmt->bindParam(':adress_id', $adress_id, PDO::PARAM_INT);
    $stmt->execute();
}
function deleteChild($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        DELETE FROM
            children
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
function insertChildValidate($name, $sex, $birth, $adress_id, $adress_name, $tel, $postal_code1, $postal_code2, $nursery_adress)
{
    $errors = [];
    if ($adress_id == 'new') {
        $errors = insertAdressValidate($adress_name, $tel, $postal_code1, $postal_code2, $nursery_adress);
    }
    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if (empty($sex)) {
        $errors[] = MSG_SEX_REQUIRED;
    }
    if (empty($birth)) {
        $errors[] = MSG_BIRTH_REQUIRED;
    }
    if (empty($adress_id)) {
        $errors[] = MSG_ADRESS_REQUIRED;
    }
    return $errors;
}

// 予約情報

function findReseaveById($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findReseaveByUserId($user_id)
{
    $now = date('Y/m/d/H:i');

    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            user_id = :user_id
        AND
            departure_time >= :now
        ORDER BY
            departure_time
        ASC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':now', $now, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

function insertReseaveValidate($departure_postal_code_1, $departure_postal_code_2, $departure_adress, $destination_postal_code_1, $destination_postal_code_2, $destination_adress, $waypoint_1_postal_code_1, $waypoint_1_postal_code_2, $waypoint_1_adress, $waypoint_2_postal_code_1, $waypoint_2_postal_code_2, $waypoint_2_adress, $child_id)
{
    $errors = [];

    if (empty($departure_postal_code_1 || $departure_postal_code_2)) {
        $errors[] = MSG_DEPARTURE_POSTAL_CODE_REQUIRED;
    } elseif (strlen($departure_postal_code_1) != 3 ||strlen($departure_postal_code_2) != 4) {
        $errors[] = MSG_DEPARTURE_POSTAL_CODE_LIMIT;
    }
    if (empty($departure_adress)) {
        $errors[] = MSG_DEPARTURE_ADRESS_REQUIRED;
    }

    if (empty($destination_postal_code_1 || $destination_postal_code_2)) {
        $errors[] = MSG_DESTINATION_POSTAL_CODE_REQUIRED;
    } elseif (strlen($destination_postal_code_1) != 3 ||strlen($destination_postal_code_2) != 4) {
        $errors[] = MSG_DESTINATION_POSTAL_CODE_LIMIT;
    }
    if (empty($destination_adress)) {
        $errors[] = MSG_DESTINATION_ADRESS_REQUIRED;
    }

    if ($waypoint_1_postal_code_1 || $waypoint_1_postal_code_2 || $waypoint_1_adress) {
        if (empty($waypoint_1_postal_code_1 || $waypoint_1_postal_code_2)) {
            $errors[] = MSG_WAYPOINT_1_POSTAL_CODE_REQUIRED;
        } elseif (strlen($waypoint_1_postal_code_1) != 3 ||strlen($waypoint_1_postal_code_2) != 4) {
            $errors[] = MSG_WAYPOINT_1_POSTAL_CODE_LIMIT;
        }
        if (empty($waypoint_1_adress)) {
            $errors[] = MSG_WAYPOINT_1_ADRESS_REQUIRED;
        }
    }
    
    if ($waypoint_2_postal_code_1 || $waypoint_2_postal_code_2 || $waypoint_2_adress) {
        if ($waypoint_1_postal_code_1 || $waypoint_1_postal_code_2 || $waypoint_1_adress) {
            if (empty($waypoint_2_postal_code_1 || $waypoint_2_postal_code_2)) {
                $errors[] = MSG_WAYPOINT_2_POSTAL_CODE_REQUIRED;
            } elseif (strlen($waypoint_2_postal_code_1) != 3 ||strlen($waypoint_2_postal_code_2) != 4) {
                $errors[] = MSG_WAYPOINT_2_POSTAL_CODE_LIMIT;
            }
            if (empty($waypoint_2_adress)) {
                $errors[] = MSG_WAYPOINT_2_ADRESS_REQUIRED;
            }
        } else {
            $errors[] = MSG_WAYPOINT_1_REQUIRED;
        }
    }
    if (empty($child_id)) {
        $errors[] = MSG_CHILD_REQUIRED;
    }

    return $errors;
}

function insertReseave($reseave)
{
    $null = null;
    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            reseaves
            (user_id, departure_time, destination_time, departure_area_id, departure_postal_code, departure_adress, destination_area_id, destination_postal_code, destination_adress, waypoint_1_area_id, waypoint_1_postal_code, waypoint_1_adress, waypoint_2_area_id, waypoint_2_postal_code, waypoint_2_adress)
        VALUES
            (:user_id, :departure_time, :destination_time, :departure_area_id, :departure_postal_code, :departure_adress, :destination_area_id, :destination_postal_code, :destination_adress, :waypoint_1_area_id, :waypoint_1_postal_code, :waypoint_1_adress, :waypoint_2_area_id, :waypoint_2_postal_code, :waypoint_2_adress)
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id',$reseave['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':departure_time',$reseave['departure_time'], PDO::PARAM_STR);
    $stmt->bindParam(':destination_time',$reseave['destination_time'], PDO::PARAM_STR);
    $stmt->bindParam(':departure_area_id',$reseave['departure_area_id'], PDO::PARAM_INT);
    $stmt->bindParam(':departure_postal_code',$reseave['departure_postal_code'], PDO::PARAM_STR);
    $stmt->bindParam(':departure_adress',$reseave['departure_adress'], PDO::PARAM_STR);
    $stmt->bindParam(':destination_area_id',$reseave['destination_area_id'], PDO::PARAM_INT);
    $stmt->bindParam(':destination_postal_code',$reseave['destination_postal_code'], PDO::PARAM_STR);
    $stmt->bindParam(':destination_adress',$reseave['destination_adress'], PDO::PARAM_STR);

    if ($reseave['waypoint_1_postal_area_id']) {
        $stmt->bindParam(':waypoint_1_area_id',$reseave['waypoint_1_area_id'], PDO::PARAM_INT);
        $stmt->bindParam(':waypoint_1_postal_code',$reseave['waypoint_1_postal_code'], PDO::PARAM_STR);
        $stmt->bindParam(':waypoint_1_adress',$reseave['waypoint_1_adress'], PDO::PARAM_STR);
    } else {
        $stmt->bindParam(':waypoint_1_area_id',$null, PDO::PARAM_NULL);
        $stmt->bindParam(':waypoint_1_postal_code',$null, PDO::PARAM_NULL);
        $stmt->bindParam(':waypoint_1_adress',$null, PDO::PARAM_NULL);
    }
    if ($reseave['waypoint_2_area_id']) {
        $stmt->bindParam(':waypoint_2_area_id',$reseave['waypoint_2_area_id'], PDO::PARAM_INT);
        $stmt->bindParam(':waypoint_2_postal_code',$reseave['waypoint_2_postal_code'], PDO::PARAM_STR);
        $stmt->bindParam(':waypoint_2_adress',$reseave['waypoint_2_adress'], PDO::PARAM_STR);
    } else {
        $stmt->bindParam(':waypoint_2_area_id',$null, PDO::PARAM_NULL);
        $stmt->bindParam(':waypoint_2_postal_code',$null, PDO::PARAM_NULL);
        $stmt->bindParam(':waypoint_2_adress',$null, PDO::PARAM_NULL);
    }
    $stmt->execute();
}

function insertReseaveChildren($reseave)
{
    $reseave_id = findNewReseaveId($reseave);

    foreach ($reseave['child_id'] as $child_id) {
        $dbh = connectDb();
        $sql = <<<EOM
            INSERT INTO
            reserve_children
            (reseave_id,child_id)
            VALUES
            (:reseave_id,:child_id);
        EOM;
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':reseave_id',$reseave_id, PDO::PARAM_INT);
        $stmt->bindParam(':child_id',$child_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

function findNewReseaveId($reseave)
{
    $now = date('Y/m/d/H:i:s');

    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            user_id = :user_id
        AND
            created_at <= :now
        ORDER BY
            created_at
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id',$reseave['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':now',$now, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
}

function findAfterReseaveIdByUserId($user_id)
{
    $now = date('Y/m/d/H:i');

    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            user_id = :user_id
        AND
            destination_time <= :now
        ORDER BY
            destination_time
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id',$user_id, PDO::PARAM_INT);
    $stmt->bindParam(':now',$now, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function timeCalculationAtReseave($departure_area_id, $destination_area_id, $waypoint_1_area_id, $waypoint_2_area_id)
{
    if ($waypoint_2_area_id) {
        $calc = timeCalculationByAreaId($departure_area_id, $waypoint_1_area_id) + 10 
        + timeCalculationByAreaId($waypoint_1_area_id, $waypoint_2_area_id) + 10 
        + timeCalculationByAreaId($waypoint_2_area_id, $destination_area_id);
    } elseif ($waypoint_1_area_id) {
        $calc = timeCalculationByAreaId($departure_area_id, $waypoint_1_area_id) +10 
        + timeCalculationByAreaId($waypoint_1_area_id, $destination_area_id);
    } else {
        $calc = timeCalculationByAreaId($departure_area_id, $destination_area_id);
    }

    return $calc;
}

function timeCalculationByAreaId($area_1_id, $area_2_id) {
    $area_1_code = findAreaCode($area_1_id);
    $area_2_code = findAreaCode($area_2_id);

    $distance = floor(sqrt(abs(pow($area_1_code, 2) - pow($area_2_code, 2))));

    return $distance * 4 + 5;
}

function checkReseave($reseave, $departure_time)
{
    // $reseave 一例
    // $reseave = [
    //     'user_id' => 1,
    //     'departure_area_id' => 0,
    //     'departure_postal_code' => '0000000',
    //     'departure_adress' => 'asdfasdf',
    //     'destination_area_id' => 0,
    //     'destination_postal_code' => '0000000',
    //     'destination_adress' => 'asdfasdf',
    //     'waypoint_1_area_id' => 0,
    //     'waypoint_1_postal_code' => '0000000',
    //     'waypoint_1_adress' => 'asdfasdf',
    //     'waypoint_2_area_id' => 0,
    //     'waypoint_2_postal_code' => '0000000',
    //     'waypoint_2_adress' => 'asdfasdf',
    // ];

    $flg = false;
    $reseave['time'] = timeCalculationAtReseave($reseave['departure_area_id'], $reseave['destination_area_id'], $reseave['waypoint_1_area_id'], $reseave['waypoint_2_area_id']);
    
    $dif = strtotime($departure_time) - strtotime(date('Y/m/d/H:i')) - 1800;

    $before_reseave_check = beforeReseaveCheck($reseave, $departure_time);
    $after_reseave_check = afterReseaveCheck($reseave, $departure_time);
    
    if ($before_reseave_check && $after_reseave_check && $dif > 0) {
        $flg = true;
    }
    return $flg;
}

function beforeReseaveCheck($reseave, $departure_time)
{
    $flg = false;

    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            departure_time <= :departure_time
        ORDER BY
            departure_time
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt ->bindParam(':departure_time', $departure_time, PDO::PARAM_STR);
    $stmt->execute();

    $beforReseave = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $calc = timeCalculationByAreaId($beforReseave['destination_area_id'], $reseave['departure_area_id']);
    
    $time1 = strtotime($departure_time);
    $time2 = strtotime($beforReseave['destination_time']);
    $check = $time1 - $time2 - ($calc * 60);

    
    if ($check > 0) {
        $flg = true;
    }
    return $flg;
}

function afterReseaveCheck($reseave, $departure_time)
{
    $flg = true;
    $destination_time = date('Y/m/d h:i', strtotime('+' . $reseave['time'] . 'min', strtotime( $departure_time)));

    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            reseaves
        WHERE
            departure_time >= :destination_time
        ORDER BY
            departure_time
        ASC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt ->bindParam(':destination_time', $destination_time, PDO::PARAM_STR);
    $stmt->execute();

    $afterReseave = $stmt->fetch(PDO::FETCH_ASSOC);

    $calc = timeCalculationByAreaId($afterReseave['departure_area_id'], $reseave['destination_area_id']);
    
    $time1 = strtotime($afterReseave['departure_time']);
    $time2 = strtotime($destination_time);
    $check = $time1 - $time2 - ($calc * 60);

    if ($check < 0) {
        $flg = false;
    }
    return $flg;
}

// お知らせ

function findNews()
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            news
        ORDER BY
            created_at
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function findNewsById($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            news
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function insertNews()
{
    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            news
            (category_id, title, body)
        VALUES
            (:category_id, :title, :body)
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->execute();
}

// 

function findThoughts()
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            thoughts
        ORDER BY
            created_at
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function findThoughtsById($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            thoughts
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function findThoughtsByUserId($user_id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            thoughts
        WHERE
            user_id = :user_id;
        ORDER BY
            created_at
        DESC;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
}
function insertThoughts($user_id, $reseave_id, $title, $body)
{
    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            thoughts
            (user_id, reserve_id, title, body, goods)
        VALUES
            (:user_id, :reserve_id, :title, :body, 0)
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':reseave_id', $reseave_id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->execute();
}
function LimitStrlen($str, $limit)
{
    if (mb_strlen($str) > $limit) { 
    $str = mb_substr($str, 0, $limit) . '･･･' ;
    }
    return $str;
}