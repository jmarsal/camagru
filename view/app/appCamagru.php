<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> <h2/>
    <div class="video-containter">
        <div class="booth_filter">

        </div>
        <div class="booth">
            <video id="myvideo"></video>
            <form class="take-photo" method="post" id="form-cache-photo">
                <img src="https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" id="startbutton" class="take-photo" onclick="getSrcImg()" title="Cheeeese !"/>
                <input id="getSrc" type="hidden" name="getSrc" value="">
                <canvas class="canvas" id="canvas"></canvas>
                <img class="img-booth" id="photo" alt="photo" src="">
            </form>
        </div>
        <div class="booth_prev">

        </div>
    </div>
