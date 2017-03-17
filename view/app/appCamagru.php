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
            toggleActiveObjClass("<?php echo $_SESSION['objFilter'];?>");
            changeFilterObjet("<?php echo $_SESSION['objFilter'];?>");
        });
    <?php } ?>
</script>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> </h2>
<div class="elems-app">
    <div class="video-containter">
        <div class="filters">
            <img class="filters__icon" id="filters__icon" title="Filtres" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
            <nav class="menu2">
                <div class="filters-button">
                    <div class="button" id="none" onclick="changeFilter('none')">None</div>
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
        <div class="booth" id="booth">
            <video id="myvideo"></video>
            <audio id="audioPlayer" src="<?php echo BASE_URL.DS.'webroot'.DS.'sounds'.DS."photo2.ogg";?>"></audio>
            <form class="take-photo" method="post" id="form-cache-photo">
                <img src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' id="startbutton" class="take-photo" title="Cheeeese !"/>
                <input id="getSrc" type="hidden" name="getSrc" value="takePhoto">
                <canvas class="canvas" id="canvas"></canvas>
                <img class="img-booth" id="photo" alt="photo" src="">
            </form>
            <div class="prev-img" id="prev-img">
                <?php
                if (!empty($_SESSION['img'])){
                    ?><script type="text/javascript">
                        var container = document.getElementById('prev-img');
                        container.style.display = "inline-flex";
                    </script><?php
                foreach($_SESSION['img'] as $v){
                //                        var_dump($v);
                if (!empty($v['file'])){?>
                    <div class="container-prev" id="<?php echo $v['id'];?>">
                        <img src="<?php echo BASE_URL.$v['file'];?>">
                        <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Loupe.png'; ?>" class="see-button" id="see-button" title="Agrandir ?" onclick="enlargePhoto(<?php echo $v['id'];?>)"/>
                        <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Trash.ico'; ?>" class="del-button" id="del-button" title="Supprimer la photo ?" onclick="delImg(<?php echo $v['id'];?>)"/>
                    </div>
                    <?php
                }
                }
                    unset($_SESSION['img']);
                }
                ?>
            </div>
        </div>
        <div class="objets-filter">
            <img class="objets__icon" id="objets__icon" title="Objets" onclick="showhide()" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'rubix.png';?>"/>
            <nav class="menu-objets">
                <div class="objets-button">
                    <div class="button" id="noneObj" onclick="changeFilterObjet('noneObj')">None</div>
                    <img class="button" id="beardMustaches" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'beardMustaches.png';?>" onclick="changeFilterObjet('beardMustaches')"/>
                    <img class="button" id="chapeauPirate" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'chapeauPirate.png';?>" onclick="changeFilterObjet('chapeauPirate')"/>
                    <img class="button" id="dog" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'dog.png';?>" onclick="changeFilterObjet('dog')"/>
                    <img class="button" id="epee" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'epee.png';?>" onclick="changeFilterObjet('epee')"/>
                    <img class="button" id="epeeLaser" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'epeeLaser.png';?>" onclick="changeFilterObjet('epeeLaser')"/>
                    <img class="button" id="largeMustache" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'largeMustache.png';?>" onclick="changeFilterObjet('largeMustache')"/>
                    <img class="button" id="lunette" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'lunette.png';?>" onclick="changeFilterObjet('lunette')"/>
                    <img class="button" id="monkey" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'monkey.png';?>" onclick="changeFilterObjet('monkey')"/>
                    <img class="button" id="policeHat" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'policeHat.png';?>" onclick="changeFilterObjet('policeHat')"/>
                    <img class="button" id="prismaticMustache" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'prismaticMustache.png';?>" onclick="changeFilterObjet('prismaticMustache')"/>
                </div>
            </nav>
        </div>
    </div>
</div>
