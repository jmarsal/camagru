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
                    <?php
                }
            }
        }  ?>
    </div>
</div>
