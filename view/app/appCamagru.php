<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<script type="text/javascript">
    <?php if (!empty($_SESSION['filter'])){ ?>
        var filter = "<?php echo $_SESSION['filter'];?>";
        window.addEventListener("DOMContentLoaded", function() {
            if (filter){
                changeFilter(filter);
            }
        });
    <?php } ?>
    <?php if (!empty($_SESSION['objFilter'])){ ?>
    var objFilter = "<?php echo $_SESSION['objFilter'];?>";
    window.addEventListener("DOMContentLoaded", function() {
        if (objFilter){
            changeFilterObjet(objFilter);
        }
    });
    <?php } ?>
    <?php if (!empty($_SESSION['colorMessUpload'])){ ?>
    var colorMessUpload = "<?php echo $_SESSION['colorMessUpload'];?>";
    window.addEventListener("DOMContentLoaded", function() {
        if (colorMessUpload){
            document.getElementById('file-upload').style.backgroundColor = colorMessUpload;
            document.getElementById('imgUpload').classList.add('active');
            document.getElementById('booth').classList.add('active');
        }
    });
    <?php } ?>
</script>
<h2 class='bienvenue'>Bienvenue <?php echo $_SESSION["login"];?> </h2>
<div class="elems-app">
    <div class="video-containter">
        <div class="container-all-filters" id="container-all-filters" style="display: block">
            <div class="filters" id="filters">
                <div class="filterHideButton" id="filterHideButton" onclick="showHideFilter()">
                    <img class="filters__icon" id="filters__icon" title="Filtres" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'color-filters.png';?>"/>
                    <p class="textFilter">Filtres</p>
                </div>
                <nav class="menu2" id="menuFilter" style="display: none">
                    <div class="filters-button" id="filters-button">
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
            <div class="objets-filter" id="objets-filter">
                <div class="objHideButton" id="objHideButton" onclick="showHideObj()">
                    <img class="objets__icon" id="objets__icon" title="Objets" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'rubix.png';?>"/>
                    <p class="textObjFilter">Objets</p>
                </div>
                <nav class="menu-objets" id="menu-objets" style="display: none">
                    <div class="objets-button" id="objets-button">
                        <div class="button button-none" id="noneObj" onclick="changeFilterObjet('noneObj')">None</div>
                        <div class="button" id="beardMustaches" onclick="changeFilterObjet('beardMustaches')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'beardMustaches.png';?>"/></div>
                        <div class="button" id="chapeauPirate" onclick="changeFilterObjet('chapeauPirate')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'chapeauPirate.png';?>"/></div>
                        <div class="button" id="dog" onclick="changeFilterObjet('dog')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'dog.png';?>"/></div>
                        <div class="button" id="epee"  onclick="changeFilterObjet('epee')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'epee.png';?>"/></div>
                        <div class="button" id="epeeLaser" onclick="changeFilterObjet('epeeLaser')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'epeeLaser.png';?>"/></div>
                        <div class="button" id="largeMustache" onclick="changeFilterObjet('largeMustache')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'largeMustache.png';?>"/></div>
                        <div class="button" id="lunette" onclick="changeFilterObjet('lunette')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'lunette.png';?>"/></div>
                        <div class="button" id="monkey" onclick="changeFilterObjet('monkey')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'monkey.png';?>"/></div>
                        <div class="button" id="policeHat" onclick="changeFilterObjet('policeHat')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'policeHat.png';?>"/></div>
                        <div class="button" id="prismaticMustache" onclick="changeFilterObjet('prismaticMustache')"><img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'objets'.DS.'prismaticMustache.png';?>"/></div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="booth" id="booth" >
            <img id="imgUpload" class="imgUpload" src="<?php if (!empty($_SESSION['srcUpload'])){ echo $_SESSION['srcUpload']; }?>" style="display: <?php if (empty($_SESSION['fileUpload'])){ echo 'none'; } else { echo 'inline-block'; }?>">
            <video id="myvideo" style="display: <?php if (!empty($_SESSION['fileUpload'])){ echo 'none'; } else { echo 'inline-block'; }?>"></video>
            <audio id="audioPlayer" src="<?php echo BASE_URL.DS.'webroot'.DS.'sounds'.DS."photo2.ogg";?>"></audio>
            <div class="buttonActionApp" id="buttonActionApp">
                <div class="action-app" id="action-app">
                    <form class="take-photo" method="post" id="form-cache-photo">
                        <img src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' id="startbutton" class="take-photo-img" title="Cheeeese !" style="display: <?php if(!empty($_SESSION['colorMessUpload'])){echo 'none';}else{echo 'inline-block';} ?>"/>
                        <img src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' id="startbuttonUpload" class="startbuttonUpload" title="Enregistrer ?" onclick="sendBase64ForTakePhoto('<?php if (!empty($_SESSION['srcUpload'])){ echo $_SESSION['srcUpload']; }?>')" style="display: <?php if(empty($_SESSION['colorMessUpload'])){echo 'none';}else{echo 'inline-block';} ?>"/>
                        <input id="getSrc" type="hidden" name="getSrc" value="takePhoto">
                        <canvas class="canvas" id="canvas"></canvas>
                        <img class="img-booth" id="photo" alt="photo" src="">
                    </form>
                </div>
                <div class="upload-app" id="upload-app">
                    <div class="input-file-container <?php if (!empty($_SESSION['colorMessUpload'])){echo 'active';} ?>" id="uploadButton">
                        <input class="input-file" id="my-file" type="file" accept="image/*" value="" onchange="uploadImg()">
                        <label for="my-file">
                            <img class="input-file-trigger" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS."upload.png";?>' title="Select a file...">
                        </label>
                        <img class="back-to-video" id="back-to-video" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS."backToCam.png";?>' title="Retour Camera..." style="display: <?php if (!empty($_SESSION['colorMessUpload'])){echo 'inline-block';} else {echo 'none';}?>" onclick="backCamera()">
                    </div>
                </div>
            </div>
            <p class="chooseFilter" id="chooseFilter">Choisis un filtre ou un objet pour prendre une photo</p>
            <p class="file-upload" id="file-upload"><?php if (!empty($_SESSION['errorOrFileUpload'])){echo $_SESSION['errorOrFileUpload'];}?></p>
        </div>
        <div class="prev-img-container">
            <div class="prev-img" id="prev-img" style="overflow-y: <?php if (!empty($_SESSION["img"]) && (count($_SESSION["img"]) > 2)){echo "scroll";}else{echo "hidden";}?>">
                <?php
                if (!empty($_SESSION["img"])){
                    ?> <script type="text/javascript">
                        var container = document.getElementById('prev-img');
                        container.style.display = "block";
                    </script><?php
                foreach($_SESSION['img'] as $v){
                if (!empty($v['file'])){?>
                    <div class="container-prev" id="<?php echo $v['id'];?>">
                        <img src="<?php echo BASE_URL.$v['file'];?>">
                        <div class="prev-action" id="prev-action">
                            <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Loupe.png'; ?>" class="see-button" id="see-button" title="Agrandir ?" onclick="enlargePhoto(<?php echo $v['id'];?>)"/>
                            <div class="div-namePhoto">
                                <input id="name-photo-<?php echo $v['id'];?>" class="name-photo" type="text" name="namePhoto" placeholder="Nom pour votre Photo" onblur="addValue(<?php echo $v['id'];?>)">
                                <input id="tmp-photo-<?php echo $v['id'];?>" class="tmp-photo" type="hidden" value="">
                            </div>
                            <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Trash.ico'; ?>" class="del-button" id="del-button" title="Supprimer la photo ?" onclick="delImg(<?php echo $v['id'];?>)"/>
                        </div>
                    </div>
                    <?php
                }
                }
                    unset($_SESSION['img']);
                }
                ?>
            </div>
        </div>
    </div>
</div>
