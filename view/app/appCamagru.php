<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> <h2/>
    <div class="video-containter">
        <div class="filters">
            <img class="filters__icon" id="filters__icon" title="Filtres" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
<!--            <div class="booth_filter">-->
                <nav class="menu2">
                    <p class="button2">
                        <input type="submit" name="none" value="None" onclick="changeFilter('none')">
                        <input type="submit" name="blur" value="Blur" onclick="changeFilter('blur(5px)')">
                        <input type="submit" name="brightness" value="brightness" onclick="changeFilter('brightness(0.4)')">
                        <input type="submit" name="grayscale" value="grayscale" onclick="changeFilter('grayscale(100%)')">
                        <input type="submit" name="vert" value="Vert" onclick="changeFilter('hue-rotate(45deg)')">
                        <input type="submit" name="bleu" value="Bleu" onclick="changeFilter('hue-rotate(135deg)')">
                        <input type="submit" name="mauve" value="Mauve" onclick="changeFilter('hue-rotate(220deg)')">
                        <input type="submit" name="rose" value="Rose" onclick="changeFilter('hue-rotate(320deg)')">
                        <input type="submit" name="invert" value="Invert" onclick="changeFilter('invert(75%)')">
                        <input type="submit" name="sepia" value="Sepia" onclick="changeFilter('sepia(60%)')">
                    </p>
                </nav>
            </div>
<!--        </div>-->
        <div class="booth">
            <video id="myvideo"></video>
            <form class="take-photo" method="post" id="form-cache-photo">
                <img src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' id="startbutton" class="take-photo" onclick="getSrcImg()" title="Cheeeese !"/>
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
