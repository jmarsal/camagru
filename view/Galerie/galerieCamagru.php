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
                    <div class="galerie-login" id="<?php echo 'galerie-login'.$v['id']; ?>">
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
                            <img class="like-galerie" id="<?php echo 'like-galerie'.$v['id']; ?>" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'nonelike.png'; ?>" title="j'aime" onclick="likeImg(<?php echo $v['id']; ?>)">
                            <?php
                        } else{
                            ?>
                            <img class="like-galerie" id="<?php echo 'like-galerie'.$v['id']; ?>" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'like.png'; ?>" title="j'aime plus" onclick="likeImg(<?php echo $v['id']; ?>)">
                            <?php
                        }
                            echo "<span class='like-span'"."id='like-span".$v['id']."'>".$like."</span>";
                        ?>
                        <img class="comments-galerie" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'galerie'.DS.'comments.png'; ?>" title="commentaires ..." onclick="commmentsClick(<?php echo $v['id']; ?>)">
                        <?php
                            echo "<span class='like-span'>".$nbComments."</span>";
                        ?>
                        <div class="container-comments" id="<?php echo 'container-comments'.$v['id']; ?>"></div>
                        <div class="new-comments-container" id="<?php echo 'new-comments-container'.$v['id']; ?>">
                            <form action="#" method="post">
                                <div class="new-comments" id="id="<?php echo 'new-comments-container'.$v['id']; ?>">
                                <div class="new-comment-span"><span>Nouveau Commentaire : </span></div>
                                <div class="input-comment-text"><input id="<?php echo 'input-comment-text'.$v['id']; ?>" type="text" name="new-comment" value=""></div>
                                <div class="input-comment-submit"><div class="button" id="<?php echo 'input-comment-submit'.$v['id']; ?>" onclick="submitComment(<?php echo $v['id']; ?>)">Poster</div></div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                <?php
            }
        }  ?>
    </div>
</div>