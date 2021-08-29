<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/common/_head.php' ?>

<body>

<?php include_once __DIR__ . '/common/_header.php' ?>

<div class="topImg">
<div class="topImgCover"></div></div>
<article class="index wrapper">
    <section class="slider">
        <ul>
            <li><a href=""><img src="images/slide3.jpg" alt="イメージ1"></a></li>
            <!-- <li><a href=""><img src="images/slide2.jpg" alt="イメージ2"></a></li>
            <li><a href=""><img src="images/slide3.jpg" alt="イメージ3"></a></li>
            <li><a href=""><img src="images/slide4.jpg" alt="イメージ4"></a></li> -->
        </ul>
    </section>
    <section class="indexNews indexParts">
        <div class="indexPartsContainer">
            <h2 class="indexH2">おしらせ</h2>
            <div class="indexContents">
                <ul>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                    <li><a href=""><span class="newsDate">◯月◯日</span><span> - </span> asdfasdfas</a></li>
                </ul>
                <a href="" class="more">もっと見る</a>
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
                    <li><a href="">
                        <span class="thoughtH2">見出し見出し</span> - <span class="thoughtUserName"> name </span>
                        <p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf...</p>
                    </a></li>
                    <li><a href="">
                        <span class="thoughtH2">見出し見出し</span> - <span class="thoughtUserName"> name </span>
                        <p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf...</p>
                    </a></li>
                    <li><a href="">
                        <span class="thoughtH2">見出し見出し</span> - <span class="thoughtUserName"> name </span>
                        <p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf...</p>
                    </a></li>
                    <li><a href="">
                        <span class="thoughtH2">見出し見出し</span> - <span class="thoughtUserName"> name </span>
                        <p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf...</p>
                    </a></li>
                    <li><a href="">
                        <span class="thoughtH2">見出し見出し</span> - <span class="thoughtUserName"> name </span>
                        <p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf...</p>
                    </a></li>
                </ul>
                <a href="" class="more">もっと見る</a>
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