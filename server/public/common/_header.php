<?php

require_once __DIR__ . '/../../common/config.php';

?>

<header>

    <div class="title">
        <h1>
            <a href="../index.php" class="logo">
                <img src="" alt="ママさんタクシー">
            </a>
        </h1>
    </div>
    
    <nav>
        <!-- マイページorログイン -->
        <div class="navSideL button">
            <a href="../mypage/mypage.php">マイページ
        </a>
            <!-- <a href="../login/login.php">ログイン</a> -->
        </div>
        <!-- 次回予約or会員登録 -->
        <div class="navSideR">
            <div class="navReserve">
                <a href="">
                    <div class="nextReserveMessage">
                        次回予約
                    </div>
                    <!-- 予約ありor新規予約 -->
                    <div class="nextReserve">
                        <a href="../mypage/mypage.php">2021年9月5日(日) 12:00~</a>
                        <!-- 新規予約 -->
                        <!-- <a href="">予約する</a> -->
                    </div>
                </a>
            </div>
        </div>
    </nav>

</header>