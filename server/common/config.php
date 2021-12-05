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
define('MSG_POSTAL_CODE_LEN_CHECK', '郵便番号はハイフン含め8文字で入力ください');
define('MSG_ADRESS_REQUIRED', '住所が未入力です');
define('MSG_DEPARTURE_POSTAL_CODE_REQUIRED', '出発地の郵便番号が未入力です');
define('MSG_DEPARTURE_POSTAL_CODE_LIMIT', '出発地の郵便番号は3桁と4桁で入力ください');
define('MSG_DEPARTURE_ADRESS_REQUIRED', '出発地の住所が未入力です');
define('MSG_DESTINATION_POSTAL_CODE_REQUIRED', '目的地の郵便番号が未入力です');
define('MSG_DESTINATION_POSTAL_CODE_LIMIT', '目的地の郵便番号は3桁と4桁で入力ください');
define('MSG_DESTINATION_ADRESS_REQUIRED', '目的地の住所が未入力です');
define('MSG_WAYPOINT_1_POSTAL_CODE_REQUIRED', '経由地①の郵便番号が未入力です');
define('MSG_WAYPOINT_1_POSTAL_CODE_LIMIT', '経由地①の郵便番号は3桁と4桁で入力ください');
define('MSG_WAYPOINT_1_ADRESS_REQUIRED', '経由地①の住所が未入力です');
define('MSG_WAYPOINT_2_POSTAL_CODE_REQUIRED', '経由地②の郵便番号が未入力です');
define('MSG_WAYPOINT_2_POSTAL_CODE_LIMIT', '経由地②の郵便番号は3桁と4桁で入力ください');
define('MSG_WAYPOINT_2_ADRESS_REQUIRED', '経由地②の住所が未入力です');
define('MSG_WAYPOINT_1_REQUIRED', '経由地①が未入力です');
define('MSG_CHILD_REQUIRED', 'お子様を一人以上選択してください');
define('MSG_NO_CHANGE', '情報が変更されていません');
define('MSG_ALREADY_THOUGHT', 'そのご予約への感想はすでに投稿されています。マイページより編集ください。');
define('MSG_TITLE_REQUIRED', 'タイトルを入力してください');
define('MSG_BODY_REQUIRED', '本文を入力してください');



// 子ども情報

// 住所情報