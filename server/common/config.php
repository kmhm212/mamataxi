<?php

// 接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=mama_taxi;charset=utf8');
define('USER', 'mama_user');
define('PASSWORD', '1234');

// -----バリデーション-----

// ユーザー情報
define('MSG_EMAIL_REQUIRED', 'メールアドレスが未入力です');
define('MSG_EMAIL_USED', '使用済みのメールアドレスです');
define('MSG_PASSWORD_REQUIRED', 'パスワードが未入力です');
define('MSG_PASSWORD_2_REQUIRED', 'パスワード(確認)が未入力です');
define('MSG_NEW_PASSWORD_REQUIRED', '新しいパスワードが未入力です');
define('MSG_NEW_PASSWORD_2_REQUIRED', '新しいパスワード(確認)が未入力です');
define('MSG_PASSWORD_NOT_MATCH', 'パスワードが一致しません');
define('MSG_NEW_PASSWORD_NOT_MATCH', '新しいパスワードが一致しません');
define('MSG_EMAIL_PASSWORD_NOT_MATCH', 'メールアドレスかパスワードが間違っています');
define('MSG_NOW_PASSWORD_NOT_MATCH', '現在のパスワードが間違っています');
define('MSG_NAME_REQUIRED', '名前が未入力です');
define('MSG_SEX_REQUIRED', '性別が未選択です');
define('MSG_BIRTH_REQUIRED', '生年月日が未入力です');
define('MSG_TEL_REQUIRED', '電話番号が未入力です');
define('MSG_TEL_USED', '使用済みの電話番号です');
define('MSG_TEL_LIMIT', '電話番号は10桁もしくは11桁で入力ください');
define('MSG_POSTAL_CODE_REQUIRED', '郵便番号が未入力です');
define('MSG_POSTAL_CODE_LIMIT', '郵便番号は3桁と4桁で入力ください');
define('MSG_ADRESS_REQUIRED', '住所が未入力です');
define('MSG_NO_CHANGE', '情報が変更されていません');


// 子ども情報

// 住所情報