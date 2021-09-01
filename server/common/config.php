<?php

// 接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=mama_taxi;charset=utf8');
define('USER', 'mama_user');
define('PASSWORD', '1234');

// -----バリデーション-----

// ユーザー情報
define('MSG_EMAIL_REQUIRED', 'メールアドレスが未入力です');
define('MSG_PASSWORD_REQUIRED', 'パスワードが未入力です');
define('MSG_PASSWORD_2_REQUIRED', 'パスワード(確認)が未入力です');
define('MSG_PASSWORD_NOT_MATCH', 'パスワードが一致しません');
define('MSG_EMAIL_PASSWORD_NOT_MATCH', 'メールアドレスかパスワードが間違っています');
define('MSG_SEX_REQUIRED', '性別が未選択です');
define('MSG_BIRTH_REQUIRED', '生年月日が未入力です');
define('MSG_TEL_REQUIRED', '電話番号が未入力です');
define('MSG_EMAIL_USED', '使用済みのメールアドレスです');
define('MSG_USER_TEL_USED', '使用済みの電話番号です');

// 子ども情報

// 住所情報
