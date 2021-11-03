<?php

require_once __DIR__ . '/../../common/functions.php';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id'];

insertThoughts($id, $_SESSION['reseaveId'], $_SESSION['title'], $_SESSION['body']);

unset($_SESSION['reseaveId']);
unset($_SESSION['title']);
unset($_SESSION['body']);

header('Location: ../mypage/mypage.php?pp=insertcomp');
exit;
