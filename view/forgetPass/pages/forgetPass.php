<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 2:57 PM
 */
?>

<div class="logo">
	<h1>CAMAGRU</h1>
	<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<hr>
<form action="#" method="POST">
	<p>Vous avez perdu <br>votre mot de passe ou login ?</p>
	<div class="forget_but">
		Veuillez renseigner votre Login ou adresse mail :<br><br>
		<input type="text" name="login"><br>
	</div>
	<p class="button2">
		<input type="submit" name="submit" value="Réinitialiser">
	</p>
</form>
    <div id="popup" class="popup">
    <div class="logo-pop">
        <h1>CAMAGRU</h1>
        <img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
    </div>
    <hr>
    <div id="waiting" class="waiting">
        Voulez-vous vraiment réinitialiser votre mot de passe ?
        <hr>
    </div>
<!--        pb ici si clear cache google-->
    <div id="login" class="login">
        Bienvenue <?php echo $_SESSION['user']; ?>
    </div>
    <div id="mail_confirm" class="mail_confirm">
        Si vous confirmer, <br>
<!--        ET ici ...-->
        un email de confirmation de compte va vous etre envoyer a l'adresse <div class ="mail_reinit"><?php echo $_SESSION['email']; ?></div>
    </div>
    <div class="buttons-reinit">
        <div class="button-cancel">
            <p class="button2" onclick="hidePopup()">
                <a class="button" href="">Annuler</a>
            </p>
        </div>
        <div class="button-confirm">
            <p class="button2">
                <a class="button" href="<?php echo BASE_URL."/forgetpass/accueil/?confirm=1" ?>">
                    Confirmer
                </a>
            </p>
        </div>
    </div>
</div>
<hr>
<p class="registered">
	<a class="registered" href="../">Retour accueil</a>
</p>
<a class="registered" href="../register/">Not yet registered ?</a>
<div class="footer"></div>



<div id="overlay" class="overlay"></div>
<script type="text/javascript">
    function showPopup(){
        document.getElementById("popup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }
    function hidePopup() {
        document.getElementById("popup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }
    function RedirectionJavascript(){
        document.location.href="accueil";
    }
</script>
