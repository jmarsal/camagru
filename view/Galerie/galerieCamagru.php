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
                           $like = $val['nbLike'];
                           $nbComments = $val['nbComments'];
                       }
                   }
                }?>
                <div class="container-interact" id="<?php echo $v['id']; ?>">
                    <img class="photo-galerie" src="<?php echo BASE_URL . $v['file'].'.png'; ?>">
                    <div class="galerie-login" id="galerie-login">
                        <?php
                        if ($_SESSION['login'] === $v['login']){ ?>
                            <img class="trash-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'app'.DS.'Trash.ico'; ?>" title="Supprimer Photo?" onclick="delImgDb(<?php echo $v['id']; ?>)">
                        <?php } ?>
                        <span class="login-span"><?php echo $v['login'];?></span>
                        <?php
                        $modifyLike = -1;
                        foreach ($_SESSION['like'] as $l){
                            if ($l['post_id'] == $v['id']){
                                $modifyLike = $l['userLike'];
                            }
                        }
                        if ($modifyLike == 0 || $modifyLike == -1){
                        ?>
                            <img class="like-galerie" id="<?php echo 'like-galerie'.$v['id']; ?>" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'nonelike.png'; ?>" title="like ?" onclick="likeImg(<?php echo $v['id']; ?>)">
                            <?php
                        } else{
                            ?>
                            <img class="like-galerie" id="<?php echo 'like-galerie'.$v['id']; ?>" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'like.png'; ?>" title="like ?" onclick="likeImg(<?php echo $v['id']; ?>)">
                            <?php
                        }
                            echo "<span class='like-span'>".$like."</span>";
                        ?>
                        <img class="comments-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'comments.png'; ?>" title="commenter ?">
                        <?php
                            echo "<span class='like-span'>".$nbComments."</span>";
                        ?>
                    </div>
                </div>
                <?php
            }
        }  ?>
    </div>
</div>