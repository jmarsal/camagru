<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> <h2/>
    <div class="video-containter">
        <div class="filters">
            <img class="filters__icon" id="filters__icon" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
        </div>
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
        <?php
          if (isset($_SESSION['img']) && !empty($_SESSION['img'])){
//            echo '<div class="booth_prev">';
            echo '<div class="prev-img">';
		    foreach($_SESSION['img'] as $v){?>
                <img src="<?php echo $v[0];?>">
<!--                <br>-->
                <?php
		    }
            echo '</div>';
//        echo '</div>';
          }
				?>
        </div>

    </div>
