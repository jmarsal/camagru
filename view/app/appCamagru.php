<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> <h2/>
    <div class="video-containter">
        <div class="filters">
            <img class="filters__icon" id="filters__icon" title="Filtres" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
                <nav class="menu2">
                    <form method="post">
                        <p class="button2">
                            <input class="button2" type="button" name="filter" value="None" onclick="changeFilter('none')">
                            <input class="button2" type="button" id="filter" name="filter" value="Blur" onclick="changeFilter('blur(5px)')">
                            <input class="button2" type="button" name="filter" value="Brightness" onclick="changeFilter('brightness(0.4)')">
                            <input class="button2" type="button" name="filter" value="Grayscale" onclick="changeFilter('grayscale(100%)')">
                            <input class="button2" type="button" name="filter" value="Vert" onclick="changeFilter('hue-rotate(45deg)')">
                            <input class="button2" type="button" name="filter" value="Bleu" onclick="changeFilter('hue-rotate(135deg)')">
                            <input class="button2" type="button" name="filter" value="Mauve" onclick="changeFilter('hue-rotate(220deg)')">
                            <input class="button2" type="button" name="filter" value="Rose" onclick="changeFilter('hue-rotate(320deg)')">
                            <input class="button2" type="button" name="filter" value="Invert" onclick="changeFilter('invert(75%)')">
                            <input class="button2" type="button" name="filter" value="Sepia" onclick="changeFilter('sepia(60%)')">
                        </p>
                    </form>
                </nav>
            </div>
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
            echo '<div class="prev-img">';
		    foreach($_SESSION['img'] as $v){?>
                <img src="<?php echo $v[0];?>">
                <?php
		    }
            echo '</div>';
          }
				?>
        </div>

    </div>
