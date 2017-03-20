<?php
/**
 * Created by PhpStorm.
 * User: jbmar
 * Date: 20/03/2017
 * Time: 09:06
 */
?>
<div class="container-galerie">
    <div class="container-img">
        <?php if (!empty($_SESSION['galerie'])){
            foreach($_SESSION['galerie'] as $v){
                if (!empty($v['file'])) {
                    ?>
                    <img src="<?php echo BASE_URL . $v['file'].'.png'; ?>">
                    <div class="trash-galerie">
                        <?php
                        if ($_SESSION['login'] === $v['login']){?>
                            <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Trash.ico'; ?>" title="Supprimer Photo?">
                        <?php}
                        ?>
                    </div>
                    <div class="galerie-login">
                        <span><?php echo $v['login'];?></span>
                    </div>

                    <?php
                }
            }
        }  ?>
    </div>
</div>
