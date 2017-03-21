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
          //  die(var_dump($_SESSION['interactions']));
            foreach($_SESSION['galerie'] as $v){
                if (!empty($_SESSION['interactions'])){
                   foreach ($_SESSION['interactions'] as $val){
                       if ($val['post_id'] == $v['id']){
                           $like = $val['like'];
                           $nbComments = $val['nbComments'];
                       }
                   }
                }?>
                <div class="container-interact" id="<?php echo $v['id']; ?>">
                    <img class="photo-galerie" src="<?php echo BASE_URL . $v['file'].'.png'; ?>">
                    <div class="galerie-login">
                        <?php
                        if ($_SESSION['login'] === $v['login']){ ?>
                            <img class="trash-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Trash.ico'; ?>" title="Supprimer Photo?" onclick="delImgDb(<?php echo $v['id']; ?>)">
                        <?php } ?>
                        <span class="login-span"><?php echo $v['login'];?></span>
                        <img class="like-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'nonelike.png'; ?>" title="like ?">
                        <?php
                        if ($like){
                            echo "<span class='like-span'>".$like."</span>";
                        }
                        ?>
                        <img class="comments-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'comments.png'; ?>" title="commenter ?">
                        <?php
                        if ($nbComments){
                            echo "<span class='like-span'>".$nbComments."</span>";
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }  ?>
    </div>
</div>