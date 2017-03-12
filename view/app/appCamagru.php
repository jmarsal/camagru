<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<script type="text/javascript">
    <?php if (!empty($_SESSION['filter'])){ ?>
        window.addEventListener("DOMContentLoaded", function() {
            toggleActiveClass("<?php echo $_SESSION['filter'];?>");
            changeFilter("<?php echo $_SESSION['filter'];?>");
        });
    <?php } ?>
</script>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> <h2/>
    <div class="video-containter">
        <div class="filters">
            <img class="filters__icon" id="filters__icon" title="Filtres" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
                <nav class="menu2">
                    <div class="filters-button">
                        <div class="button active" id="none" onclick="changeFilter('none')">None</div>
                        <div class="button" id="blur(5px)" onclick="changeFilter('blur(5px)')">Blur</div>
                        <div class="button" id="brightness(0.4)" onclick="changeFilter('brightness(0.4)')">Brightness</div>
                        <div class="button" id="grayscale(100%)" onclick="changeFilter('grayscale(100%)')">Grayscale</div>
                        <div class="button" id="hue-rotate(45deg)" onclick="changeFilter('hue-rotate(45deg)')">Vert</div>
                        <div class="button" id="hue-rotate(135deg)" onclick="changeFilter('hue-rotate(135deg)')">Bleu</div>
                        <div class="button" id="hue-rotate(220deg)" onclick="changeFilter('hue-rotate(220deg)')">Mauve</div>
                        <div class="button" id="hue-rotate(320deg)" onclick="changeFilter('hue-rotate(320deg)')">Rose</div>
                        <div class="button" id="invert(100%)" onclick="changeFilter('invert(100%)')">Invert</div>
                        <div class="button" id="sepia(60%)" onclick="changeFilter('sepia(60%)')">Sepia</div>
                    </div>
                </nav>
            </div>
        <div class="booth">
            <video id="myvideo"></video>
            <form class="take-photo" method="post" id="form-cache-photo">
                <img src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' id="startbutton" class="take-photo" onclick="getSrcImg()" title="Cheeeese !"/>
                <input id="getSrc" type="hidden" name="getSrc" value="takePhoto">
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
