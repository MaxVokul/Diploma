<?php
include 'header.php';
require_once $_SERVER['DOCUMENT_ROOT']."/models/Room.php";
$rooms = Room::getAllrooms();
?>
<section class="tssection">
    <h2 class="mains">Top stories</h2>
    <a href="topstory.html">
        <div class="tssqr">
            <img class="imgts" src="../resources/image%201.png" alt="">
            <div class="tstext">
                <h3>The one question from Donald Trump that could sway many American voters in swing states.</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
                    massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                    quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
                    Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                <p>2 hours ago / by Sfsafa</p>
            </div>
        </div>
    </a>
    <div class="tssqr">
        <img class="imgts" id="tssqimg" src="../resources/image%202.png" alt="">
        <div class="tstext">
            <h3>Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.</h3>
            <p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper
                nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac,
                enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus
                varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. </p>
            <p>10 hours ago / by Najdsksd</p>
        </div>
    </div>
    <div class="tssqr" id="tssqr">
        <img class="imgts" id="tssqimg" src="../resources/image%203.png" alt="">
        <div class="tstext">
            <h3>Maecenas nec odio et ante tincidunt tempus.</h3>
            <p>Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus
                tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat,
                leo eget bibendum sodales, augue velit cursus nunc.</p>
            <p>24 hours ago / by Hskdmak</p>
        </div>
    </div>
</section>
<section class="foryou">
    <div class="foryouh2">
        <h2 id="fy">For You</h2>
        <p>Recommended based on your interests</p>
    </div>
</section>
<div class="foryouall">
    <section class="foryouin">
        <div class="bigrect">
            <img class="bigrecimg" src="../resources/Rectangle%2020.png" alt="">
            <div class="bigrecttxt">
                <h2>Sed fringilla mauris sit amet nibh.</h2>
                <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit
                    eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
            </div>
            <p class="bigrectp">15 hours ago / by dawfw</p>
        </div>
        <div class="smrect">
            <img class="smrectimg" src="../resources/Rectangle%2024.png" alt="">
            <div>
                <div class="smrecttxt">
                    <h2>Sed fringilla mauris sit amet nibh.</h2>
                    <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor,
                        suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
                </div>
                <p class="smrectp">15 hours ago / by dawfw</p>
            </div>
        </div>
        <div class="smrect2">
            <img class="smrectimg" src="../resources/Rectangle%2025.png" alt="">
            <div>
                <div class="smrecttxt">
                    <h2>Sed fringilla mauris sit amet nibh.</h2>
                    <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor,
                        suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
                </div>
                <p class="smrectp">15 hours ago / by dawfw</p>
            </div>
        </div>
        <div class="smrect3">
            <img class="smrectimg" src="../resources/image%204.png" alt="">
            <div>
                <div class="smrecttxt">
                    <h2>Sed fringilla mauris sit amet nibh.</h2>
                    <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor,
                        suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
                </div>
                <p class="smrectp">15 hours ago / by dawfw</p>
            </div>
        </div>
        <div class="smrect4">
            <img class="smrectimg" src="../resources/Rectangle%2027.png" alt="">
            <div>
                <div class="smrecttxt">
                    <h2>Sed fringilla mauris sit amet nibh.</h2>
                    <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor,
                        suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
                </div>
                <p class="smrectp">15 hours ago / by dawfw</p>
            </div>
        </div>

        <div class="bigrect2">
            <img class="bigrecimg" src="../resources/Rectangle%2026.png" alt="">
            <div class="bigrecttxt">
                <h2>Sed fringilla mauris sit amet nibh.</h2>
                <p>Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit
                    eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
            </div>
            <p class="bigrectp">15 hours ago / by dawfw</p>
        </div>
    </section>
</div>
<section class="back">
    <h1 id="back"><a href="">Back</a></h1>
</section>
