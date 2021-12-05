<?php

require_once __DIR__ . '/../common/functions.php';

session_start();
$id = $_SESSION['id'];
$news = findNews();
$thoughts = findThoughts();

?>

<?php include_once __DIR__ . '/common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/common/_header.php' ?>

<div class="topImg">
<div class="topImgCover"></div></div>
<article class="index wrapper">
    <section class="slider">
        <ul>
            <li><a href=""><img src="images/slide3.jpg" alt="イメージ1"></a></li>
        </ul>
    </section>
    <section class="indexNews indexParts">
        <div class="indexPartsContainer">
            <h2 class="indexH2">おしらせ</h2>
            <div class="indexContents">
                <ul>
                    <?php $i = 0 ?>
                    <?php foreach ($news as $n): ?>
                        <?php if ($i > 8){break;} ?>
                        <li>
                            <a href="news/news.php?id=<?= h($n['id']) ?>">
                                <span class="newsDate">
                                    <?= h(date('m月d日', strtotime($n['created_at']))) ?>
                                </span>
                                <span> - </span>
                                <?= h(LimitStrlen($n['title'], 32)) ?>
                            </a>
                        </li>
                        <?php $i++ ?>
                    <?php endforeach ?>
                    <?php unset($i) ?>
                </ul>
                <a href="news/newsPage.php" class="more">もっと見る</a>
            </div>
        </div>
    </section>
    <section class="reserveParts">
        <div class="reserveMSG">
            <p>予約する</p>
        </div>
        <div class="indexReserveForm">
            <form action="">
                <input type="postal-code" name="departurePC" id="departurePC" class="indexDeparturePC" placeholder="出発地〒000-0000" required>
                <input type="postal-code" name="destinationPC" id="destinationPC" class="indexDestinationPC" placeholder="目的地〒000-0000" required>
                <input type="postal-code" name="waypoint1PC" id="waypoint1PC" class="indexWaypoint1PC" placeholder="経由地①〒000-0000">
                <input type="postal-code" name="waypoint2PC" id="waypoint2PC" class="indexWaypoint2PC" placeholder="経由地②〒000-0000">
                <input type="date" name="reserveDate" id="reserveDate" class="indexReserveDate" placeholder="予約日" required>
                <input type="submit" value="確認" class="indexReserveSubmit">
            </form>
        </div>
        
    </section>
    <section class="howToUse">
        <a href="" class="howToUseMSG">>>ママさんタクシーの使い方を見てみる！</a>
    </section>
    <section class="indexThoughts indexParts">
        <div class="indexPartsContainer">    
            <h2 class="indexH2">新着感想</h2>
            <div class="indexContents">
                <ul>
                    <?php $i = 0 ?>
                    <?php foreach ($thoughts as $thought): ?>
                        <?php if ($i > 5){break;} ?>
                        <li>
                            <a href="thought/thought.php?id=<?= h($thought['id']) ?>">
                                <span class="thoughtH2"><?= h(LimitStrlen($thought['title'], 32)) ?></span> - 
                                <span class="thoughtUserName"><?= h(findUserById($thought['user_id'])['name']) ?></span>
                                <span> - </span>
                                <p><?= h(LimitStrlen($thought['body'], 150)) ?></p>
                            </a>
                        </li>
                        <?php $i++ ?>
                    <?php endforeach ?>
                    <?php unset($i) ?>
                </ul>
                <a href="thought/thoughts.php" class="more">もっと見る</a>
            </div>
        </div>
    </section>
    <section class="twitter indexParts">
        <div class="indexPartsContainer">
            <h2 class="indexH2">Twitter</h2>
            <div class="indexContents">
                <a class="twitter-timeline" data-height="500px" href="https://twitter.com/Twitter?ref_src=twsrc%5Etfw">Tweets by Twitter</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8">
            </script>
            </div>
        </div>
    </section>
</article>

<?php include_once __DIR__ . '/common/_footer.html' ?>

</body>
</html>