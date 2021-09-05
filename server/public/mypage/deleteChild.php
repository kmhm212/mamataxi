<?php

require_once __DIR__ . '/../../common/functions.php';

session_start();
if(empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id');

deleteChild($id);
header('Location: mypage.php?pp=delcomp');
exit;